<?php

use App\Models\Ingredient;
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



Route::get('/ingredients', function (Request $request) {
    $ingredients = Ingredient::all();
    return response()->json($ingredients);
});


Route::get('/recipes/search', function (Request $request) {
    $query = Recipe::query();

    if (!$request->filled('keyword') && !$request->filled('ingredient') && !$request->filled('author_email')) {
        $allRecipes = Recipe::paginate();
        // $allRecipes = Recipe::all();
        return response()->json($allRecipes);
    }

    if ($request->filled('author_email')) {
        $email = strtolower(trim($request->input('author_email')));
        $query->whereRaw('LOWER(email) = ?', [$email]);
    }

    if ($request->filled('ingredient')) {
        $ingredient = $request->input('ingredient');
        $query->whereHas('ingredients', function ($q) use ($ingredient) {
            $q->where('name', 'LIKE', "%{$ingredient}%");
        });
    }

    if ($request->filled('keyword')) {
        $keyword = $request->input('keyword');
        $query->where(function ($q) use ($keyword) {
            $q->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%")
                ->orWhereHas('ingredients', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                })
                ->orWhereHas('steps', function ($q) use ($keyword) {
                    $q->where('description', 'LIKE', "%{$keyword}%");
                });
        });
    }

    $recipes = $query->with(['ingredients', 'steps'])->paginate(10);

    return response()->json($recipes);
});
