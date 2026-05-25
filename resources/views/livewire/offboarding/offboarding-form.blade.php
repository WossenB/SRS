<div class="max-w-xl mx-auto p-8 bg-white shadow rounded-lg">
    <h2 class="text-2xl font-bold mb-6">Initiate Offboarding</h2>
    <div class="mb-6 p-4 bg-gray-50 rounded">
        <p class="font-bold text-gray-700">{{ $employee->first_name }} {{ $employee->last_name }}</p>
        <p class="text-sm text-gray-500">{{ $employee->employee_id }}</p>
    </div>

    <form wire:submit.prevent="initiate" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Separation Date</label>
            <input type="date" wire:model="separation_date" class="w-full border rounded p-2">
        </div>
        <div>
            <label class="block text-sm font-medium">Exit Type</label>
            <select wire:model="exit_type" class="w-full border rounded p-2">
                <option value="">Select...</option>
                <option value="Resignation">Resignation</option>
                <option value="Termination">Termination</option>
                <option value="Retirement">Retirement</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium">Reason</label>
            <textarea wire:model="reason" rows="3" class="w-full border rounded p-2"></textarea>
        </div>
        <button type="submit" class="w-full bg-red-600 text-white py-2 rounded font-bold hover:bg-red-700">Initiate Process</button>
    </form>
</div>
