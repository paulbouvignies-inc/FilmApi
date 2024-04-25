<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Comedy',
            'Fantasy',
            'Crime',
            'Drama',
            'Music',
            'Adventure',
            'History',
            'Thriller',
            'Animation',
            'Family',
            'Mystery',
            'Biography',
            'Action',
            'Film-Noir',
            'Romance',
            'Sci-Fi',
            'War',
            'Western',
            'Horror',
            'Musical',
            'Sport',
        ];

        foreach ($genres as $genre) {
            Category::create([
                'nom' => $genre,
            ]);
        }

    }
}
