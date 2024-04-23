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

        $films = Film::where('nom', 'like', "%$query%")
            ->get();

        return response()->json($films);
    }
}
