<?php

namespace App\Jobs;

use App\Services\Notification\Notification;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $mailable;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param Mailable $mailable
     */
    public function __construct(User $user, Mailable $mailable)
    {
        $this->user = $user;
        $this->mailable = $mailable;
    }

    /**
     * Execute the job.
     *
     * @param Notification $notification
     * @return void
     */
    public function handle(Notification $notification)
    {
        return $notification->sendEmail($this->user, $this->mailable);
    }
}
