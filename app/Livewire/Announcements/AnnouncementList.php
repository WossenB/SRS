<?php

namespace App\Livewire\Announcements;

use Livewire\Component;
use App\Models\Announcement;
use Livewire\WithPagination;

class AnnouncementList extends Component
{
    use WithPagination;

    public function render()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('livewire.announcements.announcement-list', ['announcements' => $announcements])->layout('layouts.app');
    }
}
