<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Training Assignments</h2>
        <a href="{{ route('training.assign') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">New Assignment</a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Employee</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Course</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($assignments as $a)
                    <tr>
                        <td class="px-6 py-4">{{ $a->employee->first_name }}</td>
                        <td class="px-6 py-4">{{ $a->course->title }}</td>
                        <td class="px-6 py-4"><span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">{{ strtoupper($a->status) }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $assignments->links() }}
</div>
