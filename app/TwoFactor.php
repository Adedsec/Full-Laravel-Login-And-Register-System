<?php

namespace App;

use App\Jobs\SendSms;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed code_for_send
 */
class TwoFactor extends Model
{
    const CODE_EXPIRE_TIME = 60; //seconds

    protected $table = 'two_factor';
    protected $fillable = [
        'user_id',
        'code'
    ];

    public static function generateCodeFor(User $user)
    {
        $user->code()->delete();
        return static::create(
            [
                'user_id' => $user->id,
                'code' => mt_rand(1000, 9999)
            ]
        );
    }

    public function getCodeForSendAttribute()
    {
        return __('auth.code for send', ['code' => $this->code]);
    }

    public function send()
    {
        SendSms::dispatch($this->user, $this->code_for_send);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired()
    {
        return $this->created_at->diffInSeconds(now()) > self::CODE_EXPIRE_TIME;
    }

    public function isEqualWith(string $code)
    {
        return $this->code == $code;
    }


}
