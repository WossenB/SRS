<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">My Leave Requests</h2>
        <a href="{{ route('leave.request') }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700">Request Leave</a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Dates</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Days</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($requests as $request)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium">{{ $request->leaveType->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $request->start_date->format('Y-m-d') }} to {{ $request->end_date->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 text-sm">{{ $request->days_requested }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 rounded text-xs {{ $request->status === 'hr_approved' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ strtoupper($request->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-4 text-center italic text-gray-500">No requests found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
