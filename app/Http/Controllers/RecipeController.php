<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    // Affiche toutes les recettes
    public function index(Request $request)
    {
        $ingredientName = $request->query('ingredient');
    
        if ($ingredientName) {
            // Si un ingrédient est spécifié dans l'URL, on filtre les recettes qui le contiennent
            $recipes = Recipe::whereHas('ingredients', function ($query) use ($ingredientName) {
                $query->where('name', $ingredientName);
            })->get();
        } else {
            // Sinon, on retourne toutes les recettes
            $recipes = Recipe::all();
        }
    
        return response()->json($recipes);
    }

    // Affiche une recette spécifique
    public function show($id)
    {
    $recipe = Recipe::with('ingredients')->findOrFail($id);
    return response()->json($recipe);
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('recipes.create');
    }

    // Enregistre une nouvelle recette
    public function store(Request $request)
    {
    $validated = $request->validate([
        'title' => 'required|max:255',
        'description' => 'nullable|string',
    ]);

    $recipe = Recipe::create($validated);

    return response()->json([
        'message' => 'Recette créée avec succès !',
        'recipe' => $recipe
    ], 201);
    }

    public function update(Request $request, $id)
    {
    $recipe = Recipe::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|max:255',
        'description' => 'nullable|string',
    ]);

    $recipe->update($validated);

    return response()->json([
        'message' => 'Recette mise à jour avec succès !',
        'recipe' => $recipe
    ]);
    }
}