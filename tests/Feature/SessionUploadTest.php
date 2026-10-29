<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SessionUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_health_check_returns_ok(): void
    {
        $response = $this->get('/api/health');
        $response->assertStatus(200);
        $response->assertJson(['status' => 'ok']);
    }

    public function test_upload_requires_valid_api_key(): void
    {
        $response = $this->postJson('/api/sessions/upload', []);
        $response->assertStatus(401);
    }

    public function test_upload_session_with_strip_and_singles(): void
    {
        Storage::fake('public');

        $strip = UploadedFile::fake()->image('strip.jpg', 600, 1800);
        $single1 = UploadedFile::fake()->image('single1.jpg', 600, 400);
        $single2 = UploadedFile::fake()->image('single2.jpg', 600, 400);
        $single3 = UploadedFile::fake()->image('single3.jpg', 600, 400);

        $response = $this->withHeaders([
            'X-API-KEY' => 'photobooth-secret-token-2026',
        ])->post('/api/sessions/upload', [
            'event_slug' => 'tunas-harapan',
            'session_code' => 'TEST_20261029',
            'user_email' => 'tamu@example.com',
            'strip_image' => $strip,
            'single_photos' => [$single1, $single2, $single3],
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'session_code',
            'slug',
            'guest_url',
        ]);

        $data = $response->json();
        $this->assertTrue($data['success']);

        // Check Guest page
        $guestResponse = $this->get('/s/' . $data['slug']);
        $guestResponse->assertStatus(200);
        $guestResponse->assertSee('Hasil Foto Photobooth');

        // Check ZIP download
        $zipResponse = $this->get('/s/' . $data['slug'] . '/download-zip');
        $zipResponse->assertStatus(200);
        $this->assertEquals('application/zip', $zipResponse->headers->get('content-type'));
    }
}
