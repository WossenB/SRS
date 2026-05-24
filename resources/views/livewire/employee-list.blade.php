<div class="space-y-4">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Employees</h2>
        <input wire:model.live="search" type="text" placeholder="Search employees..." class="border rounded px-4 py-2">
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($employees as $employee)
                    <tr>
                        <td class="px-6 py-4">{{ $employee->employee_id }}</td>
                        <td class="px-6 py-4">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                        <td class="px-6 py-4">{{ $employee->department?->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $employee->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $employee->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-blue-600 hover:text-blue-900">View</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $employees->links() }}
</div>
