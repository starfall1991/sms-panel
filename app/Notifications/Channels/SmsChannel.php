<?php

namespace App\Notifications\Channels;

use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class SmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     *
     * @return void
     */
    public function send(User $notifiable, Notification $notification): void
    {
        if ( ! $to = $notifiable->routeNotificationFor('sms', $notification)) {
            return;
        }

        $message = $notification->toSms($notifiable);

        $payload = [
            'from' => config('services.sms.from'),
            'to'   => $to,
            'text' => trim($message),
        ];

        Http::post(config('services.sms.url'), $payload);
    }
}
