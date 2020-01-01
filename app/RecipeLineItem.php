<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeLineItem extends Model
{
    //
    protected $fillable = ["recipe_id", "ingredient_id", "quantity", "unit_id", "comment"];

    public function unit()
    {
        return $this->hasOne('App\Unit', 'id', 'unit_id');
    }

    public function ingredient()
    {
        return $this->hasOne('App\Ingredient', 'id', 'ingredient_id');
    }

    public function recipes()
    {
        return $this->hasMany('App\Recipe', 'id', 'recipe_id');
    }
}
