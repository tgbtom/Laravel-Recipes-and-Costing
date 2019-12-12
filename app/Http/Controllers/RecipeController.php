<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;
use App\Ingredient;
use App\RecipeLineItem;
use App\Unit;
use App\PreparationStep;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $recipes = Recipe::orderBy("name", "asc")->get();
        return view('recipe.index', compact(["recipes"]));
    }

    public function changeUnit(Request $request){
        $unit = Ingredient::findOrFail($request->ingredient)->unit->name;
        $unit_id = Ingredient::findOrFail($request->ingredient)->unit->id;

        return response()->json(['unit'=>$unit, 'unit_id'=>$unit_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $ingredients = Ingredient::all();
        $default = Ingredient::first();
        return view('recipe.create', compact(["ingredients", "default"]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate and Store the recipe that was sent
        //THEN redirect to the edit page for that recipe

        if($request->part_to_change == "ingredient"){
            //if unit supplied (kg) is different than ingredient cost (g), convert qty and store here
            $ingredient = Ingredient::findOrFail($request->ingredient);
            if($request->unit != $ingredient->unit->id){
                switch(Unit::findOrFail($request->unit)->name){
                    case "g":
                        $request->quantity /= 1000;
                        $request->unit = 2;
                        break;
                    case "Kg":
                        $request->quantity *= 1000;
                        $request->unit = 1;
                        break;
                    case "ml":
                        $request->quantity /= 1000;
                        $request->unit = 4;
                        break;
                    case "L":
                        $request->quantity *= 1000;
                        $request->unit = 3;
                        break;
                }
            }

            if(!Recipe::whereName($request->name)->first()){
                $recipe = Recipe::create(["user_id"=>1,
                "name"=>$request->name,
                "portions"=>$request->portions,
                "portion_size"=>$request->portion_size,
                "is_draft"=>false]);

                //create the entered Line item
                $newLine = new RecipeLineItem();
                $newLine->ingredient_id = $request->ingredient;
                $newLine->quantity = $request->quantity;
                $newLine->unit_id = $request->unit;
                $newLine->comment = $request->comment;
                $recipe->recipeLineItems()->save($newLine);
                $recipe = Recipe::where("name", $request->name)->first();
            }
            elseif($request->is_edit == true){ //Recipe already exists, view that recipe and add the line
                $newLine = new RecipeLineItem();
                $newLine->ingredient_id = $request->ingredient;
                $newLine->quantity = $request->quantity;
                $newLine->unit_id = $request->unit;
                $newLine->comment = $request->comment;
                $recipe = Recipe::where("name", $request->name)->first();
                $recipe->recipeLineItems()->save($newLine);
            }
            else{
                $recipe = Recipe::where("name", $request->name)->first();
            }
        }
        elseif ($request->part_to_change == "preparation" && $request->is_edit == true){
            $recipe = Recipe::where("name", $request->name)->first();

            //re-order steps so none of them overlap
            $currentSteps = $recipe->preparationSteps;
            foreach($currentSteps as $step){
                if($step->order >= $request->order){
                    $step->order += 1;
                    $step->save();
                }
            }

            $newStep = new PreparationStep();
            $newStep->order = $request->order;
            $newStep->description = $request->description;
            $recipe->preparationSteps()->save($newStep);
        }
        
        
        return redirect('recipe/'.$recipe->id.'/edit');
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
        $recipe = Recipe::findOrFail($id);
        $line_items = $recipe->recipeLineItems;
        $prep_steps = $recipe->preparationSteps;
        return view("recipe.show", compact(["recipe", "line_items", "prep_steps"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($recipe)
    {
        //
        $ingredients = Ingredient::all();
        $default = Ingredient::first();
        $recipe = Recipe::findOrFail($recipe);
        $preparation_steps = $recipe->preparationSteps()->orderBy("order", 'asc')->get();

        $lineItems = $recipe->recipeLineItems;

        return view('recipe.edit', compact(["ingredients", "default", "recipe", "lineItems", "preparation_steps"]));
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        echo "Delete";
    }
}
