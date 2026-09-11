<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-[#070D18] text-[#F1F5F9] antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - TrainingKota</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="bg-[#070D18] text-[#F1F5F9] font-body min-h-screen flex overflow-hidden"> 
    
    <!-- SIDEBAR NAV (SINGLE CLEAN INSTANCE) -->
    <aside class="w-64 bg-[#0E1726] border-r border-[#1E293B] flex flex-col h-screen sticky top-0 overflow-y-auto z-50 shrink-0">
        <div class="p-6 border-b border-[#1E293B] flex items-center gap-3">
            <div class="w-8 h-8 bg-[#10B981] rounded-lg flex items-center justify-center font-bold text-[#070D18]">TK</div>
            <span class="font-space font-bold tracking-wider text-sm">ADMIN CMS</span>
        </div>

        <nav class="flex-1 p-4 space-y-1">
            <p class="text-[10px] font-bold text-[#64748B] uppercase tracking-widest px-3 mb-2">Main Menu</p>
            
            <!-- 1. Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#1E293B] text-white' : 'text-[#94A3B8] hover:bg-[#161F2E] hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 001-1" />
                </svg>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

            <!-- 2. Katalog Layanan -->
            <a href="/admin/services/manage" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('admin/services*') ? 'bg-[#1E293B] text-white' : 'text-[#94A3B8] hover:bg-[#161F2E] hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span class="text-sm font-medium">Katalog Layanan</span>
            </a>

            <!-- 3. Direktori Wilayah -->
            <a href="/admin/locations" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('admin/locations*') || request()->is('admin/cities*') ? 'bg-[#1E293B] text-white' : 'text-[#94A3B8] hover:bg-[#161F2E] hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-sm font-medium">Direktori Wilayah</span>
            </a>

            <!-- 4. Artikel -->
            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('admin/articles*') ? 'bg-[#1E293B] text-white' : 'text-[#94A3B8] hover:bg-[#161F2E] hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-4h-2m-4 0h-2m4 0v4" />
                </svg>
                <span class="text-sm font-medium">Artikel</span>
            </a>

            <!-- 5. Grafik -->
            <a href="/admin/graphics" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('admin/graphics*') ? 'bg-[#1E293B] text-white' : 'text-[#94A3B8] hover:bg-[#161F2E] hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span class="text-sm font-medium">Grafik</span>
            </a>

            <!-- 6. Tiket / Jadwal -->
            <a href="{{ route('admin.schedules.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('admin/schedules*') ? 'bg-[#1E293B] text-white' : 'text-[#94A3B8] hover:bg-[#161F2E] hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 11-2 2v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 112-2v-3a2 2 0 00-2-2H5z" />
                </svg>
                <span class="text-sm font-medium">Tiket / Jadwal</span>
            </a>

            <!-- 7. Blog -->
            <a href="/blog" target="_blank" class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors text-[#94A3B8] hover:bg-[#161F2E] hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                <span class="text-sm font-medium">Blog</span>
            </a>
        </nav>

        <div class="p-4 border-t border-[#1E293B]">
            <div class="flex items-center gap-3 px-3 py-2">
                <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-xs font-bold">AD</div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-xs font-bold truncate">Super Admin</p>
                    <p class="text-[10px] text-[#64748B] truncate">admin@trainingkota.my.id</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- TOPBAR -->
        <header class="h-16 bg-[#0E1726] border-b border-[#1E293B] flex items-center justify-between px-6 sticky top-0 z-40 shrink-0">
            <h2 class="font-space font-bold text-sm uppercase tracking-wider text-[#94A3B8]">
                @yield('title', 'Dashboard')
            </h2>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" target="_blank" class="text-xs font-medium text-[#38BDF8] hover:underline flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Visit Site
                </a>
            </div>
        </header>

        <!-- MAIN PAGE CONTENT -->
        <main class="flex-1 overflow-y-auto bg-[#070D18]">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
