<?php

namespace App\Policies;

use App\User;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function create(User $user)
    {
        return Auth::check(); //sprawdzenei czy użytkownik jest zalogowany
    }
    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || User::findOrFail($user->id)->hasRole('administrator') || User::findOrFail($user->id)->hasRole('moderator'); //sprawdzenie uprawnień do usuwania komentarza
    }
}
