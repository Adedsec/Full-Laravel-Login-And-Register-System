<?php


namespace App\Services\Auth;


use App\TwoFactor;
use App\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;


class TwoFactorAuthentication
{


    const CODE_SENT = 'code.sent';
    const INVALID_CODE = 'invalid.code';
    const ACTIVATED = 'code.activated';
    const AUTHENTICATED = 'code.authenticated';

    protected $request;
    protected $code;
    protected $user;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function requestCode(User $user)
    {
        $code = TwoFactor::generateCodeFor($user);
        $this->setSession($code);
        $code->send();
        //dd($code);
        return self::CODE_SENT;
    }


    protected function setSession(TwoFactor $code)
    {
        session([
            'code_id' => $code->id,
            'user_id' => $code->user_id,
            'remember' => $this->request->remember
        ]);
    }

    public function activate()
    {
        if (!$this->isValidCode()) return self::INVALID_CODE;

        $this->getToken()->delete();

        $this->getUser()->activateTwoFactor();

        $this->forgetSession();

        return self::ACTIVATED;

    }

    public function login()
    {
        if (!$this->isValidCode()) return self::INVALID_CODE;

        $this->getToken()->delete();

        Auth::login($this->getUser(), session('remember'));
        $this->forgetSession();

        return static::AUTHENTICATED;
    }

    public function resend()
    {
        return $this->requestCode($this->getUser());
    }

    public function deactivate(User $user)
    {
        $user->deactivateTwoFactor();
    }

    protected function isValidCode()
    {
        return !$this->getToken()->isExpired() && $this->getToken()->isEqualWith($this->request->code);
    }

    protected function getToken()
    {
//        if (is_null($this->code))
//            $this->code = TwoFactor::findOrFail(session('code_id'));
//        return $this->code;

        return $this->code ?? $this->code = TwoFactor::findOrFail(session('code_id'));
    }

    protected function getUser()
    {
        return $this->user ?? $this->user = User::findOrFail(session('user_id'));
    }

    protected function forgetSession()
    {
        session()->forget(['user_id', 'code_id', 'remember']);
    }


}
