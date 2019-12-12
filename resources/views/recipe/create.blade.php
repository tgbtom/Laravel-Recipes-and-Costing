@extends('layouts.app')

@section('title')
    Add Ingredient & Cost
@endsection

@section('style')
<link rel="stylesheet" href="../css/app.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('content')
    <form action="/recipe" method="post">
        <label for="name">Recipe Name</label>
        <input type="text" name="name" id="name" placeholder="Title" required><br>
        <input type="hidden" name="part_to_change" value="ingredient">
        <input type="hidden" name="is_edit" value="false">

        <label for="portions">Portions</label>
        <input type="number" name="portions" min=0 value=1 required>
        <input type="text" name="portion_size" placeholder="Describe Portion" required>
        <br>
            <select name="ingredient" id="ajaxSubmit" required>
                @foreach ($ingredients as $ingredient)
                    <option value="{{$ingredient->id}}">{{$ingredient->name}}</option>
                @endforeach
            </select>
            <input type="number" name="quantity" placeholder="quantity" step="0.01" min=0 required>
            <select name="unit" readonly>
                <option id="unit_of_measure" value="{{$default->unit->id}}">{{$default->unit->name}}</option>
            </select>
            <input type="text" name="comment" placeholder="Note (e.g Soft)">
            <br>
            <input type="submit" value="Begin New Recipe with this ingredient">
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
                    document.getElementById("unit_of_measure").innerHTML = result["unit"];
                    document.getElementById("unit_of_measure").value = result["unit_id"];
                }});
            });
            });



            // jQuery(document).ready(function(){
            // jQuery('#add_line_item').click(function(e){
            // e.preventDefault();
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            // jQuery.ajax({
            //     url: "{{ url('/recipe') }}",
            //     method: 'post',
            //     data: {
            //         name: jQuery('#name').val()
            //     },
            //     success: function(result){
            //         console.log(result);
            //     }});
            // });
            // });
    </script>
@endsection