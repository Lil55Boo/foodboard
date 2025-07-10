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
        // Si un ingrédient est spécifié, on filtre les recettes qui le contiennent
        $recipes = Recipe::whereHas('ingredients', function ($query) use ($ingredientName) {
            $query->where('name', $ingredientName);
        })->with('ingredients')->get(); // <-- ajout ici
    } else {
        // Sinon, on retourne toutes les recettes avec leurs ingrédients
        $recipes = Recipe::with('ingredients')->get(); // <-- ajout ici
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
        'ingredients' => 'array'  // On autorise un tableau d’ingrédients
    ]);

    $recipe = Recipe::create([
        'title' => $validated['title'],
        'description' => $validated['description'] ?? null,
    ]);

    if (!empty($validated['ingredients'])) {
        $ingredientIds = [];
        foreach ($validated['ingredients'] as $ingredientName) {
            $ingredient = \App\Models\Ingredient::firstOrCreate(['name' => $ingredientName]);
            $ingredientIds[] = $ingredient->id;
        }
        $recipe->ingredients()->sync($ingredientIds);
    }

    return response()->json([
        'message' => 'Recette créée avec succès !',
        'recipe' => $recipe->load('ingredients')  // On renvoie la recette avec ingrédients liés
    ], 201);
    }

    public function update(Request $request, $id)
    {
    $recipe = Recipe::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|max:255',
        'description' => 'nullable|string',
        'ingredients' => 'array'  // Autorise un tableau d’ingrédients
    ]);

    $recipe->update([
        'title' => $validated['title'],
        'description' => $validated['description'] ?? null,
    ]);

    if (isset($validated['ingredients'])) {
        $ingredientIds = [];
        foreach ($validated['ingredients'] as $ingredientName) {
            $ingredient = \App\Models\Ingredient::firstOrCreate(['name' => $ingredientName]);
            $ingredientIds[] = $ingredient->id;
        }
        $recipe->ingredients()->sync($ingredientIds);
    }

    return response()->json([
        'message' => 'Recette mise à jour avec succès !',
        'recipe' => $recipe->load('ingredients')
    ]);
    }

    public function destroy($id)
    {
    $recipe = Recipe::findOrFail($id);  // Trouve la recette ou lance une 404 si pas trouvée

    $recipe->delete();  // Supprime la recette

    return response()->json([
        'message' => 'Recette supprimée avec succès !'
    ]);
    }
}