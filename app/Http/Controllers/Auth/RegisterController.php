<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Socialite;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/tutorials';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        if($user->id == 1)
        {
          $user->assignRole('administrator'); //przypisanie pierwszemu zarejestrowanemu użytkownikowi rangi administratora
        }
        else
        {
          $user->assignRole('użytkownik'); //ranga użytkownika zostaje przypisana każdemu pozostałemu zarejestrowanemu
        }
        return $user;
    }

    public function FromTheProvider($provider)
{
    return Socialite::driver($provider)->redirect();
}

public function CreateProviderUser($user, $provider)
    {
        $RegisteredUser = User::where('provider_id', $user->id)->first();
        if($RegisteredUser)
        {
            return $RegisteredUser;
        }
        else
        {
            $user = User::create([
                'name'     => $user->name,
                'email'    => $user->email,
                'provider' => $provider,
                'provider_id' => $user->id
            ]);
            $user->assignRole('użytkownik');
            return $user;
        }
    }

    public function FeedbackData($provider)
    {
        $user = Socialite::driver($provider)->user();
        Auth::login($this->CreateProviderUser($user, $provider), true);
        return redirect('tutorials');
    }
}
