<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Film;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();

        // get films for each category
        $categories->each(function ($category) {
            $films = $category->films;
            $category->linked_films = $films->map(function ($film) {
                return [
                    'id' => $film->id,
                ];
            });
            unset($category->films);
        });

        return response()->json($categories);
    }
    public function getCatgory($id)
    {

        $category = Category::find($id);
        $films = $category->films;

        $films->each(function ($film) {
            $category = $film->categories;
            $film->linked_categorie = $category->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->nom,
                ];
            });
            unset($film->categories);
            unset($film->pivot);
        });

        return response()->json($films);

    }

}
