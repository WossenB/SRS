<div class="max-w-4xl mx-auto space-y-8">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <h2 class="text-2xl font-bold mb-6">Upload Document</h2>
        <form wire:submit.prevent="upload" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" wire:model="title" placeholder="Document Title (e.g. BSc Degree)" class="border-gray-200 rounded-xl">
                <select wire:model="category" class="border-gray-200 rounded-xl">
                    <option value="Educational">Educational</option>
                    <option value="ID/Passport">ID/Passport</option>
                    <option value="Certification">Certification</option>
                    <option value="Contract">Contract</option>
                </select>
            </div>
            <input type="file" wire:model="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold">Upload</button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($documents as $doc)
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <div class="font-bold text-gray-900">{{ $doc->title }}</div>
                    <div class="text-xs text-gray-500">{{ $doc->category }} · {{ strtoupper($doc->file_type) }}</div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-2 py-1 rounded text-[10px] font-bold {{ $doc->verification_status === 'pending' ? 'bg-amber-50 text-amber-600' : 'bg-green-50 text-green-600' }}">
                        {{ strtoupper($doc->verification_status) }}
                    </span>
                    <a href="{{ route('documents.download', $doc->id) }}" class="p-2 bg-gray-50 text-gray-400 rounded-lg hover:text-indigo-600 transition">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
