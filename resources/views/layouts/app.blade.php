<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Muscleup Poradniki do ćwiczeń kalistenicznych"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/js.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"><!--darmowe ikony fontawesome.-->
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>
<body id="barba-wrapper">
    <div id="app">
        <nav class="navbar sticky-top position-fixed navbar-expand-lg navbar-dark navbar-laravel shadow">

            <div class="container-fluid">
                <a class="navbar-brand mr-auto position-relative" href="{{ url('/tutorials') }}">
                    {{ config('app.name') }}
                </a>

                <ul class="navbar-nav abs-center-x nav_search">
                  <li class="nav-item">
                    <div class="input-group">
                      <div class="search search_app left-search row">

                          {{ Form::open(['route' => ['tutorials.index'], 'method' => 'GET']) }}
                          <i class="fas fa-search position-absolute"></i>
                          {{ Form::text('search', old('search'), array('placeholder'=>' Szukaj...', 'class'=>'form-control fa-search', 'autocomplete'=>'off')) }}
                          {{ Form::close() }}
                      </div>
                    </div>
                  </li>
                </ul>

                <button class="navbar-toggler position-relative" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                      <li class="navbar-nav mr-auto dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Kategorie</a>
                        <div class="dropdown-menu">
                          @foreach($categories as $category)
                            <a class="dropdown-item" href="{{URL::to('/')}}/tutorials/category/{{ $category->id }}">{{ $category->name }}</a>
                          @endforeach
                        </div>
                      </li>

                      <li class="nav-item position-relative">
                        @if(!Auth::guest())
                          <a class="nav-link" href="{{ action('TutorialsController@addTutorial') }}">Dodaj</a>
                        @else
                          <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">{{ __('Dodaj') }}</a>
                        @endif
                      </li>



                    </ul>

                    <ul class="navbar-nav ml-auto position-relative">

                        @guest


                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">{{ __('Zaloguj') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="#" data-toggle="modal" data-target="#registerModal">{{ __('Zarejestruj') }}</a>
                                @endif
                            </li>

                        @else


                          <li class="navbar-nav mr-auto dropleft">
                              <a id="reloader" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="#" aria-haspopup="true" aria-expanded="false">
                                    <span id="counter">
                                    @if( count(Auth::user()->unreadNotifications) > 0)
                                      <i class="fas fa-bell subscription_blue"></i>
                                      {{ count(Auth::user()->unreadNotifications)}}
                                    @else
                                      <i class="fas fa-bell"></i>
                                      {{ count(Auth::user()->unreadNotifications)}}
                                    @endif
                                    </span>
                              </a>

                              <div class="dropdown-menu">
                                <div id="notifyReload" class="mt-1">

                                @include('layouts.notifi_load')

                                </div>
                              </div>

                              <div id="zero"></div>

                          </li>

                            @role('administrator')
                              <li class="navbar-nav mr-auto dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Panel administracyjny</a>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="{{ route('admin.users.index') }}">Zarządzaj użytkownikami</a>
                                </div>
                              </li>
                            @endrole

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ str_limit(Auth::user()->name, $limit=17) }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right text-center" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('tutorials.my') }}">Moje poradniki</a>
                                    <a class="dropdown-item" href="{{ route('user.account') }}">Zmień avatar</a>
                                    <hr class="mb-1 mt-0">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Wyloguj') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>


                              <li class="nav-item position-relative">

                                  <a class="nav-link pt-0 pb-0" href="{{ route('user.show', Auth::user()->id) }}">
                                    <img class="user_img" width="35px" height="35px" src="{{ asset('uploads/avatars/'.Auth::user()->avatar) }}">
                                  </a>


                              </li>

                        @endguest
                    </ul>
                </div>

            </div>

        </nav>
        @include('layouts.LogRegModal')
          @if(session()->has('success'))
            <div class="container-fluid mt-4 error_div" id="error_div">
              <div class="alert alert-success text-center">
                  {{ session()->get('success') }}
              </div>
            </div>
          @endif
          @if(session()->has('error'))
            <div class="container-fluid mt-4 error_div"  id="error_div">
              <div class="alert alert-danger text-center">
                  {{ session()->get('error') }}
              </div>
            </div>
          @endif

          @if(!empty(Session::get('error_code')) && Session::get('error_code') == 999)
            <script>
              $(function() {
                  $('#loginModal').modal('show');
              });
            </script>
          @endif


        <main class="py-4 barba-container">
            @yield('content')
        </main>

    </div>
    <a class="buttonTop" style="display:none" href="#up"><i class="fas fa-chevron-circle-up"></i></a>
</body>
</html>
