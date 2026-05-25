<div class="max-w-5xl mx-auto space-y-8">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-black text-gray-900">Performance Review</h2>
            <p class="text-gray-500 font-medium">{{ $review->employee->first_name }} {{ $review->employee->last_name }} · {{ strtoupper($review->status) }}</p>
        </div>
        <div class="flex gap-2">
             @if($review->status === 'hr_calibration' && auth()->user()->hasAnyRole(['Super Admin', 'HR Admin']))
                <button wire:click="publish" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold">Publish Final</button>
             @endif

             @if($review->status === 'published' && auth()->id() === $review->employee->user_id && !$review->acknowledged_at)
                <button wire:click="acknowledge" class="bg-green-600 text-white px-6 py-2 rounded-xl font-bold">Acknowledge & Sign</button>
             @endif

             @if($review->acknowledged_at)
                <span class="px-4 py-1.5 bg-green-50 text-green-700 rounded-full text-xs font-black uppercase tracking-widest flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                    Acknowledged
                </span>
             @endif
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-indigo-50 text-indigo-700 px-6 py-3 rounded-2xl font-bold">{{ session('message') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Self Assessment -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold mb-6 border-b pb-4">Self Assessment</h3>
            <textarea wire:model="self_data.comments" class="w-full rounded-2xl border-gray-100 h-32" {{ $review->status !== 'self_assessment' ? 'disabled' : '' }}></textarea>
            @if($review->status === 'self_assessment' && auth()->id() === $review->employee->user_id)
                <button wire:click="submitSelf" class="mt-4 bg-indigo-50 text-indigo-600 px-6 py-2 rounded-xl font-bold w-full">Submit My Assessment</button>
            @endif
        </div>

        <!-- Manager Review -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold mb-6 border-b pb-4">Manager Review</h3>
            <textarea wire:model="manager_data.comments" class="w-full rounded-2xl border-gray-100 h-32" {{ $review->status !== 'manager_review' ? 'disabled' : '' }}></textarea>
            @if($review->status === 'manager_review' && auth()->id() === $review->employee->supervisor?->user_id)
                <button wire:click="submitManager" class="mt-4 bg-indigo-50 text-indigo-600 px-6 py-2 rounded-xl font-bold w-full">Submit Manager Review</button>
            @endif
        </div>
    </div>

    <!-- HR Calibration -->
    @if($review->final_rating || auth()->user()->hasAnyRole(['Super Admin', 'HR Admin']))
    <div class="bg-slate-900 p-8 rounded-3xl shadow-xl text-white">
        <h3 class="text-lg font-bold mb-6 border-b border-slate-800 pb-4">Calibration & Final Results</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Final Rating (1-5)</label>
                @if(auth()->user()->hasAnyRole(['Super Admin', 'HR Admin']) && $review->status === 'hr_calibration')
                    <input type="number" step="0.1" wire:model="final_rating" class="w-full bg-slate-800 border-none rounded-xl text-white">
                @else
                    <div class="text-4xl font-black text-indigo-400">{{ $final_rating ?? 'TBD' }}</div>
                @endif
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">HR Remarks</label>
                @if(auth()->user()->hasAnyRole(['Super Admin', 'HR Admin']) && $review->status === 'hr_calibration')
                    <textarea wire:model="hr_remarks" class="w-full bg-slate-800 border-none rounded-xl text-white"></textarea>
                @else
                    <div class="text-sm text-slate-400 italic">{{ $hr_remarks ?? 'No remarks provided.' }}</div>
                @endif
            </div>
        </div>
        @if(auth()->user()->hasAnyRole(['Super Admin', 'HR Admin']) && $review->status === 'hr_calibration')
            <button wire:click="calibrate" class="mt-6 bg-indigo-500 text-white px-8 py-3 rounded-xl font-black w-full shadow-lg shadow-indigo-500/20">Save Calibration</button>
        @endif
    </div>
    @endif
</div>
