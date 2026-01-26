<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification
{
    use Queueable;

    protected $message;

    public function __construct($message = 'This is a test notification')
    {
        $this->message = $message;
    }

    // ⚡ فقط database
    public function via($notifiable)
    {
        return ['database'];
    }

    // البيانات اللي غادي تتخزن فـ notifications table
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
        ];
    }
}
