@extends('layouts.app')

@section('content')
  <div class="slider">
    <span>縮小</span>
    <input id="zoom-slider" type="range"/>
    <span>拡大</span>
  </div>
  <div class="monochrome">
    シルエット（β版）
    <input type="radio" name="monochrome-radio" value="1"/>ON
    <input type="radio" name="monochrome-radio" value="0" checked="checked"/>OFF
  </div>
  <div id="image-info" url="{{$imageUrl}}"></div>
  <div id="input">
    <canvas id="canvas" width="500" height="280"></canvas>
  </div>
  <div id="output"></div>
@endsection

@section('javascript')
  <script type="text/javascript" src="/js/html2canvas.min.js"></script>
  <script type="text/javascript" src="/js/app.js"></script>
@endsection
