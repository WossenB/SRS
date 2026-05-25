<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Performance Reviews</h2>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Employee</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Rating</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($reviews as $review)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $review->employee->first_name }} {{ $review->employee->last_name }}</div>
                            <div class="text-[10px] text-gray-400">{{ $review->employee->employee_id }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm font-black text-indigo-600">{{ $review->final_rating ?? 'TBD' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-[10px] font-black uppercase tracking-tighter">{{ $review->status }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('performance.show', $review->id) }}" class="text-indigo-600 font-bold text-sm hover:underline">Open Review</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $reviews->links() }}
    </div>
</div>
