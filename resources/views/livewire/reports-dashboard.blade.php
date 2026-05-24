<div class="space-y-8">
    <h2 class="text-3xl font-extrabold text-gray-900">Analytics & Reports</h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-sm font-medium text-gray-500">Hires (YTD)</div>
            <div class="mt-2 text-3xl font-bold text-indigo-600">{{ $hires }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-sm font-medium text-gray-500">Turnover (YTD)</div>
            <div class="mt-2 text-3xl font-bold text-red-600">{{ $turnover }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-sm font-medium text-gray-500">Training Completions</div>
            <div class="mt-2 text-3xl font-bold text-green-600">{{ $trainingCompletion }}</div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold mb-6">Recruitment Pipeline</h3>
        <div class="flex items-center gap-4">
            @foreach($recruitmentStats as $stat)
                <div class="flex-1 bg-gray-50 p-4 rounded-lg text-center">
                    <div class="text-xs uppercase text-gray-400 font-bold">{{ $stat->status }}</div>
                    <div class="text-xl font-bold">{{ $stat->count }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
