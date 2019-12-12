@extends('layouts.app')

@section('title')
    Add Ingredient & Cost
@endsection

@section('style')
<link rel="stylesheet" href="../css/app.css">
@endsection

@section('content')
    <form action="/ingredient" method="post">
        <label for="name">Ingredient</label>
        <input type="text" name="name" placeholder="Ingredient Name" required>
        <label for="yield_percent">Yield</label>
        <input type="number" name="yield_percent" min=0 max=100 value=100>%<br>
        <label for="cost_per_unit">$</label>
        <input type="number" name="cost_per_unit" step="0.01"  placeholder="Cost" value='1.00' required>
        <label for="unit_amount">Per</label>
        <input type="number" name="unit_amount" placeholder="Qty" value="1" required>
        <select name="unit_id" required>
            @foreach ($units as $unit)
                <option value={{$unit->id}}>{{$unit->name}}</option>
            @endforeach
        </select><br>
        <input type="submit" value="Create Ingredient">
        {{csrf_field()}}
    </form>    
@endsection