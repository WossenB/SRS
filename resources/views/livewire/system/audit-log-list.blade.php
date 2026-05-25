<div class="space-y-6">
    <h2 class="text-2xl font-bold">Audit Trail</h2>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Timestamp</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">User</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Action</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Metadata</th>
                </tr>
            </thead>
            <tbody class="divide-y text-sm">
                @foreach($logs as $log)
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $log->created_at }}</td>
                        <td class="px-4 py-3 font-medium">{{ $log->user_name }}</td>
                        <td class="px-4 py-3"><span class="px-2 py-1 bg-gray-100 rounded text-[10px] font-bold">{{ strtoupper($log->action_type) }}</span></td>
                        <td class="px-4 py-3 text-gray-400 font-mono text-xs">{{ substr($log->after_json, 0, 50) }}...</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $logs->links() }}
</div>
