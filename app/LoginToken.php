<?php

namespace App;

use App\Jobs\SendEmail;
use App\Mail\SendMagicLink;
use Illuminate\Database\Eloquent\Model;

class LoginToken extends Model
{
    //

    const TOKEN_EXPIRE_TIME = 10;

    protected $fillable = [
        'token'
    ];

    public function getRouteKeyName()
    {
        return 'token';
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function send(array $options)
    {
        SendEmail::dispatch($this->user, new SendMagicLink($this, $options));
    }

    public function isExpired()
    {
        return $this->created_at->diffInSeconds(now()) > self::TOKEN_EXPIRE_TIME;
    }

    public function scopeExpired($query)
    {
        $query->where('created_at', '<', now()->subSeconds(self::TOKEN_EXPIRE_TIME));
    }
}
