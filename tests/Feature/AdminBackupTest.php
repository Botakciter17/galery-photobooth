<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\PhotoSession;
use App\Models\SessionPhoto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminBackupTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_and_backup_zip(): void
    {
        Storage::fake('public');

        // Create event with session and photo
        $event = Event::create([
            'name' => 'SMK Tunas Harapan Event',
            'slug' => 'tunas-harapan',
        ]);

        $session = PhotoSession::create([
            'event_id' => $event->id,
            'session_code' => 'TEST_SESSION_01',
            'slug' => 'sesi01',
            'user_email' => 'bagus@smkth.sch.id',
        ]);

        $file = UploadedFile::fake()->image('strip.jpg', 600, 1800);
        $path = $file->storeAs('photos/events/tunas-harapan/TEST_SESSION_01', 'strip.jpg', 'public');

        SessionPhoto::create([
            'photo_session_id' => $session->id,
            'type' => 'strip',
            'file_path' => $path,
            'original_filename' => 'strip.jpg',
        ]);

        // Attempt backup without login -> should redirect to login
        $res = $this->get("/admin/events/{$event->id}/backup");
        $res->assertRedirect(route('admin.login'));

        // Login with admin password
        $loginRes = $this->post('/admin/login', [
            'password' => 'admin123',
        ]);
        $loginRes->assertRedirect(route('admin.dashboard'));

        // Perform backup download as authenticated admin
        $backupRes = $this->withSession(['admin_logged_in' => true])
            ->get("/admin/events/{$event->id}/backup");

        $backupRes->assertStatus(200);
        $this->assertEquals('application/zip', $backupRes->headers->get('content-type'));
    }
}
