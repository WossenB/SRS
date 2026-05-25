<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Job Openings</h2>
        @can('applicant.manage')
            <a href="{{ route('recruitment.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700">New Job Opening</a>
        @endcan
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Department</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($jobs as $job)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $job->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $job->department?->name }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs uppercase font-bold">{{ $job->status }}</span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                             <a href="{{ route('recruitment.show', $job->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">View Applicants</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $jobs->links() }}
</div>
