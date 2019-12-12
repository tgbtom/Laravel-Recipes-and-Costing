@extends('layouts.app')

@section('title')
    Browse Ingredients
@endsection

@section('style')
    <link rel="stylesheet" href="css/app.css">
@endsection

@section('content')
    <table class="spacious">
        <thead>
            <tr>
                <th>Ingredient</th>
                <th>Cost Per</th>
                <th colspan=2>Unit</th>
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

                        <td><a href="ingredient/{{$ingredient->id}}/edit">Edit</a></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
