<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\RecipeController;

// Route::resource('recipes', RecipeController::class);

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

Route::get('/{any}', function () {
    return File::get(public_path('index.html'));
})->where('any', '.*');