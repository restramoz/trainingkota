<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-[#070D18] text-[#F1F5F9] antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'TrainingKota') }} - Portal K3 & Layanan Profesional</title>

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
                <span class="text-[#94A3B8]">JARINGAN RESMI: KEMNAKER RI & BNSP</span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-[#64748B]">REGIONAL HUB: MALANG - JAWA TIMUR</span>
                <span class="text-[#1E324E]">|</span>
                <a href="https://wa.me/6281234567890" target="_blank" class="text-[#25D366] hover:underline flex items-center gap-1 font-semibold">
                    <span class="w-1.5 h-1.5 bg-[#25D366] inline-block"></span>
                    HOTLINE CEPAT: +62 812-3456-7890
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="bg-[#0F2038] border-b border-[#1E324E] sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 h-18 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center space-x-3 py-3">
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

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center space-x-1 font-space text-xs uppercase tracking-wider">
                <a href="#katalog" class="px-3 py-2 text-[#F1F5F9] hover:bg-[#142338] border border-transparent hover:border-[#1E324E] transition-colors">Katalog K3</a>
                <a href="#jadwal" class="px-3 py-2 text-[#94A3B8] hover:text-[#F1F5F9] hover:bg-[#142338] border border-transparent hover:border-[#1E324E] transition-colors">Jadwal & Kuota</a>
                <a href="#perizinan" class="px-3 py-2 text-[#94A3B8] hover:text-[#F1F5F9] hover:bg-[#142338] border border-transparent hover:border-[#1E324E] transition-colors">Jasa Teknis & SLF</a>
                <a href="#akreditasi" class="px-3 py-2 text-[#94A3B8] hover:text-[#F1F5F9] hover:bg-[#142338] border border-transparent hover:border-[#1E324E] transition-colors">Verifikasi Sertifikat</a>
            </nav>

            <!-- Action Triggers -->
            <div class="flex items-center space-x-3">
                <a href="https://wa.me/6281234567890" target="_blank" class="btn-whatsapp text-xs py-2.5 px-4 hidden sm:inline-flex">
                    WhatsApp Direct
                </a>
                <a href="#daftar" class="btn-primary text-xs py-2.5 px-5">
                    Daftar Sekarang
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
                        TRAININGKOTA.MY.ID
                    </div>
                    <p class="text-[#94A3B8] leading-relaxed">
                        Pusat layanan operasional sertifikasi Keselamatan dan Kesehatan Kerja (K3), audit kepatuhan regulasi, kajian kelayakan teknis industri berstandar Kemnaker RI dan BNSP.
                    </p>
                    <div class="flex items-center gap-2 pt-2">
                        <span class="badge-kemnaker">Kemnaker RI</span>
                        <span class="badge-bnsp">BNSP Certified</span>
                    </div>
                </div>

                <!-- Col 2 -->
                <div>
                    <div class="font-space font-bold text-xs uppercase text-[#F1F5F9] tracking-wider mb-3">Layanan Utama K3</div>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-[#10B981] transition-colors">Ahli K3 Umum Kemnaker RI</a></li>
                        <li><a href="#" class="hover:text-[#10B981] transition-colors">Auditor SMK3 PP 50/2012</a></li>
                        <li><a href="#" class="hover:text-[#10B981] transition-colors">K3 Lingkungan Kerja & Higiene</a></li>
                        <li><a href="#" class="hover:text-[#10B981] transition-colors">Sertifikasi Operator Alat Berat</a></li>
                    </ul>
                </div>

                <!-- Col 3 -->
                <div>
                    <div class="font-space font-bold text-xs uppercase text-[#F1F5F9] tracking-wider mb-3">Jasa Teknis & Audit</div>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-[#10B981] transition-colors">Kajian Sertifikat Laik Fungsi (SLF)</a></li>
                        <li><a href="#" class="hover:text-[#10B981] transition-colors">Riksa Uji Instalasi Petir & Listrik</a></li>
                        <li><a href="#" class="hover:text-[#10B981] transition-colors">Uji Emisi & Baku Mutu Industri</a></li>
                        <li><a href="#" class="hover:text-[#10B981] transition-colors">Penyusunan Dokumen UKL-UPL / AMDAL</a></li>
                    </ul>
                </div>

                <!-- Col 4 -->
                <div>
                    <div class="font-space font-bold text-xs uppercase text-[#F1F5F9] tracking-wider mb-3">Regional Hub & Kontak</div>
                    <p class="mb-2">Kota Malang, Jawa Timur - Indonesia</p>
                    <p class="text-[#F1F5F9] font-space font-semibold mb-1">Direct Line: (0341) 500-KOTA</p>
                    <p class="text-[#25D366] font-space font-semibold">WA: +62 812-3456-7890</p>
                    <p class="text-[#64748B] text-[11px] mt-2">Senin - Sabtu: 08.00 - 17.00 WIB</p>
                </div>
            </div>

            <!-- Bottom Copyright & Compliance Notes -->
            <div class="pt-8 border-t border-[#142338] flex flex-col md:flex-row items-center justify-between gap-4 text-[11px] text-[#64748B] font-space">
                <div>
                    &copy; {{ date('Y') }} TrainingKota (trainingkota.my.id). Hak Cipta Dilindungi Undang-Undang.
                </div>
                <div class="flex items-center space-x-6">
                    <span>REGULATORY COMPLIANCE SYSTEM V1.0</span>
                    <span>ALL INTERFACES: ZERO-RADIUS (0PX)</span>
                    <span class="text-[#0D7A5F]">STANDAR KEMNAKER / BNSP</span>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
