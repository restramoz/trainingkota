@extends('layouts.app')

@section('content')

<!-- Filter & Search in Category – moved to top for better UX -->
<section class="py-6 bg-[#0E1726] border-b border-[#1E293B]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-xs font-space text-[#94A3B8] uppercase">
            MENAMPILKAN <span class="text-[#F1F5F9] font-bold">{{ count($services) }}</span> LAYANAN DI KATALOG {{ strtoupper($category) }}
        </div>
        <div class="w-full sm:w-80">
            <input 
                type="text" 
                id="service-search-input" 
                placeholder="Cari program layanan ini..." 
                class="input-k3 w-full text-xs font-space"
                oninput="filterServices(this.value)"
            >
        </div>
    </div>
</section>

<!-- Header Category Banner -->
<section class="bg-gradient-to-b from-[#0F2038] to-[#070D18] border-b border-[#1E324E] py-14">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center space-x-2 text-xs font-space uppercase text-[#94A3B8] mb-4">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <span class="text-[#10B981] font-semibold">{{ strtoupper($category) }}</span>
        </div>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="badge-kemnaker">{{ strtoupper($category) }} RESMI</span>
                    <span class="text-xs font-space text-[#94A3B8]">{{ count($services) }} Program Terdaftar</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-bold font-space text-[#F1F5F9]">
                    {{ $categoryTitle }}
                </h1>
                <p class="text-sm sm:text-base text-[#94A3B8] mt-2 max-w-3xl font-body">
                    {{ $categorySubtitle }}
                </p>
            </div>

            <!-- Switch category pills -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('category.show', 'pelatihan') }}" class="px-3 py-1.5 text-xs font-space uppercase {{ $category === 'pelatihan' ? 'bg-[#0D7A5F] text-white border border-[#0D7A5F]' : 'bg-[#0B1526] text-[#94A3B8] border border-[#1E324E] hover:text-white' }}">
                    Pelatihan (53)
                </a>
                <a href="{{ route('category.show', 'kajian') }}" class="px-3 py-1.5 text-xs font-space uppercase {{ $category === 'kajian' ? 'bg-[#0D7A5F] text-white border border-[#0D7A5F]' : 'bg-[#0B1526] text-[#94A3B8] border border-[#1E324E] hover:text-white' }}">
                    Kajian (3)
                </a>
                <a href="{{ route('category.show', 'jasa') }}" class="px-3 py-1.5 text-xs font-space uppercase {{ $category === 'jasa' ? 'bg-[#0D7A5F] text-white border border-[#0D7A5F]' : 'bg-[#0B1526] text-[#94A3B8] border border-[#1E324E] hover:text-white' }}">
                    Jasa (6)
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div id="services-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                <div class="service-card bg-[#0B1526] border border-[#1E324E] p-6 flex flex-col justify-between hover:border-[#0D7A5F] transition-all" data-name="{{ strtolower($service->name) }}" @if($loop->index >= 6) style="display:none;" @endif>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="badge-kemnaker text-[10px]">{{ $service->badge }}</span>
                            <span class="text-xs font-space text-[#10B981] font-semibold">{{ $service->duration }}</span>
                        </div>
                        
                        <h2 class="text-lg font-bold font-space text-[#F1F5F9]">
                            <a href="{{ route('service.detail', ['category' => $category, 'serviceSlug' => $service->slug]) }}" class="hover:text-[#10B981] transition-colors">
                                {{ $service->name }}
                            </a>
                        </h2>

                        <p class="text-xs text-[#94A3B8] leading-relaxed line-clamp-3">
                            {{ $service->description }}
                        </p>

                        <!-- Quick Syllabus Points (Pelatihan Only) -->
                        @if($category === 'pelatihan' && !empty($service->syllabus) && is_array($service->syllabus))
                            <div class="border-t border-[#142338] pt-3 space-y-1">
                                @foreach(array_slice($service->syllabus, 0, 2) as $point)
                                    <div class="text-[11px] text-[#c5c6ce] flex items-center gap-1.5">
                                        <span class="text-[#0D7A5F] font-bold">&#10003;</span>
                                        <span class="truncate">{{ $point }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="pt-6 mt-6 border-t border-[#1E324E] flex items-center justify-between">
                        <div class="flex items-center gap-1.5 text-[#10B981] font-space text-xs">
                            <span class="w-2 h-2 bg-[#10B981] inline-block"></span>
                            <span class="text-[11px] uppercase font-bold">{{ $service->badge ?? 'Kemnaker RI' }}</span>
                        </div>
                        <a href="{{ route('service.detail', ['category' => $category, 'serviceSlug' => $service->slug]) }}" class="btn-primary border-rounded text-xs py-2 px-3.5">
                            Detail Layanan &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="no-service-found" class="hidden p-8 bg-[#0F2038] border border-[#1E324E] text-center text-[#94A3B8] font-space text-sm mt-6">
            Program tidak ditemukan. Silakan hubungi tim kami untuk pengajuan silabus kustom.
        </div>
    </div>
</section>

@if($services->count() > 6)
    <section class="py-8 bg-[#0B1526]/20 border-t border-[#1E324E]">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-[#F1F5F9] font-space text-lg font-bold">
                Semua Layanan {{ ucfirst($category) }}
            </div>
            <div class="text-[#94A3B8] font-space">
                {{ $services->count() }} program tersedia
            </div>
            <button id="show-all-services" class="btn-primary text-sm py-2 px-4" onclick="showAllServices()">Lihat Semua</button>
        </div>
    </section>
@endif

<!-- Quick City Selector for this Category -->
<section class="py-12 bg-[#0F2038] border-t border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="border-b border-[#1E324E] pb-4 mb-6 flex items-center justify-between">
            <h3 class="font-space font-bold text-sm uppercase text-[#F1F5F9] tracking-wider flex items-center gap-2">
                <span class="w-2 h-2 bg-[#0D7A5F] inline-block"></span>
                Pelaksanaan {{ ucfirst($category) }} di Kota Pilihan Anda
            </h3>
            <a href="{{ route('home') }}#widget-kota" class="text-xs text-[#38BDF8] font-space hover:underline">
                Lihat Semua 514 Kota &rarr;
            </a>
        </div>

        <div class="flex flex-wrap gap-2">
            @foreach($hubCities as $hub)
                <a href="{{ route('city.landing', ['category' => $category, 'citySlug' => $hub->slug]) }}" class="px-3 py-1.5 bg-[#070D18] border border-[#1E324E] hover:border-[#0D7A5F] text-[#F1F5F9] hover:text-[#10B981] text-xs font-space uppercase">
                    {{ ucfirst($category) }} di {{ $hub->name }} &rarr;
                </a>
            @endforeach
        </div>
    </div>
</section>

    <!-- FAQ Section -->
    <section id="faq-section" class="py-12 bg-[#0B1526]/20 border-b border-[#1E324E]" x-data="{ openFaq: null }">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <h3 class="text-[#0D7A5F] mb-2">FAQ</h3>
            <h2 class="text-[24px] font-bold font-space text-[#F1F5F9] mb-4">Pertanyaan Umum {{ ucfirst($category) }}</h2>
            <div class="space-y-2">
                <div class="border border-[#1E324E] overflow-hidden transition-colors" :class="openFaq === 0 ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'">
                    <button @click="openFaq = openFaq === 0 ? null : 0"
                        class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                        :class="openFaq === 0 ? 'bg-[#0F2038]' : ''">
                        <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">Apa itu layanan {{ $category }}?</span>
                        <svg class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                            :class="openFaq === 0 ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 0" x-collapse class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E] text-[#94A3B8] font-body text-xs leading-relaxed">
                        <p>Layanan {{ $category }} menyediakan solusi resmi Kemnaker untuk {{ $category }} di seluruh Indonesia.</p>
                    </div>
                </div>
                <!-- Additional FAQ items -->
                <div class="border border-[#1E324E] overflow-hidden transition-colors" :class="openFaq === 1 ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'">
                    <button @click="openFaq = openFaq === 1 ? null : 1"
                        class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                        :class="openFaq === 1 ? 'bg-[#0F2038]' : ''">
                        <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">Siapa yang dapat menggunakan layanan ini?</span>
                        <svg class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                            :class="openFaq === 1 ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 1" x-collapse class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E] text-[#94A3B8] font-body text-xs leading-relaxed">
                        <p>Layanan ini terbuka untuk perusahaan, institusi, dan individu yang membutuhkan sertifikasi atau pelatihan resmi.</p>
                    </div>
                </div>
                <div class="border border-[#1E324E] overflow-hidden transition-colors" :class="openFaq === 2 ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'">
                    <button @click="openFaq = openFaq === 2 ? null : 2"
                        class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                        :class="openFaq === 2 ? 'bg-[#0F2038]' : ''">
                        <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">Bagaimana cara mendaftar?</span>
                        <svg class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                            :class="openFaq === 2 ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 2" x-collapse class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E] text-[#94A3B8] font-body text-xs leading-relaxed">
                        <p>Anda dapat mendaftar melalui tombol “Booking” di halaman layanan atau menghubungi via WhatsApp.</p>
                    </div>
                </div>
                <div class="border border-[#1E324E] overflow-hidden transition-colors" :class="openFaq === 3 ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'">
                    <button @click="openFaq = openFaq === 3 ? null : 3"
                        class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                        :class="openFaq === 3 ? 'bg-[#0F2038]' : ''">
                        <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">Berapa lama proses layanan?</span>
                        <svg class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                            :class="openFaq === 3 ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 3" x-collapse class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E] text-[#94A3B8] font-body text-xs leading-relaxed">
                        <p>Durasi bervariasi tergantung layanan, biasanya 2‑8 minggu kerja untuk kajian teknis.</p>
                    </div>
                </div>
                <div class="border border-[#1E324E] overflow-hidden transition-colors" :class="openFaq === 4 ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'">
                    <button @click="openFaq = openFaq === 4 ? null : 4"
                        class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                        :class="openFaq === 4 ? 'bg-[#0F2038]' : ''">
                        <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">Apakah layanan tersedia di kota lain?</span>
                        <svg class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                            :class="openFaq === 4 ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 4" x-collapse class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E] text-[#94A3B8] font-body text-xs leading-relaxed">
                        <p>Ya, layanan {{ $category }} tersebar di lebih dari {{ $services->count() }} wilayah di Indonesia.</p>
                    </div>
                </div>
                <div class="border border-[#1E324E] overflow-hidden transition-colors" :class="openFaq === 5 ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'">
                    <button @click="openFaq = openFaq === 5 ? null : 5"
                        class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                        :class="openFaq === 5 ? 'bg-[#0F2038]' : ''">
                        <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">Apakah layanan dapat diakses online?</span>
                        <svg class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                            :class="openFaq === 5 ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 5" x-collapse class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E] text-[#94A3B8] font-body text-xs leading-relaxed">
                        <p>Beberapa layanan pelatihan tersedia secara online melalui LMS kami.</p>
                    </div>
                </div>
                <div class="border border-[#1E324E] overflow-hidden transition-colors" :class="openFaq === 6 ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'">
                    <button @click="openFaq = openFaq === 6 ? null : 6"
                        class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                        :class="openFaq === 6 ? 'bg-[#0F2038]' : ''">
                        <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">Bagaimana proses pembayaran?</span>
                        <svg class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                            :class="openFaq === 6 ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 6" x-collapse class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E] text-[#94A3B8] font-body text-xs leading-relaxed">
                        <p>Pembayaran dapat dilakukan via transfer bank atau melalui WhatsApp setelah konfirmasi.</p>
                    </div>
                </div>
                <div class="border border-[#1E324E] overflow-hidden transition-colors" :class="openFaq === 7 ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'">
                    <button @click="openFaq = openFaq === 7 ? null : 7"
                        class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                        :class="openFaq === 7 ? 'bg-[#0F2038]' : ''">
                        <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">Bagaimana cara menghubungi tim?</span>
                        <svg class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                            :class="openFaq === 7 ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 7" x-collapse class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E] text-[#94A3B8] font-body text-xs leading-relaxed">
                        <p>Hubungi kami via WhatsApp di <a href="https://wa.me/{{ config('contact.whatsapp') }}" class="text-[#10B981] underline">+{{ config('contact.whatsapp') }}</a>.</p>
                    </div>
                </div>
                <!-- End of FAQ items -->
            </div>
        </div>
    </section>

    <!-- Q&A Section -->
    <section id="qa-section" class="py-12 bg-[#0B1526]/20 border-b border-[#1E324E]" x-data="{ openQna: null }">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <h2 class="text-[#0D7A5F] mb-2">Q&amp;A</h2>
            <h3 class="text-4xl font-bold font-space text-[#F1F5F9] mb-4">Tanya Jawab {{ ucfirst($category) }}</h3>
            <div class="space-y-2">
                <div class="border border-[#1E324E] overflow-hidden transition-colors" :class="openQna === 0 ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'">
                    <button @click="openQna = openQna === 0 ? null : 0"
                        class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                        :class="openQna === 0 ? 'bg-[#0F2038]' : ''">
                        <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">Saya masih bingung memilih layanan, mulai dari mana?</span>
                        <svg class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                            :class="openQna === 0 ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openQna === 0" x-collapse class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E] text-[#94A3B8] font-body text-xs leading-relaxed">
                        <p>Anda dapat mulai dengan membaca deskripsi layanan di katalog atau menghubungi tim kami untuk rekomendasi.</p>
                    </div>
                </div>
                <!-- Additional Q&A items -->
                <div class="border border-[#1E324E] overflow-hidden transition-colors" :class="openQna === 1 ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'">
                    <button @click="openQna = openQna === 1 ? null : 1"
                        class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                        :class="openQna === 1 ? 'bg-[#0F2038]' : ''">
                        <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">Apakah bisa konsultasi sebelum booking?</span>
                        <svg class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                            :class="openQna === 1 ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openQna === 1" x-collapse class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E] text-[#94A3B8] font-body text-xs leading-relaxed">
                        <p>Ya, tim kami siap konsultasi via WhatsApp atau telepon untuk menyesuaikan kebutuhan.</p>
                    </div>
                </div>
                <div class="border border-[#1E324E] overflow-hidden transition-colors" :class="openQna === 2 ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'">
                    <button @click="openQna = openQna === 2 ? null : 2"
                        class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                        :class="openQna === 2 ? 'bg-[#0F2038]' : ''">
                        <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">Bagaimana kalau kebutuhan saya tidak ada di katalog?</span>
                        <svg class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                            :class="openQna === 2 ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openQna === 2" x-collapse class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E] text-[#94A3B8] font-body text-xs leading-relaxed">
                        <p>Kami dapat merancang layanan khusus setelah diskusi detail kebutuhan Anda.</p>
                    </div>
                </div>
                <div class="border border-[#1E324E] overflow-hidden transition-colors" :class="openQna === 3 ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'">
                    <button @click="openQna = openQna === 3 ? null : 3"
                        class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                        :class="openQna === 3 ? 'bg-[#0F2038]' : ''">
                        <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">Apakah bisa request jadwal?</span>
                        <svg class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                            :class="openQna === 3 ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openQna === 3" x-collapse class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E] text-[#94A3B8] font-body text-xs leading-relaxed">
                        <p>Jadwal dapat diatur sesuai ketersediaan anda dan tim kami.</p>
                    </div>
                </div>
                <div class="border border-[#1E324E] overflow-hidden transition-colors" :class="openQna === 4 ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'">
                    <button @click="openQna = openQna === 4 ? null : 4"
                        class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                        :class="openQna === 4 ? 'bg-[#0F2038]' : ''">
                        <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">Apakah layanan tersedia untuk perusahaan?</span>
                        <svg class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                            :class="openQna === 4 ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openQna === 4" x-collapse class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E] text-[#94A3B8] font-body text-xs leading-relaxed">
                        <p>Ya, layanan kami dirancang untuk mendukung kebutuhan perusahaan serta organisasi.</p>
                    </div>
                </div>
                <div class="border border-[#1E324E] overflow-hidden transition-colors" :class="openQna === 5 ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'">
                    <button @click="openQna = openQna === 5 ? null : 5"
                        class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                        :class="openQna === 5 ? 'bg-[#0F2038]' : ''">
                        <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">Bagaimana jika saya perlu informasi tambahan?</span>
                        <svg class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                            :class="openQna === 5 ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openQna === 5" x-collapse class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E] text-[#94A3B8] font-body text-xs leading-relaxed">
                        <p>Hubungi tim kami melalui WhatsApp atau telepon untuk detail lebih lanjut.</p>
                    </div>
                </div>
                <div class="border border-[#1E324E] overflow-hidden transition-colors" :class="openQna === 6 ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'">
                    <button @click="openQna = openQna === 6 ? null : 6"
                        class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                        :class="openQna === 6 ? 'bg-[#0F2038]' : ''">
                        <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">Apakah bisa meminta penawaran khusus?</span>
                        <svg class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                            :class="openQna === 6 ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openQna === 6" x-collapse class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E] text-[#94A3B8] font-body text-xs leading-relaxed">
                        <p>Kami dapat menyiapkan penawaran khusus sesuai skala dan kebutuhan Anda.</p>
                    </div>
                </div>
                <div class="border border-[#1E324E] overflow-hidden transition-colors" :class="openQna === 7 ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'">
                    <button @click="openQna = openQna === 7 ? null : 7"
                        class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                        :class="openQna === 7 ? 'bg-[#0F2038]' : ''">
                        <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">Bagaimana cara menghubungi tim?</span>
                        <svg class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                            :class="openQna === 7 ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openQna === 7" x-collapse class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E] text-[#94A3B8] font-body text-xs leading-relaxed">
                        <p>Hubungi via WhatsApp <a href="https://wa.me/{{ config('contact.whatsapp') }}" class="text-[#10B981] underline">+{{ config('contact.whatsapp') }}</a> atau telepon.</p>
                    </div>
                </div>
                <!-- End of Q&A items -->
            </div>
        </div>
    </section>



<script>
function filterServices(query) {
    query = query.toLowerCase().trim();
    const cards = document.querySelectorAll('.service-card');
    let visible = 0;

    cards.forEach(c => {
        const name = c.getAttribute('data-name');
        if (!query || name.includes(query)) {
            c.style.display = 'flex';
            visible++;
        } else {
            c.style.display = 'none';
        }
    });

    document.getElementById('no-service-found').classList.toggle('hidden', visible > 0);
}

function showAllServices() {
    const cards = document.querySelectorAll('.service-card');
    cards.forEach(c => {
        c.style.display = 'flex';
    });
}
</script>

@endsection