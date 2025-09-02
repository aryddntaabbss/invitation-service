@extends('layouts.customer')

@section('title', $invitation->title . ' - Invitation Service')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $invitation->title }}</h2>
                <p class="text-gray-600 mt-2">Detail undangan Anda</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('customer.invitations.edit', $invitation) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-600 transition duration-150 ease-in-out">
                    Edit Undangan
                </a>
                <a href="{{ route('customer.invitations.index') }}"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-300 transition duration-150 ease-in-out">
                    Kembali ke List
                </a>
            </div>
        </div>
    </div>

    <!-- Status Alert -->
    @if($invitation->status === 'draft')
    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-6">
        <div class="flex items-center">
            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span>Undangan ini masih dalam status draft. Publikasikan untuk membuatnya aktif.</span>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Invitation Details Card -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Informasi Undangan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Detail Undangan</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm text-gray-500">Judul</dt>
                                    <dd class="text-sm font-medium">{{ $invitation->title }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Slug</dt>
                                    <dd class="text-sm font-medium text-blue-500">{{ $invitation->slug }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Package</dt>
                                    <dd class="text-sm font-medium">{{ $invitation->package->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Template</dt>
                                    <dd class="text-sm font-medium">{{ $invitation->template->name }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Status</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm text-gray-500">Status</dt>
                                    <dd class="text-sm">
                                        <span
                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $invitation->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $invitation->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Views</dt>
                                    <dd class="text-sm font-medium">{{ $invitation->view_count }} views</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Dibuat</dt>
                                    <dd class="text-sm font-medium">{{ $invitation->created_at->format('d M Y H:i') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Kadaluarsa</dt>
                                    <dd class="text-sm font-medium">{{ $invitation->expires_at->format('d M Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Couple Information Card -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Informasi Pasangan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Groom -->
                        <div>
                            <h4 class="font-medium text-gray-700 mb-3">Mempelai Pria</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm text-gray-500">Nama Lengkap</dt>
                                    <dd class="text-sm font-medium">{{ $invitation->groom_name }}</dd>
                                </div>
                                @if($invitation->groom_bio)
                                <div>
                                    <dt class="text-sm text-gray-500">Bio</dt>
                                    <dd class="text-sm">{{ $invitation->groom_bio }}</dd>
                                </div>
                                @endif
                                @if($invitation->groom_parents)
                                <div>
                                    <dt class="text-sm text-gray-500">Orang Tua</dt>
                                    <dd class="text-sm">{{ $invitation->groom_parents }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>

                        <!-- Bride -->
                        <div>
                            <h4 class="font-medium text-gray-700 mb-3">Mempelai Wanita</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm text-gray-500">Nama Lengkap</dt>
                                    <dd class="text-sm font-medium">{{ $invitation->bride_name }}</dd>
                                </div>
                                @if($invitation->bride_bio)
                                <div>
                                    <dt class="text-sm text-gray-500">Bio</dt>
                                    <dd class="text-sm">{{ $invitation->bride_bio }}</dd>
                                </div>
                                @endif
                                @if($invitation->bride_parents)
                                <div>
                                    <dt class="text-sm text-gray-500">Orang Tua</dt>
                                    <dd class="text-sm">{{ $invitation->bride_parents }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event Information Card -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Informasi Acara</h3>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-500">Tanggal & Waktu</dt>
                            <dd class="text-sm font-medium">
                                {{ $invitation->event_date->format('d M Y') }}
                                pukul {{ date('H:i', strtotime($invitation->event_time)) }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Alamat Acara</dt>
                            <dd class="text-sm whitespace-pre-line">{{ $invitation->event_address }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Actions Card -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi</h3>

                    <div class="space-y-3">
                        @if($invitation->status === 'draft')
                        <form action="{{ route('customer.invitations.publish', $invitation) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full bg-green-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-600 transition duration-150 ease-in-out">
                                Publikasikan Undangan
                            </button>
                        </form>
                        @else
                        <form action="{{ route('customer.invitations.unpublish', $invitation) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full bg-yellow-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-yellow-600 transition duration-150 ease-in-out">
                                Sembunyikan Undangan
                            </button>
                        </form>
                        @endif

                        <a href="{{ route('customer.invitations.preview', $invitation) }}"
                            class="block w-full bg-blue-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-600 transition duration-150 ease-in-out text-center">
                            Lihat Preview
                        </a>

                        <form action="{{ route('customer.invitations.destroy', $invitation) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full bg-red-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-600 transition duration-150 ease-in-out"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus undangan ini?')">
                                Hapus Undangan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik</h3>

                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Total Views</dt>
                            <dd class="text-sm font-medium">{{ $invitation->view_count }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Tamu Dikonfirmasi</dt>
                            <dd class="text-sm font-medium">
                                {{ $invitation->guests->where('is_confirmed', true)->count() }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Total Ucapan</dt>
                            <dd class="text-sm font-medium">{{ $invitation->messages->count() }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Sisa Waktu</dt>
                            <dd class="text-sm font-medium">
                                @if($invitation->expires_at->isFuture())
                                {{ $invitation->expires_at->diffForHumans() }}
                                @else
                                <span class="text-red-500">Kadaluarsa</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Quick Links Card -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Link Cepat</h3>

                    <div class="space-y-2">
                        <a href="#" class="block text-blue-500 hover:text-blue-700 text-sm">Kelola Tamu</a>
                        <a href="#" class="block text-blue-500 hover:text-blue-700 text-sm">Lihat Ucapan</a>
                        <a href="#" class="block text-blue-500 hover:text-blue-700 text-sm">Edit Template</a>
                        <a href="#" class="block text-blue-500 hover:text-blue-700 text-sm">Share Undangan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection