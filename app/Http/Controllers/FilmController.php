<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFilmRequest;
use App\Models\Category;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FilmController extends Controller
{

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Film API",
     *      description="Film API Documentation",
     *      @OA\Contact(
     *          email="paul.bouvignies@ynov.com",
     *          name="Paul Bouvignies"
     *     ),
     *     @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
     *
     *
     * @OA\Server(
     *     url="/api",
     *     description="Film API Server"
     * )
     *
     * @OA\Tag(
     *     name="Films",
     *     description="API Endpoints of Films"
     * )
     *
     *
     * @OA\Schema(
     *    schema="Film",
     *     required={"nom", "synopsis", "note", "date_de_sortie"},
     *     @OA\Property(
     *      property="nom",
     *      type="string",
     *      description="Nom du film"
     *     ),
     *     @OA\Property(
     *      property="synopsis",
     *      type="string",
     *      description="Synopsis du film"
     *     ),
     *     @OA\Property(
     *      property="note",
     *      type="number",
     *      description="Note du film"
     *     ),
     *     @OA\Property(
     *      property="date_de_sortie",
     *      type="string",
     *      format="date",
     *      description="Date de sortie du film"
     *     )
     * )
     *
     *
     *
     * @OA\Get(
     *     path="/films",
     *     summary="Get all films",
     *     tags={"Films"},
     *     @OA\Response(
     *     response=200,
     *     description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *               @OA\Items(ref="#/components/schemas/Film")
     *         )
     *    )
     * )
     *
     * @OA\Get(
     *      path="/films/{id}",
     *      summary="Get a film",
     *      tags={"Films"},
     *      @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="ID of the film",
     *      @OA\Schema(
     *      type="integer"
     *    )
     *  ),
     *      @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/Film")
     *  ),
     *      @OA\Response(
     *      response=404,
     *      description="Film not found"
     *  )
     *  )
     *
     *
     * @OA\Post(
     *     path="/films",
     *     summary="Create a film",
     *     tags={"Films"},
     *     @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Film")
     *   ),
     *     @OA\Response(
     *     response=201,
     *     description="Created",
     *  ),
     *     @OA\Response(
     *     response=422,
     *     description="Validation errors",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Property(
     *     property="success",
     *     type="boolean",
     *     example=false
     *     ),
     *     @OA\Property(
     *     property="message",
     *     type="string",
     *     example="Validation errors"
     *    ),
     *     )
     * )
     * )
     *
     * @OA\Put(
     *     path="/films/{id}",
     *     summary="Update a film",
     *     tags={"Films"},
     *     @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID of the film",
     *     @OA\Schema(
     *     type="integer"
     *   )
     * ),
     *     @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/Film")
     *  ),
     *     @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(ref="#/components/schemas/Film")
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Film not found"
     * )
     * )
     * @OA\Delete(
     *     path="/films/{id}",
     *     summary="Delete a film",
     *     tags={"Films"},
     *     @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID of the film",
     *     @OA\Schema(
     *     type="integer"
     *  )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="Success"
     * ),
     *     @OA\Response(
     *     response=404,
     *     description="Film not found"
     * )
     * )
     *
     *
     */
    public function index(Request $request)
    {

        $itemsPerPage = max(1, min(20, $request->input('items_per_page', 10)));
        $data = Film::paginate($request->input('per_page', $itemsPerPage));

        $data->each(function ($film) {
            $category = $film->categories;
            $film->linked_categorie = $category->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->nom,
                ];
            });
            unset($film->categories);
        });


        $meta_paginate = [
            'total' => $data->total(),
            'per_page' => $data->perPage(),
            'current_page' => $data->currentPage(),
            'prev_page_url' => $data->previousPageUrl(),
            'next_page_url' => $data->nextPageUrl(),
            'last_page' => $data->lastPage(),
        ];

        return response()->json($data);
    }

    public function getFilmCategory($id)
    {
        $film = Film::find($id);
        $categories = $film->categories;

        $categories->each(function ($film) {
            unset($film->pivot);
        });

        return response()->json($categories);
    }

    public function store(StoreFilmRequest $request)
    {


        $film = new Film();
        $film->nom = $request->nom;
        $film->synopsis = $request->synopsis;
        $film->note = $request->note;
        $film->date_de_sortie = $request->date_de_sortie;

        logger($request->all());
        if ($request->poster) {
            $file = $request->file('poster');
            $filename = uniqid() . '.' . $request->file('poster')->getClientOriginalExtension();
            $file->move(public_path('films/poster'), $filename);
            $film->poster = 'films/poster/' . $filename;
        }

        $film->save();
        return response()->json($film, 201);
    }

    public function show($id)
    {

        $film = $this->getFilm($id);

        if ($film) {
            return response()->json($film);
        } else {
            return response()->json([
                'message' => 'Film not found',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $film = $this->getFilm($id);
        if ($film) {


            $film->nom = $request->nom;
            $film->synopsis = $request->synopsis;
            $film->note = $request->note;
            $film->date_de_sortie = $request->date_de_sortie;
            $film->save();
            return response()->json($film);
        } else {
            return response()->json([
                'message' => 'Film not found',
            ], 404);
        }
    }

    public function destroy($id)
    {
        $film = $this->getFilm($id);
        if ($film) {
            $film->delete();
            return response()->json([
                'message' => 'Film deleted',
            ]);
        } else {
            return response()->json([
                'message' => 'Film not found',
            ], 404);
        }
    }

    protected function getFilm($id)
    {
        $film = Film::find($id);
        if (!$film) {
            return null;
        }

        return $film;
    }

}
