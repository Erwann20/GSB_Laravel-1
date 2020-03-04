<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use \Illuminate\Http\Request;

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
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
     protected function validateLogin(Request $request)
     {
         $messages = [
             'name.required' => 'Username is already registered',
             'email.exists' => 'Email or username already registered',
             'password.required' => 'Password cannot be empty',
         ];
 
         $request->validate([
             'name' => 'string|required',
             'password' => 'required|string',
             'email' => 'string|exists:users',
         ], $messages);
     }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

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
    * Get the login username to be used by the controller.
    *
    * @return string
    */
    public function username()
    {
        $login = request()->input('name');

     $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
     request()->merge([$field => $login]);

     return $field;
    }
}
