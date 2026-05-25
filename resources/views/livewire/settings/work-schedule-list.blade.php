<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Work Schedules</h2>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded-xl font-bold text-sm">Create Schedule</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($schedules as $s)
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-bold text-gray-900">{{ $s->name }}</h3>
                    @if($s->is_default)
                        <span class="px-2 py-1 bg-green-50 text-green-700 rounded text-[10px] font-black uppercase tracking-tighter">Default</span>
                    @endif
                </div>
                <div class="text-sm text-gray-500 mb-4">{{ $s->standard_hours }} Hours/Day</div>
                <div class="flex flex-wrap gap-2">
                    @foreach(json_decode($s->working_days_json) as $day)
                        <span class="px-2 py-1 bg-gray-50 text-gray-400 rounded text-[10px] font-bold">{{ strtoupper(substr($day, 0, 3)) }}</span>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
