<div class="max-w-3xl mx-auto p-8 bg-white shadow rounded-lg">
    <h2 class="text-2xl font-bold mb-6">System Settings</h2>

    <form wire:submit.prevent="save" class="space-y-6">
        <div>
            <label class="block text-sm font-medium">Company Name</label>
            <input type="text" wire:model="settings.company_name" class="mt-1 block w-full border rounded p-2">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" wire:model="settings.enable_geez_calendar" id="geez">
            <label for="geez" class="text-sm font-medium">Enable Ge'ez Calendar Toggle</label>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded">Save Settings</button>
    </form>
</div>
