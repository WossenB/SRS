<div class="max-w-4xl mx-auto p-8 bg-white shadow rounded-lg">
    <h2 class="text-2xl font-bold mb-8">{{ $employeeId ? 'Edit Employee' : 'Add New Employee' }}</h2>

    <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium">First Name</label>
            <input type="text" wire:model="first_name" class="mt-1 block w-full border rounded-md p-2">
        </div>
        <div>
            <label class="block text-sm font-medium">Last Name</label>
            <input type="text" wire:model="last_name" class="mt-1 block w-full border rounded-md p-2">
        </div>
        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" wire:model="email" class="mt-1 block w-full border rounded-md p-2">
        </div>
        <div>
            <label class="block text-sm font-medium">Employee ID Number</label>
            <input type="text" wire:model="employee_id_number" class="mt-1 block w-full border rounded-md p-2">
        </div>
        <div>
            <label class="block text-sm font-medium">Basic Salary (ETB)</label>
            <input type="number" wire:model="basic_salary" class="mt-1 block w-full border rounded-md p-2">
        </div>
        <div>
            <label class="block text-sm font-medium">Department</label>
            <select wire:model="department_id" class="mt-1 block w-full border rounded-md p-2">
                <option value="">Select Department</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-2 flex justify-end gap-4 mt-4">
            <a href="{{ route('employees.index') }}" class="px-6 py-2 bg-gray-100 rounded text-gray-700">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save Employee</button>
        </div>
    </form>
</div>
