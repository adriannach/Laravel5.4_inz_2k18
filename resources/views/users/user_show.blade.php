@extends('layouts.app')
@section('content')
<div class="container">

  <div class="col-md-auto text-center">
    <img class="user_img" width="150px" height="150px" src="{{ asset('uploads/avatars/'.$user->avatar) }}">
    <h2>{{ $user->name }}</h2>
  </div>
  <hr>
    Zarejestrowany od: {{ $user->created_at }}
  <hr>
  <h1 class="font-weight-bold display-5 text-center">Poradniki użytkownika</h1>
  <div class="infinite-scroll">
    @forelse ($tutorials as $tutorial)
      <div class="row">
        <div class="col-3">
           <a href="{{URL::to('/')}}/tutorial/{{ $tutorial->id }}">
             <img class="img-fluid tutorial_img" src="{{ asset('uploads/banners/'. $tutorial->bannerM) }}" alt="Tutorial Image">
           </a>
        </div>
        <div class="col d-flex align-items-center">
          <h5>{{ str_limit($tutorial->title, $limit=62) }}</h5>
        </div>
        <div class="col-lg-3 d-flex align-items-center">
          Utworzono: {{ $tutorial->created_at }}
          @if($tutorial->created_at!=$tutorial->updated_at)
            Aktualizowano :{{ $tutorial->updated_at }}
          @endif
          Kategoria:{{ $tutorial->category->name }}
        </div>
    </div>
    <hr>
    @empty
    <div class="col-md-12 px-0">
      <h2 class="font-weight-bold display-5 text-center">Użytkownik nie dodał żadnego poradnika</h2>
    </div>

    </div>
    @endforelse

      {{ $tutorials->links() }}

  </div>
@endsection
