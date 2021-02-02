<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['tutorial_user_id', 'subscribed_user_id'];

    public function user()//wskazanie relacji między subsrypcją a użytkownikiem
    {
        return $this->belongsTo('App\User');
    }
}
