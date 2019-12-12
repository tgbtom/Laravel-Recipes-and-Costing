@extends('layouts.app')

@section('content')
    <form action="/line" method="post">
        <input type="submit" value="Create Recipe Line">
        {{csrf_field()}}
    </form>    
@endsection
