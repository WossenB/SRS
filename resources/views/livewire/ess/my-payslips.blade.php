<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-800 tracking-tight">My Payslips</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($payslips as $payslip)
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:border-indigo-300 transition group relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4">
                    <div class="h-10 w-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <div class="text-xs font-black uppercase text-gray-400 tracking-widest mb-1">{{ $payslip->payrollRun->period_month }}</div>
                <div class="text-xl font-bold text-gray-900 mb-6">{{ date('F Y', strtotime($payslip->payrollRun->period_month . '-01')) }}</div>

                <div class="flex justify-between items-end">
                    <div>
                        <div class="text-xs text-gray-500 font-bold uppercase">Net Payment</div>
                        <div class="text-2xl font-black text-indigo-600 font-mono">ETB {{ number_format($payslip->net_pay, 2) }}</div>
                    </div>
                    <button class="bg-indigo-600 text-white p-3 rounded-xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="md:col-span-3 bg-white p-20 rounded-3xl border-2 border-dashed border-gray-100 flex flex-col items-center text-center">
                <div class="h-32 w-32 text-gray-100 mb-6">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">No payslips available</h3>
                <p class="text-gray-500 max-w-xs mt-2">Your payslips will appear here once the monthly payroll is finalized and locked by HR.</p>
            </div>
        @endforelse
    </div>
</div>
