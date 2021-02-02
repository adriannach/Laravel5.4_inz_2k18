<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\DataP;


class Comment extends Model
{
    use DataP;

    protected $fillable = ['tutorialComment', 'tutorial_id', 'user_id'];

    public function user()//wskazanie relacji między komentarzem a użytkownikiem
    {
        return $this->belongsTo('App\User');
    }

    public function tutorial()//wskazanie relacji między komentarzem a tutorialem
    {
        return $this->belongsTo('App\Tutorial');
    }

}
