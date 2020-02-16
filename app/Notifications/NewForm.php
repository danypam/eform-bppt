<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Submission;

class NewForm extends Notification
{
    use Queueable;

    private $submission;

    public function __construct($submission)
    {
        $this->submission=$submission;
    }

    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'submission'=>$this->submission,
            'user'=>auth()->user()
        ];
    }
    public function toBroadcast($notifiable)
    {
        return [
            'data'=>[
                'submission'=>$this->submission,
                'user'=>auth()->user()
            ]
        ];
    }
}
