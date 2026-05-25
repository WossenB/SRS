<?php
namespace App\Livewire\Announcements;
use Livewire\Component;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
class AnnouncementForm extends Component {
    public $title, $content;
    public function save() {
        $this->validate(['title' => 'required', 'content' => 'required']);
        Announcement::create(['title' => $this->title, 'content' => $this->content, 'created_by' => Auth::id()]);
        return redirect()->route('announcements.index');
    }
    public function render() { return view('livewire.announcements.announcement-form')->layout('layouts.app'); }
}
