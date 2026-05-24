<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-800">My Benefits</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($benefits as $benefit)
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-indigo-500">
                <div class="text-sm text-gray-500 uppercase font-bold">{{ $benefit->catalog->name }}</div>
                <div class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($benefit->amount, 2) }} ETB</div>
                <div class="text-xs text-gray-400 mt-4 italic">{{ $benefit->catalog->type }}</div>
            </div>
        @empty
            <div class="col-span-full bg-gray-50 p-12 text-center text-gray-500 rounded-lg">
                No active benefits assigned to you.
            </div>
        @endforelse
    </div>
</div>
