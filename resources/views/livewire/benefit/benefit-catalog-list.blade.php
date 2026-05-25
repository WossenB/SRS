<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Benefit Types</h2>
        <a href="{{ route('benefits.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">New Type</a>
    </div>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y">
            <thead><tr class="bg-gray-50"><th class="px-6 py-2 text-left">Name</th><th class="px-6 py-2 text-left">Taxable</th></tr></thead>
            <tbody class="divide-y">
                @foreach($catalogs as $c)
                    <tr><td class="px-6 py-4 font-bold text-gray-900">{{$c->name}}</td><td class="px-6 py-4">{{$c->is_taxable ? 'YES' : 'NO'}}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
