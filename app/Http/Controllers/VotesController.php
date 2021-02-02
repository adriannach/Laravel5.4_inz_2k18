<?php

namespace App\Http\Controllers;

use App\Vote;
use Illuminate\Http\Request;
use App\Tutorial;
use Auth;
use App\Http\Requests\VoteRequest;
use Illuminate\Support\Facades\Redirect;

class VotesController extends Controller
{
  public function __construct() {
    $this->middleware('auth')->only('store');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tutorial = Tutorial::findOrFail($request->tutorial_id);//pobieramy id tutoriala
        $this->authorize('create', $tutorial);
        $vote_unvote = $request->vote_unvote;
        $voteup = Vote::where('tutorial_id', '=', $tutorial->id)->where('user_id', '=', Auth::id())->where('vote', '=', 1)->first();
        $votedown = Vote::where('tutorial_id', '=', $tutorial->id)->where('user_id', '=', Auth::id())->where('vote', '=', 0)->first();

        if($vote_unvote==1)
        {
          if($tutorial->user_id == Auth::id())
          {
            return redirect::route('tutorials.id', $tutorial->id)->with('error','Nie możesz polubić swojego poradnika !');
          }
          else
          {
            $count = Vote::where('tutorial_id', '=', $tutorial->id)->where('user_id', '=', Auth::id())->where('vote', '=', 1)->count();
            if($count==0)
            {
              if($votedown)
              {
                Vote::create([//tworzymy głos
                    'vote' => 1,
                    'tutorial_id' => $tutorial->id,
                    'user_id' => Auth::id(),
                ]);
                $votedown -> delete();
                return redirect::route('tutorials.id', $tutorial->id)->with('success','Polubiono poradnik !');
              }
              else
              {
                Vote::create([//tworzymy głos
                    'vote' => 1,
                    'tutorial_id' => $tutorial->id,
                    'user_id' => Auth::id(),
                ]);
                return redirect::route('tutorials.id', $tutorial->id)->with('success','Polubiono poradnik !');
              }
            }
            else
            {
              return redirect::route('tutorials.id', $tutorial->id)->with('error','Oddano już polubienie na ten poradnik !');
            }
          }
        }
        else
        {
          if($tutorial->user_id == Auth::id())
          {
            return redirect::route('tutorials.id', $tutorial->id)->with('error','Nie możesz nie lubić swojego poradnika !');
          }
          else
          {
            $count = Vote::where('tutorial_id', '=', $tutorial->id)->where('user_id', '=', Auth::id())->where('vote', '=', 0)->count();
            if($count==0)
            {
              if($voteup)
              {
                Vote::create([//tworzymy głos
                    'vote' => 0,
                    'tutorial_id' => $tutorial->id,
                    'user_id' => Auth::id(),
                ]);
                $voteup -> delete();
                return redirect::route('tutorials.id', $tutorial->id)->with('success','Nie lubisz tego poradnika !');
              }
              else
              {
                Vote::create([//tworzymy głos
                    'vote' => 0,
                    'tutorial_id' => $tutorial->id,
                    'user_id' => Auth::id(),
                ]);
                return redirect::route('tutorials.id', $tutorial->id)->with('success','Nie lubisz tego poradnika !');
              }
            }
            else
            {
              return redirect::route('tutorials.id', $tutorial->id)->with('error','Już nie lubisz tego poradnika !');
            }
          }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function show(Vote $vote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function edit(Vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vote $vote)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vote $vote)
    {
      if(Auth::id() === $vote->user_id)
      {
        $vote -> delete();
        return redirect::route('tutorials.id', $vote->tutorial_id)->with('success','Usunięto polubienie !');
      }
      else
      {
        return redirect::route('tutorials.id', $vote->tutorial_id)->with('success','Nie można usunąć głosu !');
      }
    }
}
