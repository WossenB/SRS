<div class="max-w-6xl mx-auto p-6 bg-white shadow rounded-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Timesheet</h2>
        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $timesheet->status === 'draft' ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800' }}">
            {{ strtoupper($timesheet->status) }}
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-3 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                    <th class="p-3 text-left text-xs font-bold text-gray-500 uppercase">Day</th>
                    <th class="p-3 text-left text-xs font-bold text-gray-500 uppercase w-24">Hours</th>
                    <th class="p-3 text-left text-xs font-bold text-gray-500 uppercase w-24">Overtime</th>
                    <th class="p-3 text-left text-xs font-bold text-gray-500 uppercase">Remarks</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($entries as $id => $entry)
                    <tr class="{{ !$entry['is_working_day'] ? 'bg-gray-50' : '' }}">
                        <td class="p-3 text-sm text-gray-600">{{ $entry['date'] }}</td>
                        <td class="p-3 text-sm font-medium">{{ $entry['day_of_week'] }}</td>
                        <td class="p-3">
                            <input type="number" wire:model="entries.{{ $id }}.hours_worked" class="w-full rounded border-gray-300 text-sm" {{ $timesheet->status !== 'draft' ? 'disabled' : '' }}>
                        </td>
                        <td class="p-3">
                            <input type="number" wire:model="entries.{{ $id }}.overtime_hours" class="w-full rounded border-gray-300 text-sm" {{ $timesheet->status !== 'draft' ? 'disabled' : '' }}>
                        </td>
                        <td class="p-3">
                            <input type="text" wire:model="entries.{{ $id }}.remarks" class="w-full rounded border-gray-300 text-sm" placeholder="Optional note..." {{ $timesheet->status !== 'draft' ? 'disabled' : '' }}>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($timesheet->status === 'draft')
        <div class="mt-8 flex justify-end">
            <button wire:click="submit" class="bg-indigo-600 text-white px-8 py-2 rounded-md font-bold hover:bg-indigo-700 transition">
                Submit Weekly Timesheet
            </button>
        </div>
    @endif
</div>
