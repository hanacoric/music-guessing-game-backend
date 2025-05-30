<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GuessPointsTest extends TestCase
{
    use RefreshDatabase;

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
        $this->assertEquals(4, $response['points_awarded']);
    }

    public function test_awards_half_points_for_partial_matches()
    {
        $songId = DB::table('songs')->insertGetId([
            'title' => 'For Whom The Bell Tolls',
            'artist' => 'Metallica',
            'album' => 'Ride The Lightning',
            'audio_snippet' => 'https://test-snippet.mp3', //placeholder URL
            'genre' => 'Alternative Rock',
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
            'snippet_duration' => 30,
            'guessed_title' => 'For Whom The Bells Toll',
            'guessed_artist' => 'Metallica',
            'guessed_album' => 'Master Of Puppets',
        ]);

        $response->assertStatus(200);
        $this->assertEquals(1, $response['points_awarded']);

    }
}
