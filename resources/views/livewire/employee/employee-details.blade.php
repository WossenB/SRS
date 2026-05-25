<div class="max-w-4xl mx-auto p-8 bg-white shadow rounded-lg">
    <div class="flex justify-between items-start mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">{{ $employee->first_name }} {{ $employee->last_name }}</h2>
            <p class="text-gray-500">{{ $employee->position?->title }} | {{ $employee->department?->name }}</p>
        </div>
        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-bold uppercase">{{ $employee->status }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="space-y-4">
            <h3 class="text-lg font-bold border-b pb-2">Contact Information</h3>
            <p><span class="font-medium text-gray-500">Email:</span> {{ $employee->email }}</p>
            <p><span class="font-medium text-gray-500">Phone:</span> {{ $employee->phone }}</p>
            <p><span class="font-medium text-gray-500">Address:</span> {{ $employee->address }}</p>
        </div>
        <div class="space-y-4">
            <h3 class="text-lg font-bold border-b pb-2">Employment Details</h3>
            <p><span class="font-medium text-gray-500">Employee ID:</span> {{ $employee->employee_id }}</p>
            <p><span class="font-medium text-gray-500">Hire Date:</span> {{ $employee->hire_date?->format('M d, Y') }}</p>
            <p><span class="font-medium text-gray-500">Supervisor:</span> {{ $employee->supervisor?->first_name }} {{ $employee->supervisor?->last_name }}</p>
        </div>
    </div>
</div>
