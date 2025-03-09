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
    // Require at least one search parameter.
    if (!$request->filled('keyword') && !$request->filled('ingredient') && !$request->filled('author_email')) {
        return response()->json(['error' => 'At least one search parameter is required'], 400);
    }

    // Use the provided keyword, or empty string if none.
    $keyword = $request->input('keyword', '');

    // Begin the Algolia search using Laravel Scout.
    $searchQuery = Recipe::search($keyword);

    // Apply filtering for the author's email if provided.
    if ($request->filled('author_email')) {
        $email = strtolower(trim($request->input('author_email')));
        $searchQuery->where('author_email', $email);
    }

    // Apply filtering for ingredient if provided.
    // This assumes that your indexed recipe includes an "ingredients" attribute
    // that is a flat array or string you can filter against.
    if ($request->filled('ingredient')) {
        $ingredient = $request->input('ingredient');
        $searchQuery->where('ingredients', $ingredient);
    }

    // Execute the search with pagination.
    $recipes = $searchQuery->paginate(10);

    return response()->json($recipes);
});