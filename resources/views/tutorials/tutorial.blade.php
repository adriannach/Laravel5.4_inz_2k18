@extends('layouts.app')
@section('content')

  <div class="container barba-container" data-namespace="homepage">

    @if($tutorial->banner != 'default_banner.png' && $tutorial->video == 'video.mp4')
    <div class="row mx-0">
        <img class="img-fluid mb-1" src="{{ asset('uploads/banners/'. $tutorial->banner) }}" alt="Tutorial Image">
    </div>
    @endif

    @if($tutorial->video != 'video.mp4')

       <div class = "video_div mb-3">
         <div class="corner-tl"></div>
         <div class="corner-tr"></div>
         <video id="video-player" class="video-js vjs-sublime-skin vjs-16-9 vjs-big-play-centered"
           @if($tutorial->banner != 'default_banner.png')
            poster="{{ asset('uploads/banners/'. $tutorial->banner) }}"
            @endif
            preload="auto"
            controls preload="none" width="100%"
            data-setup = '{}'>
            <source src="{{ asset('uploads/videos/'. $tutorial->video) }}" type='video/mp4' />
          </video>
          <div class="corner-bl"></div>
          <div class="corner-br"></div>
      </div>

    @endif



    <!--{{ $tmp3=false }}-->
    @foreach ($steps as $step)
      @if(empty($steps))
        <!--  {{ $tmp3=false }}-->
      @else ($condition)
        <!--  {{ $tmp3=true }}-->
        @break
      @endif
    @endforeach

    @if(  $tmp3==true )
    <a class="btn btn-secondary container mt-3 mb-2 steps_animate" data-toggle="collapse" id="steps_animate" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Kroki</a>
      <div class="collapse" id="collapseExample">
        <div class="container-fluid">
          <ul class="row tabs">
            <!--{{ $tmp2=1 }}-->
            @foreach ($steps as $step)
            <li class="col-sm">

              <button class="btn btn-secondary disabled card-img-top" type="button" href="#{{ $tmp2 }}">
                Krok  {{ $tmp2 }} <div class="arrowhead"></div>
              </button>
            </li>
            <!--{{ $tmp2++ }}-->
            @endforeach
            </ul>

          <div class="container mt-2">
            <!--{{ $tmp2=1 }}-->
            @foreach ($steps as $step)
                <img id="{{ $tmp2 }}" class="img-fluid tab_content" src="{{ asset('uploads/steps/'. $step->tutorial_step) }}" alt="Tutorial Image">
                <!--{{ $tmp2++ }}-->
            @endforeach
          </div>
        </div>
      </div>
    @endif

    <div class="row mx-0 mt-0 pt-0">
      <div class="col-md-12 px-0">
        <h2 class="font-weight-bold text-center tutorial_text">{{ $tutorial->title }}</h2>
      </div>
    </div>

    <div class="tutorial_text">
      {!! $tutorial->body !!}
    </div>
    <hr>
    <div class="d-flex justify-content-between">
      <div class="mt-auto mb-auto ml-0 mr-auto">
            <a href="{{ route('user.show', $tutorial->user->id) }}">
              <img class="user_img" width="35px" height="35px" src="{{ asset('uploads/avatars/'.$tutorial->user->avatar) }}">
            </a>
              <div class="d-inline ml-1">{{ $tutorial->user->name }}</div>

              {{ $tutorial->created_at }}

              @if($tutorial->created_at!=$tutorial->updated_at)

                  Aktualizowano :{{ $tutorial->updated_at }}

              @endif
            Kategoria :{{ $tutorial->category->name }}
            @if ($tutorial->user_id == Auth::id() && Auth::check())
              <a class="btn btn-secondary ml-3" href="{{URL::to('/')}}/tutorial/{{ $tutorial->id }}/edit">Edytuj</a>
            @endif
            @if(!Auth::guest())
              @if (($tutorial->user_id == Auth::id() || Auth::user()->hasRole('administrator') || Auth::user()->hasRole('moderator')) && Auth::check())
                <div class="btn">
                  <button class="btn btn-secondary" data-toggle="modal" data-target="#DeleteModal">Usuń</button>
                </div>
              @endif
              <div class="modal" id="DeleteModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Czy na pewno chcesz usunąć poradnik ?</h5>
                      </div>
                      <div class="modal-body">
                        <div class="d-flex justify-content-center mb-3 text-center">
                          <button type="button" class="btn btn-secondary mr-3" data-dismiss="modal">Nie</button>
                          {{ Form::model($tutorial, ['route' => ['tutorial.delete', $tutorial->id], 'method'=>'POST']) }}
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                              {{ Form::submit('Tak', array('class'=>'btn btn-secondary')) }}
                          {{ Form::close() }}
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            @endif
          </div>
      <div class="votes mt-auto mb-auto d-flex justify-content-end">
        @if($tutorial->user_id!=Auth::id())
          <div class="btn">
          @if($subscription)
            {{ Form::model($subscription, ['route' => ['subscriptions.destroy', $subscription->id], 'method'=>'POST']) }}
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <button class="btn btn-secondary " type="submit">
                <span class="subscription_blue">
                  Desubskrybuj <i class="fas fa-bell"> {{ $tutorialSubscriptions }}</i>
                </span>
              </button>
              {{ Form::hidden('tutorial_id', $tutorial->id) }}
            {{ Form::close() }}
          @else
            {{ Form::open( ['route' => ['subscriptions.store'], 'method'=>'POST']) }}
              <button class="btn btn-primary" type="submit">
                <span>
                  Subskrybuj <i class="fas fa-bell"> {{ $tutorialSubscriptions }}</i>
                </span>
              </button>
              {{ Form::hidden('tutorial_id', $tutorial->id) }}
            {{ Form::close() }}
          @endif
        </div>
        @endif

          @if($vote)
            {{ Form::model($vote, ['route' => ['votes.destroy', $vote->id], 'method'=>'POST']) }}
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <button class="btn btn-secondary " type="submit">
                  <i class="fas fa-thumbs-up vote_green"></i>
                  <span class="vote_green">
                    {{ $vote_count }}
                  </span>
              </button>
            {{ Form::close() }}

          @else
            {{ Form::open( ['route' => ['votes.store'], 'method'=>'POST']) }}
              <button class="btn btn-success " type="submit">
                  <i class="fas fa-thumbs-up"></i>
                  <span>
                    {{ $vote_count }}
                  </span>
              </button>
              {{ Form::hidden('tutorial_id', $tutorial->id) }}
              {{ Form::hidden('vote_unvote', $vote_unvote=1) }}
            {{ Form::close() }}
          @endif

          @if($unvote)
            {{ Form::model($unvote, ['route' => ['votes.destroy', $unvote->id], 'method'=>'POST']) }}
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
                <button class="btn btn-secondary" type="submit">
                    <i class="fas fa-thumbs-down unvote_red"></i>
                    <span class="unvote_red">
                      {{ $unvote_count }}
                    </span>
                </button>
            {{ Form::close() }}
          @else
            {{ Form::open( ['route' => ['votes.store'], 'method'=>'POST']) }}
              <button class="btn btn-danger " type="submit">
                  <i class="fas fa-thumbs-down"></i>
                  <span>
                    {{ $unvote_count }}
                  </span>
              </button>
              {{ Form::hidden('tutorial_id', $tutorial->id) }}
              {{ Form::hidden('vote_unvote', $vote_unvote=0) }}
            {{ Form::close() }}
          @endif
      </div>
    </div>
    <hr/>

    <div class="containr-fluid mb-3" id="barba-wrapper">

      <h3>Komentarze:</h3>

        @if (Auth::check())

          {{ Form::open(['route' => ['comments.store'], 'method' => 'POST']) }}

          {{ Form::text('tutorialComment', old('tutorialComment'), array('placeholder'=>'Dodaj komentarz...', 'class'=>'form-control', 'rows'=>'1', 'autocomplete'=>'off')) }}

          {{ Form::hidden('tutorial_id', $tutorial->id) }}

        {{ Form::close() }}
        @endif
    </div>
    <div class="infinite-scroll">
      <div class="contaier-fluid barba-container">

          @include('tutorials.comment_data')

      </div>
      {{ $comments->links() }}
    </div>
  </div>

@endsection
