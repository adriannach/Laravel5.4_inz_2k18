<?php

namespace App\Policies;

use App\User;
use App\Vote;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class SubscriptionPolicy
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
    public function delete(User $user, Vote $subscription)
    {
        return Auth::id() === $subscription->subscribed_user_id; //sprawdzenie uprawnień do usuwania głosu
    }
}
