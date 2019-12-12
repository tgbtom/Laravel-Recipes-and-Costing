<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\RecipeLineItem;
use App\Recipe;

// Route::post('recipe/changeUnit', 'RecipeController@changeUnit');
Route::get('print/recipecost/{recipe_id}/{batches}', function ($recipe_id, $batches) {

    $recipe = Recipe::findOrFail($recipe_id);
    $lineItems = $recipe->recipeLineItems;

    return view('recipe.cost', compact('recipe_id'))->with('recipe', $recipe)->with('line_items', $lineItems)->with('batches', $batches);
    
})->name("recipe.cost");

Route::post('recipe/changeUnit', "RecipeController@changeUnit");

Route::get('/', 'RecipeController@index');

Route::resource('recipe', 'RecipeController');

Route::resource('line', 'RecipeLineItemController');

Route::resource('ingredient', 'IngredientController');

Route::resource('preparation', 'PreparationStepController');
