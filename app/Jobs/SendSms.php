<?php

namespace App\Jobs;

use App\Services\Notification\Notification;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $text;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param string $text
     */
    public function __construct(User $user, string $text)
    {
        $this->user = $user;
        $this->text = $text;
    }

    /**
     * Execute the job.
     *
     * @param Notification $notification
     * @return void
     */
    public function handle(Notification $notification)
    {
        $notification->sendSms($this->user, $this->text);
    }
}
