<div class="max-w-4xl mx-auto p-8 bg-white shadow rounded-lg">
    <div class="flex items-center justify-between mb-8 border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">Employee Onboarding</h2>
        <div class="flex gap-2">
            <span class="w-8 h-8 rounded-full flex items-center justify-center {{ $step >= 1 ? 'bg-indigo-600 text-white' : 'bg-gray-200' }}">1</span>
            <span class="w-8 h-8 rounded-full flex items-center justify-center {{ $step >= 2 ? 'bg-indigo-600 text-white' : 'bg-gray-200' }}">2</span>
            <span class="w-8 h-8 rounded-full flex items-center justify-center {{ $step >= 3 ? 'bg-indigo-600 text-white' : 'bg-gray-200' }}">3</span>
        </div>
    </div>

    <form wire:submit.prevent="save">
        @if($step == 1)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <h3 class="md:col-span-2 text-lg font-bold text-gray-700">Personal Information</h3>
                <div>
                    <label class="block text-sm font-medium">First Name</label>
                    <input type="text" wire:model="first_name" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">Last Name</label>
                    <input type="text" wire:model="last_name" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input type="email" wire:model="email" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">Phone</label>
                    <input type="text" wire:model="phone" class="w-full border rounded p-2">
                </div>
            </div>
        @endif

        @if($step == 2)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <h3 class="md:col-span-2 text-lg font-bold text-gray-700">Job Assignment</h3>
                <div>
                    <label class="block text-sm font-medium">Department</label>
                    <select wire:model="department_id" class="w-full border rounded p-2">
                        <option value="">Select...</option>
                        @foreach($departments as $d) <option value="{{ $d->id }}">{{ $d->name }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Position</label>
                    <select wire:model="position_id" class="w-full border rounded p-2">
                        <option value="">Select...</option>
                        @foreach($positions as $p) <option value="{{ $p->id }}">{{ $p->title }}</option> @endforeach
                    </select>
                </div>
            </div>
        @endif

        @if($step == 3)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <h3 class="md:col-span-2 text-lg font-bold text-gray-700">Financial Details</h3>
                <div>
                    <label class="block text-sm font-medium">Basic Salary (ETB)</label>
                    <input type="number" wire:model="basic_salary" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">TIN Number</label>
                    <input type="text" wire:model="tin_number" class="w-full border rounded p-2">
                </div>
            </div>
        @endif

        <div class="flex justify-between mt-8 border-t pt-4">
            @if($step > 1)
                <button type="button" wire:click="prevStep" class="px-6 py-2 bg-gray-100 rounded">Back</button>
            @else
                <div></div>
            @endif

            @if($step < 3)
                <button type="button" wire:click="nextStep" class="px-6 py-2 bg-indigo-600 text-white rounded">Next</button>
            @else
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded">Complete Onboarding</button>
            @endif
        </div>
    </form>
</div>
