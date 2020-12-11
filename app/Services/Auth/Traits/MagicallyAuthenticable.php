<?php


namespace App\Services\Auth\Traits;


use App\LoginToken;
use Illuminate\Support\Str;

trait MagicallyAuthenticable
{
    public function magicToken()
    {
        return $this->hasOne(LoginToken::class);
    }

    public function createToken()
    {
        $this->magicToken()->delete();
        return $this->magicToken()->create([
            'token' => Str::random(50)
        ]);
    }
}
