<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Birrama HRMS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @livewireStyles
</head>
<body class="h-full font-sans antialiased text-gray-900 overflow-hidden">
    <div class="flex h-screen overflow-hidden bg-gray-100">
        <!-- Sidebar -->
        <x-sidenav />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white border-b border-gray-200 z-10 shadow-sm">
                <div class="px-8 py-4 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                         <div class="text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                         </div>
                         <h1 class="text-lg font-semibold text-gray-700">Birrama Digital Commerce</h1>
                    </div>
                    <div class="flex items-center gap-6">
                        <button class="text-gray-400 hover:text-gray-600 relative">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                             <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                        </button>
                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <div class="text-sm font-bold text-gray-800">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-gray-500 uppercase">{{ auth()->user()->roles->first()->name }}</div>
                            </div>
                            <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold shadow-indigo-200 shadow-lg">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
