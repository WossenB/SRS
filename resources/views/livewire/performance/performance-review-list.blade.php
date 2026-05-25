<div class="space-y-6">
    <h2 class="text-2xl font-bold">Performance Reviews</h2>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Employee</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Rating</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($reviews as $review)
                    <tr>
                        <td class="px-6 py-4">{{ $review->employee->first_name }} {{ $review->employee->last_name }}</td>
                        <td class="px-6 py-4">{{ $review->final_rating ?? 'N/A' }}</td>
                        <td class="px-6 py-4"><span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">{{ strtoupper($review->status) }}</span></td>
                        <td class="px-6 py-4 text-right"><button class="text-indigo-600">Review</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $reviews->links() }}
</div>
