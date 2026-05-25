<?php

namespace App\Livewire\Employee;

use Livewire\Component;
use App\Models\EmployeeDocument;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class DocumentVerificationList extends Component
{
    use WithPagination;

    public function verify(int $id)
    {
        $doc = EmployeeDocument::findOrFail($id);
        $doc->update([
            'verification_status' => 'verified',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);
        session()->flash('message', 'Document verified.');
    }

    public function render()
    {
        $documents = EmployeeDocument::where('verification_status', 'pending')
            ->with('employee')
            ->latest()
            ->paginate(10);

        return view('livewire.employee.document-verification-list', [
            'documents' => $documents
        ])->layout('layouts.app');
    }
}
