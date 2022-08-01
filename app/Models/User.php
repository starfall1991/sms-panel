<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    public function routeNotificationForSms(Notification $notification): int
    {
        return $this->mobile;
    }

    public function sms(): HasMany
    {
        return $this->hasMany(Sms::class, 'user_id');
    }
}
