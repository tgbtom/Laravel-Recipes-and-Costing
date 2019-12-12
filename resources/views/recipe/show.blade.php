@extends('layouts.print')

@section('title')
    View - {{$recipe->name}}
@endsection

@section('style')
    <link rel="stylesheet" href="../../css/app.css">
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
    <h2 class="centerText">{{$recipe->name}}</h2>

    <table class="spacious">
        <thead>
            <tr>
                <th>Ingredient</th>
                <th>Quantity</th>
                <th>Alt.</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($line_items as $item)
                <tr>
                    @if ($item->ingredient->id == 1)
                        <td colspan=3></tr><tr>
                        <th colspan=3>{{$item->comment}}</th>
                    @else
                        <td>{{$item->ingredient->name}}
                            @if ($item->comment != "")
                                ({{$item->comment}})
                            @endif
                        </td>
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
                    @endif
                   
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>
    <h3 class="centerText"><u>Preparation Steps</u></h3>
    <table class="spacious">
        <thead>
            <tr>
                <th>Step #</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prep_steps as $step)
                <tr>
                    <td>{{$step->order}}</td>
                    <td>{{$step->description}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection