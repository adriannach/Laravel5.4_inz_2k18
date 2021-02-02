@extends('layouts.app')
@section('content')
<div class="infinite-scroll">
  <div class="container-fluid">
      <div class="row">
          @include('tutorials.data')
      </div>
  </div>
</div>

<a class="buttonMail" style="display:none" data-toggle="modal" data-target="#ContactModal"><i class="fas fa-envelope"></i></a>
@include('emails.contact')
@endsection
