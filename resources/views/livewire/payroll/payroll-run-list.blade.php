<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Payroll Runs</h2>
        @can('payroll.initiate')
            <a href="{{ route('payroll.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700">New Run</a>
        @endcan
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Period</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Gross</th>
                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Net</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($runs as $run)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $run->period_month }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ strtoupper($run->run_type) }}</td>
                        <td class="px-6 py-4 text-sm text-right font-mono">{{ number_format($run->total_gross, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-right font-mono font-bold">{{ number_format($run->total_net, 2) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 {{ $run->status === 'locked' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }} rounded text-xs uppercase font-bold">{{ $run->status }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('payroll.details', $run->id) }}" class="text-indigo-600 hover:text-indigo-900">Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $runs->links() }}
</div>
