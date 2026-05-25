<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Public Holidays</h2>
        <a href="{{ route('settings.holidays.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-xl font-bold text-sm">Add Holiday</a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($holidays as $h)
                    <tr>
                        <td class="px-6 py-4 text-sm font-mono">{{ $h->date }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $h->name }}</td>
                        <td class="px-6 py-4 text-right">
                             <button wire:click="delete({{ $h->id }})" class="text-red-600 font-bold text-sm">Remove</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
