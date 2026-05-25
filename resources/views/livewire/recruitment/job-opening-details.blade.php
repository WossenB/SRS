<div class="space-y-6">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-black text-gray-900">{{ $job->title }}</h2>
            <p class="text-gray-500 font-medium mt-1">{{ $job->department->name }} · {{ $applicants->count() }} Applicants</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('recruitment.apply', $job->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-xl font-bold text-sm">Add Applicant</a>
            <span class="px-4 py-1.5 bg-indigo-50 text-indigo-700 rounded-full text-xs font-black uppercase tracking-widest">{{ $job->status }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-4">
            @foreach($applicants as $applicant)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:border-indigo-200 transition">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 font-bold">
                            {{ substr($applicant->first_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">{{ $applicant->first_name }} {{ $applicant->last_name }}</div>
                            <div class="text-xs text-gray-500">{{ $applicant->email }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <select wire:change="updateStatus({{ $applicant->id }}, $event.target.value)" class="text-xs font-bold border-none bg-gray-50 rounded-lg focus:ring-0">
                            <option value="applied" {{ $applicant->status == 'applied' ? 'selected' : '' }}>APPLIED</option>
                            <option value="interview" {{ $applicant->status == 'interview' ? 'selected' : '' }}>INTERVIEW</option>
                            <option value="hired" {{ $applicant->status == 'hired' ? 'selected' : '' }}>HIRED</option>
                        </select>
                        <button wire:click="selectApplicant({{ $applicant->id }})" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 h-fit sticky top-8">
            @if($selectedApplicant)
                <h3 class="text-xl font-bold text-gray-900 mb-6 border-b pb-4">Score Interview</h3>
                <form wire:submit.prevent="submitScore" class="space-y-6">
                    <div>
                        <label class="block text-xs font-black uppercase text-gray-400 mb-2">Score (1-5)</label>
                        <div class="flex gap-2">
                            @foreach(range(1,5) as $i)
                                <button type="button" wire:click="$set('score', {{ $i }})" class="flex-1 py-2 rounded-xl border {{ $score == $i ? 'bg-indigo-600 border-indigo-600 text-white' : 'bg-white text-gray-400 hover:border-indigo-300' }} font-bold transition">
                                    {{ $i }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase text-gray-400 mb-2">Feedback</label>
                        <textarea wire:model="feedback" rows="4" class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 text-sm" placeholder="Detailed interview notes..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-2xl font-black shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">Save Score</button>
                </form>
            @else
                <div class="text-center py-12">
                    <div class="h-20 w-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-200 mx-auto mb-4">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>
                    </div>
                    <p class="text-gray-400 font-medium text-sm">Select an applicant to record interview scores and feedback.</p>
                </div>
            @endif
        </div>
    </div>
</div>
