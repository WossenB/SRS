<div class="max-w-xl mx-auto p-8 bg-white shadow rounded-lg">
    <h2 class="text-2xl font-bold mb-6">Create Benefit Type</h2>
    <form wire:submit.prevent="save" class="space-y-4">
        <div><label class="block text-sm font-medium">Name</label><input type="text" wire:model="name" class="w-full border rounded p-2"></div>
        <div><label class="block text-sm font-medium">Type</label><select wire:model="type" class="w-full border rounded p-2"><option value="allowance">Allowance</option><option value="insurance">Insurance</option></select></div>
        <div class="flex items-center gap-2"><input type="checkbox" wire:model="is_taxable" id="taxable"><label for="taxable">Taxable Benefit</label></div>
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold">Save Benefit</button>
    </form>
</div>
