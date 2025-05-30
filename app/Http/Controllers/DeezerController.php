<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeezerController extends Controller
{
    public function getSong(Request $request)
    {
        $genre = $request->query('genre');

        $genreArtists = [
            'Alternative Rock' => ['Red Hot Chili Peppers', 'Radiohead', 'Smashing Pumpkins', 'Foo Fighters', 'Jeff Buckley'],
            'Psychedelic Rock' => ['Jimi Hendrix', 'Pink Floyd', 'Jefferson Airplane', 'The Doors', 'The Beatles'],
            'Classic Rock' => ['Led Zeppelin', 'Queen', 'David Bowie', 'The Rolling Stones', 'Fleetwood Mac'],
            'Grunge' => ['Alice in Chains', 'Nirvana', 'Soundgarden', 'Pearl Jam', 'Stone Temple Pilots'],
            'Metal' => ['Metallica', 'Black Sabbath', 'Pantera', 'Megadeth', 'Slayer'],
            'Nu Metal' => ['Korn', 'Slipknot', 'System of a Down', 'Linkin Park', 'Limp Bizkit'],
            'New Wave' => ['Talking Heads', 'Eurythmics', 'Blondie', 'Depeche Mode', 'The Cure'],
            'Shoegaze' => ['My Bloody Valentine', 'Cocteau Twins', 'Slowdive', 'Deftones', 'TV Girl'],
            'Indie Rock' => ['Oasis', 'Blur', 'The Strokes', 'The Pixies', 'Arctic Monkeys'],
            'Hip Hop' => ['Souls of Mischief', 'A Tribe Called Quest', 'Nas', 'MF DOOM', 'Wu-Tang Clan']
        ];

        if (!isset($genreArtists[$genre])) {
            return response()->json(['error' => 'Genre not supported'], 400);
        }

        $randomArtist = collect($genreArtists[$genre])->random();

        // Step 1: Search for the artist
        $artistSearch = Http::get("https://api.deezer.com/search/artist?q=" . urlencode($randomArtist));
        $artistData = $artistSearch->json()['data'][0] ?? null;

        if (!$artistData) {
            return response()->json(['error' => 'Artist not found on Deezer'], 404);
        }

        $artistId = $artistData['id'];

        // Step 2: Get top tracks
        $topTracksResponse = Http::get("https://api.deezer.com/artist/{$artistId}/top?limit=10");
        $topTracks = $topTracksResponse->json()['data'] ?? [];

        if (empty($topTracks)) {
            return response()->json(['error' => 'No top tracks found for artist'], 404);
        }

        $track = collect($topTracks)->random();

        return response()->json([
            'id' => $track['id'],
            'title' => $track['title'],
            'artist' => $track['artist']['name'],
            'album' => $track['album']['title'],
            'release_date' => $track['release_date'] ?? null,
            'preview' => $track['preview'],
        ]);
    }
}

