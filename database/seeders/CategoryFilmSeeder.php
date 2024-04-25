<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Film;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CategoryFilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $films = Film::all();

        foreach ($films as $film) {
            $film->categories()->attach(Category::inRandomOrder()->take(rand(1, 3))->pluck('id'));
        }

    }
}
