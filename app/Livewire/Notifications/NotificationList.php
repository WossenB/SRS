<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationList extends Component
{
    public function markRead($id)
    {
        Auth::user()->notifications()->findOrFail($id)->markAsRead();
    }

    public function render()
    {
        $notifications = Auth::user()->notifications()->paginate(15);
        return view('livewire.notifications.notification-list', ['notifications' => $notifications])->layout('layouts.app');
    }
}
