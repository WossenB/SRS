<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Job Openings</h2>
        @can('applicant.manage')
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">New Job Opening</button>
        @endcan
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Applicants</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($jobs as $job)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $job->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $job->status }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">0</td>
                        <td class="px-6 py-4 text-right"><button class="text-indigo-600">View</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $jobs->links() }}
</div>
