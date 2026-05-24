<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($stats as $label => $value)
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="text-gray-500 uppercase text-xs font-bold">{{ str_replace('_', ' ', $label) }}</div>
            <div class="text-3xl font-bold">{{ is_numeric($value) ? number_format($value, 2) : $value }}</div>
        </div>
    @endforeach
</div>
