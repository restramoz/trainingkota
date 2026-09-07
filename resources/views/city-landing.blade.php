@extends('layouts.app')

@push('meta_seo')
<meta name="description" content="{{ $article ? $article->meta_description : 'Layanan ' . $categoryName . ' resmi Kemnaker RI di ' . $city->name . '. Cek jadwal batch, silabus, dan booking kursi.' }}">
<meta property="og:title" content="{{ $article ? $article->seo_title : $categoryName . ' di ' . $city->name . ' | TrainingKota' }}">
<meta property="og:description" content="{{ $article ? $article->meta_description : 'Layanan ' . $categoryName . ' resmi di ' . $city->name }}">
<meta property="og:type" content="website">
<link rel="canonical" href="{{ url()->current() }}">
@endpush

@push('schema')
{{-- ── 1. LocalBusiness / EducationalOrganization Schema ─────────────── --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "EducationalOrganization",
  "name": "TrainingKota — {{ $categoryName }} di {{ $city->name }}",
  "url": "{{ url()->current() }}",
  "description": "Layanan {{ $categoryName }} resmi bersertifikat Kemnaker RI di {{ $city->name }}, {{ $city->province ?? $city->island }}.",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "{{ $city->name }}",
    "addressRegion": "{{ $city->province ?? $city->island }}",
    "addressCountry": "ID",
    "streetAddress": "{{ $city->address ?? $city->name . ', Indonesia' }}"
  },
  @if($city->hasGeo())
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": {{ $city->lat }},
    "longitude": {{ $city->lng }}
  },
  @endif
  "telephone": "+6281234567890",
  "openingHours": "Mo-Sa 08:00-17:00",
  "sameAs": ["https://trainingkota.my.id"]
}
</script>

@if($article)
{{-- ── 2. Article Schema ───────────────────────────────────────────────── --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "{{ $article->title }}",
  "description": "{{ $article->meta_description ?? $article->excerpt }}",
  "datePublished": "{{ $article->created_at->toIso8601String() }}",
  "dateModified": "{{ $article->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Organization",
    "name": "TrainingKota"
  },
  "publisher": {
    "@type": "Organization",
    "name": "TrainingKota",
    "url": "https://trainingkota.my.id"
  },
  "keywords": "{{ $article->focus_keywords }}",
  "articleBody": "{{ strip_tags(substr($article->content, 0, 500)) }}..."
}
</script>
@endif

