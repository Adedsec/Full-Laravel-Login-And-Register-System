<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Code;
use App\Providers\RouteServiceProvider;
use App\Rules\recaptcha;
use App\Services\Auth\TwoFactorAuthentication;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    protected $twoFactor;
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

    //use AuthenticatesUsers;
    use ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @param TwoFactorAuthentication $twoFactor
     */
    public function __construct(TwoFactorAuthentication $twoFactor)
    {
        $this->middleware('guest')->except('logout');
        $this->twoFactor = $twoFactor;
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function showCodeForm()
    {
        return view('auth.two-factor.login');
    }


    public function login(Request $request)
    {
        $this->validateForm($request);
        //WITH TWO FACTOR
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        if (!$this->isValidCredentials($request)) {
            $this->incrementLoginAttempts($request);
            return $this->sendLoginFailedResponse();
        }

        $user = $this->getUser($request);
        if ($user->hasTwoFactor()) {
            $this->twoFactor->requestCode($user);
            return $this->sendHasTwoFactorResponse();
        }

        Auth::login($user, $request->remember);
        return $this->sendSuccessResponse();

//        WITHOUT TWO FACTOR :
//        if (method_exists($this, 'hasTooManyLoginAttempts') &&
//            $this->hasTooManyLoginAttempts($request)) {
//            return $this->sendLockoutResponse($request);
//        }
//        $this->incrementLoginAttempts($request);
//
//        if ($this->attemptLogin($request)) {
//            return $this->sendSuccessResponse();
//        } else {
//            return $this->sendLoginFailedResponse();
//        }

    }

    public function confirmCode(Code $request)
    {
        $response = $this->twoFactor->login();


        return $response === $this->twoFactor::AUTHENTICATED
            ? $this->sendSuccessResponse()
            : back()->with('invalidCode', true);
    }

    protected function validateForm(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required'],
            'g-recaptcha-response' => ['required', new recaptcha]
        ],
            [
                'g-recaptcha-response.required' => __("auth.recaptcha")
            ]
        );
    }

//    protected function attemptLogin(Request $request)
//    {
//        return Auth::attempt($request->only('email', 'password'), $request->filled('remember'));
//    }

    protected function sendSuccessResponse()
    {
        session()->regenerate();
        return redirect()->intended();
    }

    protected function sendLoginFailedResponse()
    {
        return redirect()->back()->with('wrongCredentials', true);
    }

    protected function isValidCredentials(Request $request)
    {
        return Auth::validate($request->only(['email', 'password']));
    }


    public function logout()
    {
        session()->invalidate();
        Auth::logout();
        return redirect()->route('home');
    }

    protected function username()
    {
        return 'email';
    }

    protected function getUser($request)
    {
        return User::where('email', $request->email)->firstOrFail();
    }

    protected function sendHasTwoFactorResponse()
    {
        return redirect()->route('auth.login.code.form');
    }
}
