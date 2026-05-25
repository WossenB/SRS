<div class="max-w-2xl mx-auto p-8 bg-white shadow rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">New Announcement</h2>
    <form wire:submit.prevent="save" class="space-y-6">
        <div><label class="block text-sm font-medium">Title</label><input type="text" wire:model="title" class="w-full border rounded p-2"></div>
        <div><label class="block text-sm font-medium">Content</label><textarea wire:model="content" rows="5" class="w-full border rounded p-2"></textarea></div>
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold">Publish</button>
    </form>
</div>
