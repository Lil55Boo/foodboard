<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 🌿 Créer une liste fixe d’ingrédients
        $ingredientNames = [
            'Tomate', 'Oignon', 'Fromage', 'Poulet',
            'Pâtes', 'Crème', 'Laitue', 'Basilic',
            'Thon', 'Carotte', 'Poivron', 'Champignon'
        ];

        $ingredientIds = [];

        foreach ($ingredientNames as $name) {
            $ingredient = Ingredient::create(['name' => $name]);
            $ingredientIds[] = $ingredient->id;
        }

        // 🍽 Générer 10 recettes avec des ingrédients aléatoires
        for ($i = 1; $i <= 10; $i++) {
            $recipe = Recipe::create([
                'title' => "Recette #$i",
                'description' => "Une délicieuse recette numéro $i."
            ]);

            // Choisir entre 2 et 5 ingrédients aléatoires
            $randomIngredients = Arr::random($ingredientIds, rand(2, 5));

            // Associer les ingrédients à la recette
            $recipe->ingredients()->sync($randomIngredients);
        }
    }
}