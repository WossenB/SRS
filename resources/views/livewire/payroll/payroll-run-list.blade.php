<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Payroll Runs</h2>
        @can('payroll.initiate')
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">New Run</button>
        @endcan
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Period</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Gross</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Net</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($runs as $run)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $run->period_month }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $run->run_type }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ number_format($run->total_gross, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ number_format($run->total_net, 2) }}</td>
                        <td class="px-6 py-4 text-sm"><span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded">{{ $run->status }}</span></td>
                        <td class="px-6 py-4 text-right"><button class="text-indigo-600">Details</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $runs->links() }}
</div>
