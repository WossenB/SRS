<div class="max-w-4xl mx-auto space-y-8">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-6">
        <div class="h-24 w-24 rounded-3xl bg-indigo-600 flex items-center justify-center text-white text-4xl font-black shadow-xl shadow-indigo-200">
            {{ substr($employee->first_name, 0, 1) }}
        </div>
        <div>
            <h2 class="text-3xl font-black text-gray-900">{{ $employee->first_name }} {{ $employee->last_name }}</h2>
            <p class="text-gray-500 font-medium">{{ $employee->position->title }} · {{ $employee->department->name }}</p>
        </div>
    </div>

    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <h3 class="text-xl font-bold mb-8 border-b pb-4">Personal Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-4">
                <label class="block text-xs font-bold text-gray-400 uppercase">Primary Phone</label>
                <input type="text" wire:model="phone" class="w-full border-gray-100 rounded-xl bg-gray-50">
            </div>
            <div class="space-y-4">
                <label class="block text-xs font-bold text-gray-400 uppercase">Home Address</label>
                <textarea wire:model="address" class="w-full border-gray-100 rounded-xl bg-gray-50"></textarea>
            </div>
        </div>
        <button wire:click="requestUpdate" class="mt-8 bg-indigo-600 text-white px-8 py-3 rounded-2xl font-black shadow-lg shadow-indigo-200">Request Information Update</button>
    </div>
</div>
