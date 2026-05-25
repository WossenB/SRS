<div class="max-w-xl mx-auto p-8 bg-white shadow rounded-lg">
    <h2 class="text-2xl font-bold mb-6">Create Work Schedule</h2>
    <form wire:submit.prevent="save" class="space-y-4">
        <div><label class="block text-sm font-medium">Name</label><input type="text" wire:model="name" class="w-full border rounded p-2"></div>
        <div><label class="block text-sm font-medium">Standard Hours/Day</label><input type="number" wire:model="standard_hours" class="w-full border rounded p-2"></div>
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold">Save Schedule</button>
    </form>
</div>
