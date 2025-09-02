@extends('layouts.customer')

@section('title', 'Preview Undangan - ' . $invitation->title)

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <h1 class="text-xl font-semibold text-gray-800">Preview Undangan</h1>
                    <p class="text-sm text-gray-600">Pratinjau undangan Anda</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('customer.invitations.show', $invitation) }}"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-300 transition duration-150 ease-in-out">
                        Kembali ke Detail
                    </a>
                    <button onclick="window.print()"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-600 transition duration-150 ease-in-out">
                        Print Preview
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Content -->
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <!-- Template-based preview will go here -->
            <div class="p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $invitation->title }}</h1>
                    <p class="text-gray-600">Undangan Pernikahan</p>
                </div>

                <!-- Couple Information -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                        {{ $invitation->groom_name }} & {{ $invitation->bride_name }}
                    </h2>

                    @if($invitation->groom_parents || $invitation->bride_parents)
                    <div class="text-gray-600 mb-4">
                        <p>Keluarga {{ $invitation->groom_parents }}</p>
                        <p class="text-sm">&</p>
                        <p>Keluarga {{ $invitation->bride_parents }}</p>
                    </div>
                    @endif
                </div>

                <!-- Event Details -->
                <div class="border-t border-b border-gray-200 py-6 mb-6">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Waktu Acara</h3>
                        <p class="text-gray-700 text-lg mb-1">
                            {{ $invitation->event_date->translatedFormat('l, d F Y') }}
                        </p>
                        <p class="text-gray-600">
                            Pukul {{ date('H:i', strtotime($invitation->event_time)) }} WIB
                        </p>
                    </div>
                </div>

                <!-- Event Location -->
                <div class="text-center mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Lokasi Acara</h3>
                    <p class="text-gray-700 whitespace-pre-line">{{ $invitation->event_address }}</p>

                    @if($invitation->google_maps_link)
                    <div class="mt-3">
                        <a href="{{ $invitation->google_maps_link }}" target="_blank"
                            class="text-blue-500 hover:text-blue-700 text-sm flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Lihat di Google Maps
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Additional Information -->
                @if($invitation->groom_bio || $invitation->bride_bio)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    @if($invitation->groom_bio)
                    <div class="text-center">
                        <h4 class="font-semibold text-gray-800 mb-2">Tentang Mempelai Pria</h4>
                        <p class="text-gray-600">{{ $invitation->groom_bio }}</p>
                    </div>
                    @endif

                    @if($invitation->bride_bio)
                    <div class="text-center">
                        <h4 class="font-semibold text-gray-800 mb-2">Tentang Mempelai Wanita</h4>
                        <p class="text-gray-600">{{ $invitation->bride_bio }}</p>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Footer -->
                <div class="text-center border-t border-gray-200 pt-6">
                    <p class="text-sm text-gray-500">
                        Undangan dibuat melalui {{ config('app.name') }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        Berakhir pada: {{ $invitation->expires_at->format('d M Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Preview Actions -->
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Preview</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-medium text-gray-700 mb-2">Informasi Status</h4>
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Status Publikasi</dt>
                            <dd class="text-sm">
                                <span
                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $invitation->is_active ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $invitation->is_active ? 'Published' : 'Draft' }}
                                </span>
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Template</dt>
                            <dd class="text-sm font-medium">{{ $invitation->template->name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Package</dt>
                            <dd class="text-sm font-medium">{{ $invitation->package->name }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h4 class="font-medium text-gray-700 mb-2">Aksi</h4>
                    <div class="space-y-2">
                        @if(!$invitation->is_active)
                        <form action="{{ route('customer.invitations.publish', $invitation) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full bg-green-500 text-white px-3 py-2 rounded-md text-sm font-medium hover:bg-green-600 transition duration-150 ease-in-out">
                                Publikasikan Sekarang
                            </button>
                        </form>
                        @else
                        <a href="#" target="_blank"
                            class="block w-full bg-blue-500 text-white px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-600 transition duration-150 ease-in-out text-center">
                            Lihat Live Version
                        </a>
                        @endif

                        <a href="{{ route('customer.invitations.edit', $invitation) }}"
                            class="block w-full bg-gray-200 text-gray-700 px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-300 transition duration-150 ease-in-out text-center">
                            Edit Undangan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {

        .bg-gray-50,
        .bg-white {
            background: white !important;
        }

        .shadow,
        .shadow-xl {
            box-shadow: none !important;
        }

        .rounded-lg {
            border-radius: 0 !important;
        }

        .hidden-print {
            display: none !important;
        }
    }
</style>
@endpush
@endsection