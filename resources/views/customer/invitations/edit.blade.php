@extends('layouts.customer')

@section('title', 'Edit Undangan - Invitation Service')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Undangan</h2>
        <p class="text-gray-600 mt-2">Perbarui informasi undangan Anda</p>
    </div>

    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('customer.invitations.update', $invitation) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Informasi Dasar</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Undangan
                                *</label>
                            <input type="text" name="title" id="title" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('title', $invitation->title) }}"
                                placeholder="Contoh: Pernikahan John & Jane">
                            @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Package Selection -->
                        <div>
                            <label for="package_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Paket
                                *</label>
                            <select name="package_id" id="package_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Paket</option>
                                @foreach($packages as $package)
                                <option value="{{ $package->id }}"
                                    {{ old('package_id', $invitation->package_id) == $package->id ? 'selected' : '' }}>
                                    {{ $package->name }} - Rp {{ number_format($package->price) }}
                                </option>
                                @endforeach
                            </select>
                            @error('package_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Template Selection -->
                        <div class="md:col-span-2">
                            <label for="template_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Template
                                *</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach($templates as $template)
                                <label
                                    class="relative border-2 rounded-lg p-4 cursor-pointer transition duration-150 ease-in-out 
                                        {{ old('template_id', $invitation->template_id) == $template->id ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                                    <input type="radio" name="template_id" value="{{ $template->id }}" class="sr-only"
                                        {{ old('template_id', $invitation->template_id) == $template->id ? 'checked' : '' }}
                                        required>
                                    <div class="text-center">
                                        <div class="bg-gray-200 h-32 mb-3 rounded flex items-center justify-center">
                                            @if($template->preview_image)
                                            <img src="{{ asset('storage/' . $template->preview_image) }}"
                                                alt="{{ $template->name }}" class="h-full w-full object-cover rounded">
                                            @else
                                            <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            @endif
                                        </div>
                                        <h4 class="font-medium text-gray-900">{{ $template->name }}</h4>
                                        <p class="text-sm text-gray-500 mt-1">{{ $template->category }}</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            @error('template_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Couple Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Informasi Pasangan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Groom -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-900">Mempelai Pria</h4>

                            <div>
                                <label for="groom_name" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                    Lengkap *</label>
                                <input type="text" name="groom_name" id="groom_name" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('groom_name', $invitation->groom_name) }}"
                                    placeholder="Nama mempelai pria">
                                @error('groom_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="groom_bio" class="block text-sm font-medium text-gray-700 mb-1">Bio
                                    (Optional)</label>
                                <textarea name="groom_bio" id="groom_bio" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Tentang mempelai pria">{{ old('groom_bio', $invitation->groom_bio) }}</textarea>
                                @error('groom_bio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="groom_parents" class="block text-sm font-medium text-gray-700 mb-1">Orang
                                    Tua (Optional)</label>
                                <input type="text" name="groom_parents" id="groom_parents"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('groom_parents', $invitation->groom_parents) }}"
                                    placeholder="Nama orang tua">
                                @error('groom_parents')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Bride -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-900">Mempelai Wanita</h4>

                            <div>
                                <label for="bride_name" class="block text-sm font-medium text-gray-700 mb-1">Nama
                                    Lengkap *</label>
                                <input type="text" name="bride_name" id="bride_name" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('bride_name', $invitation->bride_name) }}"
                                    placeholder="Nama mempelai wanita">
                                @error('bride_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="bride_bio" class="block text-sm font-medium text-gray-700 mb-1">Bio
                                    (Optional)</label>
                                <textarea name="bride_bio" id="bride_bio" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Tentang mempelai wanita">{{ old('bride_bio', $invitation->bride_bio) }}</textarea>
                                @error('bride_bio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="bride_parents" class="block text-sm font-medium text-gray-700 mb-1">Orang
                                    Tua (Optional)</label>
                                <input type="text" name="bride_parents" id="bride_parents"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('bride_parents', $invitation->bride_parents) }}"
                                    placeholder="Nama orang tua">
                                @error('bride_parents')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Informasi Acara</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Event Date & Time -->
                        <div>
                            <label for="event_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Acara
                                *</label>
                            <input type="date" name="event_date" id="event_date" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('event_date', $invitation->event_date->format('Y-m-d')) }}">
                            @error('event_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="event_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu Acara
                                *</label>
                            <input type="time" name="event_time" id="event_time" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('event_time', $invitation->event_time) }}">
                            @error('event_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Event Address -->
                        <div>
                            <label for="event_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Acara
                                *</label>
                            <textarea name="event_address" id="event_address" rows="3" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Alamat lengkap tempat acara">{{ old('event_address') }}</textarea>
                            @error('event_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Google Maps Link -->
                        <div>
                            <label for="google_maps_link" class="block text-sm font-medium text-gray-700 mb-1">Link
                                Google Maps
                                (Optional)</label>
                            <input type="url" name="google_maps_link" id="google_maps_link"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('google_maps_link') }}" placeholder="https://maps.google.com/...">
                            @error('google_maps_link')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">
                                Cara dapatkan link: Buka Google Maps → cari lokasi → klik "Share" → copy link
                            </p>
                        </div>

                        <!-- Latitude & Longitude (Optional) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="latitude" class="block text-sm font-medium text-gray-700 mb-1">Latitude
                                    (Optional)</label>
                                <input type="number" step="any" name="latitude" id="latitude"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('latitude') }}" placeholder="-6.175392">
                                @error('latitude')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1">Longitude
                                    (Optional)</label>
                                <input type="number" step="any" name="longitude" id="longitude"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('longitude') }}" placeholder="106.827153">
                                @error('longitude')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('customer.invitations.show', $invitation) }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-150 ease-in-out">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-500 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                        Update Undangan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    input[type="radio"]:checked+div {
        border-color: #3B82F6;
        background-color: #EFF6FF;
    }
</style>
@endpush
@endsection