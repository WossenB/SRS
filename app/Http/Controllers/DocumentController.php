<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Securely download an employee document.
     * SRS Ref: FR-DOC-01-05
     */
    public function download(EmployeeDocument $document)
    {
        $user = Auth::user();

        // RBAC Check
        if (!$user->hasRole('Super Admin') && !$user->hasRole('HR Admin') && !$user->hasRole('HR Officer')) {
            // Check if it's their own document
            if ($document->employee->user_id !== $user->id) {
                // If it's a manager, check if they are the supervisor
                if ($user->hasRole('Department Manager')) {
                   if ($document->employee->supervisor_id !== $user->employee->id) {
                       abort(403);
                   }
                } else {
                    abort(403);
                }
            }
        }

        // Log download to audit trail
        \Illuminate\Support\Facades\DB::table('audit_logs')->insert([
            'action_type' => 'document_download',
            'correlation_id' => (string) \Illuminate\Support\Str::uuid(),
            'user_id' => $user->id,
            'before_json' => json_encode(['document_id' => $document->id, 'title' => $document->title]),
            'after_json' => null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);

        return Storage::disk('private')->download($document->file_path, $document->title);
    }
}
