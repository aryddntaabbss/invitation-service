<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Invitation Service')</title>
        <script src="https://cdn.tailwindcss.com"></script>
        @stack('styles')
        <style>
            .form-input:focus,
            .form-checkbox:focus {
                ring: 2px;
                ring-color: rgba(59, 130, 246, 0.5);
            }

            .transition {
                transition-property: color, background-color, border-color, transform;
            }
        </style>
    </head>

    <body class="bg-gray-50 min-h-screen flex items-center justify-center py-8">
        <div class="w-full max-w-md mx-4">
            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-500 rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">@yield('heading', 'Invitation Service')</h1>
                <p class="text-gray-600 mt-2">@yield('subheading', '')</p>
            </div>

            <!-- Content -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <!-- Alert Messages -->
                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                    {{ session('status') }}
                </div>
                @endif

                @yield('content')
            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    @yield('footer')
                </p>
            </div>
        </div>
        @stack('scripts')
    </body>

</html>