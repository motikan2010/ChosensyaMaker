@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <h5 class="card-header"></h5>
        <div class="card-body">
          {!! Form::open(['url' => Helper::formAction('/create'), 'method' => 'post', 'files' => true]) !!}
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <div class="form-group row">
            {!! Form::label('file', '画像アップロード', ['id' => 'image-form', 'class' => 'control-label']) !!}
            {!! Form::file('image', ['id' => 'image-form', 'class' => 'form-control-file']) !!}
          </div>
          <div class="form-group row">
            {!! Form::submit('アップロード', ['class' => 'btn btn-primary']) !!}
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-md-1">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <h5 class="card-header">このサイトについて</h5>
        <div class="card-body px-sm-1">
          ※人物画像の背景が自動的にトリミングされます。
          <img class="card-img-top img-thumbnail" src="/images/site-info.png" alt="">
        </div>
      </div>
    </div>
  </div>
@endsection
