<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-800">Pending Document Verifications</h2>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Employee</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Document</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($documents as $doc)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $doc->employee->first_name }} {{ $doc->employee->last_name }}</div>
                            <div class="text-xs text-gray-500">{{ $doc->employee->employee_id }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium">{{ $doc->title }}</div>
                            <div class="text-xs text-gray-400">{{ $doc->category }}</div>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                             <a href="{{ route('documents.download', $doc->id) }}" class="text-indigo-600 text-sm font-bold">Download</a>
                             <button wire:click="verify({{ $doc->id }})" class="bg-green-600 text-white px-3 py-1 rounded text-xs font-bold">Verify</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="p-12 text-center text-gray-400 italic">No pending verifications.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $documents->links() }}
</div>
