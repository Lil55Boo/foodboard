<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Recipe;

class Ingredient extends Model
{
    protected $fillable = [
    'name',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'ingredient_recipe', 'ingredient_id', 'recipe_id');
    }
}
