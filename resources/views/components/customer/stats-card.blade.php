@props([
'title',
'value',
'icon' => null,
'color' => 'blue'
])

@php
$colors = [
'blue' => 'bg-blue-500',
'green' => 'bg-green-500',
'purple' => 'bg-purple-500',
'red' => 'bg-red-500',
'yellow' => 'bg-yellow-500',
];

$iconColor = $colors[$color] ?? 'bg-blue-500';
@endphp

<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex items-center">
            @if($icon)
            <div class="flex-shrink-0 {{ $iconColor }} rounded-md p-3">
                {!! $icon !!}
            </div>
            @endif
            <div class="{{ $icon ? 'ml-5' : '' }} w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">{{ $title }}</dt>
                    <dd class="text-lg font-medium text-gray-900">{{ $value }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>