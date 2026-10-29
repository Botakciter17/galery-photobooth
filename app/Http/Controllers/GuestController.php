<?php

namespace App\Http\Controllers;

use App\Models\PhotoSession;
use App\Models\SessionPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class GuestController extends Controller
{
    public function show(string $slug)
    {
        $session = PhotoSession::with(['event', 'photos'])
            ->where('slug', $slug)
            ->firstOrFail();

        $stripPhoto = $session->photos->firstWhere('type', 'strip');
        $singlePhotos = $session->photos->where('type', 'single')->sortBy('photo_index');

        return view('guest.session', compact('session', 'stripPhoto', 'singlePhotos'));
    }

    public function downloadPhoto(string $slug, int $photoId): BinaryFileResponse
    {
        $session = PhotoSession::where('slug', $slug)->firstOrFail();
        $photo = SessionPhoto::where('photo_session_id', $session->id)
            ->where('id', $photoId)
            ->firstOrFail();

        $path = Storage::disk('public')->path($photo->file_path);
        if (!file_exists($path)) {
            abort(404, 'File photo not found on server.');
        }

        $cleanEvent = preg_replace('/[^a-zA-Z0-9_-]/', '_', $session->event->name ?? 'Photobooth');
        $filename = $photo->type === 'strip'
            ? "{$cleanEvent}_Polaroid_Strip_{$session->session_code}.jpg"
            : "{$cleanEvent}_Pose_{$photo->photo_index}_{$session->session_code}.jpg";

        return response()->download($path, $filename, [
            'Content-Type' => 'image/jpeg',
        ]);
    }

    public function downloadZip(string $slug)
    {
        $session = PhotoSession::with(['event', 'photos'])
            ->where('slug', $slug)
            ->firstOrFail();

        $zip = new ZipArchive();
        $tempZipPath = tempnam(sys_get_temp_dir(), 'session_zip_');

        if ($zip->open($tempZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Could not create ZIP archive.');
        }

        $cleanEvent = preg_replace('/[^a-zA-Z0-9_-]/', '_', $session->event->name ?? 'Photobooth');

        foreach ($session->photos as $photo) {
            $path = Storage::disk('public')->path($photo->file_path);
            if (file_exists($path)) {
                $entryName = $photo->type === 'strip'
                    ? "Polaroid_Strip.jpg"
                    : "Foto_Pose_{$photo->photo_index}.jpg";

                $zip->addFile($path, $entryName);
            }
        }

        $zip->close();

        $downloadFilename = "{$cleanEvent}_Foto_Sesi_{$session->session_code}.zip";

        return response()->download($tempZipPath, $downloadFilename, [
            'Content-Type' => 'application/zip',
        ])->deleteFileAfterSend(true);
    }
}
