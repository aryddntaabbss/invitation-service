<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Dashboard - Invitation Service')</title>
        <script src="https://cdn.tailwindcss.com"></script>
        @stack('styles')
        <style>
            .btn-primary {
                @apply bg-blue-500 text-white px-4 py-2 rounded-md text-sm font-medium hover: bg-blue-600 transition duration-150 ease-in-out;
            }

            .btn-secondary {
                @apply bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover: bg-gray-300 transition duration-150 ease-in-out;
            }

            .table-row-hover:hover {
                @apply bg-gray-50;
            }
        </style>
    </head>

    <body class="bg-gray-100 min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h1 class="text-xl font-semibold text-gray-800">Customer Dashboard</h1>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700 text-sm">Hello, {{ Auth::guard('customer')->user()->name }}</span>
                        <form method="POST" action="{{ route('customer.logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-blue-500 hover:text-blue-700 font-medium text-sm transition duration-150 ease-in-out">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            @yield('content')
        </main>

        @stack('scripts')
    </body>

</html>