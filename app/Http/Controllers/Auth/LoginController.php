<?php

namespace App\Http\Controllers\Auth;

use App\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectTo()
    {
        $user = User::find(Auth::user()->id);

        if ($user->hasRole('admin')) {
            return route('admin');
        }
        if ($user->hasRole('user')) {
            return route('user.dashboard');
        }
    }
    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToFacebookProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookProviderCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
        } catch (InvalidStateException $e) {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();
        }
        $user = User::where('email', $facebookUser->getEmail())->first();
        if (!$user) {
            $avatarUrl = $facebookUser->getAvatar() . "&access_token=" . $facebookUser->token;
            $user = User::create([
                'name' => $facebookUser->getName(),
                'email' => $facebookUser->getEmail(),
                'provider' => 'facebook',
                'avatar' => $avatarUrl
            ]);
            $user->roles()->attach(Role::where('name', 'user')->first());
        }

        Auth::login($user, false);
        return redirect()->intended('/user/dashboard');
    }
}
