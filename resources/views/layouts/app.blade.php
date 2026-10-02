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

    <!-- Alpine.js v3 — UI interaktif (FAQ Accordion, TOC toggle, dll) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Per-page SEO Meta (og:title, og:description, canonical, dll) -->
    @stack('meta_seo')

    <!-- JSON-LD Structured Data (FAQPage, Article, LocalBusiness) -->
    @stack('schema')
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
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
                <span class="hidden sm:inline text-[#1E324E]">|</span>
                <span class="hidden sm:inline text-[#94A3B8]">62 PROGRAM &bull; 514 KOTA &amp; KABUPATEN</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="https://wa.me/{{ config('contact.whatsapp') }}" target="_blank" class="text-[#25D366] hover:underline flex items-center gap-1 font-semibold">
                    <span class="w-1.5 h-1.5 bg-[#25D366] inline-block"></span>
                    HOTLINE: {{ config('contact.display') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header (Sticky on all pages) -->
    <header class="bg-[#0F2038]/95 backdrop-blur border-b border-[#1E324E] sticky top-0 z-50 shadow-md" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-3 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 shrink-0">
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

            <!-- Desktop Navigation: Home, Pelatihan, Jasa, Kajian, Kota, Button WhatsApp -->
            <nav class="hidden md:flex items-center space-x-1 font-space text-xs uppercase tracking-wider">
                <a href="{{ route('home') }}" class="px-3.5 py-2 {{ request()->is('/') ? 'bg-[#142338] text-[#10B981] border border-[#0D7A5F]' : 'text-[#F1F5F9] hover:bg-[#142338] border border-transparent hover:border-[#1E324E]' }} transition-colors">
                    Home
                </a>
                <a href="{{ route('category.show', 'pelatihan') }}" class="px-3.5 py-2 {{ request()->is('pelatihan*') ? 'bg-[#142338] text-[#10B981] border border-[#0D7A5F]' : 'text-[#F1F5F9] hover:bg-[#142338] border border-transparent hover:border-[#1E324E]' }} transition-colors">
                    Pelatihan
                </a>
                <a href="{{ route('category.show', 'jasa') }}" class="px-3.5 py-2 {{ request()->is('jasa*') ? 'bg-[#142338] text-[#10B981] border border-[#0D7A5F]' : 'text-[#94A3B8] hover:text-[#F1F5F9] hover:bg-[#142338] border border-transparent hover:border-[#1E324E]' }} transition-colors">
                    Jasa
                </a>
                <a href="{{ route('category.show', 'kajian') }}" class="px-3.5 py-2 {{ request()->is('kajian*') ? 'bg-[#142338] text-[#10B981] border border-[#0D7A5F]' : 'text-[#94A3B8] hover:text-[#F1F5F9] hover:bg-[#142338] border border-transparent hover:border-[#1E324E]' }} transition-colors">
                    Kajian
                </a>
                <a href="{{ route('city.index') }}" class="px-3.5 py-2 {{ request()->is('kota*') ? 'bg-[#142338] text-[#10B981] border border-[#0D7A5F]' : 'text-[#94A3B8] hover:text-[#F1F5F9] hover:bg-[#142338] border border-transparent hover:border-[#1E324E]' }} transition-colors">
                    Kota
                </a>
            </nav>

            <!-- Right: Button WhatsApp & Mobile Toggle -->
            <div class="flex items-center gap-3">
                <a href="https://wa.me/{{ config('contact.whatsapp') }}?text={{ urlencode('Halo Admin TrainingKota, saya ingin konsultasi layanan K3.') }}" target="_blank" class="btn-whatsapp text-xs py-2 px-4 inline-flex items-center gap-2 shadow">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.062-2.115-.527-1.748-.724-2.883-2.493-2.97-2.607-.088-.114-.709-.942-.709-1.796 0-.853.447-1.274.607-1.446.16-.172.352-.215.469-.215.118 0 .235.001.338.006.109.005.255-.041.399.304.149.356.508 1.239.553 1.329.045.09.076.196.015.315-.06.12-.091.196-.18.301-.091.106-.19.237-.272.318-.09.09-.184.188-.079.369.105.18.468.772 1.004 1.249.69.614 1.272.805 1.452.895.18.09.286.076.392-.045.106-.12.454-.528.575-.708.121-.18.243-.15.406-.09.164.06 1.034.488 1.212.577.177.09.296.135.34.21.045.075.045.436-.099.841z"/></svg>
                    WhatsApp
                </a>

                <!-- Hamburger Button (mobile) -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="md:hidden flex flex-col justify-center items-center w-9 h-9 bg-[#0B1526] border border-[#1E324E] hover:border-[#0D7A5F] transition-colors gap-1.5"
                    :aria-expanded="mobileMenuOpen" aria-label="Buka menu">
                    <span class="w-5 h-0.5 bg-[#F1F5F9] block transition-all duration-300" :class="mobileMenuOpen ? 'rotate-45 translate-y-2' : ''"></span>
                    <span class="w-5 h-0.5 bg-[#F1F5F9] block transition-all duration-300" :class="mobileMenuOpen ? 'opacity-0 scale-x-0' : ''"></span>
                    <span class="w-5 h-0.5 bg-[#F1F5F9] block transition-all duration-300" :class="mobileMenuOpen ? '-rotate-45 -translate-y-2' : ''"></span>
                </button>
            </div>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden border-t border-[#1E324E] bg-[#0B1526]">
            <nav class="max-w-7xl mx-auto px-4 py-3 flex flex-col space-y-1 font-space text-xs uppercase tracking-wider">
                <a href="{{ route('home') }}" @click="mobileMenuOpen=false"
                   class="px-4 py-3 flex items-center gap-3 {{ request()->is('/') ? 'text-[#10B981] border-l-2 border-[#0D7A5F] bg-[#142338]' : 'text-[#F1F5F9] border-l-2 border-transparent hover:border-[#0D7A5F] hover:bg-[#142338]' }} transition-colors">
                    <span class="w-1.5 h-1.5 bg-[#0D7A5F] inline-block shrink-0"></span>
                    Home
                </a>
                <a href="{{ route('category.show', 'pelatihan') }}" @click="mobileMenuOpen=false"
                   class="px-4 py-3 flex items-center gap-3 {{ request()->is('pelatihan*') ? 'text-[#10B981] border-l-2 border-[#0D7A5F] bg-[#142338]' : 'text-[#F1F5F9] border-l-2 border-transparent hover:border-[#0D7A5F] hover:bg-[#142338]' }} transition-colors">
                    <span class="w-1.5 h-1.5 bg-[#0D7A5F] inline-block shrink-0"></span>
                    Pelatihan
                </a>
                <a href="{{ route('category.show', 'jasa') }}" @click="mobileMenuOpen=false"
                   class="px-4 py-3 flex items-center gap-3 {{ request()->is('jasa*') ? 'text-[#10B981] border-l-2 border-[#0D7A5F] bg-[#142338]' : 'text-[#94A3B8] border-l-2 border-transparent hover:border-[#0D7A5F] hover:bg-[#142338]' }} transition-colors">
                    <span class="w-1.5 h-1.5 bg-[#0D7A5F] inline-block shrink-0"></span>
                    Jasa
                </a>
                <a href="{{ route('category.show', 'kajian') }}" @click="mobileMenuOpen=false"
                   class="px-4 py-3 flex items-center gap-3 {{ request()->is('kajian*') ? 'text-[#10B981] border-l-2 border-[#0D7A5F] bg-[#142338]' : 'text-[#94A3B8] border-l-2 border-transparent hover:border-[#0D7A5F] hover:bg-[#142338]' }} transition-colors">
                    <span class="w-1.5 h-1.5 bg-[#0D7A5F] inline-block shrink-0"></span>
                    Kajian
                </a>
                <a href="{{ route('city.index') }}" @click="mobileMenuOpen=false"
                   class="px-4 py-3 flex items-center gap-3 {{ request()->is('kota*') ? 'text-[#10B981] border-l-2 border-[#0D7A5F] bg-[#142338]' : 'text-[#94A3B8] border-l-2 border-transparent hover:border-[#0D7A5F] hover:bg-[#142338]' }} transition-colors">
                    <span class="w-1.5 h-1.5 bg-[#0D7A5F] inline-block shrink-0"></span>
                    Kota (514 Wilayah)
                </a>
                <div class="pt-2">
                    <a href="https://wa.me/{{ config('contact.whatsapp') }}" target="_blank" class="btn-whatsapp w-full py-2.5 text-center text-xs flex items-center justify-center gap-2">
                        WhatsApp Hotline
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content Body -->
    <main class="flex-grow pb-10 sm:pb-20">
        @yield('content')
    </main>

    <!-- Footer: Industrial K3 Command & Compliance -->
    <footer class="bg-[#0B1526] border-t border-[#1E324E] text-[#94A3B8] text-xs font-body">
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
                        
                    </ul>
                </div>

                <!-- Col 3 -->
                <div>
                    <div class="font-space font-bold text-xs uppercase text-[#F1F5F9] tracking-wider mb-3">Kota Layanan</div>
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
                    <p class="text-[#25D366] font-space font-semibold">WA: {{ config('contact.display') }}</p>
                    <p class="text-[#64748B] text-[11px] mt-2">Senin - Sabtu: 08.00 - 17.00 WIB</p>
                </div>
            </div>

            <!-- Bottom Copyright & Compliance Notes -->
            <div class="pt-8 border-t border-[#142338] flex flex-col md:flex-row items-center justify-between gap-4 text-[11px] text-[#64748B] font-space">
                <div>
                    &copy; {{ date('Y') }} trainingkota.my.id
                </div>
                <div class="flex items-center space-x-6">
                    <span>RESERVED BY</span>
                    <span class="text-[#0D7A5F]">RYO DGITAL</span>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>

