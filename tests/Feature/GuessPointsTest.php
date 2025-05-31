<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GuessPointsTest extends TestCase
{
    use RefreshDatabase;


//Test 1: awards points based on correct guesses and snippet duration
    public function test_awards_correct_points_based_on_matches_and_duration()
    {
        $songId = DB::table('songs')->insertGetId([
            'title' => 'Fade To Black',
            'artist' => 'Metallica',
            'album' => 'Ride The Lightning',
            'audio_snippet' => 'https://test-snippet.mp3', //placeholder URL
            'genre' => 'Metal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $sessionId = DB::table('game_sessions')->insertGetId([
            'genre' => 'Metal',
            'score' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->postJson('/api/guess', [
            'game_session_id' => $sessionId,
            'song_id' => $songId,
            'snippet_duration' => 15,
            'guessed_title' => 'Fade To Black',
            'guessed_artist' => 'Metallica',
            'guessed_album' => 'Ride The Lightning',
        ]);

        $response->assertStatus(200);
        $this->assertEquals(3, $response['points_awarded']);
    }


//Test 2: handles remastered/deluxe/etc.
    public function test_awards_full_points_even_without_remastered_or_deluxe_suffixes()
    {
        $songId = DB::table('songs')->insertGetId([
            'title' => 'Under the Bridge (Remastered)',
            'artist' => 'Red Hot Chili Peppers',
            'album' => 'Blood Sugar Sex Magik (Deluxe Edition)',
            'audio_snippet' => 'https://test-snippet.mp3',
            'genre' => 'Alternative Rock',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $sessionId = DB::table('game_sessions')->insertGetId([
            'genre' => 'Alternative Rock',
            'score' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->postJson('/api/guess', [
            'game_session_id' => $sessionId,
            'song_id' => $songId,
            'snippet_duration' => 15,
            'guessed_title' => 'Under the Bridge',
            'guessed_artist' => 'Red Hot Chili Peppers',
            'guessed_album' => 'Blood Sugar Sex Magik',
        ]);

        $response->assertStatus(200);
        $this->assertEquals(3, $response['points_awarded']);
    }
}
