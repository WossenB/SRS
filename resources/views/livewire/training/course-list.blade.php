<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Training Catalog</h2>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Provider</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($courses as $course)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $course->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $course->category }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $course->provider }}</td>
                        <td class="px-6 py-4 text-right"><button class="text-indigo-600">Details</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $courses->links() }}
</div>
