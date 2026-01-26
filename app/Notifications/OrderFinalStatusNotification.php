<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OrderFinalStatusNotification extends Notification
{
    use Queueable;

    public $orderData;

    /**
     * Create a new notification instance.
     *
     * @param array $orderData
     */
    public function __construct(array $orderData)
    {
        $this->orderData = $orderData;
    }

    /**
     * Delivery channels: database + broadcast
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->orderData['order_id'],
            'final_status' => $this->orderData['final_status'], // accepted / partially_accepted / rejected
            'total_amount' => $this->orderData['total_amount'],
            'summary' => $this->orderData['summary'], // array of merchants + status
            'message' => $this->orderData['message'], // human readable
        ];
    }

}
