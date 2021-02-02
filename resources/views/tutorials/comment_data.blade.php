@forelse ($comments as $comment)
  <a href="{{ route('user.show', $comment->user->id) }}">
    <img class="user_img" width="35px" height="35px" src="{{ asset('uploads/avatars/'.$comment->user->avatar) }}">
  </a>
  {{ $comment->user->name }}
  {{ $comment->created_at}}
  @if(!Auth::guest())
    @if (($comment->user_id == Auth::id() || Auth::user()->hasRole('administrator') || Auth::user()->hasRole('moderator')) && Auth::check())
      <div class="btn">
        {{ Form::model($comment, ['route' => ['comments.destroy', $comment->id], 'method'=>'POST']) }}
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
            {{ Form::submit('Usuń', array('class'=>'btn btn-secondary')) }}
        {{ Form::close() }}
      </div>
    @endif
  @endif
  <div class="col col_comment tutorial_text">
    {{ $comment->tutorialComment }}
  </div>
  <hr>
@empty

    <p>Ten poradnik nie ma jeszcze komentarza</p>

@endforelse
