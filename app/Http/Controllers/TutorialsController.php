<?php

namespace App\Http\Controllers;

use Auth;
use App\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Form;
use Image;
use Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use App\Category;
use App\Notifications\SubscribeTutorial;
use App\User;
use App\Subscription;
use App\Comment;
use App\Steps;
use App\Vote;

class TutorialsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth')->only('store');
    }

    public function show($id, Request $request)
    {
      $tutorial = Tutorial::findOrFail($id); //findOrFail - przyjmuje id zwracając pojedyńczy model. Jeżeli nie istnieje model, zostanie wygenerowany błąd 404
      $steps = Steps::where('tutorial_id', $tutorial->id)->get();
      $comments = Comment::where('tutorial_id', $tutorial->id)->orderBy('id', 'desc')->Paginate(5);
      $vote = Vote::where('tutorial_id', '=', $tutorial->id)->where('user_id', '=', Auth::id())->where('vote', '=', 1)->first();
      $unvote = Vote::where('tutorial_id', '=', $tutorial->id)->where('user_id', '=', Auth::id())->where('vote', '=', 0)->first();
      $vote_count = Vote::where('tutorial_id', '=', $tutorial->id)->where('vote', '=', 1)->count();
      $unvote_count = Vote::where('tutorial_id', '=', $tutorial->id)->where('vote', '=', 0)->count();
      $tutorialSubscriptions = Subscription::where('tutorial_user_id', '=', $tutorial->user_id)->count();
      $subscription = Subscription::where('tutorial_user_id', '=', $tutorial->user_id)->where('subscribed_user_id', '=', Auth::id())->first();
      return view('tutorials.tutorial', ['tutorial' => $tutorial])->with('steps', $steps)
      ->with('comments', $comments)->with('vote', $vote)->with('vote_count', $vote_count)
      ->with('unvote', $unvote)->with('unvote_count', $unvote_count)
      ->with('tutorialSubscriptions', $tutorialSubscriptions)->with('subscription', $subscription);
    }

    public function index(Request $request)
    {
        $key = Input::get('search');
        $tutorials = Tutorial::where('title', 'like', '%'.$key.'%')->orderBy('id', 'desc')->Paginate(16); //pobiera wszystkie tutoriale znajdujące się w bazie danych.
        return view('tutorials.tutorials')->with('tutorials', $tutorials);;
    }

    public function my()
    {
      $tutorials = Tutorial::where('user_id', Auth::id())->orderBy('id', 'desc')->Paginate(15); //pobiera wszystkie tutoriale znajdujące się w bazie danych.
      return view('tutorials.my_tutorials', ['tutorials' => $tutorials]);
    }

    public function addTutorial()
    {
        $categories = Category::pluck('name', 'id');
        return view('tutorials.create')->with('categories', $categories);
    }

    public function edit(Request $request)
    {
      $tutorial = Tutorial::findOrFail($request->id);
      $this->authorize('update', $tutorial);
      $categories = Category::pluck('name', 'id');
      return view('tutorials.tutorialEdit', ['tutorial' => $tutorial])->with('categories', $categories);
    }

    public function category($id)
    {
      $tutorials = Tutorial::where('category_id', $id)->orderBy('id', 'desc')->Paginate(16);
      return view('tutorials.tutorials', ['tutorials' => $tutorials]);
   }

    public function store(Request $request)
    {
      $validatedData = $request->validate([ //sprawdzanie poprawności danych wpisanych w formularzu
        'banner' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        'video' => 'mimes:mp4|max:102400',
        'title' => 'required|unique:tutorials|max:100',
        'body' => 'required',
        'category_id' => 'required|integer',
        'steps.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
      ]);

      // pobranie danych przekazywanych przez POST i wstawienie danych
      $tutorial = new Tutorial;
      $tutorial->user_id = Auth::id();
      $tutorial->title = $request->title;
      $tutorial->body = $request->body;
      $tutorial->title = $request->title;
      $tutorial->category_id = $request->category_id;

      if ($request->hasFile('banner'))
      {
        $banner = $request->file('banner'); //pobieramy baner tutoriala
        $fileName = date("d_m_y-g_i_s_u_a") . '.' . $banner->getClientOriginalExtension(); //nazwa pliku względem czasu , przypisanie tego samego rozszerzenia pliku
        $fileNameM = date("d_m_y-g_i_s_u_a") . 'M' . '.' . $banner->getClientOriginalExtension();
        $loc = public_path('uploads/banners/' . $fileName); //wyznaczenie lokalizacji pliku banera public/banners/
        $locM = public_path('uploads/banners/' . $fileNameM);
        Image::make($banner)->resize(1366, 683)->save($loc);//zmiana rozdzielczości banera na 1366x683
        Image::make($banner)->resize(600,300)->save($locM);
        $tutorial->banner = $fileName; //zapisanie banera pod wygenerowaną nazwą
        $tutorial->bannerM = $fileNameM;
      }

      if ($request->hasFile('video'))
      {
        $video = $request->file('video');
        $fileName = date("d_m_y-g_i_s_u_a") . '_V' . '.' . $video->getClientOriginalExtension();
        $loc = public_path('uploads/videos/');
        $video->move($loc, $fileName);
        $tutorial->video = $fileName;
      }

      $tutorial->save();//zapisanie tutoriala

      if($request->file('steps'))
      {
          $tmp=0;
          $steps = $request->file('steps');
          $steps = collect($steps)->sortBy('name')->toArray();
          foreach($steps as $step)
          {
              if(!empty($step))
              {
                    $fileName = date("d_m_y-g_i_s_u_a") . $tmp . '.' . $step->getClientOriginalExtension();
                    $loc = public_path('uploads/steps/' . $fileName);
                    Image::make($step)->resize(1000, 500)->save($loc);

                    $tutorial_steps = new Steps;
                    $tutorial_steps->tutorial_step = $fileName;//przypisanie id twórcy
                    $tutorial_steps->tutorial_id = $tutorial->id;//przypisanie subskrybenta
                    $tutorial_steps->save();//zapisanie subskrypcji

                    $tmp++;
              }
          }
      }

      $subscriptions = Subscription::all(); //tabela subskrypcji
      foreach ($subscriptions as $subscription)//przejście po wierszach tabeli subskrypcji
      {
        if ($subscription->tutorial_user_id==Auth::id())//sprawdzenie czy autor jest ssubskrybowany
        {
          $user = User::find($subscription->subscribed_user_id);//przypisanie id użytkonika który subskrybuje do zmiennej user
          $user->notify(new SubscribeTutorial($tutorial));// utworzenie powiadomienia dla użytkownika subskrybującego
        }
      }

      return redirect::route('tutorials.id', $tutorial->id)->with('success','Dodano nowy poradnik !');
    }

    public function change(Request $request)
    {
      $tutorial = Tutorial::findOrFail($request->id);
      $this->authorize('update', $tutorial);
      $validatedData = $request->validate([ //sprawdzanie poprawności danych wpisanych w formularzu
        'banner' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        'video' => 'mimes:mp4|max:102400',
        'title' => 'required|unique:tutorials,title,'.$tutorial->id.'|max:100',
        'body' => 'required',
        'category_id' => 'required|integer',
        'steps.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
      ]);
      $tutorial->title = $request->title;
      $tutorial->body = $request->body;
      $tutorial->category_id = $request->category_id;

      if ($request->hasFile('banner'))
      {
        $banner = $request->file('banner'); //pobieramy baner tutoriala
        $fileName = date("d_m_y-g_i_s_u_a") . '.' . $banner->getClientOriginalExtension(); //nazwa pliku względem czasu , przypisanie tego samego rozszerzenia pliku
        $fileNameM = date("d_m_y-g_i_s_u_a") . 'M' . '.' . $banner->getClientOriginalExtension();
        $loc = public_path('uploads/banners/' . $fileName);
        $locM = public_path('uploads/banners/' . $fileNameM);
        Image::make($banner)->resize(1366, 683)->save($loc);//zmiana rozdzielczości banera na 1366x683
        Image::make($banner)->resize(600,300)->save($locM);
        $OldFile = $tutorial->banner; // przypisanie starej nazwy
        $OldFileM = $tutorial->bannerM;
        $tutorial->banner = $fileName; //przypisanie nowej nazwy banera
        $tutorial->bannerM = $fileNameM;
        if($OldFile!='default_banner.png' && $OldFileM!='default_bannerM.png')// sprawdzenie czy baner nie jest domyślnym
        {
          Storage::delete('banners/' .$OldFile);//usunięcie starego banera
          Storage::delete('banners/' .$OldFileM);
        }
      }

      if ($request->hasFile('video'))
      {
        $video = $request->file('video');
        $fileName = date("d_m_y-g_i_s_u_a") . '_V' . '.' . $video->getClientOriginalExtension();
        $loc = public_path('uploads/videos/');
        $OldFile = $tutorial->video;
        $tutorial->video = $fileName;
        $video->move($loc, $fileName);
        Storage::delete('videos/' .$OldFile);
      }

      if($request->file('steps'))
      {
          $tmp=0;
          $steps = $request->file('steps');
          $steps = collect($steps)->sortBy('name')->toArray();
          $steps_old = Steps::where('tutorial_id', $tutorial->id)->get();
          foreach($steps_old as $step)
          {
            $tutorial_step = $step->tutorial_step;
            Storage::delete('steps/' .$tutorial_step);
            $step -> delete();
          }
          foreach($steps as $step)
          {
              if(!empty($step))
              {
                    $fileName = date("d_m_y-g_i_s_u_a") . $tmp . '.' . $step->getClientOriginalExtension();
                    $loc = public_path('uploads/steps/' . $fileName);
                    Image::make($step)->resize(1000, 500)->save($loc);

                    $tutorial_steps = new Steps;
                    $tutorial_steps->tutorial_step = $fileName;//przypisanie id twórcy
                    $tutorial_steps->tutorial_id = $tutorial->id;//przypisanie subskrybenta
                    $tutorial_steps->save();//zapisanie subskrypcji

                    $tmp++;
              }
          }
      }

      $tutorial->update();//aktualizacja tutoriala

      return redirect::route('tutorials.id', $tutorial->id)->with('success','Poradnik został zaktualizowany !');//przekierowanie do ścieżki tutorial/id
    }

    public function deleteT(Request $request)
    {
      $tutorial = Tutorial::findOrFail($request->id);
      $this->authorize('delete', $tutorial);
      $OldFile = $tutorial->banner;
      $OldFileV = $tutorial->video;
      $OldFileM = $tutorial->bannerM;
      $steps = Steps::where('tutorial_id', 'like', '%'.$tutorial->id.'%')->get();
      foreach($steps as $step)
      {
        $tutorial_step = $step->tutorial_step;
        Storage::delete('steps/' .$tutorial_step);
        $step -> delete();
      }

      if($OldFile!='default_banner.png' && $OldFileM!='default_bannerM.png')// sprawdzenie czy baner nie jest domyślnym
      {
        Storage::delete('banners/' . $OldFile);//usunięcie starego banera
        Storage::delete('banners/' . $OldFileM);
        Storage::delete('videos/' .$OldFileV);
      }

      $tutorial -> delete();

      return redirect('tutorials')->with('success','Wybrany poradnik został usunięty !');
    }
}
