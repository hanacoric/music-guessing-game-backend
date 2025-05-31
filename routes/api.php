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

// i know i shouldve used a database but i didnt have the time. sorry about that :/

$artistLists = [
    1 => [ // Alternative Rock
        'Radiohead', 'Red Hot Chili Peppers', 'Smashing Pumpkins', 'Foo Fighters', 'Alanis Morissette',
        'Beck', 'Blur', 'Oasis', 'The Cranberries', 'No Doubt', 'Sonic Youth', 'Mazzy Star',
        'R.E.M.', 'Jane’s Addiction', 'Bush', 'The Verve', 'Incubus', 'Lenny Kravitz',
        'Fiona Apple', 'Cake', 'The Breeders', 'PJ Harvey', 'Arctic Monkeys',
        'Kings of Leon', 'Muse', 'The Strokes', 'Faith No More', 'Green Day',
        'Queens of the Stone Age', 'Sublime', 'Ghost'
    ],
    2 => [ // Grunge
        'Nirvana', 'Pearl Jam', 'Soundgarden', 'Alice in Chains', 'Stone Temple Pilots',
        'Mudhoney', 'Temple of the Dog', 'Screaming Trees', 'Mother Love Bone', 'Hole',
        'Mad Season', 'Bush', 'Melvins', 'Silverchair', 'Meat Puppets'
    ],
    3 => [ // Metal
        'Metallica', 'Iron Maiden', 'Black Sabbath', 'Slayer', 'Megadeth', 'Pantera', 'Judas Priest',
        'Ozzy Osbourne', 'System of a Down', 'Korn', 'Slipknot', 'Tool', 'Avenged Sevenfold',
        'Linkin Park', 'Rammstein', 'Lamb of God', 'Disturbed', 'Sepultura', 'Mastodon',
        'Deftones', 'Anthrax', 'Dream Theater', 'Gojira', 'Amon Amarth', 'Opeth', 'Testament',
        'Bring Me the Horizon', 'Arch Enemy', 'Behemoth', 'Cannibal Corpse', 'Napalm Death',
        'Morbid Angel', 'Obituary'
    ],
    4 => [ // Classic Rock
        'The Beatles', 'Led Zeppelin', 'The Rolling Stones', 'Pink Floyd', 'Queen', 'Jimi Hendrix',
        'The Doors', 'David Bowie', 'Fleetwood Mac', 'The Who', 'Eagles', 'Eric Clapton',
        'Creedence Clearwater Revival', 'The Beach Boys', 'Bruce Springsteen', 'Lynyrd Skynyrd',
        'Aerosmith', 'Bob Dylan', 'Elton John', 'Neil Young', 'Deep Purple', 'The Kinks', 'Santana',
        'ZZ Top', 'Jefferson Airplane', 'Tom Petty and the Heartbreakers', 'Janis Joplin',
        'The Allman Brothers Band', 'Grateful Dead', 'Genesis', 'Chicago', 'Billy Joel',
        'Yes', 'Dire Straits', 'The Byrds', 'Supertramp', 'The Moody Blues', 'Bad Company',
        'Crosby, Stills, Nash & Young', 'Rod Stewart'
    ],
    5 => [ // New Wave
        'The Cure', 'Depeche Mode', 'Talking Heads', 'Duran Duran', 'The Police', 'Blondie',
        'New Order', 'The Smiths', 'Tears for Fears', 'A-ha', 'Eurythmics', 'INXS', 'Soft Cell',
        'Echo & the Bunnymen', 'Joy Division', 'Bow Wow Wow', 'The Go-Go’s'
    ],
    6 => [ // Shoegaze
        'My Bloody Valentine', 'Slowdive', 'Cocteau Twins', 'Ride', 'Lush', 'Deftones', 'TV Girl',
        'Beach House', 'Have a Nice Life', 'DIIV', 'Curve', 'The Jesus and Mary Chain'
    ],
    7 => [ // Hip Hop
        'Tupac Shakur', 'The Notorious B.I.G.', 'Nas', 'Jay-Z', 'Dr. Dre', 'Snoop Dogg', 'Ice Cube',
        'Wu-Tang Clan', 'A Tribe Called Quest', 'OutKast', 'Mobb Deep', 'The Fugees', 'Lauryn Hill',
        'Busta Rhymes', 'Cypress Hill', 'Beastie Boys', 'Public Enemy', 'Rakim', 'Method Man',
        'The Roots', 'Queen Latifah', 'Scarface', 'Quasimoto', 'MF Doom', 'Madvillain',
        'Lords of the Underground', 'Eminem'
    ],
    8 => [ // Pop
        'Madonna', 'Britney Spears', 'Taylor Swift', 'Beyoncé', 'Rihanna', 'Lady Gaga', 'Ariana Grande',
        'Justin Bieber', 'Katy Perry', 'Justin Timberlake', 'Ed Sheeran', 'Harry Styles',
        'Olivia Rodrigo', 'Dua Lipa', 'Miley Cyrus', 'Bruno Mars', 'Christina Aguilera',
        'Selena Gomez', 'Shawn Mendes', 'Camila Cabello', 'Sam Smith', 'Adele',
        'Ellie Goulding', 'Carly Rae Jepsen', 'Charli XCX', 'Meghan Trainor', 'Doja Cat',
        'Ava Max', 'Halsey', 'Mariah Carey', 'Celine Dion', 'Whitney Houston',
        'Janet Jackson', 'Kylie Minogue', 'George Michael', 'Robbie Williams',
        'Zara Larsson', 'Sabrina Carpenter', 'Rita Ora', 'Kelly Clarkson', 'Nelly Furtado'
    ],
    9 => [ // R&B
        'Marvin Gaye', 'Stevie Wonder', 'Aretha Franklin', 'Al Green', 'Otis Redding', 'Erykah Badu',
        'Jill Scott', "D'Angelo", 'Mary J. Blige', 'Alicia Keys', 'Usher', 'R. Kelly',
        'Brandy', 'Aaliyah', 'Ashanti', 'Daniel Caesar'
    ],
    10 => [ // Jazz
        'Miles Davis', 'John Coltrane', 'Louis Armstrong', 'Thelonious Monk', 'Charlie Parker',
        'Billie Holiday', 'Ella Fitzgerald', 'Nina Simone', 'Chet Baker', 'Dizzy Gillespie',
        'Herbie Hancock', 'Sarah Vaughan', 'Stan Getz', 'Dave Brubeck', 'Charles Mingus',
        'Sonny Rollins', 'Count Basie', 'Art Blakey', 'Oscar Peterson', 'Wayne Shorter',
        'Clifford Brown', 'Wynton Marsalis', 'Joe Henderson', 'Bill Evans'
    ],
    11 => [ // Punk
        'The Ramones', 'The Sex Pistols', 'The Clash', 'Dead Kennedys', 'Black Flag', 'Bad Brains',
        'Misfits', 'Buzzcocks', 'Minor Threat', 'Blink-182', 'The Offspring', 'Rancid',
        'Iggy Pop', 'The Stooges', 'Fugazi', 'Descendents', 'Social Distortion', 'Bad Religion',
        'The Damned', 'Anti-Flag', 'Against Me!', 'Alkaline Trio', 'The Germs', 'Youth Brigade',
        'The Cramps', 'Dropkick Murphys', 'Bikini Kill'
    ],
    12 => [ // Blues
        'B.B. King', 'Muddy Waters', 'Robert Johnson', 'Howlin’ Wolf', 'John Lee Hooker', 'Buddy Guy',
        'Stevie Ray Vaughan', 'Eric Clapton', 'Albert King', 'Freddie King', 'Etta James',
        'Willie Dixon', 'Elmore James', 'T-Bone Walker', 'Otis Rush', 'Junior Wells',
        'Big Mama Thornton', 'Lead Belly', 'Keb’ Mo’', 'Bonnie Raitt', 'Bo Diddley',
        'Lightnin’ Hopkins', 'Taj Mahal', 'Johnny Winter', 'Rory Gallagher', 'Koko Taylor',
        'Susan Tedeschi', 'Joe Bonamassa', 'J.J. Cale', 'John Mayall', 'Champion Jack Dupree',
        'Slim Harpo', 'Jimmy Reed'
    ],
    13 => [ // Reggae
        'Bob Marley', 'Peter Tosh', 'Jimmy Cliff', 'Burning Spear', 'Toots and the Maytals',
        'Black Uhuru', 'Steel Pulse', 'Dennis Brown', 'Gregory Isaacs', 'Bunny Wailer',
        'Culture', 'Lee "Scratch" Perry', 'Augustus Pablo', 'Sizzla', 'Damian Marley',
        'Ziggy Marley', 'Buju Banton', 'Shabba Ranks', 'Beenie Man', 'Capleton', 'Barrington Levy'
    ],
];


    if (!$genreId || !isset($artistLists[$genreId])) {
        return response()->json(['error' => 'Invalid or missing genre_id'], 400);
    }

    $genreName = $request->query('genre') ?? 'Unknown';

    $artists = $artistLists[$genreId];
    $randomArtist = $artists[array_rand($artists)];

    //Search for artist ID
    $artistSearch = Http::get('https://api.deezer.com/search/artist', [
        'q' => $randomArtist
    ]);

    $artistData = $artistSearch->json()['data'][0] ?? null;

    if (!$artistData || empty($artistData['id'])) {
        return response()->json(['error' => 'Artist not found on Deezer'], 404);
    }

    $artistId = $artistData['id'];

    //Get top songs by that artist
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
    $points = min($points, 3);

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
