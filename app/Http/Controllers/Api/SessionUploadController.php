<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\PhotoSession;
use App\Models\SessionPhoto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SessionUploadController extends Controller
{
    public function upload(Request $request): JsonResponse
    {
        // 1. Verify API Key
        $configuredKey = config('app.photobooth_api_key', env('PHOTOBOOTH_API_KEY', 'photobooth-secret-token-2026'));
        $incomingKey = $request->header('X-API-KEY') ?: $request->input('api_key');

        if (empty($incomingKey) || !hash_equals((string)$configuredKey, (string)$incomingKey)) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized. Invalid API Key.',
            ], 401);
        }

        // 2. Validate Request
        $request->validate([
            'strip_image' => 'required|file|image|max:30720', // Max 30MB
            'single_photos' => 'nullable|array',
            'single_photos.*' => 'file|image|max:30720',
            'event_slug' => 'nullable|string|max:100',
            'session_code' => 'nullable|string|max:100',
            'user_email' => 'nullable|email|max:150',
        ]);

        $eventSlug = Str::slug($request->input('event_slug', 'tunas-harapan'));
        if (empty($eventSlug)) {
            $eventSlug = 'default';
        }

        $sessionCode = preg_replace('/[^a-zA-Z0-9_-]/', '', (string)$request->input('session_code', ''));
        if (empty($sessionCode)) {
            $sessionCode = date('Ymd_His') . '_' . Str::lower(Str::random(4));
        }

        $userEmail = $request->input('user_email');

        // 3. Find or Create Event
        $event = Event::firstOrCreate(
            ['slug' => $eventSlug],
            ['name' => ucwords(str_replace('-', ' ', $eventSlug)), 'is_active' => true]
        );

        // 4. Find or Create PhotoSession
        $photoSession = PhotoSession::where('event_id', $event->id)
            ->where('session_code', $sessionCode)
            ->first();

        if (!$photoSession) {
            // Generate unique short slug
            do {
                $slug = Str::lower(Str::random(7));
            } while (PhotoSession::where('slug', $slug)->exists());

            $photoSession = PhotoSession::create([
                'event_id' => $event->id,
                'session_code' => $sessionCode,
                'slug' => $slug,
                'user_email' => $userEmail,
            ]);
        } else {
            if (!empty($userEmail)) {
                $photoSession->update(['user_email' => $userEmail]);
            }
            // Clear existing photo records and files to avoid duplicates on re-stitch
            foreach ($photoSession->photos as $oldPhoto) {
                Storage::disk('public')->delete($oldPhoto->file_path);
                $oldPhoto->delete();
            }
        }

        $baseDir = "photos/events/{$eventSlug}/{$sessionCode}";

        // 5. Save Polaroid Strip Image
        $stripFile = $request->file('strip_image');
        $stripFilename = 'strip_' . time() . '.' . $stripFile->getClientOriginalExtension();
        $stripPath = $stripFile->storeAs($baseDir, $stripFilename, 'public');

        SessionPhoto::create([
            'photo_session_id' => $photoSession->id,
            'type' => 'strip',
            'file_path' => $stripPath,
            'original_filename' => $stripFile->getClientOriginalName(),
            'photo_index' => 0,
            'file_size' => $stripFile->getSize(),
        ]);

        // 6. Save Single Pose Photos
        if ($request->hasFile('single_photos')) {
            $singles = $request->file('single_photos');
            $idx = 1;
            foreach ($singles as $singleFile) {
                if ($singleFile && $singleFile->isValid()) {
                    $singleFilename = "pose_{$idx}_" . time() . '.' . $singleFile->getClientOriginalExtension();
                    $singlePath = $singleFile->storeAs($baseDir, $singleFilename, 'public');

                    SessionPhoto::create([
                        'photo_session_id' => $photoSession->id,
                        'type' => 'single',
                        'file_path' => $singlePath,
                        'original_filename' => $singleFile->getClientOriginalName(),
                        'photo_index' => $idx,
                        'file_size' => $singleFile->getSize(),
                    ]);
                    $idx++;
                }
            }
        }

        $guestUrl = url('/s/' . $photoSession->slug);

        return response()->json([
            'success' => true,
            'message' => 'Session uploaded successfully.',
            'event' => $event->name,
            'session_code' => $photoSession->session_code,
            'slug' => $photoSession->slug,
            'guest_url' => $guestUrl,
        ]);
    }
}
