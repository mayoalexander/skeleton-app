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
    $query = Recipe::query();

    if ($request->filled('email')) {
        $query->where('email', $request->email);
    }

    if ($request->filled('keyword')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'LIKE', "%{$request->keyword}%")
                ->orWhere('description', 'LIKE', "%{$request->keyword}%")
                ->orWhere('ingredients', 'LIKE', "%{$request->keyword}%")
                ->orWhere('steps', 'LIKE', "%{$request->keyword}%");
        });
    }

    if ($request->filled('ingredient')) {
        $query->where('ingredients', 'LIKE', "%{$request->ingredient}%");
    }

    return response()->json($query->paginate(5)); // Change 5 to desired per-page value
});
