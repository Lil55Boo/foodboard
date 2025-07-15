<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\RecipeController;

// Route::resource('recipes', RecipeController::class);

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

Route::get('/{any}', function () {
    return File::get(public_path('index.html'));
})->where('any', '.*');

use Illuminate\Support\Facades\Artisan;

Route::get('/run-seeder', function () {
    if (request()->get('key') !== 'super-secret-key') {
        abort(403, 'Unauthorized');
    }

    Artisan::call('migrate:fresh --seed'); // pour reset et insérer les données
    return 'Base de données réinitialisée et seeders exécutés ✅';
});