<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class AdminUsersController extends Controller
{
    public function index() {
      $users = User::where('name', 'like', '%'.Input::get('search').'%')->Paginate(20);
      $roles = Role::pluck('name', 'name');
      return view('admin.admin_users', ['users' => $users])->with('roles', $roles);
    }

    public function activate(Request $request) {
        if ($request->user_id != Auth::id())
        {
            $user = User::findOrFail($request->user_id);
            $user->active = !($user->active); //zmiana statusu użytkownika zablokowany/odblokowany
            $user->save();
            $status = 'odblokowany';
            if($user->active != 1)
            {
               $status = 'zablokowany';
            }
            return redirect::route("admin.users.index")->with('success','Użytkownik '.$user->name.' został '.$status.' !');
        }
        else
        {
            return redirect::back()->withErrors(['Nie możesz zmienić swojego statusu użytkownika!']);
        }
    }

    public function UpdateRole(Request $request) {
        if ($request->user_id != Auth::id())
        {
            $user = User::findOrFail($request->user_id);
            $user->syncRoles($request->role); //zmiana rangi użytkownika
            return redirect::route("admin.users.index")->with('success','Ranga użytkownika ' .$user->name.' została zmieniona na '.$request->role.'!');
        }
        else
        {
            return redirect::back()->withErrors(['Nie możesz zmienić swojej rangi !']);
        }
    }
}
