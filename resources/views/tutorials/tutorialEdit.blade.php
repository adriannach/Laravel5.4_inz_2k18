@extends('layouts.app')
@section('content')
<div class="page_loader_div"></div>
@include('tutorials.error')
@if ($tutorial->user_id == Auth::id() && Auth::check())
<div class="container">
{{ Form::model($tutorial, ['route' => ['tutorials.change', $tutorial->id], 'method'=>'PUT', 'files'=> true]) }}

    <div class="form-group">
        <div  class="d-flex">
          {{ Form::label('banner', 'Edytuj banner do poradnika:') }}
        </div>
        <div class="d-flex">
          {{ Form::file('banner', array('class'=>'btn')) }}
        </div>
    </div>

    <div class="form-group">
        <div  class="d-flex">
          {{ Form::label('video', 'Edytuj video: ') }}
        </div>
        <div class="d-flex">
          {{ Form::file('video', array('class'=>'btn')) }}
        </div>
    </div>

    <div class="form-group">
        <div  class="d-flex">
          {{ Form::label('step', 'Aktualizuj kroki:') }}
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
          {{ Form::text('title', old('title'), array('class'=>'form-control', 'maxlenghth' => '255', 'autocomplete'=>'off', 'required')) }}
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
        {{ Form::submit('Edytuj tutorial', array('class'=>'btn btn-primary')) }}
        </div>
    </div>
  {{ Form::close() }}

</div>
@endif
@endsection
