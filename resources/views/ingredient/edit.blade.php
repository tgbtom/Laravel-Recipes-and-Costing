@extends('layouts.app')

@section('title')
    Edit Ingredient
@endsection

@section('style')
<link rel="stylesheet" href="../../css/app.css">
@endsection

@section('content')

    <form action="/ingredient/{{$ingredient->id}}" method="post">
        <div class="form-group">
            <label for="name">Ingredient</label>
            <input class="form-control" type="text" name="name" value="{{$ingredient->name}}" readonly>
        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Yield</span>
                </div>
                <input class="form-control" type="number" name="yield_percent" min=0 max=100 value={{$ingredient->yield_percent * 100}}>
                <div class="input-group-append">
                    <span class="input-group-text">%</span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                </div>

                @if ($ingredient->unit->name == "g")
                    <input class="form-control" type="number" name="cost_per_unit" step="0.01"  placeholder="Cost" value={{number_format($ingredient->cost_per_unit * 100, 2)}} required>
                    <div class="input-group-append">
                        <span class="input-group-text">Per</span>
                    </div>
                    <input class="form-control" type="number" name="unit_amount" placeholder="Qty" value="100" required>
                @else
                    <input class="form-control" type="number" name="cost_per_unit" step="0.01"  placeholder="Cost" value={{$ingredient->cost_per_unit}} required>
                    <div class="input-group-append">
                        <span class="input-group-text">Per</span>
                    </div>
                    <input class="form-control" type="number" name="unit_amount" placeholder="Qty" value="1" required>
                @endif

                <div class="input-group-append">
                    <select class="form-control" name="unit_id" required>
                        <option value={{$ingredient->unit_id}}>{{$ingredient->unit->name}}</option>
                        @foreach ($units as $unit)
                            @if ($unit->id != $ingredient->unit_id)
                                <option value={{$unit->id}}>{{$unit->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        @method('PUT')
        {{csrf_field()}}

        <input class="btn btn-lg btn-block btn-success" type="submit" value="Update Ingredient">
    </form>    
@endsection