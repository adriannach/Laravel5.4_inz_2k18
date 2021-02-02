<?php

namespace App\Policies;

use App\User;
use App\Vote;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class VotePolicy
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
    public function delete(User $user, Vote $vote)
    {
        return Auth::id() === $vote->user_id; //sprawdzenie uprawnień do usuwania głosu
    }
}
