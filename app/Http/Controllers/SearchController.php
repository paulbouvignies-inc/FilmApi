<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @OA\Tag(
     *      name="Search",
     *      description="Search for films",
     *  )
     *
     * @OA\Get(
     *     path="/search",
     *     tags={"Search"},
     *     summary="Search for films",
     *     operationId="search",
     *
     *     @OA\Parameter(
     *     name="q",
     *     in="query",
     *     description="Search query",
     *     required=true,
     *
     *     @OA\Schema(
     *     type="string"
     *    )
     *  ),
     *
     *     @OA\Response(
     *     response=200,
     *     description="Successful operation",
     *
     *     @OA\JsonContent(
     *     type="array",
     *
     *     @OA\Items(ref="#/components/schemas/Film")
     *   )
     * ),
     *
     *     @OA\Response(
     *     response=404,
     *     description="No films found",
     *
     *     @OA\JsonContent(
     *     type="object",
     *
     *     @OA\Property(
     *     property="message",
     *     type="string"
     *   )
     * )
     *
     *)
     * )
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (! $query) {
            return response()->json([
                'message' => 'search paramater is missing',
            ], 404);
        }

        $films = Film::where('title', 'like', "%$query%")
            ->orWhere('plot', 'like', "%$query%")
            ->orWhere('director', 'like', "%$query%")
            ->get();

        if ($films->isEmpty()) {
            return response()->json([
                'message' => 'No films found matching the search query',
            ], 404);
        }

        return response()->json($films);
    }
}
