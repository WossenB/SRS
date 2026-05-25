<div class="space-y-6">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-2xl font-bold">Payroll Details: {{ $run->period_month }}</h2>
            <div class="flex gap-2 mt-2">
                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">{{ strtoupper($run->run_type) }}</span>
                <span class="px-2 py-1 {{ $run->status === 'locked' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }} rounded text-xs uppercase font-bold">{{ $run->status }}</span>
            </div>
        </div>
        <div class="flex gap-2">
            <button wire:click="exportBank" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">Bank File</button>
            <button wire:click="export" class="bg-green-600 text-white px-4 py-2 rounded flex items-center gap-2 text-sm font-bold hover:bg-green-700 transition">
                <span>Excel Report</span>
            </button>
            @if($run->status !== 'locked')
                <button wire:click="lock" class="bg-red-600 text-white px-4 py-2 rounded font-bold text-sm shadow-lg shadow-red-100 hover:bg-red-700 transition" onclick="confirm('Lock payroll? No further changes allowed.') || event.stopImmediatePropagation()">Lock & Approve</button>
            @endif
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Employee</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">Gross</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase text-red-500">Tax</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">Pension</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase font-black text-gray-900">Net Pay</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($items as $item)
                    <tr>
                        <td class="px-4 py-3 text-sm font-medium">{{ $item->employee->first_name }} {{ $item->employee->last_name }}</td>
                        <td class="px-4 py-3 text-sm text-right font-mono">{{ number_format($item->gross_salary, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-right text-red-600 font-mono">{{ number_format($item->income_tax, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-right font-mono">{{ number_format($item->pension_employee, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-right font-bold text-indigo-600 font-mono">{{ number_format($item->net_pay, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
