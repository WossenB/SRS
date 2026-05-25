<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($stats as $label => $value)
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="text-gray-400 uppercase text-xs font-black tracking-widest">{{ str_replace('_', ' ', $label) }}</div>
                <div class="text-4xl font-black text-gray-800 mt-4">
                    {{ is_numeric($value) && $value > 1000 ? number_format($value, 2) : $value }}
                </div>
                <div class="mt-4 flex items-center text-xs font-bold text-green-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <span class="ml-1">+12% from last month</span>
                </div>
            </div>
        @endforeach
    </div>

    @if(isset($chartData['dept']))
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Headcount by Department</h3>
            <div class="h-64">
                <canvas id="deptChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
             <h3 class="text-lg font-bold text-gray-800 mb-6">Recent Activity</h3>
             <div class="space-y-4">
                 <div class="flex items-center gap-4">
                     <div class="h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                     </div>
                     <div>
                         <p class="text-sm font-bold text-gray-800">New Employee Joined</p>
                         <p class="text-xs text-gray-500">Abebe Kebede added to Engineering</p>
                     </div>
                 </div>
                 <div class="flex items-center gap-4">
                     <div class="h-10 w-10 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                     </div>
                     <div>
                         <p class="text-sm font-bold text-gray-800">Payroll Finalized</p>
                         <p class="text-xs text-gray-500">May 2024 payroll has been locked</p>
                     </div>
                 </div>
             </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:navigated', () => {
        const ctx = document.getElementById('deptChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(array_keys($chartData['dept'] ?? [])) !!},
                    datasets: [{
                        data: {!! json_encode(array_values($chartData['dept'] ?? [])) !!},
                        backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
                    }
                }
            });
        }
    });
</script>
@endpush
