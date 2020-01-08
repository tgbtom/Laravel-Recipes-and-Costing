@extends('layouts.app')

@section('title')
    Add Ingredient & Cost
@endsection

@section('style')
<link rel="stylesheet" href="../css/app.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('content')

<div class="row justify-content-center">
    <div class="col border pb-3 pt-3">
        <form action="/recipe" method="post">
            <div class="form-group">
                <label for="name">Recipe Name</label>
                <input class="form-control" type="text" name="name" id="name" placeholder="Title" required><br>
                <input type="hidden" name="part_to_change" value="ingredient">
                <input type="hidden" name="is_edit" value="false">
            </div>

            <div class="form-group">
                <label for="portions">Portions</label>
                <div class="input-group">
                    <input class="form-control" type="number" name="portions" min=0 value=1 required>
                    <div class="input-group-append">
                        <input class="form-control" type="text" name="portion_size" placeholder="Describe Portion" required>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="ingredient">First Ingredient:</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <select class="form-control" name="ingredient" id="ajaxSubmit" required>
                            @foreach ($ingredients as $ingredient)
                                <option value="{{$ingredient->id}}">{{$ingredient->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input class="form-control" type="number" name="quantity" placeholder="quantity" step="0.01" min=0 required>
                    <div class="input-group-append">
                        <select class="form-control" name="unit" readonly>
                            <option id="unit_of_measure" value="{{$default->unit->id}}">{{$default->unit->name}}</option>
                        </select>
                    </div>
                </div>
                
            </div>
                
            <div class="form-group">
                <label for="comment">Comment/Text</label>
                <input class="form-control" type="text" name="comment" placeholder="Note (e.g Soft)">
            </div>

                <input type="submit" class="btn btn-lg btn-success btn-block" value="Start this Recipe">
            {{csrf_field()}}
        </form> 
    </div>  
</div>
    
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