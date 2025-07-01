<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class IngredientRecipe extends Pivot
{

    protected $fillable = [];


    public $timestamps = false; 
}