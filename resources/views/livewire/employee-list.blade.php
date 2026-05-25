<div class="space-y-4">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Employees</h2>
        <div class="flex gap-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search employees..." class="border rounded px-4 py-2 text-sm w-64 shadow-sm focus:ring-indigo-500">
            @can('employee.create')
                <a href="{{ route('employees.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700">Add Employee</a>
            @endcan
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden relative">
        <div wire:loading class="absolute inset-0 bg-white bg-opacity-50 flex items-center justify-center z-10">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Department</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($employees as $employee)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-mono">{{ $employee->employee_id }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $employee->department?->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-bold uppercase rounded-full {{ $employee->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $employee->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-3">
                            <a href="{{ route('employees.show', $employee->id) }}" class="text-gray-600 hover:text-gray-900 font-medium">View</a>
                            @can('employee.edit')
                                <a href="{{ route('employees.edit', $employee->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                            @endcan
                            @can('employee.purge')
                                <a href="{{ route('offboarding.initiate', $employee->id) }}" class="text-red-600 hover:text-red-900 font-medium">Offboard</a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $employees->links() }}
    </div>
</div>
