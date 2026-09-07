<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-[#070D18] text-[#F1F5F9] antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'TrainingKota' }} - Portal K3 &amp; Layanan Profesional</title>

    <!-- Preconnect Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Compiled Assets via Vite (Local Compilation) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#070D18] text-[#F1F5F9] font-body min-h-screen flex flex-col selection:bg-[#0D7A5F] selection:text-white">
    <!-- Regulatory Top Operational Bar -->
    <div class="bg-[#0B1526] border-b border-[#1E324E] text-[11px] font-space tracking-wider uppercase text-[#94A3B8] px-4 lg:px-8 py-2">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center space-x-4">
                <span class="inline-flex items-center text-[#10B981]">
                    <span class="w-2 h-2 bg-[#10B981] inline-block mr-2 animate-pulse"></span>
                    SISTEM OPERASIONAL K3 NASIONAL
                </span>
                <span class="text-[#1E324E]">|</span>
                <span class="text-[#94A3B8]">62 PROGRAM LAYANAN &bull; 212 KOTA/KABUPATEN</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="text-[#38BDF8] hover:underline flex items-center gap-1 font-semibold">
                    <span class="w-1.5 h-1.5 bg-[#38BDF8] inline-block"></span>
                    CMS ADMIN DASHBOARD
                </a>
                <span class="text-[#1E324E]">|</span>
                <a href="https://wa.me/6281234567890" target="_blank" class="text-[#25D366] hover:underline flex items-center gap-1 font-semibold">
                    <span class="w-1.5 h-1.5 bg-[#25D366] inline-block"></span>
                    HOTLINE: +62 812-3456-7890
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="bg-[#0F2038] border-b border-[#1E324E] sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 h-18 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 py-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 50" fill="none" class="h-9 w-auto">
                    <g transform="translate(4, 5)">
                        <rect x="0" y="2" width="36" height="36" fill="#0B1526" stroke="#1E324E" stroke-width="1.5"/>
                        <path d="M18 8L30 14V22C30 28.5 24.9 34.6 18 36C11.1 34.6 6 28.5 6 22V14L18 8Z" stroke="#10B981" stroke-width="2" stroke-linejoin="round" fill="none"/>
                        <path d="M14 22L17 25L23 18" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="28" cy="8" r="3" fill="#F59E0B"/>
                    </g>
                    <text x="52" y="25" font-family="'Space Grotesk', sans-serif" font-size="20" font-weight="700" letter-spacing="-0.5px" fill="#F1F5F9">Training<tspan fill="#0D7A5F">Kota</tspan></text>
                    <text x="53" y="37" font-family="'Space Grotesk', sans-serif" font-size="8.5" font-weight="600" letter-spacing="1px" fill="#94A3B8">PORTAL K3 &amp; LAYANAN PROFESIONAL</text>
                </svg>
            </a>

            <!-- Navigation Links (3 Master Categories + Cities + Admin) -->
            <nav class="hidden md:flex items-center space-x-1 font-space text-xs uppercase tracking-wider">
                <a href="{{ route('category.show', 'pelatihan') }}" class="px-3 py-2 {{ request()->is('pelatihan*') ? 'bg-[#142338] text-[#10B981] border border-[#0D7A5F]' : 'text-[#F1F5F9] hover:bg-[#142338] border border-transparent hover:border-[#1E324E]' }} transition-colors">
                    Pelatihan K3 (53)
                </a>
                <a href="{{ route('category.show', 'kajian') }}" class="px-3 py-2 {{ request()->is('kajian*') ? 'bg-[#142338] text-[#10B981] border border-[#0D7A5F]' : 'text-[#94A3B8] hover:text-[#F1F5F9] hover:bg-[#142338] border border-transparent hover:border-[#1E324E]' }} transition-colors">
                    Kajian Teknis (3)
                </a>
                <a href="{{ route('category.show', 'jasa') }}" class="px-3 py-2 {{ request()->is('jasa*') ? 'bg-[#142338] text-[#10B981] border border-[#0D7A5F]' : 'text-[#94A3B8] hover:text-[#F1F5F9] hover:bg-[#142338] border border-transparent hover:border-[#1E324E]' }} transition-colors">
                    Jasa SLF &amp; Izin (6)
                </a>
                <a href="{{ route('home') }}#widget-kota" class="px-3 py-2 text-[#94A3B8] hover:text-[#F1F5F9] hover:bg-[#142338] border border-transparent hover:border-[#1E324E] transition-colors">
                    212 Kota/Kab
                </a>
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 text-[#38BDF8] hover:bg-[#142338] border border-transparent hover:border-[#1E324E] transition-colors">
                    CMS Admin
                </a>
            </nav>

            <!-- Action Triggers -->
            <div class="flex items-center space-x-3">
                <a href="https://wa.me/6281234567890" target="_blank" class="btn-whatsapp text-xs py-2 px-3.5 hidden sm:inline-flex">
                    WhatsApp Direct
                </a>
                <a href="{{ route('category.show', 'pelatihan') }}" class="btn-primary text-xs py-2 px-4">
                    Katalog Lengkap
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Body -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer: Industrial K3 Command & Compliance -->
    <footer class="bg-[#0B1526] border-t border-[#1E324E] text-[#94A3B8] text-xs font-body mt-20">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
                <!-- Col 1 -->
                <div class="space-y-3">
                    <div class="font-space font-bold text-sm uppercase text-[#F1F5F9] tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 bg-[#0D7A5F] inline-block"></span>
                        TRAININGKOTA.MY.ID (LOCAL MVP)
                    </div>
                    <p class="text-[#94A3B8] leading-relaxed">
                        Pusat layanan operasional sertifikasi Keselamatan dan Kesehatan Kerja (K3), audit kepatuhan regulasi, kajian kelayakan teknis industri berstandar Kemnaker RI dan BNSP di 212 Kota/Kabupaten.
                    </p>
                    <div class="flex items-center gap-2 pt-2">
                        <span class="badge-kemnaker">Kemnaker RI</span>
                        <span class="badge-bnsp">BNSP Certified</span>
                    </div>
                </div>

                <!-- Col 2 -->
                <div>
                    <div class="font-space font-bold text-xs uppercase text-[#F1F5F9] tracking-wider mb-3">3 Pilar Layanan Utama</div>
                    <ul class="space-y-2 font-space text-[12px]">
                        <li><a href="{{ route('category.show', 'pelatihan') }}" class="hover:text-[#10B981] transition-colors flex items-center justify-between">Pelatihan K3 <span>(53 Program)</span></a></li>
                        <li><a href="{{ route('category.show', 'kajian') }}" class="hover:text-[#10B981] transition-colors flex items-center justify-between">Kajian Teknis K3 <span>(3 Program)</span></a></li>
                        <li><a href="{{ route('category.show', 'jasa') }}" class="hover:text-[#10B981] transition-colors flex items-center justify-between">Jasa SLF &amp; Izin <span>(6 Program)</span></a></li>
                        <li><a href="{{ route('admin.dashboard') }}" class="text-[#38BDF8] hover:underline pt-1 block">Akses CMS Admin &rarr;</a></li>
                    </ul>
                </div>

                <!-- Col 3 -->
                <div>
                    <div class="font-space font-bold text-xs uppercase text-[#F1F5F9] tracking-wider mb-3">Hub Kota Utama</div>
                    <div class="flex flex-wrap gap-1.5">
                        <a href="{{ route('city.landing', ['category' => 'pelatihan', 'citySlug' => 'malang']) }}" class="px-2 py-1 bg-[#070D18] border border-[#1E324E] text-[#94A3B8] hover:text-[#10B981] hover:border-[#0D7A5F] text-[11px] font-space uppercase">Malang</a>
                        <a href="{{ route('city.landing', ['category' => 'pelatihan', 'citySlug' => 'surabaya']) }}" class="px-2 py-1 bg-[#070D18] border border-[#1E324E] text-[#94A3B8] hover:text-[#10B981] hover:border-[#0D7A5F] text-[11px] font-space uppercase">Surabaya</a>
                        <a href="{{ route('city.landing', ['category' => 'pelatihan', 'citySlug' => 'jakarta']) }}" class="px-2 py-1 bg-[#070D18] border border-[#1E324E] text-[#94A3B8] hover:text-[#10B981] hover:border-[#0D7A5F] text-[11px] font-space uppercase">Jakarta</a>
                        <a href="{{ route('city.landing', ['category' => 'pelatihan', 'citySlug' => 'balikpapan']) }}" class="px-2 py-1 bg-[#070D18] border border-[#1E324E] text-[#94A3B8] hover:text-[#10B981] hover:border-[#0D7A5F] text-[11px] font-space uppercase">Balikpapan</a>
                        <a href="{{ route('city.landing', ['category' => 'pelatihan', 'citySlug' => 'makassar']) }}" class="px-2 py-1 bg-[#070D18] border border-[#1E324E] text-[#94A3B8] hover:text-[#10B981] hover:border-[#0D7A5F] text-[11px] font-space uppercase">Makassar</a>
                        <a href="{{ route('city.landing', ['category' => 'pelatihan', 'citySlug' => 'medan']) }}" class="px-2 py-1 bg-[#070D18] border border-[#1E324E] text-[#94A3B8] hover:text-[#10B981] hover:border-[#0D7A5F] text-[11px] font-space uppercase">Medan</a>
                    </div>
                </div>

                <!-- Col 4 -->
                <div>
                    <div class="font-space font-bold text-xs uppercase text-[#F1F5F9] tracking-wider mb-3">Kontak Operasional</div>
                    <p class="mb-2">Local Development Environment: 127.0.0.1:8000</p>
                    <p class="text-[#F1F5F9] font-space font-semibold mb-1">Direct Line: (0341) 500-KOTA</p>
                    <p class="text-[#25D366] font-space font-semibold">WA: +62 812-3456-7890</p>
                    <p class="text-[#64748B] text-[11px] mt-2">Senin - Sabtu: 08.00 - 17.00 WIB</p>
                </div>
            </div>

            <!-- Bottom Copyright & Compliance Notes -->
            <div class="pt-8 border-t border-[#142338] flex flex-col md:flex-row items-center justify-between gap-4 text-[11px] text-[#64748B] font-space">
                <div>
                    &copy; {{ date('Y') }} TrainingKota. Database: SQLite Local (62 Layanan &bull; 212 Kota).
                </div>
                <div class="flex items-center space-x-6">
                    <span>ZERO-RADIUS 0PX ENFORCED</span>
                    <span class="text-[#0D7A5F]">TAILWIND CSS &amp; VITE LOCAL</span>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
