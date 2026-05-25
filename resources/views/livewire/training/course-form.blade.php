<div class="max-w-2xl mx-auto p-8 bg-white shadow rounded-lg">
    <h2 class="text-2xl font-bold mb-6">Manage Training Course</h2>
    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Course Title</label>
            <input type="text" wire:model="title" class="w-full border rounded p-2">
        </div>
        <div>
            <label class="block text-sm font-medium">Category</label>
            <input type="text" wire:model="category" class="w-full border rounded p-2">
        </div>
        <div>
            <label class="block text-sm font-medium">Provider</label>
            <input type="text" wire:model="provider" class="w-full border rounded p-2">
        </div>
        <div>
            <label class="block text-sm font-medium">Duration (Hours)</label>
            <input type="number" wire:model="duration_hours" class="w-full border rounded p-2">
        </div>
        <div>
            <label class="block text-sm font-medium">Description</label>
            <textarea wire:model="description" rows="3" class="w-full border rounded p-2"></textarea>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded font-bold">Save Course</button>
    </form>
</div>
