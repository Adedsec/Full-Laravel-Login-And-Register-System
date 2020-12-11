<?php


namespace App\Services\Notification\Providers;


use App\Services\Notification\Exceptions\UserDoesNotHaveNumber;
use App\Services\Notification\Providers\Contracts\Provider;
use App\User;
use GuzzleHttp\Client;

class SmsProvider implements Provider
{
    private $user;
    private $message;

    public function __construct(User $user, string $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    public function send()
    {
        $this->havePhoneNumber();
        $client = new Client();
        $response = $client->post(config('services.sms.uri'), $this->prepareDataForSms());
        return $response->getBody();
    }

    private function prepareDataForSms()
    {
        $data = array_merge(config('services.sms.auth'),
            [
                'op' => 'send',
                'message' => $this->message,
                'to' => $this->user->phone_number,

            ]);
        return [
            'json' => $data
        ];
    }

    public function havePhoneNumber()
    {
        if (is_null($this->user->phone_number)) {
            throw new UserDoesNotHaveNumber();
        }
    }
}
