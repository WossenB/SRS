<div class="max-w-xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">Assign Training</h2>
    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Employee</label>
            <select wire:model="employee_id" class="w-full border rounded p-2">
                <option value="">Select Employee</option>
                @foreach($employees as $e) <option value="{{ $d->id }}">{{ $e->first_name }} {{ $e->last_name }}</option> @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium">Course</label>
            <select wire:model="training_course_id" class="w-full border rounded p-2">
                <option value="">Select Course</option>
                @foreach($courses as $c) <option value="{{ $c->id }}">{{ $c->title }}</option> @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium">Due Date</label>
            <input type="date" wire:model="due_date" class="w-full border rounded p-2">
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Assign</button>
    </form>
</div>
