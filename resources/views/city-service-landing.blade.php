@extends('layouts.app')

@php
    $pageTitle = $override?->seo_title ?? ($service->name . ' di ' . $city->name . ' - Sertifikasi Resmi Kemnaker RI | TrainingKota');
    $pageDesc = $override?->meta_description ?? ('Pendaftaran resmi ' . $service->name . ' di ' . $city->name . '. Jadwal batch terdekat, silabus lengkap, biaya resmi, dan pelaksanaan bersertifikat Kemnaker RI / BNSP.');
    $heading = $override?->custom_heading ?? ($service->name . ' di ' . $city->name);
@endphp

@push('meta_seo')
<meta name="description" content="{{ $pageDesc }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDesc }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<link rel="canonical" href="{{ url()->current() }}">
@endpush

@push('schema')
{{-- ── 1. BreadcrumbList Schema ────────────────────────────────────────── --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
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
      "name": "{{ $service->name }}",
      "item": "{{ route('service.detail', ['category' => $category, 'serviceSlug' => $service->slug]) }}"
    },
    {
      "@type": "ListItem",
      "position": 4,
      "name": "{{ $city->name }}",
      "item": "{{ url()->current() }}"
    }
  ]
}
</script>

{{-- ── 2. LocalBusiness / EducationalOrganization Schema ─────────────── --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "EducationalOrganization",
  "name": "TrainingKota {{ $service->name }} — Sentra {{ $city->name }}",
  "url": "{{ url()->current() }}",
  "description": "{{ $pageDesc }}",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "{{ $city->name }}",
    "addressRegion": "{{ $city->province ?? $city->island }}",
    "addressCountry": "ID",
    "streetAddress": "{{ $city->address ?? ($city->sentra_praktik ?? $city->name . ', Indonesia') }}"
  },
  @if($city->hasGeo())
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": {{ $city->lat }},
    "longitude": {{ $city->lng }}
  },
  @endif
  "telephone": "+{{ config('contact.whatsapp') }}",
  "openingHours": "Mo-Sa 08:00-17:00"
}
</script>

{{-- ── 3. FAQPage Schema ───────────────────────────────────────────────── --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Kapan jadwal batch terdekat {{ $service->name }} di {{ $city->name }}?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Jadwal batch {{ $service->name }} di wilayah {{ $city->name }} diselenggarakan setiap bulan. Hubungi hotline tim pendaftaran kami untuk konfirmasi tanggal pasti dan ketersediaan kuota kelas."
      }
    },
    {
      "@type": "Question",
      "name": "Apakah sertifikat {{ $service->name }} yang diselenggarakan di {{ $city->name }} resmi Kemnaker RI?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Benar. Seluruh peserta yang lulus evaluasi akan mendapatkan sertifikat, lisensi K3, dan SKP resmi yang diterbitkan oleh Kementerian Ketenagakerjaan RI atau BNSP yang berlaku sah secara nasional."
      }
    }
  ]
}
</script>
@endpush

@section('title', $pageTitle)

@section('content')
<!-- Breadcrumbs -->
<div class="bg-[#0B1526] border-b border-[#1E324E] py-3 text-xs font-space text-[#94A3B8]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 flex items-center space-x-2">
        <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
        <span>/</span>
        <a href="{{ route('category.show', $category) }}" class="hover:text-white uppercase">{{ $category }}</a>
        <span>/</span>
        <a href="{{ route('service.detail', ['category' => $category, 'serviceSlug' => $service->slug]) }}" class="hover:text-white">{{ $service->name }}</a>
        <span>/</span>
        <span class="text-[#10B981] font-semibold truncate">{{ $city->name }}</span>
    </div>
</div>

