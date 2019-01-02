@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-6 offset-md-3">
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
@endsection
