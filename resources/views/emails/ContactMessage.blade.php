@if(Auth::user())
Użytkownik: {{ $name }}
@else
Nazwa: {{ $name }}
@endif
<br><br>
E-mail: {{ $email }}
<br><br>
Wiadomość:
<br>
{{ $msg }}
