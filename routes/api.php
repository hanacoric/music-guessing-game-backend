<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

Route::get('/test', function () {
    return response()->json(['message' => 'Test endpoint is working!']);
});

Route::get('/deezer/song', function (Request $request) {
    $genreId = $request->query('genre_id');

    $artistLists = [
        152 => ['Nirvana', 'Alice In Chains', 'Pearl Jam', 'Soundgarden', 'Stone Temple Pilots'],
        464 => ['Metallica', 'Black Sabbath', 'Pantera', 'Megadeth', 'Slayer'],
        116 => ['Nas', 'MF DOOM', 'Wu-Tang Clan', 'A Tribe Called Quest', 'Souls of Mischief'],
        85  => ['My Bloody Valentine', 'Cocteau Twins', 'Slowdive', 'Deftones', 'TV Girl'],
        132 => ['Talking Heads', 'Eurythmics', 'Blondie', 'Depeche Mode', 'The Cure'],
        77  => ['Led Zeppelin', 'Queen', 'David Bowie', 'The Rolling Stones', 'Fleetwood Mac'],
        1521 => ['Red Hot Chili Peppers', 'Radiohead', 'Smashing Pumpkins', 'Foo Fighters', 'Jeff Buckley'],
        999 => ['Oasis', 'Blur', 'The Strokes', 'The Pixies', 'Arctic Monkeys'],
        888 => ['Korn', 'Slipknot', 'System of a Down', 'Linkin Park', 'Limp Bizkit'],
        133 => ['Jimi Hendrix', 'Pink Floyd', 'Jefferson Airplane', 'The Doors', 'The Beatles']
    ];

    if (!$genreId || !isset($artistLists[$genreId])) {
        return response()->json(['error' => 'Invalid or missing genre_id'], 400);
    }

    $genreName = $request->query('genre') ?? 'Unknown';

    $artists = $artistLists[$genreId];
    $randomArtist = $artists[array_rand($artists)];

    // Step 1: Search for artist ID
    $artistSearch = Http::get('https://api.deezer.com/search/artist', [
        'q' => $randomArtist
    ]);

    $artistData = $artistSearch->json()['data'][0] ?? null;

    if (!$artistData || empty($artistData['id'])) {
        return response()->json(['error' => 'Artist not found on Deezer'], 404);
    }

    $artistId = $artistData['id'];

    // Step 2: Get top songs by that artist
    $songSearch = Http::get("https://api.deezer.com/artist/$artistId/top?limit=20");

    $results = $songSearch->json()['data'] ?? [];

    if (empty($results)) {
        return response()->json(['error' => 'No songs found for artist'], 404);
    }

    $song = $results[array_rand($results)];

    if (
        empty($song['title']) || empty($song['artist']['name']) ||
        empty($song['album']['title']) || empty($song['preview'])
    ) {
        return response()->json(['error' => 'Incomplete song data from Deezer'], 422);
    }

    $existing = DB::table('songs')->where('title', $song['title'])->where('artist', $song['artist']['name'])->first();

    if (!$existing) {
        $songId = DB::table('songs')->insertGetId([
            'title' => $song['title'],
            'artist' => $song['artist']['name'],
            'album' => $song['album']['title'],
            'audio_snippet' => $song['preview'],
            'genre' => $genreName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    } else {
        $songId = $existing->id;
    }

    return response()->json([
        'id' => $songId,
        'title' => $song['title'],
        'artist' => $song['artist']['name'],
        'album' => $song['album']['title'],
        'audio_snippet' => $song['preview']
    ]);
});

Route::get('/ping', fn() => response()->json(['message' => 'pong']));

Route::post('/game/start', function (Request $request) {
    $genre = $request->input('genre');

    $id = DB::table('game_sessions')->insertGetId([
        'genre' => $genre,
        'score' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json(['game_session_id' => $id]);
});

Route::post('/guess', function (Request $request) {
    $data = $request->all();

    if (!isset($data['song_id'])) {
        return response()->json(['error' => 'Missing song_id'], 400);
    }

    $song = DB::table('songs')->find($data['song_id']);
    if (!$song) {
        return response()->json(['error' => 'Song not found'], 404);
    }

    $duration = isset($data['snippet_duration']) ? (int)$data['snippet_duration'] : 30;

    $multiplier = match ($duration) {
        5 => 1.5,
        15 => 1.25,
        30 => 1,
        default => 1
    };

    $normalize = function ($value) {
        $value = strtolower($value);

        // Remove anything in parentheses or brackets (e.g., "(Remastered)", "[Deluxe Edition]")
        $value = preg_replace('/[\(\[].*?[\)\]]/', '', $value);

        // Remove common keywords even if they appear outside brackets
        $value = preg_replace('/\b(remaster(ed)?( \d{4})?|deluxe|version|edition|explicit|greatest hits|best of|essential|gold|collection|anthology|singles|expanded|original recording)\b/i', '', $value);

        // Remove special characters
        $value = preg_replace('/[^a-z0-9\s]/', '', $value);

        // Collapse multiple spaces
        $value = preg_replace('/\s+/', ' ', $value);

        return trim($value);
    };


    $normalizedGuesses = [
        'title' => $normalize($data['guessed_title'] ?? ''),
        'artist' => $normalize($data['guessed_artist'] ?? ''),
        'album' => $normalize($data['guessed_album'] ?? ''),
    ];

    $normalizedCorrect = [
        'title' => $normalize($song->title),
        'artist' => $normalize($song->artist),
        'album' => $normalize($song->album),
    ];

    $rawPoints = 0;

    if ($normalizedGuesses['title'] === $normalizedCorrect['title']) {
        $rawPoints += 1;
    }
    if ($normalizedGuesses['artist'] === $normalizedCorrect['artist']) {
        $rawPoints += 1;
    }
    if ($normalizedGuesses['album'] === $normalizedCorrect['album']) {
        $rawPoints += 1;
    }

    $duration = isset($data['snippet_duration']) ? (int)$data['snippet_duration'] : 30;

    $multiplier = match ($duration) {
        5 => 1.5,
        15 => 1.25,
        30 => 1,
        default => 1
    };

    $points = round($rawPoints);
    $points = min($points, 3); // Don't go over 3 even with multiplier

    DB::table('guesses')->insert([
        'game_session_id' => $data['game_session_id'],
        'song_id' => $data['song_id'],
        'guessed_title' => $data['guessed_title'],
        'guessed_artist' => $data['guessed_artist'],
        'guessed_album' => $data['guessed_album'],
        'points_awarded' => $points,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DB::table('game_sessions')->where('id', $data['game_session_id'])->increment('score', $points);

    return response()->json([
        'points_awarded' => $points,
        'correct' => [
            'title' => $song->title,
            'artist' => $song->artist,
            'album' => $song->album
        ]
    ]);
});

Route::get('/game/score/{game_session_id}', function ($game_session_id) {
    $score = DB::table('game_sessions')->where('id', $game_session_id)->value('score');
    return response()->json(['score' => $score]);
});