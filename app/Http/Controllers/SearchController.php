<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
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
