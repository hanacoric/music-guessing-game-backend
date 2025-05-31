<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run()
    {
        Genre::truncate();

        $genres = [
            ['name' => 'Alternative Rock', 'deezer_id' => 1],
            ['name' => 'Grunge', 'deezer_id' => 2],
            ['name' => 'Metal', 'deezer_id' => 3],
            ['name' => 'Classic Rock', 'deezer_id' => 4],
            ['name' => 'New Wave', 'deezer_id' => 5],
            ['name' => 'Shoegaze', 'deezer_id' => 6],
            ['name' => 'Hip Hop', 'deezer_id' => 7],
            ['name' => 'Pop', 'deezer_id' => 8],
            ['name' => 'R&B', 'deezer_id' => 9],
            ['name' => 'Jazz', 'deezer_id' => 10],
            ['name' => 'Punk', 'deezer_id' => 11],
            ['name' => 'Blues', 'deezer_id' => 12],
            ['name' => 'Reggae', 'deezer_id' => 13],
            ['name' => 'Soul & Funk', 'deezer_id' => 14],
        ];

        DB::table('genres')->insert($genres);
    }
}
