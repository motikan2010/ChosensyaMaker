@extends('layouts.app')

@section('content')
  <div id="image-info" url="{{$imageUrl}}"/>
  <div id="input">
    <canvas id="canvas" width="500" height="480"></canvas>
  </div>
  <div id="output"></div>
@endsection