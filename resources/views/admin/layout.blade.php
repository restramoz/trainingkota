<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin Dashboard') — TrainingKota</title>

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

<body
    x-data="{ sidebarOpen: false }"
    class="min-h-screen bg-[#070D18] text-white antialiased"
>

    {{-- =========================================================
         MOBILE OVERLAY
    ========================================================== --}}
    <div
        x-show="sidebarOpen"
        x-transition.opacity
        @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm"
        style="display: none;"
    ></div>


    {{-- =========================================================
         SIDEBAR
    ========================================================== --}}
    <aside
        x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 z-50 w-64
               h-screen overflow-y-auto
               border-r border-white/10
               bg-[#0E1726]"
        style="display: none;"
    >

        {{-- Sidebar Header --}}
        <div class="flex h-16 items-center justify-between border-b border-white/10 px-5">

            <a
                href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3"
            >
                <div
                    class="flex h-9 w-9 items-center justify-center
                           rounded-xl bg-blue-600 font-bold text-white"
                >
                    T
                </div>

                <div>
                    <div class="text-sm font-bold text-white">
                        TrainingKota
                    </div>

                    <div class="text-[10px] font-medium uppercase tracking-wider text-slate-400">
                        Admin Panel
                    </div>
                </div>
            </a>

            {{-- Close --}}
            <button
                type="button"
                @click="sidebarOpen = false"
                class="flex h-8 w-8 items-center justify-center rounded-lg
                       text-slate-400 transition hover:bg-white/10 hover:text-white"
                aria-label="Tutup menu"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>

        </div>


        {{-- =====================================================
             NAVIGATION
        ====================================================== --}}
        <nav class="space-y-1 p-3">

            {{-- Dashboard --}}
            <a
                href="{{ route('admin.dashboard') }}"
                @click="sidebarOpen = false"
                class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium
                       transition
                       {{ request()->routeIs('admin.dashboard')
                            ? 'bg-blue-600 text-white'
                            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10"
                    />
                </svg>

                <span>Dashboard</span>
            </a>


            {{-- Katalog Layanan --}}
            <a
                href="/admin/services/manage"
                @click="sidebarOpen = false"
                class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium
                       transition
                       {{ request()->is('admin/services/*')
                            ? 'bg-blue-600 text-white'
                            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>

                <span>Katalog Layanan</span>
            </a>


            {{-- Direktori Wilayah --}}
            <a
                href="/admin/locations"
                @click="sidebarOpen = false"
                class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium
                       transition
                       {{ request()->is('admin/locations*')
                            ? 'bg-blue-600 text-white'
                            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 21s7-6.2 7-12a7 7 0 10-14 0c0 5.8 7 12 7 12z"
                    />
                    <circle cx="12" cy="9" r="2.5" />
                </svg>

                <span>Direktori Wilayah</span>
            </a>


            {{-- Artikel --}}
            <a
                href="{{ route('admin.articles.index') }}"
                @click="sidebarOpen = false"
                class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium
                       transition
                       {{ request()->routeIs('admin.articles.*')
                            ? 'bg-blue-600 text-white'
                            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 4h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8 8h8M8 12h8M8 16h5"
                    />
                </svg>

                <span>Artikel</span>
            </a>


            {{-- Grafik --}}
            <a
                href="/admin/graphics"
                @click="sidebarOpen = false"
                class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium
                       transition
                       {{ request()->is('admin/graphics*')
                            ? 'bg-blue-600 text-white'
                            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 19V5M4 19h16"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8 16v-4M12 16V8M16 16v-7"
                    />
                </svg>

                <span>Grafik</span>
            </a>


            {{-- Tiket / Jadwal --}}
            <a
                href="{{ route('admin.schedules.index') }}"
                @click="sidebarOpen = false"
                class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium
                       transition
                       {{ request()->routeIs('admin.schedules.*')
                            ? 'bg-blue-600 text-white'
                            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 3v4M18 3v4M4 9h16M5 5h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"
                    />
                </svg>

                <span>Tiket / Jadwal</span>
            </a>


            {{-- Divider --}}
            <div class="my-3 border-t border-white/10"></div>


            {{-- Blog --}}
            <a
                href="/blog"
                target="_blank"
                rel="noopener noreferrer"
                @click="sidebarOpen = false"
                class="group flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium
                       text-slate-300 transition hover:bg-white/5 hover:text-white"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 20h9"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4z"
                    />
                </svg>

                <span>Blog</span>

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="ml-auto h-4 w-4 opacity-50"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M7 17L17 7M7 7h10v10"
                    />
                </svg>
            </a>

        </nav>


        {{-- =====================================================
             SIDEBAR FOOTER
        ====================================================== --}}
        <div class="mt-auto border-t border-white/10 p-3">

            <div class="flex items-center gap-3 rounded-xl bg-white/5 p-3">

                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center
                           rounded-full bg-blue-600 text-sm font-bold"
                >
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>

                <div class="min-w-0">
                    <div class="truncate text-sm font-semibold text-white">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </div>

                    <div class="truncate text-xs text-slate-400">
                        Administrator
                    </div>
                </div>

            </div>

        </div>

    </aside>


    {{-- =========================================================
         MAIN WRAPPER
    ========================================================== --}}
    <div class="min-h-screen w-full">

        {{-- =====================================================
             TOPBAR
        ====================================================== --}}
        <header
            class="sticky top-0 z-30 flex h-16 items-center
                   border-b border-white/10
                   bg-[#070D18]/95 px-4 backdrop-blur-md sm:px-6"
        >

            <div class="flex w-full items-center justify-between">

                {{-- Hamburger --}}
                <button
                    type="button"
                    @click="sidebarOpen = true"
                    class="flex h-10 w-10 items-center justify-center
                           rounded-xl border border-white/10
                           bg-white/5 text-slate-300
                           transition hover:bg-white/10 hover:text-white"
                    aria-label="Buka menu"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                </button>


                {{-- Page Title --}}
                <div class="hidden sm:block">
                    <h1 class="text-sm font-semibold text-white">
                        @yield('page-title', 'Admin Dashboard')
                    </h1>
                </div>


                {{-- Right Side --}}
                <div class="flex items-center gap-2">

                    <span class="hidden text-xs text-slate-400 md:block">
                        {{ now()->format('d M Y') }}
                    </span>

                    <div
                        class="flex h-9 w-9 items-center justify-center
                               rounded-full border border-white/10
                               bg-white/5 text-xs font-bold text-white"
                    >
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>

                </div>

            </div>

        </header>


        {{-- =====================================================
             PAGE CONTENT
             Browser/body handles scrolling.
             Jangan gunakan overflow-y-auto di sini.
        ====================================================== --}}
        <main class="min-h-screen overflow-x-hidden bg-[#070D18]">

            @yield('content')

        </main>

    </div>


    @stack('scripts')

</body>
</html>