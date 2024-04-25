<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Film;

class CategoryController extends Controller
{
    /**
     * @OA\Tag(
     *     name="Category",
     *     description="Category API"
     * )
     *
     * @OA\Get(
     *     path="/categories",
     *     tags={"Category"},
     *     summary="Get all categories",
     *     operationId="index",
     *
     *     @OA\Response(
     *     response=200,
     *     description="Successful operation",
     *
     *     @OA\JsonContent(
     *     type="array",
     *
     *     @OA\Items(ref="#/components/schemas/Category")
     *  )
     * )
     * )
     *
     * @OA\Get(
     *     path="/categories/{id}",
     *     tags={"Category"},
     *     summary="Get films by category",
     *     operationId="getCatgory",
     *
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Category ID",
     *      required=true,
     *
     *      @OA\Schema(
     *          type="integer"
     *      )
     *     ),
     *
     *     @OA\Response(
     *      response=200,
     *      description="Successful operation",
     *
     *     @OA\JsonContent(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/Film")
     *          )
     * ),
     *
     *     @OA\Response(
     *     response=404,
     *     description="Category not found",
     *
     *     @OA\JsonContent(
     *     type="object",
     *
     *     @OA\Property(
     *     property="message",
     *     type="string"
     *  )
     * )
     * )
     * )
     */
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
