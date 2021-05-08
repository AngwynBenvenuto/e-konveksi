<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    //ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Max login attempts allowed.
     */
    public $maxAttempts = 5;

    /**
     * Number of minutes to lock the login.
     */
    public $decayMinutes = 3;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user)
    {
        if(!$user->verified) {
            auth()->logout();
            return back()
                ->with('email', $user->email)
                ->with('verification_error', 'Kamu hanya dapat login ketika sudah konfirmasi email.
                    Bila ingin melakukan verifikasi ulang,
                    silahkan tekan link yang sudah tertera dibawah');
        }
        return redirect()->intended($this->redirectPath());
    }


    /**
     * Logout
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login')
                ->with('success', 'You have been logout.');
    }


}
