@extends('layouts.app')
@section('content')
<div class="container">
    <h1>
        {{$title}}
    </h1>
    <h5>This app was written using: </h5>
    @if(count($services) > 0)
    <ul class="list-group">
        @foreach($services as $service)
        <li class="list-group-item">{{$service}}</li>
        @endforeach
    </ul>
    <h6>This data is taken from the PagesController inside the Laravel code</h6>
    @endif
</div>
@endsection