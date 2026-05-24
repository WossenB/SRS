<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-800">Timesheet Approvals</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Week</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Hours</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($pendingTimesheets as $ts)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $ts->employee->first_name }} {{ $ts->employee->last_name }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $ts->week_start->format('M d') }} - {{ $ts->week_end->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold">
                             {{ $ts->entries->sum('hours_worked') + $ts->entries->sum('overtime_hours') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('timesheet.edit', $ts->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Review</a>
                            <button wire:click="approve({{ $ts->id }})" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Approve</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">No pending timesheets found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $pendingTimesheets->links() }}
    </div>
</div>
