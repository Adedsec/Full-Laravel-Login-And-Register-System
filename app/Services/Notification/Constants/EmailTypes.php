<?php


namespace App\Services\Notification\Constants;


use App\Mail\ForgetPassword;
use App\Mail\TopicCreated;
use App\Mail\UserRegistered;
use phpDocumentor\Reflection\Types\Integer;

class EmailTypes
{

    const USER_REGISTERED = 1;
    const TOPIC_CREATES = 2;
    const FORGET_PASSWORD = 3;

    public static function toString()
    {
        return [
            self::USER_REGISTERED => 'ثبت نام کاربر',
            self::TOPIC_CREATES => 'ایجاد مقاله ',
            self::FORGET_PASSWORD => 'فراموشی رمز عبور',
        ];
    }

    public static function toMail($type)
    {
        try {
            return $types = [
                self::USER_REGISTERED => UserRegistered::class,
                self::TOPIC_CREATES => TopicCreated::class,
                self::FORGET_PASSWORD => ForgetPassword::class
            ][$type];
        } catch (\Throwable $th) {
            throw new \InvalidArgumentException('mailable Does not Exists');
        }

    }
}
