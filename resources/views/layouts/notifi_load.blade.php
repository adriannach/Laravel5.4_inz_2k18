      <!--{{$tmp=0, $tmp1=count(Auth::user()->unreadNotifications)}}-->
      @forelse (Auth::user()->Notifications as $notification)
        <!--{{$tmp++}}-->
        @if($tmp > 10)
          @break
        @endif
        @if($tmp1 > 0)
          <div class="mb-1">
            <a class="dropdown-item b new_notifi" href="{{ route('tutorials.id', $notification->data['tutorial']['id']) }}"><i>{{ $notification->data["user"]["name"] }}</i> dodał poradnik: <b>{{ str_limit($notification->data['tutorial']['title'], $limit=35) }} </b></a>
          </div>
          <!--{{ $tmp1-- }}-->
        @else
          <div class="mb-1">
            <a class="dropdown-item" href="{{ route('tutorials.id', $notification->data['tutorial']['id']) }}"><i>{{ $notification->data["user"]["name"] }}</i> dodał poradnik: <b>{{ str_limit($notification->data['tutorial']['title'], $limit=35) }}</b></a>
          </div>
        @endif
      @empty
      <div class="mb-1">
        <p class="text-center">Brak powiadomień</p>
      </div>
      @endforelse
      <hr class="mb-1 mt-0">
      <div class="mb-1 text-center">
        <a class="dropdown-item" href="{{ route('tutorials.subscribe') }}"><b>Zobacz wszystkie</b></a>
      </div>