@if(count($faqItems) > 0)
{{-- ── 3. FAQPage Schema ───────────────────────────────────────────────── --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    @foreach($faqItems as $i => $faq)
    {
      "@type": "Question",
      "name": "{{ addslashes($faq['q']) }}",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "{{ addslashes($faq['a']) }}"
      }
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
</script>
@endif
@endpush

@section('title', ($article ? $article->seo_title : $categoryName . ' di ' . $city->name))

@section('content')
<!-- Regional City Header -->
<section class="bg-gradient-to-b from-[#0F2038] to-[#070D18] border-b border-[#1E324E] py-14 lg:py-18">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center space-x-2 text-xs font-space uppercase text-[#94A3B8] mb-4">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <a href="{{ route('category.show', $category) }}" class="hover:text-white uppercase">{{ $category }}</a>
            <span>/</span>
            <span class="text-[#10B981] font-semibold">{{ $city->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-8 space-y-5">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="badge-kemnaker">WILAYAH OPERASIONAL RESMI</span>
                    <span class="badge-bnsp">PULAU: {{ strtoupper($city->island) }}</span>
                    @if($city->is_hub)
                        <span class="badge-warning">★ HUB K3 UTAMA</span>
                    @endif
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-space text-[#F1F5F9] leading-tight">
                    {{ $categoryName }} di {{ $city->name }}
                </h1>

                <p class="text-base sm:text-lg text-[#94A3B8] leading-relaxed max-w-3xl">
                    Layanan resmi sertifikasi K3, audit SMK3 PP 50/2012, serta kajian teknis SLF dan riksa uji keteknikan untuk fasilitas industri, manufaktur, dan kontraktor di area <strong class="text-[#F1F5F9]">{{ $city->name }}</strong> dan sekitarnya.
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin TrainingKota, saya ingin konsultasi layanan ' . $categoryName . ' untuk area ' . $city->name) }}" target="_blank" class="btn-whatsapp">
                        Hubungi Koordinator Area {{ $city->name }}
                    </a>
                    <a href="#jadwal-kota" class="btn-secondary">
                        Cek Jadwal Batch di {{ $city->name }}
                    </a>
                </div>
            </div>

            <!-- Regional Dispatch Meta Card -->
            <div class="lg:col-span-4">
                <div class="bg-[#0F2038] border border-[#1E324E] p-6 space-y-4">
                    <div class="border-b border-[#1E324E] pb-3 flex items-center justify-between">
                        <span class="font-space font-bold text-xs uppercase text-[#F1F5F9]">STATUS REGIONAL KOTA</span>
                        <span class="w-2 h-2 bg-[#10B981] inline-block animate-ping"></span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between border-b border-[#142338] pb-2">
                            <span class="text-[#94A3B8]">Kota / Kabupaten:</span>
                            <span class="font-space font-bold text-[#F1F5F9]">{{ $city->name }}</span>
                        </div>
                        <div class="flex justify-between border-b border-[#142338] pb-2">
                            <span class="text-[#94A3B8]">Wilayah / Pulau:</span>
                            <span class="font-space text-[#F1F5F9]">{{ $city->island }}</span>
                        </div>
                        @if($city->address)
                        <div class="flex justify-between border-b border-[#142338] pb-2">
                            <span class="text-[#94A3B8]">Area Operasional:</span>
                            <span class="font-space text-[#c5c6ce] text-right max-w-[55%]">{{ $city->address }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between border-b border-[#142338] pb-2">
                            <span class="text-[#94A3B8]">Metode Pelaksanaan:</span>
                            <span class="font-space text-[#10B981]">Tatap Muka &amp; In-House</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[#94A3B8]">Kapasitas Batch:</span>
                            <span class="font-space text-[#F1F5F9]">25 Peserta / Kelas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══ GOOGLE MAPS SECTION ════════════════════════════════════════════════ -->
<section class="border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-10">
        <div class="mb-5 flex items-center justify-between">
            <div>
                <span class="label-caps text-[#0D7A5F] block mb-1">PETA AREA OPERASIONAL</span>
                <h2 class="text-lg font-bold font-space text-[#F1F5F9]">
                    Jangkauan Layanan di {{ $city->name }} &amp; Sekitarnya
                </h2>
            </div>
            @if($city->address)
            <div class="hidden md:flex items-center gap-2 text-xs font-space text-[#94A3B8] bg-[#0F2038] border border-[#1E324E] px-3 py-2">
                <span class="w-1.5 h-1.5 bg-[#0D7A5F] inline-block"></span>
                {{ $city->address }}
            </div>
            @endif
        </div>

        <div class="border border-[#1E324E] overflow-hidden" style="height: 380px;">
            <iframe
                src="{{ $city->mapsEmbedUrl() }}"
                width="100%"
                height="380"
                style="border:0; filter: invert(90%) hue-rotate(180deg) saturate(0.8) brightness(0.9);"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Peta Area Operasional TrainingKota di {{ $city->name }}"
            ></iframe>
        </div>
        <p class="text-[11px] text-[#64748B] font-space mt-2">
            ▲ Area operasional {{ $city->name }} dan sekitarnya. Tim instruktur kami siap mobilisasi ke fasilitas industri Anda.
        </p>
    </div>
</section>

<!-- Jadwal Batch Khusus Kota Ini -->
<section id="jadwal-kota" class="py-14 border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="mb-8">
            <span class="label-caps text-[#0D7A5F] block mb-2">JADWAL KHUSUS REGIONAL</span>
            <h2 class="text-2xl font-bold font-space text-[#F1F5F9]">
                Jadwal Batch {{ $categoryName }} di {{ $city->name }}
            </h2>
            <p class="text-xs text-[#94A3B8] mt-1">Kuota diperbarui secara langsung oleh tim registrasi cabang.</p>
        </div>

        <div class="overflow-x-auto border border-[#1E324E]">
            <table class="w-full text-left text-xs font-body border-collapse">
                <thead>
                    <tr class="bg-[#0F2038] text-[#94A3B8] font-space text-[11px] uppercase tracking-wider border-b border-[#1E324E]">
                        <th class="py-3 px-4 font-semibold">Kode Batch</th>
                        <th class="py-3 px-4 font-semibold">Nama Program Layanan</th>
                        <th class="py-3 px-4 font-semibold">Lokasi Pelaksanaan</th>
                        <th class="py-3 px-4 font-semibold">Tanggal</th>
                        <th class="py-3 px-4 font-semibold">Status Kuota</th>
                        <th class="py-3 px-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#142338]">
                    <tr class="bg-[#070D18]">
                        <td class="py-3.5 px-4 font-space font-bold text-[#F1F5F9]">BAT-{{ strtoupper(substr($city->slug, 0, 3)) }}-01</td>
                        <td class="py-3.5 px-4 font-medium text-[#F1F5F9]">Ahli K3 Umum Kemnaker RI</td>
                        <td class="py-3.5 px-4 text-[#94A3B8]">Hotel Partner di {{ $city->name }}</td>
                        <td class="py-3.5 px-4 text-[#c5c6ce]">Batch Terdekat Bulan Ini</td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1.5 text-[#10B981] font-space font-semibold uppercase text-[11px]">
                                <span class="w-1.5 h-1.5 bg-[#10B981] inline-block"></span>
                                Tersedia 5 Kursi
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin TrainingKota, saya booking kursi Ahli K3 Umum untuk batch di ' . $city->name) }}" target="_blank" class="btn-primary text-[11px] py-1.5 px-3">
                                Booking Slot
                            </a>
                        </td>
                    </tr>
                    <tr class="bg-[#0B1526]">
                        <td class="py-3.5 px-4 font-space font-bold text-[#F1F5F9]">BAT-{{ strtoupper(substr($city->slug, 0, 3)) }}-02</td>
                        <td class="py-3.5 px-4 font-medium text-[#F1F5F9]">Auditor SMK3 PP 50/2012 &amp; Riksa Uji</td>
                        <td class="py-3.5 px-4 text-[#94A3B8]">Pusat Pelatihan {{ $city->name }}</td>
                        <td class="py-3.5 px-4 text-[#c5c6ce]">Minggu Ke-3 Bulan Depan</td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1.5 text-[#F59E0B] font-space font-semibold uppercase text-[11px]">
                                <span class="w-1.5 h-1.5 bg-[#F59E0B] inline-block"></span>
                                Tersisa 3 Kursi
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin TrainingKota, saya booking kursi SMK3 untuk batch di ' . $city->name) }}" target="_blank" class="btn-primary text-[11px] py-1.5 px-3">
                                Booking Slot
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Available Services in this Category for this City -->
<section class="py-14 bg-[#0B1526]/40 border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="mb-8">
            <span class="label-caps text-[#0D7A5F] block mb-2">PILIHAN PROGRAM LENGKAP</span>
            <h2 class="text-2xl font-bold font-space text-[#F1F5F9]">
                Katalog Program {{ $categoryName }} di {{ $city->name }}
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($featuredServices as $serv)
                <div class="bg-[#0B1526] border border-[#1E324E] p-5 flex flex-col justify-between hover:border-[#0D7A5F] transition-colors">
                    <div>
                        <span class="badge-kemnaker text-[10px] mb-2">{{ $serv->badge }}</span>
                        <h3 class="font-space font-bold text-sm text-[#F1F5F9] mb-1">
                            <a href="{{ route('service.detail', ['category' => $category, 'serviceSlug' => $serv->slug]) }}" class="hover:text-[#10B981]">
                                {{ $serv->name }}
                            </a>
                        </h3>
                        <p class="text-[11px] text-[#94A3B8] line-clamp-2">{{ $serv->description }}</p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-[#142338] flex items-center justify-between text-xs">
                        <span class="font-space text-[11px] text-[#10B981]">{{ $serv->duration }}</span>
                        <a href="{{ route('service.detail', ['category' => $category, 'serviceSlug' => $serv->slug]) }}" class="text-[#38BDF8] hover:underline font-space text-[11px]">
                            Detail &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ══ ARTIKEL SEO 1500+ KATA ════════════════════════════════════════════ -->
@if($article)
<section id="artikel-seo" class="py-16 border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <!-- Main Article Content -->
            <div class="lg:col-span-8">
                <!-- Article Header -->
                <div class="mb-8">
                    <span class="label-caps text-[#0D7A5F] block mb-3">PANDUAN &amp; REGULASI TERKAIT {{ strtoupper($city->name) }}</span>
                    <h2 class="text-2xl lg:text-3xl font-bold font-space text-[#F1F5F9] leading-snug mb-4">
                        {{ $article->title }}
                    </h2>
                    <div class="flex flex-wrap items-center gap-4 text-xs text-[#64748B] font-space uppercase">
                        <span class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 bg-[#0D7A5F] inline-block"></span>
                            {{ $article->reading_time }} Menit Membaca
                        </span>
                        @if($article->focus_keywords)
                        <span class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 bg-[#38BDF8] inline-block"></span>
                            {{ $article->focus_keywords }}
                        </span>
                        @endif
                        <span class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 bg-[#D97706] inline-block"></span>
                            {{ $article->updated_at->format('d M Y') }}
                        </span>
                    </div>
                </div>

                <!-- Table of Contents (Alpine.js) -->
                <div
                    x-data="articleTOC()"
                    x-init="buildTOC()"
                    class="mb-8 bg-[#0F2038] border border-[#1E324E] border-l-2 border-l-[#0D7A5F] p-5"
                >
                    <button
                        @click="open = !open"
                        class="w-full flex items-center justify-between text-left"
                    >
                        <span class="font-space font-bold text-xs uppercase tracking-wider text-[#F1F5F9] flex items-center gap-2">
                            <span class="w-2 h-2 bg-[#0D7A5F] inline-block"></span>
                            DAFTAR ISI ARTIKEL
                        </span>
                        <span class="text-[#0D7A5F] font-space text-xs" x-text="open ? '[ TUTUP ]' : '[ BUKA ]'"></span>
                    </button>

                    <nav x-show="open" x-transition class="mt-4 space-y-1" id="toc-nav">
                        <!-- TOC items akan di-inject oleh Alpine.js -->
                        <p class="text-xs text-[#64748B] font-space italic">Memuat daftar isi...</p>
                    </nav>
                </div>

                <!-- Article Body -->
                <div id="article-body" class="article-prose bg-[#0B1526] border border-[#1E324E] p-6 lg:p-8">
                    {!! $article->content !!}
                </div>

                <!-- Article CTA -->
                <div class="mt-8 bg-[#0F2038] border border-[#1E324E] border-l-4 border-l-[#0D7A5F] p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <div class="font-space font-bold text-sm text-[#F1F5F9] mb-1">
                            Butuh konsultasi untuk implementasi di {{ $city->name }}?
                        </div>
                        <p class="text-xs text-[#94A3B8]">Tim teknis kami siap membantu. Respon dalam &lt; 5 menit pada jam kerja.</p>
                    </div>
                    <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin TrainingKota, saya baru membaca artikel: ' . $article->title . '. Saya butuh konsultasi untuk implementasi di ' . $city->name) }}" target="_blank" class="btn-whatsapp text-xs shrink-0">
                        Konsultasi Gratis via WA &rarr;
                    </a>
                </div>
            </div>

            <!-- Article Sidebar -->
            <aside class="lg:col-span-4 space-y-6">
                <!-- Quick Booking Card -->
                <div class="bg-[#0F2038] border border-[#1E324E] p-5 sticky top-24">
                    <div class="font-space font-bold text-xs uppercase tracking-wider text-[#F1F5F9] mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 bg-[#10B981] inline-block animate-pulse"></span>
                        BOOKING CEPAT — {{ strtoupper($city->name) }}
                    </div>
                    <p class="text-xs text-[#94A3B8] mb-4">Daftarkan tim Anda ke program {{ $categoryName }} terbaik di {{ $city->name }}.</p>
                    <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin TrainingKota, saya ingin booking program ' . $categoryName . ' di ' . $city->name . ' setelah membaca artikel.') }}" target="_blank" class="btn-primary w-full text-xs py-3 text-center block mb-3">
                        Booking Slot Program &rarr;
                    </a>
                    <a href="#jadwal-kota" class="btn-secondary w-full text-xs py-2.5 text-center block">
                        Lihat Jadwal Batch
                    </a>
                </div>

                <!-- Related Articles -->
                @if(count($relatedArticles) > 0)
                <div class="bg-[#0B1526] border border-[#1E324E] p-5">
                    <div class="font-space font-bold text-xs uppercase tracking-wider text-[#F1F5F9] mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 bg-[#38BDF8] inline-block"></span>
                        ARTIKEL TERKAIT
                    </div>
                    <div class="space-y-3">
                        @foreach($relatedArticles as $rel)
                        <a href="{{ route('article.show', $rel->slug) }}" class="block p-3 bg-[#070D18] border border-[#142338] hover:border-[#0D7A5F] transition-colors group">
                            <div class="font-space font-bold text-xs text-[#F1F5F9] group-hover:text-[#10B981] leading-snug mb-1">{{ $rel->title }}</div>
                            <div class="flex items-center gap-2 text-[11px] text-[#64748B] font-space">
                                <span>{{ $rel->reading_time }} menit</span>
                                <span>•</span>
                                <span class="uppercase">{{ $rel->category }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </aside>
        </div>
    </div>
</section>
@endif

<!-- ══ FAQ ACCORDION (Alpine.js) ═════════════════════════════════════════ -->
@if(count($faqItems) > 0)
<section id="faq-kota" class="py-16 bg-[#0B1526]/30 border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- FAQ Header -->
            <div class="lg:col-span-4">
                <span class="label-caps text-[#0D7A5F] block mb-3">TANYA JAWAB REGULASI</span>
                <h2 class="text-2xl font-bold font-space text-[#F1F5F9] leading-tight mb-4">
                    FAQ: {{ $categoryName }}<br>di {{ $city->name }}
                </h2>
                <p class="text-sm text-[#94A3B8] leading-relaxed mb-6">
                    Pertanyaan yang paling sering ditanyakan oleh pelaku industri dan HSE officer terkait layanan {{ $categoryName }} di wilayah {{ $city->name }}.
                </p>
                <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin TrainingKota, saya punya pertanyaan tentang ' . $categoryName . ' di ' . $city->name) }}" target="_blank" class="btn-whatsapp text-xs">
                    Pertanyaan Lainnya via WA
                </a>
            </div>

            <!-- FAQ Accordion Items -->
            <div class="lg:col-span-8">
                <div class="space-y-2" x-data="{ openIndex: null }">
                    @foreach($faqItems as $idx => $faq)
                    <div
                        class="border border-[#1E324E] overflow-hidden transition-colors"
                        :class="openIndex === {{ $idx }} ? 'border-[#0D7A5F]' : 'hover:border-[#44474d]'"
                    >
                        <button
                            @click="openIndex = openIndex === {{ $idx }} ? null : {{ $idx }}"
                            class="w-full flex items-start justify-between text-left px-5 py-4 bg-[#0B1526] gap-4"
                            :class="openIndex === {{ $idx }} ? 'bg-[#0F2038]' : ''"
                        >
                            <div class="flex items-start gap-3">
                                <span class="font-space font-bold text-xs text-[#0D7A5F] shrink-0 pt-0.5">{{ sprintf('%02d', $idx + 1) }}</span>
                                <span class="font-space font-semibold text-sm text-[#F1F5F9] leading-snug">{{ $faq['q'] }}</span>
                            </div>
                            <div class="shrink-0 mt-0.5">
                                <svg
                                    class="w-4 h-4 text-[#0D7A5F] transition-transform duration-200"
                                    :class="openIndex === {{ $idx }} ? 'rotate-180' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>

                        <div
                            x-show="openIndex === {{ $idx }}"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E]"
                        >
                            <p class="text-sm text-[#c5c6ce] leading-relaxed font-body">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Other Cities in the Same Island/Region -->
@if(count($otherCitiesInIsland) > 0)
<section class="py-12 bg-[#0F2038]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <h3 class="font-space font-bold text-sm uppercase text-[#F1F5F9] mb-4">
            Kota Lainnya di Wilayah {{ $city->island }}
        </h3>
        <div class="flex flex-wrap gap-2">
            @foreach($otherCitiesInIsland as $other)
                <a href="{{ route('city.landing', ['category' => $category, 'citySlug' => $other->slug]) }}" class="px-3 py-1.5 bg-[#070D18] border border-[#1E324E] hover:border-[#0D7A5F] text-[#c5c6ce] hover:text-white text-xs font-space">
                    {{ $other->name }} &rarr;
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ══ ARTICLE TOC JAVASCRIPT ════════════════════════════════════════════ -->
<script>
function articleTOC() {
    return {
        open: true,
        items: [],
        buildTOC() {
            const body = document.getElementById('article-body');
            const nav  = document.getElementById('toc-nav');
            if (!body || !nav) return;

            const headings = body.querySelectorAll('h2, h3');
            if (headings.length === 0) {
                nav.innerHTML = '<p class="text-xs text-[#64748B] font-space italic">Daftar isi tidak tersedia.</p>';
                return;
            }

            let html = '';
            headings.forEach((h, i) => {
                // Buat ID jika belum ada
                if (!h.id) {
                    h.id = 'heading-' + i;
                }
                const isH3 = h.tagName === 'H3';
                html += `<a
                    href="#${h.id}"
                    class="flex items-start gap-2 text-xs font-space py-1 ${isH3 ? 'pl-4 text-[#64748B] hover:text-[#94A3B8]' : 'text-[#94A3B8] hover:text-[#10B981]'} transition-colors"
                    onclick="event.preventDefault(); document.getElementById('${h.id}').scrollIntoView({behavior:'smooth', block:'start'})"
                >
                    <span class="shrink-0 mt-0.5 ${isH3 ? 'text-[#44474d]' : 'text-[#0D7A5F]'}">${isH3 ? '↳' : '▪'}</span>
                    <span>${h.textContent}</span>
                </a>`;
            });

            nav.innerHTML = html;
        }
    };
}
</script>

<!-- ══ ARTICLE PROSE CSS INLINE ══════════════════════════════════════════ -->
<style>
.article-prose { color: #c5c6ce; font-family: 'IBM Plex Sans', sans-serif; font-size: 15px; line-height: 1.8; }
.article-prose h2 { font-family: 'Space Grotesk', sans-serif; font-size: 1.2rem; font-weight: 700; color: #F1F5F9; margin: 2rem 0 0.75rem; padding-bottom: 0.5rem; border-bottom: 1px solid #1E324E; }
.article-prose h3 { font-family: 'Space Grotesk', sans-serif; font-size: 1rem; font-weight: 600; color: #dde2f3; margin: 1.5rem 0 0.5rem; }
.article-prose p { margin-bottom: 1rem; }
.article-prose ul, .article-prose ol { margin: 0.75rem 0 1rem 1.25rem; }
.article-prose li { margin-bottom: 0.4rem; }
.article-prose strong { color: #F1F5F9; font-weight: 600; }
.article-prose table { width: 100%; border-collapse: collapse; margin: 1.25rem 0; font-size: 0.8rem; font-family: 'IBM Plex Sans', sans-serif; }
.article-prose table th { background: #0F2038; color: #94A3B8; font-family: 'Space Grotesk', sans-serif; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; padding: 0.6rem 0.75rem; text-align: left; border: 1px solid #1E324E; }
.article-prose table td { padding: 0.6rem 0.75rem; border: 1px solid #142338; color: #c5c6ce; vertical-align: top; }
.article-prose table tr:nth-child(even) td { background: #0B1526; }
.article-prose table tr:nth-child(odd) td { background: #070D18; }
.article-prose .callout-box { background: #0F2038; border: 1px solid #1E324E; border-left: 3px solid #D97706; padding: 0.875rem 1rem; margin: 1.25rem 0; font-size: 0.8rem; color: #F59E0B; }
.article-prose a { color: #38BDF8; text-decoration: underline; }
.article-prose a:hover { color: #10B981; }
</style>
@endsection
