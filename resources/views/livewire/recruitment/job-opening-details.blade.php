<div class="space-y-6">
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold">{{ $job->title }}</h2>
        <p class="text-gray-500">{{ $job->department->name }}</p>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <h3 class="p-4 font-bold border-b">Applicants</h3>
        <table class="min-w-full divide-y">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-2 text-left text-xs font-bold text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-2 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($applicants as $applicant)
                    <tr>
                        <td class="px-6 py-4">{{ $applicant->first_name }} {{ $applicant->last_name }}</td>
                        <td class="px-6 py-4">
                            <select wire:change="updateStatus({{ $applicant->id }}, $event.target.value)" class="text-sm border rounded">
                                <option value="applied" {{ $applicant->status == 'applied' ? 'selected' : '' }}>Applied</option>
                                <option value="screening" {{ $applicant->status == 'screening' ? 'selected' : '' }}>Screening</option>
                                <option value="interview" {{ $applicant->status == 'interview' ? 'selected' : '' }}>Interview</option>
                                <option value="offer" {{ $applicant->status == 'offer' ? 'selected' : '' }}>Offer</option>
                                <option value="hired" {{ $applicant->status == 'hired' ? 'selected' : '' }}>Hired</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-indigo-600">View Resume</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
