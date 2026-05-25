<div class="max-w-xl mx-auto p-8 bg-white shadow rounded-lg">
    <h2 class="text-2xl font-bold mb-6">Initiate Payroll Run</h2>

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="create" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Period Month (YYYY-MM)</label>
            <input type="month" wire:model="period_month" class="w-full border rounded p-2">
            @error('period_month') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Run Type</label>
            <select wire:model="run_type" class="w-full border rounded p-2">
                <option value="regular">Regular</option>
                <option value="supplementary">Supplementary</option>
            </select>
        </div>

        <div class="flex justify-end gap-2 pt-4">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                <span wire:loading.remove>Start Calculation</span>
                <span wire:loading italic>Calculating...</span>
            </button>
        </div>
    </form>
</div>
