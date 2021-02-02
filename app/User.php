<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tutorials() {//wskazanie relacji między tutorialem a użytkownikiem
        return $this->hasMany("App\Tutorial");
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function addNew($input)
    {
        $check = static::where('facebook_id',$input['facebook_id'])->first();

        if(is_null($check)){
            return static::create($input);
        }
        return $check;
    }

    public function subscriptions()//wskazanie relacji między użytkownikiem a subskrypcją
    {
        return $this->hasMany('App\Subscription');
    }
}
