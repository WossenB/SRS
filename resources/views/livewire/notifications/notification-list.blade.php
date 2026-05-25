<div class="max-w-3xl mx-auto space-y-6">
    <h2 class="text-2xl font-bold">Notifications</h2>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <ul class="divide-y">
            @forelse($notifications as $n)
                <li class="p-6 {{ $n->read_at ? 'opacity-50' : 'bg-indigo-50/30' }} flex justify-between items-center">
                    <div>
                        <div class="font-bold text-gray-900">{{ $n->data['title'] }}</div>
                        <div class="text-sm text-gray-500">{{ $n->data['message'] }}</div>
                        <div class="text-[10px] text-gray-400 mt-2 uppercase font-bold">{{ $n->created_at->diffForHumans() }}</div>
                    </div>
                    @if(!$n->read_at)
                        <button wire:click="markRead('{{ $n->id }}')" class="text-xs font-bold text-indigo-600 hover:underline">Mark as Read</button>
                    @endif
                </li>
            @empty
                <li class="p-12 text-center text-gray-400 italic">No notifications.</li>
            @endforelse
        </ul>
    </div>
    {{ $notifications->links() }}
</div>
