<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-800">Pending Leave Approvals</h2>

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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dates</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Days</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($pendingLeaves as $leave)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $leave->employee->first_name }} {{ $leave->employee->last_name }}</div>
                            <div class="text-xs text-gray-500">{{ $leave->employee->employee_id }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $leave->leaveType->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $leave->start_date->format('M d') }} - {{ $leave->end_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold">{{ $leave->days_requested }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button wire:click="approve({{ $leave->id }})" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Approve</button>
                            <button wire:click="reject({{ $leave->id }})" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">Reject</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">No pending requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $pendingLeaves->links() }}
    </div>
</div>
