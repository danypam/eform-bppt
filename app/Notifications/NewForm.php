<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewForm extends Notification
{
    use Queueable;

    public $submission;

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
        return new BroadcastMessage( [
            'submission'=>$this->submission,
            'user'=>auth()->user()
        ]);
    }
}
