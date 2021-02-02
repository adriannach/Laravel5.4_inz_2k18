@extends('layouts.app')
@section('content')
@if (Auth::check()) <!--sprawdzenie czy użytkownik został zalogowany-->
<div class="container no-barba">
<div class="page_loader_div"></div>
@include('tutorials.error')
{{ Form::open(array('url'=>'/tutorials', 'data-parsley-validate' =>'','enctype'=>'multipart/form-data', 'files'=> true)) }}
{{ csrf_field() }}

  <div class="form-group">
      <div  class="d-flex">
        {{ Form::label('banner', 'Dodaj banner do poradnika:') }}
      </div>
      <div class="d-flex">
        {{ Form::file('banner', array('class'=>'btn')) }}
      </div>
  </div>

  <div class="form-group">
      <div  class="d-flex">
        {{ Form::label('video', 'Dodaj video: ') }}
      </div>
      <div class="d-flex">
        {{ Form::file('video', array('class'=>'btn')) }}
      </div>
  </div>

  <div class="form-group">
      <div  class="d-flex">
        {{ Form::label('step', 'Dodaj kroki:') }}
      </div>
      <div class="steps">
        <div class="d-flex">
          {{ Form::file('steps[]',['multiple'], array('class'=>'btn')) }}
        </div>
      </div>
  </div>

  <div class="form-group">
    {{ Form::label('category_id', 'Kategoria', array('class'=>'my-1 mr-2')) }}

    {{ Form::select('category_id', $categories, null, ['class' => 'form-control']) }}

  </div>

  <div class="form-group">
      <div  class="d-flex">
          {{ Form::label('title', '*Tytuł') }}
      </div>
      <div class="d-flex">
        {{ Form::text('title', null, array('class'=>'form-control', 'placeholder'=>'Wpisz tytuł...', 'maxlenghth' => '255', 'autocomplete'=>'off', 'required')) }}
      </div>
  </div>

  <div class="form-group">
      <div  class="d-flex">
        {{ Form::label('body', '*Treść') }}
      </div>
      <div>
        {{ Form::textarea('body', old('body'), array('class'=>'form-control', 'id'=>'summernote_textarea')) }}
      </div>
  </div>

  <div class="form-group">
      <div class="d-flex">
      {{ Form::submit('Stwórz poradnik',array('class'=>'btn btn-primary', 'id'=>'create_form')) }}
      </div>
  </div>
{{ Form::close() }}

</div>
@endif

@endsection
