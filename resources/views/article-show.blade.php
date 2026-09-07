@extends('layouts.app')

@push('meta_seo')
<meta name="description" content="{{ $article->meta_description ?? $article->excerpt }}">
<meta name="keywords" content="{{ $article->focus_keywords }}">
<meta property="og:title" content="{{ $article->seo_title ?? $article->title }}">
<meta property="og:description" content="{{ $article->meta_description ?? $article->excerpt }}">
<meta property="og:type" content="article">
<meta property="article:published_time" content="{{ $article->created_at->toIso8601String() }}">
<meta property="article:modified_time" content="{{ $article->updated_at->toIso8601String() }}">
<link rel="canonical" href="{{ route('article.show', $article->slug) }}">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "{{ $article->title }}",
  "description": "{{ addslashes($article->meta_description ?? $article->excerpt) }}",
  "datePublished": "{{ $article->created_at->toIso8601String() }}",
  "dateModified": "{{ $article->updated_at->toIso8601String() }}",
  "author": { "@type": "Organization", "name": "TrainingKota" },
  "publisher": {
    "@type": "Organization",
    "name": "TrainingKota",
    "url": "https://trainingkota.my.id"
  },
  "keywords": "{{ $article->focus_keywords }}",
  "articleBody": "{{ strip_tags(substr($article->content, 0, 500)) }}..."
}
</script>

@if($article->faq_items && count($article->faq_items) > 0)
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    @foreach($article->faq_items as $faq)
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

@section('title', $article->seo_title ?? $article->title)

