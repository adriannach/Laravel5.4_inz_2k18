
@extends('layouts.app')
@section('content')

  @if (Auth::check())
    <div class="container">
      <div class="row">
        <div class="col-md-auto text-center">
          <img class="user_img" width="150px" height="150px" src="{{ asset('uploads/avatars/'.$user->avatar) }}">
          <h2>{{ $user->name }}</h2>
        </div>
        <div class="col">
          <div class="p-2 bd-highlight">
            <h4>Zmień avatar</h4>
          </div>
          <div class="p-2 bd-highlight">
          @include('tutorials.error')
            {{ Form::open(['route' => ['user.account.edit'], 'files' => true, 'method' => 'PUT']) }}
            <div class="form-group">
                <div class="d-flex">
                    {{ Form::file('avatar', array('class'=>'btn avatar')) }}
                </div>
            </div>

            <div class="form-group">
                <div  class="d-flex">
                    {{ Form::submit('Zaktualizuj', ['name' => 'submit']) }}
                </div>
            </div>
          {{ Form::close() }}
        </div>
      </div>
      </div>

    </div>
    @endif


@endsection
