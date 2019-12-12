<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    //
    protected $fillable = ["user_id", "name", "portions", "portion_size", "is_draft"];

    public function recipeLineItems()
    {
        return $this->hasMany('App\RecipeLineItem', 'recipe_id', 'id');
    }

    public function preparationSteps(){
        return $this->hasMany('App\PreparationStep', 'recipe_id', 'id');
    }
}
