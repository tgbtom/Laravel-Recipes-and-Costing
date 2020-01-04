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
            <input type="hidden" name="name" id="name" value="{{$recipe->name}}"><br>
            <input type="hidden" name="part_to_change" value="ingredient">
            <input type="text" name="is_edit" value="true" hidden>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <select name="ingredient" class="form-control" id="ajaxSubmit">
                            @foreach ($ingredients as $ingredient)
                                <option value="{{$ingredient->id}}">{{$ingredient->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="number" class="form-control" name="quantity" step="0.001" value=0 min=0 placeholder="quantity" required>
                    <div class="input-group-append">
                        <select name="unit" class="form-control">

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
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Comment</span>
                    </div>
                    <input type="text" class="form-control" name="comment" placeholder="e.g Soft">
                </div>
            </div>
            
            <input type="submit" class="btn btn-lg btn-block btn-primary" value="Add This Ingredient">
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
                            <input type="submit" class="btn btn-danger" value="Delete">
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


<h3 class="centerText"><u>Preparation Steps</u></h3>
    <form action="/recipe" method="post" class="centerText">
        <input type="hidden" name="name" id="name" value="{{$recipe->name}}">
        <input type="hidden" name="part_to_change" value="preparation">
        <input type="text" name="is_edit" value="true" hidden>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Step #</span>
                </div>
                <select name="order" class="form-control">
                    <option value="1">1</option>
                    @foreach ($preparation_steps as $key => $step)
                        @if ($key == count($preparation_steps) - 1)
                            <option value="{{$step->order + 1}}" selected="selected">{{$step->order + 1}}</option>
                        @else
                            <option value="{{$step->order + 1}}">{{$step->order + 1}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
    
        <textarea name="description" class="form-control" cols="60" rows="3" required></textarea>
        <input type="submit" class="btn btn-block btn-lg btn-primary" value="Add this Step" style="vertical-align: middle;">
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
            <div class="row">

                <tr>
                    <td>{{$step->order}}</td>
                    <td colspan=3>
                        <form action="../../preparation" method="post"> 
                            <input type="hidden" name="step_id" value={{$step->id}}>
                            <input type="hidden" name="recipe_id" value={{$recipe->id}}>
                            <textarea name="newDescription" class="form-control form-control-lg" cols="100" rows="2">{{$step->description}}</textarea>
                    </td>
                    <td>
                        <input type="submit" class="btn btn-success" value="Save Changes">{{csrf_field()}}</form>
                    </td>

                    <td>
                        <form action="../../preparation/{{$step->id}}" method="post">
                            <input type="hidden" name="step_id" value={{$step->id}}>
                            <input type="hidden" name="step_order" value={{$step->order}}>
                            <input type="hidden" name="recipe_id" value={{$recipe->id}}>                      
                            @method("DELETE")
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-danger" value="Delete">
                        </form>
                    </td>
                </tr>

            </div>
            @endforeach
        </tbody>
    </table>
@endsection