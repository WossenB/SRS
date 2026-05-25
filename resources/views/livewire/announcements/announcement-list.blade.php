<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Announcements</h2>
        @can('system.manage')
             <a href="{{ route('announcements.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-xl font-bold text-sm">New Announcement</a>
        @endcan
    </div>

    <div class="grid grid-cols-1 gap-6">
        @forelse($announcements as $a)
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-bold text-gray-900">{{ $a->title }}</h3>
                    <span class="text-xs text-gray-400 font-medium">{{ $a->created_at->diffForHumans() }}</span>
                </div>
                <div class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $a->content }}</div>
            </div>
        @empty
             <div class="p-12 text-center text-gray-400 italic">No announcements found.</div>
        @endforelse
    </div>
    {{ $announcements->links() }}
</div>
