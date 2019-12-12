@extends('layouts.print')

@section('title')
    Cost - {{$recipe->name}}
@endsection

@section('style')
    <link rel="stylesheet" href="../../../css/app.css">
    <style>
    body{
        font-size: 25%;
    }
    </style>
@endsection

@php
    
    function numberOfDecimals($value)
    {
        if ((int)$value == $value)
        {
            return 0;
        }
        else if (! is_numeric($value))
        {
            // throw new Exception('numberOfDecimals: ' . $value . ' is not a number!');
            return false;
        }

        return strlen($value) - strrpos($value, '.') - 1;
    }
@endphp

@section('content')

    <div class="costInfo">
        <table class="printHead">
            <thead>
                <tr>
                    <td colspan=3><b>Recipe:</b> {{$recipe->name}}</td>
                    <td><B>Batches:</b> {{$batches}}</td>
                    <td><b>Date:</b> {{date("M d, Y")}}</td>
                </tr>
                <tr>
                    <td colspan=3><b>Cost Per Portion:</b> $<span id="costPer"></span></td>
                    <td colspan=2><b>Portions:</b> <span id="portions">{{$recipe->portions * $batches}}</span> x {{$recipe->portion_size}}</td>
                </tr>
                <tr>
                    <td><b>Selling Price per Portion:</b> <span id="sellPrice"></span></td>
                    <td><b>Total Price:</b> <span id="totalSellPrice"></span></td>
                    <td><b>Profit:</b> <span id="profit"></span></td>
                    <td colspan=2><b>Food Cost:</b> 40%</td>
                </tr>
            </thead>
        </table>
    </div>
    <table class="spaciousPrint">
        <thead>
            <tr>
                <th colspan=3>Recipe Quantity</th>
                <th colspan=2>Quantity To Purchase</th>
                <th colspan=2>Total Cost</th>
            </tr>
            <tr>
                <th>Ingredient</th>
                <th>Quantity (PU)</th>
                <th>Alt. Qty</th>
                <th>Yield %</th>
                <th>As Purchased Quantity</th>
                <th>As Purchased Cost</th>
                <th>Ingredient Cost</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalCost = 0.00;
            @endphp

            @foreach ($line_items as $item)
                <tr>

                @if ($item->ingredient->id == 1)
                    <th colspan=7> {{$item->comment}}</th>
                @else
                    @php
                        $item->quantity *= $batches;
                    @endphp
                {{-- Ingredient Name --}}
                <td>{{$item->ingredient->name}}</td>

                {{-- Quantity of Ingredient & Alternative Qty --}}
                @switch($item->unit->name)
                    @case("g")
                        @if ($item->quantity >= 1000)
                            <td>{{$item->quantity}}{{$item->unit->name}} <td>{{$item->quantity / 1000}} Kg</td></td>
                        @else
                            <td>{{$item->quantity}} {{$item->unit->name}}<td></td></td>
                        @endif
                        @break
                    @case("Kg")
                        @if ($item->quantity < 1)
                            <td>{{$item->quantity}}{{$item->unit->name}} <td>{{$item->quantity * 1000}} g</td></td>   
                        @else
                            <td>{{$item->quantity}} {{$item->unit->name}}<td></td></td>
                        @endif                            
                        @break
                    @case("ml")
                        @if ($item->quantity >= 1000)
                            <td>{{$item->quantity}}{{$item->unit->name}} <td>{{$item->quantity / 1000}} L</td></td>
                        @else
                            <td>{{$item->quantity}} {{$item->unit->name}}<td></td></td>
                        @endif
                        @break
                    @case("L")
                        @if ($item->quantity < 1 || numberOfDecimals($item->quantity) >= 3)
                            <td>{{$item->quantity}}{{$item->unit->name}} <td>{{$item->quantity * 1000}} ml</td></td> 
                        @else
                            <td>{{$item->quantity}} {{$item->unit->name}}<td></td></td>
                        @endif                            
                        @break
                    @default
                        <td>{{$item->quantity}} {{$item->unit->name}}<td></td></td>
                        
                @endswitch

                {{-- Yield Percent --}}
                <td>{{$item->ingredient->yield_percent * 100}}%</td>
                {{-- As Purchased Quantity --}}
                <td>{{$item->quantity/$item->ingredient->yield_percent}} {{$item->unit->name}}</td>
                {{-- As purchased Cost --}}
                @switch($item->unit->name)
                    @case("g")
                        <td>${{number_format($item->ingredient->cost_per_unit * 100 ,2)}} per 100 {{$item->unit->name}}</td>
                        @break
                    @default
                        <td>${{number_format($item->ingredient->cost_per_unit,2)}} / {{$item->unit->name}}</td>
                @endswitch

                {{-- Ingredient Cost --}}
                <td>${{number_format(round($item->quantity * $item->ingredient->cost_per_unit, 2),2)}}</td>

                @php
                    $totalCost += str_replace(",", "", number_format(round($item->quantity * $item->ingredient->cost_per_unit, 2),2));
                @endphp

                @endif

                   
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan=6 style="text-align: right;">Total Cost:</th>
                <th>$<span id="totalCost">{{number_format($totalCost, 2)}}</span></th>
            </tr>
        </tfoot>
    </table>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
    $(window).on('load', function(){
        //$("#costPer").html($("#totalCost").html / $("#portions").html);
        var cost_per_portion = parseFloat($("#totalCost").html().replace(',', '')) / parseFloat($("#portions").html().replace(',', ''));
        cost_per_portion = cost_per_portion.toFixed(2);
        $("#costPer").html(cost_per_portion);

        var sellPrice = $("#costPer").html() / 0.4;
        var totalPrice = sellPrice.toFixed(2) * {{$recipe->portions * $batches}};
        var profit = totalPrice - $("#totalCost").html();

        $("#sellPrice").html("$" + sellPrice.toFixed(2));
        $("#profit").html("$" + profit.toFixed(2));
        $("#totalSellPrice").html("$" + totalPrice.toFixed(2));
    });
</script>