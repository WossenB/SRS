<div class="max-w-xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">Assign Benefit</h2>
    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Employee</label>
            <select wire:model="employee_id" class="w-full border rounded p-2">
                <option value="">Select...</option>
                @foreach($employees as $e) <option value="{{ $e->id }}">{{ $e->first_name }} {{ $e->last_name }}</option> @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium">Benefit</label>
            <select wire:model="benefit_catalog_id" class="w-full border rounded p-2">
                <option value="">Select...</option>
                @foreach($catalogs as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium">Amount (ETB)</label>
            <input type="number" wire:model="amount" class="w-full border rounded p-2">
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Assign Benefit</button>
    </form>
</div>
