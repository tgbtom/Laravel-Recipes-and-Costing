@extends('layouts.app')

@section('title')
    Browse Ingredients
@endsection

@section('style')
    <link rel="stylesheet" href="css/app.css">
@endsection

@section('content')
<div class="row">
<div class="col-md-12">
    <table class="spacious table">
        <thead>
            <tr>
                <th colspan=2>Ingredient</th>
                <th>Cost Per Unit</th>
                <th colspan=2></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ingredients as $ingredient)
                <tr>
                    @if ($ingredient->id != 1)
                        <td>{{$ingredient->name}}</td>
                        @if ($ingredient->unit->name == "g")
                            <td>${{number_format($ingredient->cost_per_unit * 100, 2)}}</td>
                            <td>100 {{$ingredient->unit->name}}</td>
                        @elseif($ingredient->unit->name == "ml")
                            <td>${{number_format($ingredient->cost_per_unit * 100, 2)}}</td>
                            <td>100 {{$ingredient->unit->name}}</td>
                        @else
                            <td>${{number_format($ingredient->cost_per_unit, 2)}}</td>
                            <td>{{$ingredient->unit->name}}</td>
                        @endif

                        <td><a class="btn btn-primary" href="ingredient/{{$ingredient->id}}/edit">Edit</a></td>
                        <td>
                            <form action="{{ route('ingredient.destroy', $ingredient->id) }}" method="post">
                                <button class="btn btn-danger" type="submit">Delete</button>
                                @method("DELETE")
                                @csrf
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
    
@endsection
