@extends('layouts.app')

@section('title')
    Browse Recipes
@endsection

@section('style')
    <link rel="stylesheet" href="css/app.css">
@endsection

@section('content')
    <table class="spacious">
        <thead>
            <tr>
                <th colspan=3>Recipe</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recipes as $recipe)
                <tr>
                    <td><a href="recipe/{{$recipe->id}}" target="_blank">{{$recipe->name}}</a></td>
                    <td><a href="recipe/{{$recipe->id}}/edit">Edit</a></td>
                    <td>
                    <a id="myForm" name="{{$recipe->id}}" href="/print/recipecost/{{$recipe->id}}" target="_blank" onclick="askUser(this)">Create Recipe Costing Form</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
            function askUser(dom) {
    
                var batches = prompt("How many batches do you wish to price for?", 1);
    
                if(batches){
                    dom.href = "print/recipecost/" + dom.name + "/" + batches;
                    dom.target = "_blank";
                }
                else{
                    dom.href = "";
                    dom.target = "";
                }

                console.log(dom);
            }
    
        </script>
@endsection
