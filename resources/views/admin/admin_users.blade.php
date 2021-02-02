@extends('layouts.app')

@section('content')
<div class="container">

  <div class="row mx-0 mt-0 pt-0">
    <div class="col-md-12 px-0">
      <h1 class="font-weight-bold display-4 text-center">Zarządzaj użytkownikami</h1>
      @if(session()->has('success'))
        <hr>
      @endif
    </div>
  </div>

  {{ Form::open(['route' => ['admin.users.index'], 'method' => 'GET']) }}
  <div class="input-group">
    <div class="search search_admin left-search col">
      <i class="fas fa-search position-absolute"></i>
      {{ Form::text('search', old('search'), array('placeholder'=>'Wyszukaj użytkownika po nazwie...', 'class'=>'form-control', 'autocomplete'=>'off')) }}
    </div>
  </div>
  {{ Form::close() }}
  <br>

  @include('tutorials.error')

  <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nazwa</th>
      <th scope="col">E-mail</th>
      <th scope="col">Ranga</th>
      <th scope="col">Zarządzaj</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($users as $user)
      @foreach ($user->roles()->pluck('name') as $role)
            <!--{{ $role }}-->
      @endforeach
      @if($user->active == 0)
        <!--{{$activated = 'table-danger'}}-->
      @else
        @if($role=='administrator')
            <!--{{$activated = 'table-success'}}-->
          @elseif($role=='moderator')
            <!--{{$activated = 'table-info'}}-->
          @else
            <!--{{$activated = ''}}-->
        @endif
      @endif
    <tr class="{{$activated}}">
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $role }}</td>
        <td>
          <div class="d-flex justify-content-end">
              @if (Auth::id() != $user->id && $user->id!=1)
                  <button type="button" class="change-role btn btn-sm mr-1" data-user_id="{{ $user->id }}" data-user_role="{{ $role }}">Zmień rangę</button>
                  @if($user->active == 0)
                    <!--{{$activ = 'Odblokuj'}}-->
                  @else
                    <!--{{$activ = 'Zablokuj'}}-->
                  @endif
                  {{ Form::open(['route' => ['admin.users.activate'], 'method' => 'POST']) }}
                      {{ Form::submit($activ , ['class' => 'btn btn-sm']) }}
                      {{ Form::hidden('user_id', $user->id) }}
                  {{ Form::close() }}
              @endif
          </div>
        </td>
    </tr>
    @endforeach
  </tbody>
</table>

</div>

<div class="modal fade" tabindex="-1" role="dialog" id="role">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title">Zmień rangę</h2>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body mb-3">
                {{ Form::open(['route' => ['admin.users.role'], 'method' => 'POST']) }}
                    {{ Form::hidden('user_id') }}
                      {{ Form::select('role', $roles, null, ['class' => 'form-control']) }}
                      <br>
                    {{ Form::submit('Zmień', ['class'=>'btn btn-block']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
  <div class="col-md-12 px-0 d-flex justify-content-center normal_url_pagination">
    {{ $users->links() }}
  </div>
</div>


@endsection
