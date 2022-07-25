<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;
use App\Ingredient;
use App\Http\Requests\StoreIngredient;
use Auth;

class IngredientController extends Controller
{
    /**
     * Display a listing of ingredients.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //pass a list of all ingredients that belong to either the current user OR no user at all (universal/public ingredients)
        $ingredients = Ingredient::where("user_id", Auth::user()->id)->orWhere("user_id", null)->orderBy("name")->get();

        return view('ingredient.index', compact(["ingredients"]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Navigate the user to the 'new ingredient' form, and pass an array of the possible units from the DB
        $units = Unit::all();
        return view("ingredient.create", compact(["units"]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreIngredient  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIngredient $request)
    {
        //TODO: Add if the ingredient name is not already in use

        $cost_per_unit = $request->free ? 0 : max(round($request->cost_per_unit / $request->unit_amount, 6), 0.0001); //Cost must be 0.01 cent per unit of measure (1 cent per 100g) or higher IF it is not free
        $request->yield_percent = ($request->yield_percent <= 100 && $request->yield_percent >= 0) ? $request->yield_percent : 100; //Ensures the yield value was between 0 and 100, otherwise sets it to 100 by default
        $yield_percent = $request->yield_percent / 100; //convert the yield percentage to a decimal

        //create a new Ingredient object with the provided values from the create form ($request)
        $ingredient = new Ingredient([
            "name"=>$request->name, 
            "cost_per_unit"=>$cost_per_unit, 
            "yield_percent"=>$yield_percent, 
            "unit_id"=>$request->unit_id]);

        //Save the ingredient with a relation to the current authenticated user
        Auth::user()->ingredients()->save($ingredient);
    
        return redirect('/ingredient');        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Store all Units in an array to be passed to the view
        $units = Unit::all();

        //ensure the ingredient belongs to the authenticated user before redirecting to the edit form
        if($ingredient = Auth::user()->ingredients->find($id)){
            return view('ingredient.edit', compact(["ingredient", "units"]));
        }

        //if the ingredient did not belong to the authenticated user; redirect back to the list of the authenticated user's ingredients
        return redirect()->route('ingredient.index');
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Ensure the ingredient we are updating belongs to the authenticated user
        if($ingredient = Auth::user()->ingredients->find($id)){
            $cost_per_unit = max(round($request->cost_per_unit / $request->unit_amount, 6), 0.0001); //Cost must be 0.1cent per unit of measure or higher
            $request->yield_percent = ($request->yield_percent <= 100 && $request->yield_percent >= 0) ? $request->yield_percent : 100; //Ensures the yield value was between 0 and 100
            $yield_percent = $request->yield_percent / 100; //convert yield percentage to a decimal

            //Update object attributes according to calculated data above and user input from the request
            $ingredient->name = $request->name;
            $ingredient->cost_per_unit = $cost_per_unit;
            $ingredient->yield_percent = $yield_percent;
            $ingredient->unit_id = $request->unit_id;

            $ingredient->save();
        }

        return redirect()->route('ingredient.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Ensure ingredient belongs to current user
        if($ingredient = Auth::user()->ingredients->find($id)){
            $ingredient->delete();
        }
        return redirect()->route('ingredient.index');
    }
}
