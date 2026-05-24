<div class="max-w-3xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-6">{{ $jobId ? 'Edit' : 'Create' }} Job Opening</h2>
    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Job Title</label>
            <input type="text" wire:model="title" class="w-full border rounded p-2">
        </div>
        <div>
            <label class="block text-sm font-medium">Department</label>
            <select wire:model="department_id" class="w-full border rounded p-2">
                <option value="">Select Department</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium">Description</label>
            <textarea wire:model="description" rows="5" class="w-full border rounded p-2"></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium">Closing Date</label>
            <input type="date" wire:model="closing_date" class="w-full border rounded p-2">
        </div>
        <div class="flex justify-end gap-2">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Save</button>
        </div>
    </form>
</div>
