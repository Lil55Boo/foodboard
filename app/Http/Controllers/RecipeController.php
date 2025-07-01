<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    // Affiche toutes les recettes
    public function index()
    {
        $recipes = Recipe::all();
        return view('recipes.index', compact('recipes'));
    }

    // Affiche une recette spécifique
    public function show($id)
    {
        $recipe = Recipe::findOrFail($id);
        return view('recipes.show', compact('recipe'));
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

        Recipe::create($validated);

        return redirect()->route('recipes.index')->with('success', 'Recette créée !');
    }
}