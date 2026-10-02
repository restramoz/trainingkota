<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin Dashboard') — TrainingKota</title>

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>

<body class="min-h-screen bg-[#070D18] text-white antialiased">

    {{-- =========================================================
         MAIN WRAPPER - Full width, no sidebar
    ========================================================== --}}
    <div class="min-h-screen w-full">

        {{-- =====================================================
             TOPBAR - Clean header with navigation
        ====================================================== --}}
        <header
            class="sticky top-0 z-30 flex h-16 items-center
                   border-b border-white/10
                   bg-[#070D18]/95 px-4 backdrop-blur-md sm:px-6"
        >

            <div class="flex w-full items-center justify-between">

                {{-- Brand / Logo --}}
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 flex-shrink-0">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 font-bold text-white">
                        T
                    </div>
                    <div class="hidden sm:block">
                        <div class="text-sm font-bold text-white">TrainingKota</div>
                        <div class="text-[10px] font-medium uppercase tracking-wider text-slate-400">Admin Panel</div>
                    </div>
                </a>

                {{-- Navigation Tabs --}}
                <nav class="hidden md:flex flex-1 items-center justify-center space-x-1 px-4">
                    <a href="{{ route('admin.dashboard') }}"
                       class="px-3 py-2 text-xs font-medium uppercase tracking-wider rounded-lg transition
                              {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        Dashboard
                    </a>
                    <a href="/admin/services/manage"
                       class="px-3 py-2 text-xs font-medium uppercase tracking-wider rounded-lg transition
                              {{ request()->is('admin/services/*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        Katalog Layanan
                    </a>
                    <a href="/admin/locations"
                       class="px-3 py-2 text-xs font-medium uppercase tracking-wider rounded-lg transition
                              {{ request()->is('admin/locations*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        Direktori Wilayah
                    </a>
                    <a href="{{ route('admin.articles.index') }}"
                       class="px-3 py-2 text-xs font-medium uppercase tracking-wider rounded-lg transition
                              {{ request()->routeIs('admin.articles.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        Artikel
                    </a>
                    <a href="/admin/graphics"
                       class="px-3 py-2 text-xs font-medium uppercase tracking-wider rounded-lg transition
                              {{ request()->is('admin/graphics*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        Grafik
                    </a>
                    <a href="{{ route('admin.schedules.index') }}"
                       class="px-3 py-2 text-xs font-medium uppercase tracking-wider rounded-lg transition
                              {{ request()->routeIs('admin.schedules.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        Tiket / Jadwal
                    </a>
                </nav>

                {{-- Right Side --}}
                <div class="flex items-center gap-3">

                    <span class="hidden text-xs text-slate-400 sm:block">
                        {{ now()->format('d M Y') }}
                    </span>

                    <a href="/blog" target="_blank" rel="noopener noreferrer"
                       class="flex h-9 w-9 items-center justify-center rounded-full border border-white/10 bg-white/5 text-xs font-bold text-slate-300 hover:text-white hover:bg-white/10 transition"
                       title="Buka Blog">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4z" />
                        </svg>
                    </a>

                    <div class="flex h-9 w-9 items-center justify-center rounded-full border border-white/10 bg-white/5 text-xs font-bold text-white">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>

                </div>

            </div>

        </header>


        {{-- =====================================================
             MOBILE NAVIGATION DROPDOWN
        ====================================================== --}}
        <div x-data="{ mobileNavOpen: false }" class="md:hidden">
            <button @click="mobileNavOpen = !mobileNavOpen"
                    class="w-full px-4 py-2 text-left text-sm font-medium text-slate-300 hover:text-white"
                    aria-label="Toggle navigation">
                <span class="flex items-center justify-between">
                    Navigasi Admin
                    <span x-show="mobileNavOpen">−</span>
                    <span x-show="!mobileNavOpen">+</span>
                </span>
            </button>
            <div x-show="mobileNavOpen" x-transition class="border-t border-white/10 bg-[#0E1726] px-4 py-2 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">Dashboard</a>
                <a href="/admin/services/manage" class="block px-3 py-2 text-sm rounded-lg {{ request()->is('admin/services/*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">Katalog Layanan</a>
                <a href="/admin/locations" class="block px-3 py-2 text-sm rounded-lg {{ request()->is('admin/locations*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">Direktori Wilayah</a>
                <a href="{{ route('admin.articles.index') }}" class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.articles.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">Artikel</a>
                <a href="/admin/graphics" class="block px-3 py-2 text-sm rounded-lg {{ request()->is('admin/graphics*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">Grafik</a>
                <a href="{{ route('admin.schedules.index') }}" class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.schedules.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">Tiket / Jadwal</a>
                <a href="/blog" target="_blank" class="block px-3 py-2 text-sm rounded-lg text-slate-300 hover:bg-white/5 hover:text-white">Blog</a>
            </div>
        </div>


        {{-- =====================================================
             PAGE CONTENT - Full width
        ====================================================== --}}
        <main class="min-h-screen overflow-x-hidden bg-[#070D18]">
            @yield('content')
        </main>

    </div>

    @stack('scripts')

</body>
</html>