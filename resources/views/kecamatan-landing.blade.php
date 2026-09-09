@extends('layouts.app')

@php
    $seoTitle = $kecamatan->seo_title ?: "Layanan " . ucfirst($category) . " K3 di Kecamatan {$kecamatan->name}, {$city->name} - TrainingKota";
    $metaDesc = $kecamatan->meta_description ?: "Pusat informasi " . ucfirst($category) . " K3 resmi di Kecamatan {$kecamatan->name}, {$city->name}. Sentra praktik, jadwal, konsultasi izin dan sertifikasi Kemnaker RI.";
@endphp

@section('title', $seoTitle)

@section('meta')
    <meta name="description" content="{{ $metaDesc }}">
    <link rel="canonical" href="{{ url("/{$category}/kecamatan-{$kecamatan->slug}") }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $metaDesc }}">
    <meta property="og:url" content="{{ url("/{$category}/kecamatan-{$kecamatan->slug}") }}">
@endsection

@section('content')
<!-- 1. Breadcrumbs -->
<div class="bg-[#0B1526] border-b border-[#1E324E] py-3 text-xs font-space text-[#94A3B8]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 flex flex-wrap items-center space-x-2">
        <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
        <span>/</span>
        <a href="{{ route('category.show', $category) }}" class="hover:text-white uppercase">{{ $category }}</a>
        <span>/</span>
        <a href="{{ route('city.landing', ['category' => $category, 'citySlug' => $city->slug]) }}" class="hover:text-white">{{ $city->name }}</a>
        <span>/</span>
        <span class="text-[#10B981] font-semibold">Kecamatan {{ $kecamatan->name }}</span>
    </div>
</div>

