<div class="max-w-xl mx-auto p-8 bg-white shadow rounded-lg">
    <h2 class="text-2xl font-bold mb-6">Log New Applicant</h2>
    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Job Opening</label>
            <select wire:model="job_opening_id" class="w-full border rounded p-2">
                <option value="">Select Job...</option>
                @foreach($jobs as $j) <option value="{{ $j->id }}">{{ $j->title }}</option> @endforeach
            </select>
        </div>
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
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold">Register Applicant</button>
    </form>
</div>
