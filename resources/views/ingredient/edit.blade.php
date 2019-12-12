@extends('layouts.app')

@section('title')
    Edit Ingredient
@endsection

@section('style')
<link rel="stylesheet" href="../../css/app.css">
@endsection

@section('content')

{{-- <form action="/line/{{$lineItem->id}}" method="post">
    <input type="hidden" name="line_id" value={{$lineItem->id}}>
    <input type="hidden" name="recipe_id" value={{$recipe->id}}>
    @method('DELETE')
    {{csrf_field()}}
    <input type="submit" value="Delete">
</form> --}}


    <form action="/ingredient/{{$ingredient->id}}" method="post">
        <label for="name">Ingredient</label>
        <input type="text" name="name" value="{{$ingredient->name}}" readonly>
        <label for="yield_percent">Yield</label>
        <input type="number" name="yield_percent" min=0 max=100 value={{$ingredient->yield_percent * 100}}>%<br>
        <label for="cost_per_unit">$</label>

        @if ($ingredient->unit->name == "g")
            <input type="number" name="cost_per_unit" step="0.01"  placeholder="Cost" value={{number_format($ingredient->cost_per_unit * 100, 2)}} required>
            <label for="unit_amount">Per</label>
            <input type="number" name="unit_amount" placeholder="Qty" value="100" required>
        @else
            <input type="number" name="cost_per_unit" step="0.01"  placeholder="Cost" value={{$ingredient->cost_per_unit}} required>
            <label for="unit_amount">Per</label>
            <input type="number" name="unit_amount" placeholder="Qty" value="1" required>
        @endif


        <select name="unit_id" required>
            <option value={{$ingredient->unit_id}}>{{$ingredient->unit->name}}</option>
            @foreach ($units as $unit)
                @if ($unit->id != $ingredient->unit_id)
                    <option value={{$unit->id}}>{{$unit->name}}</option>
                @endif
            @endforeach
        </select><br>

        @method('PUT')
        {{csrf_field()}}

        <input type="submit" value="Update Ingredient">
    </form>    
@endsection