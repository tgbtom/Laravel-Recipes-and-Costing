<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PreparationStep;
use App\Recipe;

class PreparationStepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Called when you EDIT a step
        //Step creation is covered in RecipeController@store
        $step = Preparationstep::findOrFail($request->step_id);
        $step->description = $request->newDescription;
        $step->save();

        return redirect('recipe/' . $request->recipe_id . "/edit");
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
    public function destroy($id, Request $request)
    {
        //
        $stepToDelete = PreparationStep::findOrFail($request->step_id);
        $allSteps = Recipe::findOrFail($request->recipe_id)->preparationSteps;
        foreach($allSteps as $step){
            if($step->order > $stepToDelete->order){
                $step->order -= 1;
                $step->save();
            }
        }
        $stepToDelete->delete();

        return redirect('recipe/' . $request->recipe_id . '/edit');
    }
}
