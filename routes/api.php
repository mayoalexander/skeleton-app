<?php

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/recipes/search', function (Request $request) {
    if (!$request->filled('keyword')) {
        return response()->json(['error' => 'Keyword is required'], 400);
    }

    // Step 1: Get IDs from Algolia Search
    $recipeIds = Recipe::search($request->keyword)->get()->pluck('id');

    // Step 2: Fetch Full Recipes from Database with Relationships
    $recipes = Recipe::whereIn('id', $recipeIds)
        ->with(['ingredients', 'steps'])
        ->paginate(10);

    return response()->json($recipes);
});
