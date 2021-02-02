@extends('layouts.app')
@section('content')
@if(Auth::check())
  <div class="container">

    <div class="row mx-0 mt-0 pt-0">
      <div class="col-md-12 px-0">
        <h1 class="font-weight-bold display-4 text-center">Powiadomienia</h1>
        <hr>
      </div>
    </div>

<div class="infinite-scroll">
    @forelse ($notifications as $notification)
    <div class="mb-1">
      <a class="dropdown-item b" href="{{ route('tutorials.id', $notification->data['tutorial']['id']) }}"><i>{{ $notification->data["user"]["name"] }}</i> dodał poradnik: <b>{{ str_limit($notification->data['tutorial']['title'], $limit=47) }}</b></a>
    </div>
    <hr>
    @empty
    <div class="col-md-12 px-0">
      <h2 class="font-weight-bold display-5 text-center">Brak powiadomień</h2>
    </div>
    @endforelse

        {{ $notifications->links() }}

</div>
@endif
@endsection
