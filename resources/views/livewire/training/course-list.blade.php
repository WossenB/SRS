<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Training Catalog</h2>
        @can('training.mark_complete')
            <a href="{{ route('training.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-xl font-bold text-sm shadow-lg shadow-indigo-100">Add Course</a>
        @endcan
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase text-right">Assignments</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($courses as $course)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $course->title }}</div>
                            <div class="text-[10px] text-gray-400 italic">By {{ $course->provider ?? 'Internal' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $course->category }}</td>
                        <td class="px-6 py-4 text-sm text-right font-bold">0</td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-indigo-600 font-bold text-sm">View Track</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $courses->links() }}
</div>
