<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Film;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Film::factory(200)->create();
        Category::factory(10)->create();

        $films = Film::all();

        foreach ($films as $film) {
            $film->categories()->attach(Category::inRandomOrder()->take(rand(1, 3))->pluck('id'));
        }


    }
}
