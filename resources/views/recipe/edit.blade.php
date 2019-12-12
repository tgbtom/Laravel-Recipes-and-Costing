@extends('layouts.app')

@section('title')
    Add Ingredient & Cost
@endsection

@section('style')
<link rel="stylesheet" href="../../css/app.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('content')

    <h2 class="centerText">{{$recipe->name}}</h2>

    <form action="/recipe" method="post" class="centerText">
            <input type="hidden" name="name" id="name" value="{{$recipe->name}}" readonly><br>
            <input type="hidden" name="part_to_change" value="ingredient">
            <input type="text" name="is_edit" value="true" hidden>
            <select name="ingredient" id="ajaxSubmit">
                @foreach ($ingredients as $ingredient)
                    <option value="{{$ingredient->id}}">{{$ingredient->name}}</option>
                @endforeach
            </select>
            <input type="number" name="quantity" step="0.001" min=0 placeholder="quantity" required>
            <select name="unit">

                @switch($default->unit->name)
                    @case("g")
                    @case("Kg") 
                        <option id="unit_of_measure_spec1" value="1">g</option>
                        <option id="unit_of_measure_spec2" value="2">Kg</option>
                        @break
                    @case("ml")
                    @case("L")
                        <option id="unit_of_measure_spec1" value="3">ml</option>
                        <option id="unit_of_measure_spec2" value="4">L</option>
                        @break
                    @default
                        <option id="unit_of_measure_spec1" value="{{$default->unit->id}}">{{$default->unit->name}}</option>
                @endswitch

            </select>

            <label for="comment">Comment: </label>
            <input type="text" name="comment" placeholder="e.g Soft">
            <input type="submit" value="Add This Ingredient">
        {{csrf_field()}}
    </form>   
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>         
        jQuery(document).ready(function(){
            jQuery('#ajaxSubmit').change(function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('recipe/changeUnit') }}",
                method: 'post',
                data: {
                    ingredient: jQuery('#ajaxSubmit').val()
                },
                success: function(result){
                    console.log(result);

                    switch(result["unit"]){
                        case "g":
                        case "Kg":
                            document.getElementById("unit_of_measure_spec1").innerHTML = "g";
                            document.getElementById("unit_of_measure_spec1").value = 1;
                            document.getElementById("unit_of_measure_spec2").innerHTML = "Kg";
                            document.getElementById("unit_of_measure_spec2").value = 2;
                            break;
                        case "ml":
                        case "L":
                            document.getElementById("unit_of_measure_spec1").innerHTML = "ml";
                            document.getElementById("unit_of_measure_spec1").value = 3;
                            document.getElementById("unit_of_measure_spec2").innerHTML = "L";
                            document.getElementById("unit_of_measure_spec2").value = 4;
                            break;
                        default:
                            document.getElementById("unit_of_measure_spec1").innerHTML = result["unit"];
                            document.getElementById("unit_of_measure_spec1").value = result["unit_id"];
                            document.getElementById("unit_of_measure_spec2").innerHTML = result["unit"];
                            document.getElementById("unit_of_measure_spec2").value = result["unit_id"];
                    }
                }});
            });
            });



            jQuery(document).ready(function(){
            jQuery('#add_line_item').click(function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/recipe') }}",
                method: 'post',
                data: {
                    name: jQuery('#name').val()
                },
                success: function(result){
                    console.log(result);
                }});
            });
            });
    </script>

<table class="spacious">
    <thead>
        <tr>
            <th colspan=4>Recipe</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lineItems as $lineItem)
            <tr>
                @if ($lineItem->ingredient->id != 1)
                    <td>{{$lineItem->ingredient->name}} 
                    @if ($lineItem->comment != "")
                        ({{$lineItem->comment}})  
                    @endif
                    </td>
                    <td>{{$lineItem->quantity}}</td>
                    <td>{{$lineItem->unit->name}}</td>
                    <td>
                        <form action="/line/{{$lineItem->id}}" method="post">
                            <input type="hidden" name="line_id" value={{$lineItem->id}}>
                            <input type="hidden" name="recipe_id" value={{$recipe->id}}>
                            @method('DELETE')
                            {{csrf_field()}}
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                @else
                </tr><td colspan=4></td><tr>
                <th colspan=4>{{$lineItem->comment}}</th>
                @endif

            </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('content2')
<br>
<h3 class="centerText"><u>Preparation Steps</u></h3>
<form action="/recipe" method="post" class="centerText">
    <input type="hidden" name="name" id="name" value="{{$recipe->name}}">
    <input type="hidden" name="part_to_change" value="preparation">
    <input type="text" name="is_edit" value="true" hidden>
    <label for="order">Step #:</label>
    <select name="order">
        <option value="1">1</option>
        @foreach ($preparation_steps as $key => $step)
            @if ($key == count($preparation_steps) - 1)
                <option value="{{$step->order + 1}}" selected="selected">{{$step->order + 1}}</option>
            @else
                <option value="{{$step->order + 1}}">{{$step->order + 1}}</option>
            @endif
        @endforeach
    </select>

    <textarea name="description" cols="60" rows="3" required></textarea>

    <input type="submit" value="Add this Step" style="vertical-align: middle;">
{{csrf_field()}}
</form> 

<table class="spacious">
    <thead>
        <tr>
            <th>Step #</th>
            <th colspan=5>Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($preparation_steps as $step)
            <tr>
                <td>{{$step->order}}</td>
                <td colspan=3>
                    <form action="../../preparation" method="post"> 
                        <input type="hidden" name="step_id" value={{$step->id}}>
                        <input type="hidden" name="recipe_id" value={{$recipe->id}}>
                        <textarea name="newDescription" cols="100" rows="2">{{$step->description}}</textarea>
                </td>
                <td><input type="submit" value="Save Changes">{{csrf_field()}}</form></td>
                <td>
                    <form action="../../preparation/{{$step->id}}" method="post">
                        <input type="hidden" name="step_id" value={{$step->id}}>
                        <input type="hidden" name="step_order" value={{$step->order}}>
                        <input type="hidden" name="recipe_id" value={{$recipe->id}}>                      
                        @method("DELETE")
                        {{ csrf_field() }}
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection