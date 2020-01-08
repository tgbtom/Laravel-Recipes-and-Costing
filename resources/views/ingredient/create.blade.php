@extends('layouts.app')

@section('title')
    Add Ingredient & Cost
@endsection

@section('style')
<link rel="stylesheet" href="../css/app.css">
@endsection

@section('content')
    <form action="/ingredient" method="post">
        <div class="form-group">
            <label for="name">Ingredient</label>
            <input class="form-control form-control-lg" type="text" name="name" placeholder="Ingredient Name" required>
        </div>

        <div class="form-group">
            <label for="yield_percent">Yield %</label>
            <input type="number" class="form-control" name="yield_percent" min=0 max=100 value=100>
        </div>
        
        <div class="form-group form-inline">

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="dollar-sign">$</span>
                </div>
                <input class="form-control" type="number" name="cost_per_unit" step="0.01"  placeholder="Cost" aria-label="Cost" value='1.00' aria-describedby="dollar-sign" required> &nbsp;
            </div>
   
            <label for="unit_amount"> Per &nbsp; </label>


            <div class="input-group">
                <input class="form-control" type="number" name="unit_amount" placeholder="Qty" value="100" aria-label="Number input with dropdown unit selection" required>
                <div class="input-group-append">
                    <select class="form-control" name="unit_id" required>
                        @foreach ($units as $unit)
                            <option value={{$unit->id}}>{{$unit->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="free" id="free">
                <label for="free" class="form-check-label">Free Ingredient</label>
            </div>
        </div>
  
        <input type="submit" class="btn btn-lg btn-block btn-success" value="Create Ingredient">
        {{csrf_field()}}
    </form>    
@endsection