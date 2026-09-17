<?php

namespace Tests\Feature;

use Database\Seeders\LuminaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test halaman utama Lumina
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed(LuminaSeeder::class);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('LUMINA');
    }

    /**
     * Test halaman detail buku & klub buku
     */
    public function test_book_detail_page(): void
    {
        $this->seed(LuminaSeeder::class);

        $response = $this->get('/buku/1');

        $response->assertStatus(200);
        $response->assertSee('Bite-Sized Info');
    }

    /**
     * Test ruang baca digital (mode fokus)
     */
    public function test_reader_page(): void
    {
        $this->seed(LuminaSeeder::class);

        $response = $this->get('/baca/1');

        $response->assertStatus(200);
        $response->assertSee('Mode Fokus');
    }

    /**
     * Test ruang gamifikasi & fraksi
     */
    public function test_gamification_page(): void
    {
        $this->seed(LuminaSeeder::class);

        $response = $this->get('/gamifikasi');

        $response->assertStatus(200);
        $response->assertSee('Ruang Gamifikasi');
    }

    /**
     * Test API AI Book Matchmaker
     */
    public function test_ai_matchmaker_api(): void
    {
        $this->seed(LuminaSeeder::class);

        $response = $this->postJson('/api/matchmaker', [
            'mood' => 'santai',
            'interest' => 'sejarah',
            'duration' => 30,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'ai_analysis', 'matched_books']);
    }

    /**
     * Test API Roleplay Chat Tokoh Sejarah
     */
    public function test_roleplay_ai_api(): void
    {
        $this->seed(LuminaSeeder::class);

        $response = $this->postJson('/api/roleplay-chat', [
            'character_id' => 1,
            'message' => 'Halo Bung Karno, apa kabar?',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'character_name', 'reply']);
    }
}
