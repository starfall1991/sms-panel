<?php

namespace App\Notifications;

use App\Models\User;
use App\Notifications\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SmsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  User  $notifiable
     *
     * @return array
     */
    public function via(User $notifiable): array
    {
        return [SmsChannel::class];
    }

    public function viaQueues(): array
    {
        return [SmsChannel::class => 'sms-queue'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  User  $notifiable
     *
     * @return string
     */
    public function toSms(User $notifiable): string
    {
        return "test has been send to $notifiable->id";
    }
}