@section('content')
<!-- Breadcrumb -->
<div class="bg-[#0B1526] border-b border-[#1E324E] py-3">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center space-x-2 text-xs font-space uppercase text-[#94A3B8]">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            @if($article->category)
                <a href="{{ route('category.show', $article->category) }}" class="hover:text-white">{{ $article->category }}</a>
                <span>/</span>
            @endif
            @if($article->city)
                <a href="{{ route('city.landing', ['category' => $article->category, 'citySlug' => $article->city->slug]) }}" class="hover:text-white">{{ $article->city->name }}</a>
                <span>/</span>
            @endif
            <span class="text-[#10B981] font-semibold truncate max-w-xs">{{ Str::limit($article->title, 50) }}</span>
        </div>
    </div>
</div>

<!-- Article Hero Header -->
<section class="bg-gradient-to-b from-[#0F2038] to-[#070D18] border-b border-[#1E324E] py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="max-w-4xl">
            <!-- Meta Badges -->
            <div class="flex flex-wrap items-center gap-2 mb-4">
                @if($article->category)
                    <span class="badge-kemnaker">{{ strtoupper($article->category) }}</span>
                @endif
                @if($article->city)
                    <span class="badge-bnsp">{{ strtoupper($article->city->name) }}</span>
                @endif
                <span class="badge-warning">{{ $article->reading_time }} MENIT MEMBACA</span>
            </div>

            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold font-space text-[#F1F5F9] leading-tight mb-5">
                {{ $article->title }}
            </h1>

            <p class="text-base text-[#94A3B8] leading-relaxed max-w-3xl mb-6">
                {{ $article->excerpt }}
            </p>

            <div class="flex flex-wrap items-center gap-6 text-xs text-[#64748B] font-space uppercase tracking-wider">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-[#0D7A5F] inline-block"></span>
                    Diterbitkan: {{ $article->created_at->format('d F Y') }}
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-[#38BDF8] inline-block"></span>
                    Diperbarui: {{ $article->updated_at->format('d F Y') }}
                </div>
                @if($article->focus_keywords)
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-[#D97706] inline-block"></span>
                    {{ $article->focus_keywords }}
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <!-- Article Body (8 cols) -->
            <div class="lg:col-span-8">

                <!-- Table of Contents -->
                <div
                    x-data="articleTOC()"
                    x-init="buildTOC()"
                    class="mb-8 bg-[#0F2038] border border-[#1E324E] border-l-2 border-l-[#0D7A5F] p-5"
                >
                    <button @click="open = !open" class="w-full flex items-center justify-between text-left">
                        <span class="font-space font-bold text-xs uppercase tracking-wider text-[#F1F5F9] flex items-center gap-2">
                            <span class="w-2 h-2 bg-[#0D7A5F] inline-block"></span>
                            DAFTAR ISI
                        </span>
                        <span class="text-[#0D7A5F] font-space text-xs" x-text="open ? '[ TUTUP ]' : '[ BUKA ]'"></span>
                    </button>
                    <nav x-show="open" x-transition class="mt-4 space-y-1" id="toc-nav">
                        <p class="text-xs text-[#64748B] font-space italic">Memuat daftar isi...</p>
                    </nav>
                </div>

                <!-- Article Full Content -->
                <div id="article-body" class="article-prose bg-[#0B1526] border border-[#1E324E] p-6 lg:p-10">
                    {!! $article->content !!}
                </div>

                <!-- FAQ Section (jika artikel punya FAQ items) -->
                @if($article->faq_items && count($article->faq_items) > 0)
                <div class="mt-10">
                    <h2 class="text-xl font-bold font-space text-[#F1F5F9] mb-5 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-[#0D7A5F] inline-block"></span>
                        Tanya Jawab Terkait Artikel Ini
                    </h2>
                    <div class="space-y-2" x-data="{ openIndex: null }">
                        @foreach($article->faq_items as $idx => $faq)
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
                                <svg class="w-4 h-4 text-[#0D7A5F] shrink-0 transition-transform duration-200 mt-0.5"
                                    :class="openIndex === {{ $idx }} ? 'rotate-180' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div
                                x-show="openIndex === {{ $idx }}"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                class="px-5 pb-5 pt-3 bg-[#070D18] border-t border-[#1E324E]"
                            >
                                <p class="text-sm text-[#c5c6ce] leading-relaxed font-body">{{ $faq['a'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Bottom CTA -->
                <div class="mt-10 bg-[#0F2038] border border-[#1E324E] border-l-4 border-l-[#0D7A5F] p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <div class="font-space font-bold text-sm text-[#F1F5F9] mb-1">Butuh pendampingan teknis atau pelatihan K3?</div>
                        <p class="text-xs text-[#94A3B8]">Tim TrainingKota siap membantu di lebih dari 212 kota seluruh Indonesia.</p>
                    </div>
                    <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin TrainingKota, saya baru membaca artikel: ' . $article->title . '. Saya butuh konsultasi.') }}" target="_blank" class="btn-whatsapp text-xs shrink-0">
                        Konsultasi Gratis via WA
                    </a>
                </div>

                <!-- Tags -->
                @if($article->focus_keywords)
                <div class="mt-6 flex flex-wrap items-center gap-2">
                    <span class="text-xs font-space text-[#64748B] uppercase">Tags:</span>
                    @foreach(explode(',', $article->focus_keywords) as $kw)
                        <span class="px-2 py-1 bg-[#0B1526] border border-[#1E324E] text-[11px] font-space text-[#94A3B8]">{{ trim($kw) }}</span>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Sidebar (4 cols) -->
            <aside class="lg:col-span-4 space-y-6">

                <!-- CTA Sticky Card -->
                <div class="bg-[#0F2038] border border-[#1E324E] p-5 sticky top-24">
                    <div class="font-space font-bold text-xs uppercase tracking-wider text-[#F1F5F9] mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 bg-[#10B981] inline-block animate-pulse"></span>
                        KONSULTASI GRATIS
                    </div>
                    <p class="text-xs text-[#94A3B8] mb-4 leading-relaxed">Diskusikan kebutuhan pelatihan K3 atau jasa teknis langsung dengan tim spesialis kami.</p>
                    <a href="https://wa.me/6281234567890" target="_blank" class="btn-whatsapp w-full text-xs py-3 text-center block mb-2">
                        WhatsApp Sekarang
                    </a>
                    @if($article->category)
                    <a href="{{ route('category.show', $article->category) }}" class="btn-secondary w-full text-xs py-2.5 text-center block">
                        Lihat Katalog {{ ucfirst($article->category) }}
                    </a>
                    @endif
                </div>

                <!-- City Link (jika artikel terkait kota) -->
                @if($article->city)
                <div class="bg-[#0B1526] border border-[#1E324E] p-5">
                    <div class="font-space font-bold text-xs uppercase tracking-wider text-[#F1F5F9] mb-3">
                        Layanan di {{ $article->city->name }}
                    </div>
                    @if($article->category)
                    <a href="{{ route('city.landing', ['category' => $article->category, 'citySlug' => $article->city->slug]) }}" class="block p-3 bg-[#070D18] border border-[#1E324E] hover:border-[#0D7A5F] transition-colors text-xs font-space text-[#10B981]">
                        → {{ ucfirst($article->category) }} di {{ $article->city->name }}
                    </a>
                    @endif
                </div>
                @endif

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
                            <div class="text-[11px] text-[#64748B] font-space">{{ $rel->reading_time }} menit • {{ strtoupper($rel->category ?? '') }}</div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </aside>
        </div>
    </div>
</section>

<!-- TOC Script & Article Prose CSS -->
<script>
function articleTOC() {
    return {
        open: true,
        buildTOC() {
            const body = document.getElementById('article-body');
            const nav  = document.getElementById('toc-nav');
            if (!body || !nav) return;
            const headings = body.querySelectorAll('h2, h3');
            if (!headings.length) { nav.innerHTML = ''; return; }
            let html = '';
            headings.forEach((h, i) => {
                if (!h.id) h.id = 'heading-' + i;
                const isH3 = h.tagName === 'H3';
                html += `<a href="#${h.id}" onclick="event.preventDefault();document.getElementById('${h.id}').scrollIntoView({behavior:'smooth'})"
                    class="flex items-start gap-2 text-xs font-space py-1 transition-colors ${isH3 ? 'pl-4 text-[#64748B] hover:text-[#94A3B8]' : 'text-[#94A3B8] hover:text-[#10B981]'}">
                    <span class="shrink-0 ${isH3 ? 'text-[#44474d]' : 'text-[#0D7A5F]'}">${isH3 ? '↳' : '▪'}</span>
                    <span>${h.textContent}</span>
                </a>`;
            });
            nav.innerHTML = html;
        }
    };
}
</script>

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
