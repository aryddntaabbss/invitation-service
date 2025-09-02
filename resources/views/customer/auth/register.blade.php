@extends('layouts.guest')

@section('title', 'Daftar Customer - Invitation Service')
@section('heading', 'Buat Akun Baru')
@section('subheading', 'Pilih metode pendaftaran yang Anda inginkan')

@section('content')
<!-- Social Registration Buttons -->
<div class="space-y-3 mb-6">
    <a href="{{ route('customer.auth.google') }}"
        class="w-full flex justify-center items-center px-4 py-3 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" class="h-5 w-5 mr-3">
        Daftar dengan Google
    </a>
</div>

<!-- Separator -->
<div class="relative mb-6">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-gray-300"></div>
    </div>
    <div class="relative flex justify-center text-sm">
        <span class="px-2 bg-white text-gray-500 text-xs uppercase tracking-wider">Atau dengan email</span>
    </div>
</div>

<!-- Email Registration Form -->
<form method="POST" action="{{ route('customer.register.submit') }}" class="space-y-4">
    @csrf

    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
        <input type="text" name="name" id="name"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
            value="{{ old('name') }}" required autofocus placeholder="masukkan nama lengkap">
        @error('name')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" id="email"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
            value="{{ old('email') }}" required placeholder="masukkan email">
        @error('email')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
        <input type="tel" name="phone" id="phone"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
            value="{{ old('phone') }}" required placeholder="masukkan nomor telepon">
        @error('phone')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password" id="password"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
            required placeholder="buat password">
        @error('password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi
            Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
            required placeholder="ulangi password">
    </div>

    <button type="submit"
        class="w-full bg-blue-500 text-white font-medium py-2.5 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
        Daftar
    </button>
</form>
@endsection

@section('footer')
Sudah punya akun?
<a href="{{ route('customer.login') }}"
    class="font-medium text-blue-500 hover:text-blue-400 transition duration-150 ease-in-out">
    Login di sini
</a>
@endsection