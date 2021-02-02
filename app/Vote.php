<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['vote', 'tutorial_id', 'user_id'];

    public function user()//wskazanie relacji między głosem a użytkownikiem
    {
        return $this->belongsTo('App\User');
    }

    public function tutorial()//wskazanie relacji między głosem a tutorialem
    {
        return $this->belongsTo('App\Tutorial');
    }
}
