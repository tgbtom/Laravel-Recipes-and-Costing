<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    //
    protected $fillable = ["name", "cost_per_unit", "yield_percent", "unit_id"];


    public function unit()
    {
        return $this->hasOne('App\Unit', 'id', 'unit_id');
    }

}
