<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // run the seeder
        $this->call(FilmSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CategoryFilmSeeder::class);
    }
}
