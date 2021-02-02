<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Storage;
use Image;
use App\User;
use App\Tutorial;

class UserController extends Controller
{
    public function user_account() {
      return view('users.user_account', ['user' => Auth::user()]);
    }

    public function edit_choice() {
      return view('users.user_account_edit');
    }

    public function show($id) {
      $user = User::findOrFail($id);
      $tutorials = Tutorial::where('user_id', $id)->orderBy('id', 'desc')->Paginate(10);
      return view('users.user_show', ['user' => $user])->with('tutorials', $tutorials);;
    }

    public function account_edit(Request $request) {
    $validatedData = $request->validate([
      'avatar' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    ]);
    $user = Auth::user();
    if ($request->hasFile('avatar'))
    {
      $banner = $request->file('avatar'); //pobieramy baner tutoriala
      $fileName = date("d_m_y-g_i_s_u_a") . '.' . $banner->getClientOriginalExtension(); //nazwa pliku względem czasu , przypisanie tego samego rozszerzenia pliku
      $loc = public_path('uploads/avatars/' . $fileName);
      Image::make($banner)->resize(100, 100)->save($loc);
      $OldFile = $user->avatar; // przypisanie starej nazwy
      $user->avatar = $fileName; //przypisanie nowej nazwy avatara
      if($OldFile!='default_avatar.png')// sprawdzenie czy avatar nie jest domyślnym
      {
        Storage::delete('avatars/' . $OldFile);//usunięcie starego avatara
      }
    }
    $user->update();//aktualizacja użytkownika

    return redirect('user_account')->with('success','Avatar został zmieniony !');
  }
}
