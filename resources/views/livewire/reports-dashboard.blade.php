<div class="space-y-8">
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight">System Analytics</h2>
        <div class="flex gap-2">
            <button class="bg-white border border-gray-200 px-4 py-2 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 transition">Download PDF Report</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="bg-indigo-600 p-8 rounded-3xl shadow-xl shadow-indigo-200 text-white">
            <div class="text-indigo-100 text-xs font-bold uppercase tracking-wider">Hires (YTD)</div>
            <div class="text-5xl font-black mt-2">{{ $hires }}</div>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <div class="text-gray-400 text-xs font-bold uppercase tracking-wider">Turnover</div>
            <div class="text-5xl font-black mt-2 text-red-500">{{ $turnover }}</div>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <div class="text-gray-400 text-xs font-bold uppercase tracking-wider">Learning</div>
            <div class="text-5xl font-black mt-2 text-green-500">{{ $trainingCompletion }}</div>
        </div>
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <div class="text-gray-400 text-xs font-bold uppercase tracking-wider">Open Positions</div>
            <div class="text-5xl font-black mt-2 text-indigo-600">14</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-800 mb-8">Recruitment Pipeline</h3>
            <div class="h-80">
                <canvas id="recruitmentChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-800 mb-8">Top Departments</h3>
            <div class="space-y-6">
                @foreach($recruitmentStats as $stat)
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-bold text-gray-700 uppercase tracking-wide">{{ $stat->status }}</span>
                            <span class="text-gray-500">{{ $stat->count }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ min(100, $stat->count * 10) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:navigated', () => {
        const ctx = document.getElementById('recruitmentChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($recruitmentStats->pluck('status')) !!},
                    datasets: [{
                        label: 'Applicants',
                        data: {!! json_encode($recruitmentStats->pluck('count')) !!},
                        backgroundColor: '#6366f1',
                        borderRadius: 12,
                        barThickness: 40
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, grid: { display: false } },
                        x: { grid: { display: false } }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        }
    });
</script>
@endpush
