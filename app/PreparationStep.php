<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreparationStep extends Model
{
    //
    protected $fillable = ["recipe_id", "order", "description"];
}
