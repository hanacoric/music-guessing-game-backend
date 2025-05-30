<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('songs')->insert([
            [
                'title' => 'Would?',
                'artist' => 'Alice in Chains',
                'album' => 'Dirt',
                'genre' => 'Grunge',
                'release_year' => 1992,
                'audio_snippet' => 'audio/would.mp3',
            ],
            [
                'title' => 'Even Flow',
                'artist' => 'Pearl Jam',
                'album' => 'Ten',
                'genre' => 'Grunge',
                'release_year' => 1991,
                'audio_snippet' => 'audio/even_flow.mp3',
            ],
            [
                'title' => 'Spoonman',
                'artist' => 'Soundgarden',
                'album' => 'Superunknown',
                'genre' => 'Grunge',
                'release_year' => 1994,
                'audio_snippet' => 'audio/spoonman.mp3',
            ],
            [
                'title' => 'Heart-Shaped Box',
                'artist' => 'Nirvana',
                'album' => 'In Utero',
                'genre' => 'Grunge',
                'release_year' => 1993,
                'audio_snippet' => 'audio/heart_shaped_box.mp3',
            ],
            [
                'title' => 'Creep',
                'artist' => 'Stone Temple Pilots',
                'album' => 'Core',
                'genre' => 'Grunge',
                'release_year' => 1992,
                'audio_snippet' => 'audio/creep.mp3',
            ],

            [
                'title' => 'Universally Speaking',
                'artist' => 'Red Hot Chili Peppers',
                'album' => 'By the Way',
                'genre' => 'Alternative Rock',
                'release_year' => 2002,
                'audio_snippet' => 'audio/universally_speaking.mp3',
            ],
            [
                'title' => 'Everlong',
                'artist' => 'Foo Fighters',
                'album' => 'The Colour and the Shape',
                'genre' => 'Alternative Rock',
                'release_year' => 1997,
                'audio_snippet' => 'audio/everlong.mp3',
            ],
            [
                'title' => 'Jigsaw Falling Into Place',
                'artist' => 'Radiohead',
                'album' => 'In Rainbows',
                'genre' => 'Alternative Rock',
                'release_year' => 2007,
                'audio_snippet' => 'audio/jigsaw_falling_into_place.mp3',
            ],
            [
                'title' => '1979',
                'artist' => 'The Smashing Pumpkins',
                'album' => 'Mellon Collie and the Infinite Sadness',
                'genre' => 'Alternative Rock',
                'release_year' => 1995,
                'audio_snippet' => 'audio/1979.mp3',
            ],
            [
                'title' => 'Fade Into You',
                'artist' => 'Mazzy Star',
                'album' => 'So Tonight That I Might See',
                'genre' => 'Alternative Rock',
                'release_year' => 1993,
                'audio_snippet' => 'audio/fade_into_you.mp3',
            ],
            [
                'title' => 'Toxicity',
                'artist' => 'System of a Down',
                'album' => 'Toxicity',
                'genre' => 'Metal',
                'release_year' => 2001,
                'audio_snippet' => 'audio/toxicity.mp3',
            ],
            [
                'title' => 'Fade to Black',
                'artist' => 'Metallica',
                'album' => 'Ride the Lightning',
                'genre' => 'Metal',
                'release_year' => 1984,
                'audio_snippet' => 'audio/fade_to_black.mp3',
            ],
            [
                'title' => 'Holy Diver',
                'artist' => 'Dio',
                'album' => 'Holy Diver',
                'genre' => 'Metal',
                'release_year' => 1983,
                'audio_snippet' => 'audio/holy_diver.mp3',
            ],
            [
                'title' => 'War Pigs',
                'artist' => 'Black Sabbath',
                'album' => 'Paranoid',
                'genre' => 'Metal',
                'release_year' => 1970,
                'audio_snippet' => 'audio/war_pigs.mp3',
            ],
            [
                'title' => 'Cowboys from Hell',
                'artist' => 'Pantera',
                'album' => 'Cowboys from Hell',
                'genre' => 'Metal',
                'release_year' => 1990,
                'audio_snippet' => 'audio/cowboys_from_hell.mp3',
            ],
            [
                'title' => 'Have a Cigar',
                'artist' => 'Pink Floyd',
                'album' => 'Wish You Were Here',
                'genre' => 'Psychedelic Rock',
                'release_year' => 1975,
                'audio_snippet' => 'audio/have_a_cigar.mp3',
            ],
            [
                'title' => 'Little Wing',
                'artist' => 'Jimi Hendrix',
                'album' => 'Axis: Bold as Love',
                'genre' => 'Psychedelic Rock',
                'release_year' => 1967,
                'audio_snippet' => 'audio/little_wing.mp3',
            ],
            [
                'title' => 'White Rabbit',
                'artist' => 'Jefferson Airplane',
                'album' => 'Surrealistic Pillow',
                'genre' => 'Psychedelic Rock',
                'release_year' => 1967,
                'audio_snippet' => 'audio/white_rabbit.mp3',
            ],
            [
                'title' => 'Light My Fire',
                'artist' => 'The Doors',
                'album' => 'The Doors',
                'genre' => 'Psychedelic Rock',
                'release_year' => 1967,
                'audio_snippet' => 'audio/light_my_fire.mp3',
            ],
            [
                'title' => 'Strawberry Fields Forever',
                'artist' => 'The Beatles',
                'album' => 'Magical Mystery Tour',
                'genre' => 'Psychedelic Rock',
                'release_year' => 1967,
                'audio_snippet' => 'audio/strawberry_fields_forever.mp3',
            ],
            [
                'title' => 'Shook Ones Pt. II',
                'artist' => 'Mobb Deep',
                'album' => 'The Infamous',
                'genre' => 'Hip Hop',
                'release_year' => 1995,
                'audio_snippet' => 'audio/shook_ones_pt2.mp3',
            ],
            [
                'title' => '93 Til Infinity',
                'artist' => 'Souls of Mischief',
                'album' => '93 Til Infinity',
                'genre' => 'Hip Hop',
                'release_year' => 1993,
                'audio_snippet' => 'audio/93_til_infinity.mp3',
            ],
            [
                'title' => 'Check the Rhime',
                'artist' => 'A Tribe Called Quest',
                'album' => 'The Low End Theory',
                'genre' => 'Hip Hop',
                'release_year' => 1991,
                'audio_snippet' => 'audio/check_the_rhyme.mp3',
            ],
            [
                'title' => 'Doomsday',
                'artist' => 'MF DOOM',
                'album' => 'Operation: Doomsday',
                'genre' => 'Hip Hop',
                'release_year' => 1999,
                'audio_snippet' => 'audio/doomsday.mp3',
            ],
            [
                'title' => 'The World Is Yours',
                'artist' => 'Nas',
                'album' => 'Illmatic',
                'genre' => 'Hip Hop',
                'release_year' => 1994,
                'audio_snippet' => 'audio/the_world_is_yours.mp3',
            ],
        ]);
    }
}
