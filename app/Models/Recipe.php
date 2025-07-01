<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ingredient;

class Recipe extends Model
{
    // Champs autorisés à être remplis en masse
    protected $fillable = [
        'title',
        'description',
    ];

    // Relation plusieurs-à-plusieurs avec les ingrédients
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_recipe', 'recipe_id', 'ingredient_id');
    }
}