@props([
'title' => 'Data tidak ditemukan',
'message' => 'Mulai buat data pertama Anda!',
'icon' => null
])

<div class="text-center py-12">
    @if($icon)
    <div class="mx-auto mb-4">
        {!! $icon !!}
    </div>
    @else
    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
        </path>
    </svg>
    @endif
    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $title }}</h3>
    <p class="text-gray-500">{{ $message }}</p>
    {{ $slot }}
</div>