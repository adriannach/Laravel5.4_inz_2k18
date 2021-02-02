<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;
use Auth;
use App\Tutorial;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SubscribeRequest;
use DB;
use App\User;

class SubscriptionController extends Controller
{

  public function __construct() {
    $this->middleware('auth')->only('store');
  }
  public function index()
  {
    $notifications = Auth::user()->Notifications()->paginate(10);
    return view('notifictions.subscriptions', ['notifications' => $notifications]);
  }

  public function store(Request $request)
  {
        $tutorial = Tutorial::findOrFail($request->tutorial_id);//pobieramy id tutoriala
        if($tutorial->user_id == Auth::id())
        {
          return redirect::route('tutorials.id', $tutorial->id)->with('error','Nie możesz subskrybować siebie samego !');
        }
        else
        {
          $count = Subscription::where('tutorial_user_id', '=', $tutorial->user_id)->where('subscribed_user_id', '=', Auth::id())->count();
          if($count==0)
          {
            $this->authorize('create', $tutorial);
            Subscription::create([//tworzymy subskrypcje
                'tutorial_user_id' => $tutorial->user_id,
                'subscribed_user_id' => Auth::id(),
            ]);
          return redirect::route('tutorials.id', $tutorial->id)->with('success','Subskrybujesz użytkownika '.$tutorial->user->name. ' !');
          }
          else
          {
            return redirect::route('tutorials.id', $tutorial->id)->with('error','Już subskrybujesz użytkownika ' .$tutorial->user->name. ' !');
          }
        }
  }

  public function destroy(Subscription $subscription)
  {
      $user = User::where('id', '=', $subscription->tutorial_user_id)->first();
      $subscription -> delete();
      return Redirect::back()->with('success','Deskrybowano użytkownika ' .$user->name. ' !');
  }

}
