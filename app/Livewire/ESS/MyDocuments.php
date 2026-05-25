<?php

namespace App\Livewire\ESS;

use Livewire\Component;
use App\Models\EmployeeDocument;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class MyDocuments extends Component
{
    use WithFileUploads;

    public $file;
    public $title;
    public $category = 'Educational';

    public function upload()
    {
        $this->validate([
            'file' => 'required|max:25600|mimes:pdf,jpg,png',
            'title' => 'required',
        ]);

        $path = $this->file->store('documents', 'private');

        EmployeeDocument::create([
            'employee_id' => Auth::user()->employee->id,
            'title' => $this->title,
            'category' => $this->category,
            'file_path' => $path,
            'file_type' => $this->file->getClientOriginalExtension(),
            'file_size' => $this->file->getSize(),
            'verification_status' => 'pending',
        ]);

        $this->reset(['file', 'title']);
        session()->flash('message', 'Document uploaded successfully.');
    }

    public function render()
    {
        $docs = EmployeeDocument::where('employee_id', Auth::user()->employee?->id)->latest()->get();
        return view('livewire.ess.my-documents', ['documents' => $docs])->layout('layouts.app');
    }
}
