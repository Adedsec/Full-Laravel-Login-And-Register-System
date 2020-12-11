<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Code;
use App\Services\Auth\TwoFactorAuthentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{

    protected $twoFactor;


    public function __construct(TwoFactorAuthentication $twoFactor)
    {
        $this->middleware(['auth'])->except('resend');
        $this->twoFactor = $twoFactor;
    }

    public function showToggleForm()
    {
        return view('auth.two-factor.toggle');
    }

    public function showEnterCodeForm()
    {
        return view('auth.two-factor.code');
    }

    public function activate()
    {
        $response = $this->twoFactor->requestCode(Auth::user());
        return $response === $this->twoFactor::CODE_SENT
            ? redirect()->route('auth.two.factor.code.form')
            : back()->with('cantSendCode', true);
    }

    public function confirmCode(Code $request)
    {
        $request->validated();
        $response = $this->twoFactor->activate();

        return $response === $this->twoFactor::ACTIVATED
            ? redirect()->route('home')->with('twoFactorActivated', true)
            : back()->with('invalidCode', true);
    }

    public function resend()
    {
        $this->twoFactor->resend();
        return back()->with('codeResent', true);
    }


    public function deactivate()
    {
        $this->twoFactor->deactivate(Auth::user());
        return back()->with('twoFactorDeactivated', true);
    }

}
