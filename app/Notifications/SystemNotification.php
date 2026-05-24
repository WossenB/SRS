<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\NotificationPreference;

class SystemNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $title, public string $message, public string $category = 'system', public string $type = 'info')
    {
    }

    public function via(object $notifiable): array
    {
        // Check preferences
        $pref = NotificationPreference::where('user_id', $notifiable->id)
            ->where('category', $this->category)
            ->first();

        $via = [];
        if (!$pref || $pref->in_app_enabled) $via[] = 'database';
        if (!$pref || $pref->email_enabled) $via[] = 'mail';

        return $via;
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject($this->title)
                    ->line($this->message)
                    ->action('View Details', url('/dashboard'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'category' => $this->category,
        ];
    }
}
