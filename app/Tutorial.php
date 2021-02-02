<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Presenters\DataP;

class Tutorial extends Model
{
    use DataP;

    protected $fillable = ['user_id', 'banner', 'video', 'steps', 'title', 'body']; // pola w których będą możliwe zmiany w modelu

    public function user()//wskazanie relacji między tutorialem a użytkownikiem
    {
        return $this->belongsTo('App\User');
    }

    public function comments()//wskazanie relacji między tutorialem a komentarzem
    {
        return $this->hasMany('App\Comment');
    }

    public function votes()//wskazanie relacji między tutorialem a głosem
    {
        return $this->hasMany('App\Vote');
    }

    public function category()//wskazanie relacji między kategorią a tutorialem
    {
        return $this->belongsTo('App\Category');
    }

}
