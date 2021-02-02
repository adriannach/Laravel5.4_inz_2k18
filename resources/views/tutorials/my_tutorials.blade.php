@extends('layouts.app')
@section('content')

<div class="container">

    <div class="col-md-12 px-0">
      <h1 class="font-weight-bold display-4 text-center">Twoje poradniki</h1>
    </div>
    <hr>

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
        <div class="col-lg-2 d-flex align-items-center">
          @if ($tutorial->user_id == Auth::id() && Auth::check())
            <a class="btn btn-secondary" href="{{URL::to('/')}}/tutorial/{{ $tutorial->id }}/edit">Edytuj</a>
            <div class="btn">
            {{ Form::model($tutorial, ['route' => ['tutorial.delete', $tutorial->id], 'method'=>'POST']) }}
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
                {{ Form::submit('Usuń', array('class'=>'btn btn-secondary')) }}
            {{ Form::close() }}
            </div>
          @endif
        </div>
    </div>
    <hr>
    @empty
    <div class="col-md-12 px-0">
      <h2 class="font-weight-bold display-5 text-center">Nie stworzyłeś jeszcze poradnika</h2>
    </div>

    @endforelse

          {{ $tutorials->links() }}
  </div>
</div>
@endsection
