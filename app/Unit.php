<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    //
    protected $fillable = ["name"];

    public $timestamps = false;

    public function ingredients()
    {
        return $this->hasMany('App\Ingredient', 'unit_id', 'id');
    }
}