<!-- 2. Hero Section -->
<section class="bg-gradient-to-b from-[#0F2038] to-[#070D18] border-b border-[#1E324E] py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 space-y-6">
        <div class="flex flex-wrap items-center gap-2">
            <span class="badge-kemnaker">Kemnaker RI &bull; BNSP</span>
            <span class="badge-warning">KECAMATAN {{ strtoupper($kecamatan->name) }}</span>
            <span class="badge-bnsp">{{ strtoupper($city->name) }}</span>
        </div>

        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-space text-[#F1F5F9] leading-tight">
            Pusat {{ ucfirst($category) }} K3 di Kecamatan {{ $kecamatan->name }}, {{ $city->name }}
        </h1>

        <p class="text-base sm:text-lg text-[#94A3B8] leading-relaxed max-w-3xl font-body">
            Layanan resmi pembinaan kompetensi keselamatan kerja, inspeksi teknis fasilitas industri, dan sertifikasi keahlian K3 di kawasan Kecamatan {{ $kecamatan->name }} dan sekitarnya. Terhubung langsung dengan jejaring sentra praktik regional {{ $city->name }}.
        </p>

        <div class="flex flex-wrap items-center gap-4 pt-2">
            <a href="https://wa.me/6281234567890?text={{ urlencode("Halo Admin TrainingKota, saya membutuhkan informasi program {$category} di Kecamatan {$kecamatan->name}, {$city->name}") }}" target="_blank" class="btn-primary">
                Konsultasi Layanan {{ ucfirst($category) }}
            </a>
            <a href="#locations" class="btn-secondary">
                Lihat Titik Lokasi &amp; Sentra Praktik
            </a>
        </div>
    </div>
</section>

<!-- 3. Technical Visual Section -->
<section class="max-w-7xl mx-auto px-4 lg:px-8">
    <x-service-visual :category="$category" />
</section>

<!-- 4. Related Services Grid -->
<section class="py-12 border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#1E324E] pb-4">
            <div>
                <h2 class="text-xl lg:text-2xl font-bold font-space text-[#F1F5F9] flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#0D7A5F] inline-block"></span>
                    Program {{ ucfirst($category) }} Tersedia di Wilayah {{ $kecamatan->name }}
                </h2>
                <p class="text-xs text-[#94A3B8] mt-1 font-body">Pilih program untuk melihat silabus, persyaratan berkas, dan detail teknis.</p>
            </div>
            <a href="{{ route('category.show', $category) }}" class="text-xs font-space text-[#10B981] hover:underline uppercase">
                Lihat Semua Katalog &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $srv)
                <div class="bg-[#0B1526] border border-[#1E324E] hover:border-[#0D7A5F] transition flex flex-col justify-between p-6">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-space uppercase px-2 py-0.5 border border-[#1E324E] text-[#10B981] bg-[#070D18]">
                                {{ $srv->badge ?? 'Kemnaker RI' }}
                            </span>
                            @if($category === 'pelatihan' && !empty($srv->duration))
                                <span class="text-[11px] font-space text-[#94A3B8]">{{ $srv->duration }}</span>
                            @endif
                        </div>
                        <h3 class="font-space font-bold text-base text-[#F1F5F9]">
                            {{ $srv->name }}
                        </h3>
                        <p class="text-xs text-[#94A3B8] leading-relaxed line-clamp-3 font-body">
                            {{ $srv->description }}
                        </p>
                    </div>

                    <div class="pt-6 border-t border-[#142338] mt-6 flex items-center justify-between">
                        <a href="{{ route('city.service.landing', ['category' => $category, 'serviceSlug' => $srv->slug, 'citySlug' => $city->slug]) }}" class="text-xs font-space text-[#10B981] hover:underline font-semibold flex items-center gap-1">
                            Info di {{ $city->name }} &rarr;
                        </a>
                        <a href="{{ route('service.detail', ['category' => $category, 'serviceSlug' => $srv->slug]) }}" class="text-xs font-space text-[#94A3B8] hover:text-white">
                            Detail Layanan
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 5. Locations & Google Maps Section -->
<section id="locations" class="py-12 border-b border-[#1E324E] bg-[#080E19]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 space-y-8">
        <div class="border-b border-[#1E324E] pb-4">
            <span class="text-[11px] font-space uppercase tracking-wider text-[#10B981] block mb-1">TITIK OPERASIONAL &amp; SENTRA PRAKTIK</span>
            <h2 class="text-xl lg:text-2xl font-bold font-space text-[#F1F5F9]">
                Lokasi Sentra K3 Kecamatan {{ $kecamatan->name }}
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left: Location Details -->
            <div class="lg:col-span-5 space-y-4">
                <div class="bg-[#0B1526] border border-[#1E324E] p-6 space-y-4">
                    <div class="border-b border-[#1E324E] pb-3">
                        <h3 class="font-space font-bold text-sm text-[#F1F5F9] uppercase">Pos Koordinasi Kecamatan {{ $kecamatan->name }}</h3>
                        <p class="text-xs text-[#94A3B8] mt-1 font-body">
                            {{ $kecamatan->address ?: ($city->address ?: "Sentra K3 Regional {$city->name}") }}
                        </p>
                    </div>

                    @if($locations->count() > 0)
                        <div class="space-y-3 pt-2">
                            <span class="text-[10px] font-space uppercase text-[#64748B] block tracking-wider">FASILITAS SENTRA PRAKTIK RESMI:</span>
                            @foreach($locations as $loc)
                                <div class="bg-[#070D18] border border-[#1E324E] p-3 space-y-1">
                                    <div class="font-space font-bold text-xs text-[#10B981]">{{ $loc->location_name }}</div>
                                    <p class="text-[11px] text-[#94A3B8] font-body">{{ $loc->address }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="pt-2">
                        <a href="https://maps.google.com/?q={{ urlencode($kecamatan->name . ', ' . $city->name) }}" target="_blank" class="btn-whatsapp w-full text-center text-xs block py-2.5">
                            Buka di Google Maps Langsung &nearr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right: Interactive Google Maps Embed -->
            <div class="lg:col-span-7">
                <div class="bg-[#0B1526] border border-[#1E324E] p-2 h-full min-h-[320px]">
                    <iframe
                        src="{{ $kecamatan->mapsEmbedUrl() }}"
                        width="100%"
                        height="100%"
                        style="border:0; min-height: 320px;"
                        allowfullscreen=""

<!-- 5. Related Articles Section -->
<section class="py-12 border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold font-space text-[#F1F5F9]">
                    Artikel Terkait Kecamatan {{ $kecamatan->name }}
                </h2>
                <p class="text-[#94A3B8] font-body text-sm mt-1">
                    Panduan, regulasi, dan informasi terbaru seputar {{ ucfirst($category) }} di wilayah {{ $kecamatan->name }} dan {{ $city->name }}.
                </p>
            </div>
            @if($relatedArticles->count() > 0)
                <a href="{{ route('articles.index', ['city' => $city->slug]) }}" class="btn-secondary text-xs py-2 px-4">
                    Lihat Semua Artikel {{ $city->name }} &rarr;
                </a>
            @endif
        </div>

        @if($relatedArticles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedArticles as $relArticle)
                    <article class="group bg-[#0B1526] border border-[#1E324E] rounded-xl overflow-hidden hover:border-[#10B981] transition-all duration-300 flex flex-col">
                        <div class="aspect-video overflow-hidden relative">
                            <img src="{{ $relArticle->image_url }}" alt="{{ $relArticle->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-3 left-3">
                                <span class="bg-[#10B981] text-white text-[10px] font-bold px-2 py-1 rounded uppercase">
                                    {{ $relArticle->category }}
                                </span>
                            </div>
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold font-space text-[#F1F5F9] leading-snug group-hover:text-[#10B981] transition-colors mb-3">
                                <a href="{{ route('articles.show', $relArticle->slug) }}">{{ $relArticle->title }}</a>
                            </h3>
                            <p class="text-[#94A3B8] font-body text-xs line-clamp-3 mb-4 flex-grow">
                                {{ Str::limit(strip_tags($relArticle->content), 120) }}
                            </p>
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-[#1E324E]">
                                <span class="text-[10px] text-[#64748B] font-mono">
                                    {{ $relArticle->created_at->format('d M Y') }}
                                </span>
                                <a href="{{ route('articles.show', $relArticle->slug) }}" class="text-[#10B981] text-xs font-bold hover:underline">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="bg-[#0B1526] border border-dashed border-[#1E324E] rounded-xl p-12 text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-[#1E324E] text-[#94A3B8] mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <p class="text-[#94A3B8] font-body text-sm">Belum ada artikel khusus untuk wilayah ini. Silakan jelajahi artikel kota {{ $city->name }}.</p>
            </div>
        @endif
    </div>
</section>

                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Google Maps {{ $kecamatan->name }}">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. In-Depth SEO Article Section -->
@if($article)
<section class="py-12 border-b border-[#1E324E]">
    <div class="max-w-4xl mx-auto px-4 lg:px-8 space-y-6">
        <div class="border-b border-[#1E324E] pb-4">
            <span class="text-[10px] font-space uppercase tracking-widest text-[#0D7A5F] block mb-1">REGULASI &amp; WAWASAN TEKNIS LOKAL</span>
            <h2 class="text-2xl lg:text-3xl font-bold font-space text-[#F1F5F9] leading-tight">
                {{ $article->title }}
            </h2>
            <div class="flex items-center gap-4 text-xs font-space text-[#64748B] mt-2">
                <span>Ditinjau oleh Tim Teknis K3</span>
                <span>&bull;</span>
                <span>{{ $article->reading_time ?? 8 }} Menit Baca</span>
            </div>
        </div>

        <div class="prose prose-invert max-w-none text-sm leading-relaxed text-[#94A3B8] font-body space-y-4">
            {!! $article->content !!}
        </div>
    </div>
</section>
@endif

<!-- 7. Dynamic FAQ / Q&A Section with Alpine.js Accordion -->
@if($faqs->count() > 0)
<section class="py-12 border-b border-[#1E324E] bg-[#070D18]" x-data="{ activeAccordion: null }">
    <div class="max-w-4xl mx-auto px-4 lg:px-8 space-y-8">
        <div class="border-b border-[#1E324E] pb-4">
            <span class="text-[11px] font-space uppercase tracking-wider text-[#10B981] block mb-1">TANYA JAWAB TEKNIS (FAQ)</span>
            <h2 class="text-xl lg:text-2xl font-bold font-space text-[#F1F5F9]">
                Pertanyaan Umum Seputar {{ ucfirst($category) }} di {{ $kecamatan->name }}
            </h2>
        </div>

        <div class="space-y-3 font-space text-xs">
            @foreach($faqs as $index => $faq)
                <div class="bg-[#0B1526] border border-[#1E324E]">
                    <button
                        @click="activeAccordion = (activeAccordion === {{ $index }} ? null : {{ $index }})"
                        class="w-full text-left p-4 flex items-center justify-between text-[#F1F5F9] font-bold hover:text-[#10B981] transition">
                        <span>{{ $faq->question }}</span>
                        <span class="text-base text-[#10B981] ml-4 font-mono" x-text="activeAccordion === {{ $index }} ? '−' : '+'">+</span>
                    </button>
                    <div x-show="activeAccordion === {{ $index }}" x-collapse class="p-4 pt-0 text-[#94A3B8] font-body text-xs leading-relaxed border-t border-[#142338]">
                        {{ $faq->answer }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- 8. Conversion CTA -->
<section class="bg-gradient-to-r from-[#0F2038] via-[#0B1526] to-[#070D18] py-16">
    <div class="max-w-4xl mx-auto px-4 lg:px-8 text-center space-y-6">
        <h2 class="text-2xl sm:text-3xl font-bold font-space text-[#F1F5F9]">
            Butuh Pelayanan In-House atau Sertifikasi di Kecamatan {{ $kecamatan->name }}?
        </h2>
        <p class="text-sm text-[#94A3B8] max-w-xl mx-auto font-body">
            Tim instruktur dan konsultan keselamatan kerja TrainingKota siap memberikan solusi pembinaan dan inspeksi terakreditasi langsung di tempat kerja Anda.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
            <a href="https://wa.me/6281234567890?text={{ urlencode("Halo Admin TrainingKota, saya ingin konsultasi program di Kecamatan {$kecamatan->name}, {$city->name}") }}" target="_blank" class="btn-whatsapp">
                Hubungi Konsultan Wilayah (WhatsApp)
            </a>
            <a href="{{ route('city.landing', ['category' => $category, 'citySlug' => $city->slug]) }}" class="btn-secondary">
                Kembali ke Hub {{ $city->name }}
            </a>
        </div>
    </div>
</section>

<!-- JSON-LD Structured Data Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Beranda",
          "item": "{{ route('home') }}"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "{{ ucfirst($category) }}",
          "item": "{{ route('category.show', $category) }}"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "{{ $city->name }}",
          "item": "{{ route('city.landing', ['category' => $category, 'citySlug' => $city->slug]) }}"
        },
        {
          "@type": "ListItem",
          "position": 4,
          "name": "Kecamatan {{ $kecamatan->name }}",
          "item": "{{ url("/{$category}/kecamatan-{$kecamatan->slug}") }}"
        }
      ]
    }
    @if($faqs->count() > 0)
    ,{
      "@type": "FAQPage",
      "mainEntity": [
        @foreach($faqs as $i => $faq)
        {
          "@type": "Question",
          "name": "{{ addslashes($faq->question) }}",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "{{ addslashes(strip_tags($faq->answer)) }}"
          }
        }{{ $i < $faqs->count() - 1 ? ',' : '' }}
        @endforeach
      ]
    }
    @endif
  ]
}
</script>
@endsection
