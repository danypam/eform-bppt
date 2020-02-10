<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewForm extends Notification
{
    use Queueable;

    protected $submission;

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
        ];
    }
    public function toBroadcast($notifiable)
    {
        return [
            'submission'=>$this->submission,
        ];
    }
}
