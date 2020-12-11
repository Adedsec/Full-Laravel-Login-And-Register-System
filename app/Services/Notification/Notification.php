<?php

namespace App\Services\Notification;

use App\Services\Notification\Providers\Contracts\Provider;
use App\User;
use Illuminate\Mail\Mailable;

/**
 * Class Notification
 * @package App\Services\Notification
 * @method sendEmail(User $user, Mailable $mailable)
 * @method sendSms(User $user, string $message)
 */
class Notification
{
    public function __call($name, $arguments)
    {
        $providerPath = __NAMESPACE__ . '\Providers\\' . substr($name, 4) . 'Provider';
        if (!class_exists($providerPath)) {
            throw new \Exception('class Does not Exist !');
        }
        $providerInstance = new $providerPath(...$arguments);
        if (!is_subclass_of($providerInstance, Provider::class)) {
            throw new \Exception("class must implements App\Services\Notification\Providers\Contracts\Provider");
        }
        return $providerInstance->send();
    }
}
