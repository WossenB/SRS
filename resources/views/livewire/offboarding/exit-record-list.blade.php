<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Exit Records</h2>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Employee</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Separation Date</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($exits as $exit)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $exit->employee->first_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $exit->separation_date->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $exit->exit_type }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $exit->status }}</td>
                        <td class="px-6 py-4 text-right"><button class="text-indigo-600">View</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $exits->links() }}
</div>
