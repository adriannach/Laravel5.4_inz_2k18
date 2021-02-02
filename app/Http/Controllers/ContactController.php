<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Auth;

class ContactController extends Controller
{
  public function store(Request $request)
  {
    if(Auth::user())
    {
      $this->validate($request, [
        'message' => 'required'
      ]);

      Mail::send('emails.ContactMessage', [
        'name' => Auth::user()->name,
        'email' => Auth::user()->email,
        'msg' => $request->message
      ],
        function($email)
          use($request)
          {
            $email->from(Auth::user()->email, Auth::user()->name);
            $email->to('laraveltutorialadrian@gmail.com')->subject('Contact Message');
          }
      );
      return redirect()->back()->with('success','Dziękujemy za wysłanie wiadomości !');
    }
    else
    {
      $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required'
      ]);

      Mail::send('emails.ContactMessage', [
        'name' => $request->name,
        'email' => $request->email,
        'msg' => $request->message
      ],
        function($email)
          use($request)
          {
            $email->from($request->email, $request->name);
            $email->to('laraveltutorialadrian@gmail.com')->subject('Contact Message');
          }
      );
      return redirect()->back()->with('success','Dziękujemy za wysłanie wiadomości !');
    }
  }
}
