@props(['label', 'value', 'color' => 'indigo'])

<div class="bg-white rounded-lg shadow p-4 border-l-4 border-{{ $color }}-500">
    <p class="text-xs text-gray-500 uppercase tracking-wider">{{ $label }}</p>
    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $value }}</p>
</div>