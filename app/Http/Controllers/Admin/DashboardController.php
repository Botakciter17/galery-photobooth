<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\PhotoSession;
use App\Models\SessionPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class DashboardController extends Controller
{
    protected function checkAuth(Request $request): bool
    {
        return (bool)$request->session()->get('admin_logged_in', false);
    }

    public function showLogin(Request $request)
    {
        if ($this->checkAuth($request)) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $password = $request->input('password');
        $expected = env('ADMIN_PASSWORD', 'admin123');

        if (hash_equals((string)$expected, (string)$password)) {
            $request->session()->put('admin_logged_in', true);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['password' => 'Password salah.']);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function index(Request $request)
    {
        if (!$this->checkAuth($request)) {
            return redirect()->route('admin.login');
        }

        $events = Event::withCount('photoSessions')->get();
        $selectedEventId = $request->query('event_id');

        $query = PhotoSession::with(['event', 'stripPhoto', 'photos'])
            ->latest();

        if ($selectedEventId) {
            $query->where('event_id', $selectedEventId);
        }

        $sessions = $query->paginate(24);
        $totalSessions = PhotoSession::count();
        $totalPhotos = SessionPhoto::count();

        return view('admin.dashboard', compact('events', 'sessions', 'totalSessions', 'totalPhotos', 'selectedEventId'));
    }

    public function deleteSession(Request $request, int $id)
    {
        if (!$this->checkAuth($request)) {
            return redirect()->route('admin.login');
        }

        $session = PhotoSession::with('photos')->findOrFail($id);

        foreach ($session->photos as $photo) {
            Storage::disk('public')->delete($photo->file_path);
            $photo->delete();
        }

        $session->delete();

        return back()->with('success', "Sesi {$session->session_code} berhasil dihapus.");
    }

    /**
     * Backup all photos of an event into a structured ZIP file for Google Drive
     */
    public function backupEvent(Request $request, int $eventId)
    {
        if (!$this->checkAuth($request)) {
            return redirect()->route('admin.login');
        }

        $event = Event::with(['photoSessions.photos'])->findOrFail($eventId);

        $zip = new ZipArchive();
        $tempZipPath = tempnam(sys_get_temp_dir(), 'event_backup_');

        if ($zip->open($tempZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Gagal membuat file arsip ZIP.');
        }

        // CSV summary file
        $csvLines = ["No,Kode Sesi,Email Tamu,Jumlah Foto,Waktu Jepretan,Link Unduh Tamu"];
        $rowNum = 1;

        foreach ($event->photoSessions as $session) {
            $guestUrl = url('/s/' . $session->slug);
            $csvLines[] = sprintf(
                '"%d","%s","%s","%d","%s","%s"',
                $rowNum++,
                $session->session_code,
                $session->user_email ?: '-',
                $session->photos->count(),
                $session->created_at->format('Y-m-d H:i:s'),
                $guestUrl
            );

            foreach ($session->photos as $photo) {
                $realPath = Storage::disk('public')->path($photo->file_path);
                if (file_exists($realPath)) {
                    if ($photo->type === 'strip') {
                        $zipPath = "polaroids/{$session->session_code}_polaroid.jpg";
                    } else {
                        $zipPath = "singles/{$session->session_code}_pose_{$photo->photo_index}.jpg";
                    }
                    $zip->addFile($realPath, $zipPath);
                }
            }
        }

        $zip->addFromString('rekap_data_tamu.csv', implode("\r\n", $csvLines));
        $zip->close();

        $zipFilename = "BACKUP_{$event->slug}_" . date('Ymd_His') . ".zip";

        return response()->download($tempZipPath, $zipFilename, [
            'Content-Type' => 'application/zip',
        ])->deleteFileAfterSend(true);
    }
}
