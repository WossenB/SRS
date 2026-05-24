<div class="max-w-2xl mx-auto p-6 bg-white shadow rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Submit Leave Request</h2>

    @if ($error)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ $error }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Leave Type</label>
            <select wire:model.live="leave_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-- Select Type --</option>
                @foreach ($leaveTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->allowance_days }} days/year)</option>
                @endforeach
            </select>
            @error('leave_type_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" wire:model.live="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" wire:model.live="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-md">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Days Requested</label>
            <div class="text-2xl font-bold text-indigo-600">{{ $days_requested }}</div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Reason</label>
            <textarea wire:model="reason" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Please provide a reason for your request"></textarea>
            @error('reason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition duration-150">
                Submit Request
            </button>
        </div>
    </form>
</div>
