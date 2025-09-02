@extends('layouts.guest')

@section('title', 'Login Customer - Invitation Service')
@section('heading', 'Masuk ke Akun Anda')
@section('subheading', 'Pilih metode login yang Anda inginkan')

@section('content')
<!-- Social Login Buttons -->
<div class="space-y-3 mb-6">
    <a href="{{ route('customer.auth.google') }}"
        class="w-full flex justify-center items-center px-4 py-3 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" class="h-5 w-5 mr-3">
        Lanjutkan dengan Google
    </a>

    <!-- Untuk social media lainnya -->
    {{--
        <a href="{{ route('customer.auth.social', 'facebook') }}"
    class="w-full flex justify-center items-center px-4 py-3 border border-gray-300 rounded-md shadow-sm text-sm
    font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
    <svg class="h-5 w-5 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
        <path
            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
    </svg>
    Lanjutkan dengan Facebook
    </a>
    --}}
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

<!-- Email Login Form -->
<form method="POST" action="{{ route('customer.login.submit') }}" class="space-y-4">
    @csrf

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" id="email"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
            value="{{ old('email') }}" required autofocus placeholder="masukkan email anda">
        @error('email')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password" id="password"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
            required placeholder="masukkan password">
        @error('password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input type="checkbox" name="remember" id="remember"
                class="h-4 w-4 text-blue-500 focus:ring-blue-500 border-gray-300 rounded">
            <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
        </div>

        {{-- Forgot password link bisa ditambahkan later --}}
        {{--
            <div class="text-sm">
                <a href="#" class="font-medium text-blue-500 hover:text-blue-400 transition duration-150 ease-in-out">
                    Lupa password?
                </a>
            </div>
            --}}
    </div>

    <button type="submit"
        class="w-full bg-blue-500 text-white font-medium py-2.5 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
        Login
    </button>
</form>
@endsection

@section('footer')
Belum punya akun?
<a href="{{ route('customer.register') }}"
    class="font-medium text-blue-500 hover:text-blue-400 transition duration-150 ease-in-out">
    Daftar
</a>
@endsection