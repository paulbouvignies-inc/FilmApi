<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Film;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

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
