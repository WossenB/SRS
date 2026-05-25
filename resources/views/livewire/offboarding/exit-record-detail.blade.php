<div class="max-w-4xl mx-auto space-y-8">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-black">Offboarding Clearance</h2>
            <p class="text-gray-500 font-medium">{{ $exit->employee->first_name }} {{ $exit->employee->last_name }}</p>
        </div>
        @if($exit->status !== 'completed')
            <button wire:click="complete" class="bg-red-600 text-white px-6 py-2 rounded-xl font-bold shadow-lg shadow-red-200 hover:bg-red-700">Finalize Exit</button>
        @else
             <span class="px-4 py-1.5 bg-green-50 text-green-700 rounded-full text-xs font-black uppercase tracking-widest">COMPLETED</span>
        @endif
    </div>

    @if (session()->has('error'))
        <div class="bg-red-100 text-red-700 px-6 py-3 rounded-2xl font-bold">{{ session('error') }}</div>
    @endif

    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <h3 class="text-xl font-bold mb-8">Departmental Clearance</h3>
        <div class="space-y-6">
            @foreach($checklist as $dept => $data)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl">
                    <div>
                        <div class="font-bold text-gray-900">{{ $dept }}</div>
                        <div class="text-xs text-gray-500">Manual verification required</div>
                    </div>
                    <select wire:change="updateChecklist('{{ $dept }}', $event.target.value)" class="text-sm font-bold border-none bg-white rounded-xl focus:ring-0 shadow-sm" {{ $exit->status === 'completed' ? 'disabled' : '' }}>
                        <option value="pending" {{ $data['status'] == 'pending' ? 'selected' : '' }}>PENDING</option>
                        <option value="cleared" {{ $data['status'] == 'cleared' ? 'selected' : '' }}>CLEARED</option>
                        <option value="waived" {{ $data['status'] == 'waived' ? 'selected' : '' }}>WAIVED</option>
                    </select>
                </div>
            @endforeach
        </div>
    </div>
</div>
