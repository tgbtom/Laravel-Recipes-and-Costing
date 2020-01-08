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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ingredients = Ingredient::where("user_id", Auth::user()->id)->orWhere("user_id", null)->get();

        return view('ingredient.index', compact(["ingredients"]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //Add if the ingredient name is not already in use

        // Ingredient::where("name", $request->name);
            $cost_per_unit = $request->free ? 0 : max(round($request->cost_per_unit / $request->unit_amount, 6), 0.0001); //Cost must be 0.1cent per unit of measure or higher IF it is not free
            $request->yield_percent = ($request->yield_percent <= 100 && $request->yield_percent >= 0) ? $request->yield_percent : 100; //Ensures the yield value was between 0 and 100
            $yield_percent = $request->yield_percent / 100;

            $ingredient = new Ingredient(["name"=>$request->name, "cost_per_unit"=>$cost_per_unit, "yield_percent"=>$yield_percent, "unit_id"=>$request->unit_id]);
            // $ingredient = Ingredient::create(["name"=>$request->name, "cost_per_unit"=>$cost_per_unit, "yield_percent"=>$yield_percent, "unit_id"=>$request->unit_id]);

            Auth::user()->ingredients()->save($ingredient);
        

        return redirect('/ingredient');        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $ingredient = Ingredient::findOrFail($id);
        $units = Unit::all();
        if(Auth::user()->ingredients->find($id)){
            return view('ingredient.edit', compact(["ingredient", "units"]));
        }
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
        //
        if($ingredient = Auth::user()->ingredients->find($id)){
            $cost_per_unit = max(round($request->cost_per_unit / $request->unit_amount, 6), 0.0001); //Cost must be 0.1cent per unit of measure or higher
            $request->yield_percent = ($request->yield_percent <= 100 && $request->yield_percent >= 0) ? $request->yield_percent : 100; //Ensures the yield value was between 0 and 100
            $yield_percent = $request->yield_percent / 100;
            // $ingredient = Ingredient::findOrFail($id);
            $ingredient->name = $request->name;
            $ingredient->cost_per_unit = $cost_per_unit;
            $ingredient->yield_percent = $yield_percent;
            $ingredient->unit_id = $request->unit_id;

            $ingredient->save();
        }
        
        return redirect('/ingredient');    
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
            return redirect()->route('ingredient.index');
        }
        return redirect()->route('ingredient.index');
    }
}
