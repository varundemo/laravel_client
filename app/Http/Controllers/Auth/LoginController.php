<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
     protected function credentials(Request $request)
    {
        
        // $password = "anujanuj";
        // $newpass = Hash::make($password);
        // dd($newpass);
        $credentials = $request->only($this->username(), 'password');
        $user = User::where($this->username(), $request->{$this->username()})->first();
        

        if(!empty($user)){
            if ( ( ($user && $user->contractor && $user->contractor->status === 'approved') || ($user->role_id == 1) ) ) {
                return $credentials;
            }else if(($user && $user->contractor && $user->contractor->status != 'approved')){
                 $this->incrementLoginAttempts($request);
                    $errorMessage = "Our team is validating your information. We will notify you via email as soon as your account is approved.";
                    session()->flash('pending_error', $errorMessage);
                    return [];
            }
        }
        return [];
    }
}
