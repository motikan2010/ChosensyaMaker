@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-lg-6 offset-lg-3">
      <div class="monochrome">
        シルエット（β版）
        <input type="radio" name="monochrome-radio" value="1"/>ON
        <input type="radio" name="monochrome-radio" value="0" checked="checked"/>OFF
      </div>
      <div id="image-info" url="{{$imageUrl}}"></div>
      <div id="input"></div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6 offset-lg-3">
      <div class="form-group">
        <button class="btn btn-success" onclick="take()">画像を生成する</button>
        <a id="download">
          <button id="download-button" class="btn btn-primary" disabled="disabled">ダウンロード</button>
        </a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div id="output"></div>
    </div>
  </div>
@endsection

@section('javascript')
  <script type="text/javascript" src="/js/konva.min.js"></script>
  <script type="text/javascript" src="/js/html2canvas.min.js"></script>
  <script type="text/javascript" src="/js/app.js"></script>
@endsection