<!-- Hyper-specific Hero Section -->
<section class="bg-gradient-to-b from-[#0F2038] to-[#070D18] border-b border-[#1E324E] py-14 lg:py-18">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <div class="lg:col-span-8 space-y-6">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="badge-kemnaker">{{ $service->badge }}</span>
                    <span class="badge-bnsp">LOKASI: {{ strtoupper($city->name) }}</span>
                    @if($city->is_hub)
                        <span class="badge-warning">★ HUB SENTRA K3</span>
                    @endif
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-space text-[#F1F5F9] leading-tight">
                    {{ $heading }}
                </h1>

                <p class="text-base sm:text-lg text-[#94A3B8] leading-relaxed max-w-3xl">
                    {{ $pageDesc }}
                </p>

                <!-- Custom override content if defined by CMS admin -->
                @if($override?->custom_content)
                    <div class="bg-[#0B1526] border border-[#1E324E] border-l-4 border-l-[#10B981] p-5 text-xs text-[#c5c6ce] leading-relaxed">
                        {!! nl2br(e($override->custom_content)) !!}
                    </div>
                @endif

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="https://wa.me/{{ config('contact.whatsapp') }}?text={{ urlencode('Halo Admin TrainingKota, saya ingin booking kursi untuk ' . $service->name . ' di ' . $city->name) }}" target="_blank" class="btn-primary">
                        Booking Slot di {{ $city->name }} &rarr;
                    </a>
                    <a href="https://wa.me/{{ config('contact.whatsapp') }}?text={{ urlencode('Halo Admin TrainingKota, mohon kirimkan proposal silabus & jadwal ' . $service->name . ' di ' . $city->name) }}" target="_blank" class="btn-whatsapp">
                        Minta Silabus &amp; Penawaran
                    </a>
                </div>
            </div>

            <!-- Regional Logistics & Sentra Box -->
            <div class="lg:col-span-4">
                <div class="bg-[#0F2038] border border-[#1E324E] p-6 space-y-4">
                    <div class="border-b border-[#1E324E] pb-3 flex items-center justify-between">
                        <span class="font-space font-bold text-xs uppercase text-[#F1F5F9]">SENTRA PRAKTIK &amp; RIKSAP</span>
                        <span class="w-2 h-2 bg-[#10B981] inline-block animate-ping"></span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between border-b border-[#142338] pb-2">
                            <span class="text-[#94A3B8]">Sentra Layanan:</span>
                            <span class="font-space font-bold text-[#F1F5F9] text-right">{{ $city->sentra_praktik ?? 'Sentra Pembinaan K3 ' . $city->name }}</span>
                        </div>
                        <div class="flex justify-between border-b border-[#142338] pb-2">
                            <span class="text-[#94A3B8]">Alamat Kawasan:</span>
                            <span class="font-space text-[#c5c6ce] text-right max-w-[55%]">{{ $city->address ?? 'Kawasan Industri & Bisnis ' . $city->name }}</span>
                        </div>
                        <div class="flex justify-between border-b border-[#142338] pb-2">
                            <span class="text-[#94A3B8]">Durasi Program:</span>
                            <span class="font-space text-[#10B981]">{{ $service->duration }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[#94A3B8]">Biaya Resmi:</span>
                            <span class="font-space font-bold text-[#F1F5F9]">{{ $service->price_estimate }}</span>
                        </div>
                    </div>

                    @if($city->hasGeo() || $city->maps_embed_url)
                        <div class="mt-4 pt-4 border-t border-[#1E324E]">
                            <span class="text-[11px] font-space uppercase text-[#94A3B8] block mb-2">Peta Lokasi Praktik</span>
                            <div class="w-full h-36 bg-[#070D18] border border-[#1E324E] overflow-hidden">
                                <iframe src="{{ $city->mapsEmbedUrl() }}" class="w-full h-full border-0" loading="lazy"></iframe>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Syllabus & Key Curriculum -->
<section class="py-14 border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <div class="lg:col-span-8 space-y-6">
                <h2 class="text-xl lg:text-2xl font-bold font-space text-[#F1F5F9] flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#0D7A5F] inline-block"></span>
                    Materi Silabus &amp; Praktik Lapangan di {{ $city->name }}
                </h2>

                @if(!empty($service->syllabus) && is_array($service->syllabus))
                    <x-syllabus-table
                        :syllabus="$service->syllabus"
                        description="Pemahaman regulasi, studi kasus implementasi, dan pengujian lapangan langsung."
                    />
                @endif
            </div>

            <!-- Other Cities for Same Service -->
            <div class="lg:col-span-4">
                <div class="bg-[#0F2038] border border-[#1E324E] p-6 space-y-4">
                    <h3 class="font-space font-bold text-xs uppercase text-[#F1F5F9] tracking-wider">
                        {{ $service->name }} di Kota Lain (Wilayah {{ $city->island }})
                    </h3>
                    <div class="flex flex-wrap gap-2 pt-2">
                        @foreach($otherCities as $oc)
                            <a href="{{ route('city.service.landing', ['category' => $category, 'serviceSlug' => $service->slug, 'citySlug' => $oc->slug]) }}" class="px-2.5 py-1 bg-[#070D18] border border-[#1E324E] hover:border-[#0D7A5F] text-[#c5c6ce] hover:text-[#10B981] text-xs font-space">
                                {{ $oc->name }} &rarr;
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ & Regional Q&A -->
<section class="py-14 bg-[#0B1526] border-b border-[#1E324E]">
   <div class="max-w-7xl mx-auto px-4 lg:px-8">
       <div class="text-center max-w-3xl mx-auto mb-12">
           <h2 class="text-2xl lg:text-3xl font-bold font-space text-[#F1F5F9] mb-4">
               Pertanyaan Umum (FAQ) <span class="text-[#10B981]">&</span> Q&A
           </h2>
           <p class="text-[#94A3B8] text-sm leading-relaxed">
               Jawaban atas pertanyaan yang paling sering diajukan terkait pelaksanaan {{ $service->name }} di wilayah {{ $city->name }}.
           </p>
       </div>

       <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
           @forelse($faqs as $faq)
               <div class="bg-[#0F2038] border border-[#1E324E] p-5 rounded-sm">
                   <h3 class="text-sm font-bold text-[#F1F5F9] mb-3 flex gap-3">
                       <span class="text-[#10B981] font-space">Q:</span>
                       {{ $faq->question }}
                   </h3>
                   <p class="text-xs text-[#94A3B8] leading-relaxed pl-6">
                       <span class="text-[#10B981] font-space font-bold">A:</span>
                       {{ $faq->answer }}
                   </p>
               </div>
           @empty
               <div class="col-span-full text-center py-10 text-[#94A3B8] text-sm italic">
                   Belum ada FAQ spesifik untuk wilayah ini. Hubungi admin untuk informasi lebih lanjut.
               </div>
           @endforelse
       </div>
   </div>
</section>

<!-- Supporting Articles Section -->
<section class="py-14">
   <div class="max-w-7xl mx-auto px-4 lg:px-8">
       <div class="flex items-center justify-between mb-10">
           <div>
               <h2 class="text-xl lg:text-2xl font-bold font-space text-[#F1F5F9]">
                   Artikel Pendukung
               </h2>
               <p class="text-sm text-[#94A3B8]">Wawasan tambahan terkait {{ $service->name }} di {{ $city->name }}</p>
           </div>
       </div>

       <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
           @forelse($relatedArticles as $relArt)
               <a href="{{ route('article.show', $relArt->slug) }}" class="group block bg-[#0F2038] border border-[#1E324E] overflow-hidden hover:border-[#10B981] transition-all">
                   <div class="p-5 space-y-3">
                       <div class="flex items-center gap-2">
                           <span class="text-[10px] px-2 py-0.5 bg-[#1E324E] text-[#10B981] font-bold uppercase tracking-wider rounded-sm">
                               {{ $relArt->category }}
                           </span>
                       </div>
                       <h3 class="text-sm font-bold text-[#F1F5F9] group-hover:text-[#10B981] transition-colors">
                           {{ $relArt->title }}
                       </h3>
                       <p class="text-xs text-[#94A3B8] line-clamp-2 leading-relaxed">
                           {{ $relArt->excerpt }}
                       </p>
                       <div class="pt-2 flex items-center text-[11px] font-bold text-[#10B981] uppercase">
                           Baca Selengkapnya &rarr;
                       </div>
                   </div>
               </a>
           @empty
               <div class="col-span-full text-center py-10 text-[#94A3B8] text-sm italic">
                   Tidak ada artikel pendukung untuk saat ini.
               </div>
           @endforelse
       </div>
   </div>
</section>
@endsection

