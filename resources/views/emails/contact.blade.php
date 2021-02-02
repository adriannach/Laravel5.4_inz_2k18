<div class="modal fade" id="ContactModal" tabindex="-1" role="dialog" aria-labelledby="ContactModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
    @if(Auth::user())
    <h5 class="modal-title" id="ContactModalLabel">{{ Auth::user()->name }} skontaktuj się z nami</h5>
    @else
      <h5 class="modal-title" id="ContactModalLabel">Skontaktuj się z nami</h5>
    @endif
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    @include('tutorials.error')
    {{ Form::open(['route' => ['contact.store'], 'method' => 'POST']) }}
    @if(!Auth::user())
    <div class="form-group">
        <div  class="d-flex">
          {{ Form::label('name', 'Podaj nazwę użytkownika lub imię:') }}
        </div>
        <div class="d-flex">
          {{ Form::text('name', null, array('class'=>'form-control', 'maxlenghth' => '255', 'autocomplete'=>'off', 'required')) }}
        </div>
    </div>
    <div class="form-group">
        <div  class="d-flex">
          {{ Form::label('email', 'E-mail:') }}
        </div>
        <div class="d-flex">
          {{ Form::text('email', null, array('class'=>'form-control', 'maxlenghth' => '255', 'autocomplete'=>'off', 'required')) }}
        </div>
    </div>
    @endif
    <div class="form-group">
        <div  class="d-flex">
          {{ Form::label('message', 'Wiadomość:') }}
        </div>
        <div class="d-flex">
          {{ Form::textarea('message', old('message'), null, array('class'=>'form-control', 'autocomplete'=>'off', 'required')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="d-flex justify-content-end">
          {{ Form::submit('Wyślij wiadomość',array('class'=>'btn btn-primary')) }}
        </div>
    </div>
    {{ Form::close() }}

  </div>
</div>
</div>
</div>
