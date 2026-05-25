<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">My Leave Requests</h2>
        <div class="flex gap-2">
            @can('report.export')
                <button wire:click="export" class="bg-indigo-50 text-indigo-600 px-4 py-2 rounded-xl font-bold text-sm hover:bg-indigo-100 transition">Export History</button>
            @endcan
            <a href="{{ route('leave.request') }}" wire:navigate class="bg-indigo-600 text-white px-4 py-2 rounded-xl shadow-lg shadow-indigo-600/20 font-bold text-sm hover:bg-indigo-700 transition">New Request</a>
        </div>
    </div>

    @forelse($requests as $request)
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:border-indigo-200 transition group">
            <div class="flex items-center gap-6">
                <div class="h-12 w-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <div class="font-bold text-gray-900">{{ $request->leaveType->name }}</div>
                    <div class="text-xs text-gray-500 font-medium">{{ $request->start_date->format('M d') }} - {{ $request->end_date->format('M d, Y') }} ({{ $request->days_requested }} days)</div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                    {{ $request->status === 'hr_approved' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                    {{ $request->status }}
                </span>
                <svg class="w-5 h-5 text-gray-300 group-hover:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"></path></svg>
            </div>
        </div>
    @empty
        <div class="bg-white p-20 rounded-3xl border-2 border-dashed border-gray-100 flex flex-col items-center text-center">
            <div class="h-32 w-32 text-gray-200 mb-6">
                 <svg fill="currentColor" viewBox="0 0 24 24"><path d="M19 19H5V8h14m-3-7v2H8V1H6v2H5c-1.11 0-2 .89-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2h-1V1m-1 11h-5v5h5v-5z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800">No leave requests yet</h3>
            <p class="text-gray-500 max-w-xs mt-2">When you submit a leave request, it will appear here for tracking and status updates.</p>
        </div>
    @endforelse
</div>
