<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

Route::apiResource('recipes', RecipeController::class);