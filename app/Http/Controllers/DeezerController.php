<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeezerController extends Controller
{
    public function getSong(Request $request)
    {
        $genre = $request->query('genre');


// i know i shouldve used a database but i didnt have the time. sorry about that :/
        $genreArtists = [
            'Alternative Rock' => [
                'Radiohead', 'Red Hot Chili Peppers', 'Smashing Pumpkins', 'Foo Fighters', 'Alanis Morissette',
                'Beck', 'Blur', 'Oasis', 'The Cranberries', 'No Doubt', 'Sonic Youth', 'Mazzy Star', 'R.E.M.',
                'Jane’s Addiction', 'Bush', 'The Verve', 'Incubus', 'Lenny Kravitz', 'Fiona Apple', 'Cake',
                'The Breeders', 'PJ Harvey', 'Arctic Monkeys', 'Kings of Leon', 'Muse', 'The Strokes',
                'Faith No More', 'Green Day', 'Queens of the Stone Age', 'Sublime', 'Ghost',
            ],
            'Grunge' => [
                'Nirvana', 'Pearl Jam', 'Soundgarden', 'Alice in Chains', 'Stone Temple Pilots', 'Mudhoney',
                'Temple of the Dog', 'Screaming Trees', 'Mother Love Bone', 'Hole', 'Mad Season', 'Bush',
                'Melvins', 'Silverchair', 'Meat Puppets',
            ],
            'Metal' => [
                'Metallica', 'Iron Maiden', 'Black Sabbath', 'Slayer', 'Megadeth', 'Pantera', 'Judas Priest',
                'Ozzy Osbourne', 'System of a Down', 'Korn', 'Slipknot', 'Tool', 'Avenged Sevenfold',
                'Linkin Park', 'Rammstein', 'Dio', 'Lamb of God', 'Disturbed', 'Sepultura', 'Mastodon',
                'Deftones', 'Anthrax', 'Dream Theater', 'Gojira', 'Amon Amarth', 'Opeth', 'Testament',
                'Bring Me the Horizon', 'Arch Enemy', 'Behemoth', 'Cannibal Corpse', 'Napalm Death',
                'Morbid Angel', 'Obituary', 'Pantera',
            ],
            'Classic Rock' => [
                'The Beatles', 'Led Zeppelin', 'The Rolling Stones', 'Pink Floyd', 'Queen', 'Jimi Hendrix',
                'The Doors', 'David Bowie', 'Fleetwood Mac', 'The Who', 'Eagles', 'Eric Clapton',
                'Creedence Clearwater Revival', 'The Beach Boys', 'Bruce Springsteen', 'Lynyrd Skynyrd',
                'Aerosmith', 'Bob Dylan', 'Elton John', 'Neil Young', 'Deep Purple', 'The Kinks', 'Santana',
                'ZZ Top', 'Jefferson Airplane', 'Tom Petty and the Heartbreakers', 'Janis Joplin',
                'The Allman Brothers Band', 'Grateful Dead', 'Genesis', 'Chicago', 'Billy Joel', 'Yes',
                'Dire Straits', 'The Byrds', 'Supertramp', 'The Moody Blues', 'Bad Company',
                'Crosby, Stills, Nash & Young', 'Rod Stewart',
            ],
            'New Wave' => [
                'The Cure', 'Depeche Mode', 'Talking Heads', 'Duran Duran', 'The Police', 'Blondie',
                'New Order', 'The Smiths', 'Tears for Fears', 'A-ha', 'Eurythmics', 'INXS', 'Soft Cell',
                'Echo & the Bunnymen', 'Joy Division', 'Bow Wow Wow', 'The Go-Go’s',
            ],
            'Shoegaze' => [
                'My Bloody Valentine', 'Slowdive', 'Cocteau Twins', 'Ride', 'Lush', 'Deftones', 'TV Girl',
                'Beach House', 'Have a Nice Life', 'DIIV', 'Curve', 'The Jesus and Mary Chain',
            ],
            'Hip Hop' => [
                'Tupac Shakur', 'The Notorious B.I.G.', 'Nas', 'Jay-Z', 'Dr. Dre', 'Snoop Dogg', 'Ice Cube',
                'Wu-Tang Clan', 'A Tribe Called Quest', 'OutKast', 'Mobb Deep', 'The Fugees', 'Lauryn Hill',
                'Busta Rhymes', 'Cypress Hill', 'Beastie Boys', 'Public Enemy', 'Rakim', 'Method Man',
                'The Roots', 'Queen Latifah', 'Scarface', 'Quasimoto', 'MF Doom', 'Madvillain',
                'Lords of the Underground', 'Eminem', 'Outkast',
            ],
            'Pop' => [
                'Madonna', 'Britney Spears', 'Taylor Swift', 'Beyoncé', 'Rihanna', 'Lady Gaga',
                'Ariana Grande', 'Justin Bieber', 'Katy Perry', 'Justin Timberlake', 'Ed Sheeran',
                'Harry Styles', 'Olivia Rodrigo', 'Dua Lipa', 'Miley Cyrus', 'Bruno Mars',
                'Christina Aguilera', 'Selena Gomez', 'Shawn Mendes', 'Camila Cabello', 'Sam Smith',
                'Adele', 'Ellie Goulding', 'Carly Rae Jepsen', 'Charli XCX', 'Meghan Trainor', 'Doja Cat',
                'Ava Max', 'Halsey', 'Mariah Carey', 'Celine Dion', 'Whitney Houston', 'Janet Jackson',
                'Kylie Minogue', 'George Michael', 'Robbie Williams', 'Zara Larsson', 'Tove Lo', 'Kesha',
                'Troye Sivan', 'Normani', 'Bebe Rexha', 'Anne-Marie', 'Sabrina Carpenter', 'Rita Ora',
                'Alessia Cara', 'JoJo', 'Kelly Clarkson', 'Nelly Furtado',
            ],
            'R&B' => [
                'Marvin Gaye', 'Stevie Wonder', 'Aretha Franklin', 'Al Green', 'Otis Redding', 'Erykah Badu',
                'Jill Scott', "D'Angelo", 'Mary J. Blige', 'Alicia Keys', 'Usher', 'R. Kelly', 'Brandy',
                'Aaliyah', 'Ashanti', 'Daniel Caesar',
            ],
            'Jazz' => [
                'Miles Davis', 'John Coltrane', 'Louis Armstrong', 'Thelonious Monk', 'Charlie Parker',
                'Billie Holiday', 'Ella Fitzgerald', 'Nina Simone', 'Chet Baker', 'Dizzy Gillespie',
                'Herbie Hancock', 'Sarah Vaughan', 'Stan Getz', 'Dave Brubeck', 'Charles Mingus',
                'Sonny Rollins', 'Count Basie', 'Art Blakey', 'Oscar Peterson', 'Wayne Shorter',
                'Clifford Brown', 'Wynton Marsalis', 'Joe Henderson', 'Bill Evans',
            ],
            'Punk' => [
                'The Ramones', 'The Sex Pistols', 'The Clash', 'Dead Kennedys', 'Black Flag', 'Bad Brains',
                'Misfits', 'Buzzcocks', 'Minor Threat', 'Blink-182', 'The Offspring', 'Rancid', 'Iggy Pop',
                'The Stooges', 'Fugazi', 'Descendents', 'Social Distortion', 'Bad Religion', 'The Damned',
                'Anti-Flag', 'Against Me!', 'Alkaline Trio', 'The Germs', 'Youth Brigade', 'The Cramps',
                'Dropkick Murphys', 'Bikini Kill',
            ],
            'Blues' => [
                'B.B. King', 'Muddy Waters', 'Robert Johnson', 'Howlin’ Wolf', 'John Lee Hooker', 'Buddy Guy',
                'Stevie Ray Vaughan', 'Eric Clapton', 'Albert King', 'Freddie King', 'Etta James',
                'Willie Dixon', 'Elmore James', 'T-Bone Walker', 'Otis Rush', 'Junior Wells',
                'Big Mama Thornton', 'Lead Belly', 'Keb’ Mo’', 'Bonnie Raitt', 'Bo Diddley',
                'Lightnin’ Hopkins', 'Taj Mahal', 'Johnny Winter', 'Rory Gallagher', 'Koko Taylor',
                'Susan Tedeschi', 'Joe Bonamassa', 'J.J. Cale', 'John Mayall', 'Champion Jack Dupree',
                'Slim Harpo', 'Jimmy Reed',
            ],
            'Reggae' => [
                'Bob Marley', 'Peter Tosh', 'Jimmy Cliff', 'Burning Spear', 'Toots and the Maytals',
                'Black Uhuru', 'Steel Pulse', 'Dennis Brown', 'Gregory Isaacs', 'Bunny Wailer', 'Culture',
                'Lee "Scratch" Perry', 'Augustus Pablo', 'Sizzla', 'Damian Marley', 'Ziggy Marley',
                'Buju Banton', 'Shabba Ranks', 'Beenie Man', 'Capleton', 'Barrington Levy',
            ],
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