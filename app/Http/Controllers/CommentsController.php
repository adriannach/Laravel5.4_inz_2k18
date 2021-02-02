<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\Tutorial;
use Auth;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Redirect;

class CommentsController extends Controller
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
        if($request->tutorialComment!=null)
        {
          $this->authorize('create', $tutorial);
          Comment::create([//tworzymy komentarz
              'tutorialComment' => $request->tutorialComment,
              'tutorial_id' => $tutorial->id,
              'user_id' => Auth::id(),
          ]);
          return redirect::route('tutorials.id', $tutorial->id)->with('success','Dodano komentarz !');
        }
        else
        {
          return redirect::route('tutorials.id', $tutorial->id)->with('error','Próbowano dodać pusty komentarz !');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
      $this->authorize('delete', $comment);
      $comment -> delete();
      return redirect::route('tutorials.id', $comment->tutorial_id)->with('success','Usunięto komentarz !');
    }
}
