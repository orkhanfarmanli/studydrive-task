<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;
use App\Mail\RegistrationMail;
use Illuminate\Support\Facades\Mail;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */


    public function sendFailedLoginResponse(Request $request)
    {
        // Validate user credentials
        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',
        ]);

        // Create user
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'active' => 0,
            'register_token' => str_random(25)
        ]);

        // Send mail to user for email confirmation
        Mail::to($user)->send(new RegistrationMail($user));

        // Authenticate and login the registered user
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        }
        
        return redirect()->route('login');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('login');
    }
}
