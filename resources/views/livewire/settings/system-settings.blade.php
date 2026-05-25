<div class="max-w-6xl mx-auto space-y-12 pb-20">
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-black text-gray-900">System Configuration</h2>
        <button wire:click="save" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl font-black shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">Save All Changes</button>
    </div>

    <!-- General -->
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <h3 class="text-xl font-bold mb-8 border-b pb-4">General Settings</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Company Name</label>
                <input type="text" wire:model="settings.company_name" class="w-full border-gray-200 rounded-xl focus:ring-indigo-500">
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" wire:model="settings.enable_geez_calendar" id="geez" class="rounded text-indigo-600 focus:ring-indigo-500">
                <label for="geez" class="font-bold text-gray-700">Enable Ge'ez Calendar Support</label>
            </div>
        </div>
    </div>

    <!-- Tax Slabs -->
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <h3 class="text-xl font-bold mb-8 border-b pb-4">Ethiopian Income Tax Slabs (2025)</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead>
                    <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-widest">
                        <th class="pb-4">Min Income</th>
                        <th class="pb-4">Max Income</th>
                        <th class="pb-4">Rate (%)</th>
                        <th class="pb-4">Deduction</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($taxSlabs as $index => $slab)
                        <tr>
                            <td class="py-4"><input type="number" wire:model="taxSlabs.{{ $index }}.min_income" class="border-gray-100 rounded-lg text-sm w-32"></td>
                            <td class="py-4"><input type="number" wire:model="taxSlabs.{{ $index }}.max_income" class="border-gray-100 rounded-lg text-sm w-32"></td>
                            <td class="py-4"><input type="number" wire:model="taxSlabs.{{ $index }}.rate" class="border-gray-100 rounded-lg text-sm w-20"></td>
                            <td class="py-4"><input type="number" wire:model="taxSlabs.{{ $index }}.deduction" class="border-gray-100 rounded-lg text-sm w-32"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
