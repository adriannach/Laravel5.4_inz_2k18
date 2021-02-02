<?php

namespace App\Policies;

use App\User;
use App\Tutorial;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class TutorialPolicy
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
    public function update(User $user, Tutorial $tutorial)
    {
        return $user->id === $tutorial->user_id;//sprawdzenie uprawnień do edycji tutorialu
    }
    public function delete(User $user, Tutorial $tutorial)
    {
        return $user->id === $tutorial->user_id || User::findOrFail($user->id)->hasRole('administrator') || User::findOrFail($user->id)->hasRole('moderator');//sprawdzenie uprawnień do usuwania tutorialu
    }

}
