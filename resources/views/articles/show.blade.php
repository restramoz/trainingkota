<!DOCTYPE html>

<html class="dark" lang="id"><head>
    <title>{{ $article->title }} - TrainingKota</title>
    <meta name="description" content="{{ Str::limit(strip_tags($article->content), 160) }}"/>
    
    <!-- Schema.org Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Article",
      "headline": "{{ $article->title }}",
      "author": {
        "@type": "Organization",
        "name": "{{ $article->author ?? 'TrainingKota' }}"
      },
      "publisher": {
        "@type": "Organization",
        "name": "TrainingKota"
      },
      "datePublished": "{{ $article->created_at ? $article->created_at->toISOString() : date('c') }}",
      "description": "{{ Str::limit(strip_tags($article->content), 160) }}"
    }
    </script>
<meta charset="utf-8"/><meta content="width=device-width, initial-scale=1.0" name="viewport"/><link href="https://fonts.googleapis.com" rel="preconnect"/><link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/><link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600&amp;family=Space+Grotesk:wght@500;600;700&amp;display=swap" rel="stylesheet"/><link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/><style>@layer base{html,body{margin:0;padding:0;}body{overscroll-behavior:none;}main>:first-child{margin-top:0!important;}main>:last-child{margin-bottom:0!important;}}::-webkit-scrollbar{display:none;}</style><script src="https://cdn.tailwindcss.com"></script><script id="tailwind-config">tailwind.config={darkMode:"class",theme:{extend:{"colors":{"on-secondary":"#00382a","on-tertiary-container":"#cc6f00","tertiary-fixed-dim":"#ffb77d","regulatory-slate-800":"#0B1526","primary-fixed":"#d5e3ff","safety-emerald-bright":"#10B981","error":"#ffb4ab","on-primary-fixed":"#0a1c34","tertiary-container":"#351800","surface-container-high":"#242a36","surface-dim":"#0d131f","primary-fixed-dim":"#b7c7e7","on-primary":"#21314a","on-secondary-fixed":"#002117","on-primary-container":"#7888a5","on-tertiary-fixed":"#2f1500","on-error-container":"#ffdad6","on-error":"#690005","surface-container-highest":"#2f3541","secondary-fixed":"#98f4d3","inverse-on-surface":"#2a303d","inverse-primary":"#4f5f7a","border-grid":"#1E324E","background":"#0d131f","whatsapp-direct":"#25D366","outline-variant":"#44474d","text-tertiary":"#64748B","secondary-container":"#007459","on-secondary-container":"#9af6d5","error-container":"#93000a","regulatory-slate-700":"#0F2038","surface-container-lowest":"#080e19","outline":"#8e9098","secondary-fixed-dim":"#7cd8b8","surface-container":"#1a202b","surface-bright":"#333946","text-primary":"#F1F5F9","on-background":"#dde2f3","inverse-surface":"#dde2f3","tertiary":"#ffb77d","surface-variant":"#2f3541","surface":"#0d131f","on-tertiary-fixed-variant":"#6e3900","tertiary-fixed":"#ffdcc3","regulatory-slate-900":"#070D18","on-surface":"#dde2f3","on-primary-fixed-variant":"#384761","primary-container":"#0f2038","on-surface-variant":"#c5c6ce","caution-amber":"#D97706","primary":"#b7c7e7","on-tertiary":"#4d2600","on-secondary-fixed-variant":"#00513e","text-secondary":"#94A3B8","secondary":"#7cd8b8","surface-container-low":"#161c27","surface-tint":"#b7c7e7","border-grid-subtle":"#142338","safety-emerald":"#0D7A5F"},"borderRadius":{"DEFAULT":"0.25rem","lg":"0.5rem","xl":"0.75rem","full":"9999px"},"spacing":{"grid-xl":"2rem","grid-sm":"0.5rem","gutter-desktop":"1.5rem","grid-2xs":"0.125rem","grid-2xl":"3rem","grid-md":"1rem","gutter-mobile":"1rem","grid-lg":"1.5rem","grid-xs":"0.25rem","grid-3xl":"4.5rem","margin-desktop":"3rem","margin-mobile":"1rem"},"fontFamily":{"credential-meta":["Space Grotesk"],"headline-sm":["Space Grotesk"],"headline-xl-mobile":["Space Grotesk"],"headline-lg":["Space Grotesk"],"body-md":["IBM Plex Sans"],"headline-lg-mobile":["Space Grotesk"],"tabular-data":["IBM Plex Sans"],"headline-xl":["Space Grotesk"],"body-lg":["IBM Plex Sans"],"headline-md":["Space Grotesk"],"label-caps":["Space Grotesk"],"body-sm":["IBM Plex Sans"]},"fontSize":{"credential-meta":["12px",{"lineHeight":"16px","fontWeight":"600"}],"headline-sm":["18px",{"lineHeight":"24px","fontWeight":"500"}],"headline-xl-mobile":["30px",{"lineHeight":"36px","letterSpacing":"-0.01em","fontWeight":"700"}],"headline-lg":["32px",{"lineHeight":"40px","letterSpacing":"-0.01em","fontWeight":"600"}],"body-md":["14px",{"lineHeight":"22px","fontWeight":"400"}],"headline-lg-mobile":["24px",{"lineHeight":"32px","letterSpacing":"0em","fontWeight":"600"}],"tabular-data":["13px",{"lineHeight":"18px","fontWeight":"500"}],"headline-xl":["40px",{"lineHeight":"48px","letterSpacing":"-0.02em","fontWeight":"700"}],"body-lg":["16px",{"lineHeight":"26px","fontWeight":"400"}],"headline-md":["22px",{"lineHeight":"28px","fontWeight":"600"}],"label-caps":["11px",{"lineHeight":"16px","letterSpacing":"0.08em","fontWeight":"700"}],"body-sm":["12px",{"lineHeight":"18px","fontWeight":"400"}]}}}};</script></head><body class="bg-background font-body-md text-text-primary antialiased selection:bg-safety-emerald selection:text-white"><header class="fixed top-0 left-0 right-0 z-50 bg-regulatory-slate-900 border-b border-border-grid"><div class="bg-regulatory-slate-800 border-b border-border-grid-subtle px-4 lg:px-gutter-desktop h-8 flex items-center justify-between text-text-secondary font-credential-meta text-credential-meta tracking-wider uppercase"><div class="flex items-center gap-2 overflow-hidden text-ellipsis whitespace-nowrap"><span class="w-1.5 h-1.5 bg-safety-emerald-bright animate-pulse"></span><span class="text-ellipsis overflow-hidden">Layanan Pembinaan K3 Kemnaker RI, Kajian Teknis, dan Konsultasi Regulasi Nasional — Tersedia di Seluruh Kota Indonesia</span></div><div class="hidden md:flex items-center gap-4 text-text-tertiary shrink-0"><span>BNSP &amp; KEMNAKER REGISTRY ID-2024</span><span class="text-border-grid">|</span><span class="text-safety-emerald-bright flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">verified</span> 212 KOTA AKTIF</span></div></div><div class="h-20 max-w-7xl mx-auto px-4 lg:px-gutter-desktop flex items-center justify-between gap-4"><div class="flex items-center gap-6"><a class="flex items-center gap-3 shrink-0" href="{{ route('home') }}"><img alt="TrainingKota Official Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1X800IllBOS-DTwtP3jJA6ufvs3AjgCWUDjJYh5GgG-6YbIzmQw7CCCMj98H5sRY2FFvvg3Wvu45GEvb-mrspXml3QWBJto-SMfQ7Zbd50Wk5Ala6LW6YwkceU83gClgCvyouwiflZ4G7azx5U0dPKQMhgR62POOuCGEJCQX2CX9E5D7M_pbyd6qahcizw3W2fxBevPFSa_KyVr2E_8RbRXLGmZX8KXoIRDvFjACR6RBp_-OjTbcwdRHg"/><div class="flex flex-col"><span class="font-headline-sm text-headline-sm uppercase text-text-primary tracking-tight">TRAINING<span class="text-safety-emerald-bright">KOTA</span></span><span class="font-label-caps text-label-caps text-text-tertiary tracking-widest">K3 &amp; REGULATORY HUB</span></div></a><nav class="hidden xl:flex items-center gap-6" data-active-classes="text-safety-emerald-bright font-semibold border-b-2 border-safety-emerald-bright"><a class="py-2 font-headline-sm text-tabular-data text-on-surface-variant hover:text-text-primary transition-colors" href="{{ route('home') }}">Beranda</a><a class="py-2 font-headline-sm text-tabular-data text-on-surface-variant hover:text-text-primary transition-colors" href="{{ route('category.show', 'pelatihan') }}">Pelatihan</a><a class="py-2 font-headline-sm text-tabular-data text-on-surface-variant hover:text-text-primary transition-colors" href="{{ route('category.show', 'kajian') }}">Kajian</a><a class="py-2 font-headline-sm text-tabular-data text-on-surface-variant hover:text-text-primary transition-colors" href="{{ route('category.show', 'jasa') }}">Jasa</a><a class="py-2 font-headline-sm text-tabular-data text-on-surface-variant hover:text-text-primary transition-colors" href="{{ route('home') }}#direktori-kota">Kota Layanan</a><a aria-current="page" class="py-2 transition-colors text-safety-emerald-bright font-semibold border-b-2 border-safety-emerald-bright" href="{{ route('article.show', 'panduan-sertifikasi-ahli-k3-umum-kemnaker') }}">Artikel</a></nav></div><div class="flex items-center gap-3"><div class="hidden sm:flex items-center bg-regulatory-slate-800 border border-border-grid px-3 py-1.5 text-text-primary font-tabular-data text-tabular-data"><span class="material-symbols-outlined text-safety-emerald-bright text-[18px] mr-2">location_city</span><span class="text-text-secondary mr-2">Pilih Kota:</span><span class="font-credential-meta text-credential-meta text-safety-emerald-bright">212 Tersedia</span><span class="material-symbols-outlined text-text-tertiary text-[18px] ml-2">expand_more</span></div><a class="flex items-center gap-2 bg-regulatory-slate-900 border border-whatsapp-direct text-whatsapp-direct hover:bg-whatsapp-direct hover:text-regulatory-slate-900 font-headline-sm text-credential-meta uppercase px-4 py-2 transition-all" href="https://wa.me/{{ config('contact.whatsapp') }}" target="_blank"><span class="material-symbols-outlined text-[18px]">chat</span><span class="hidden md:inline">Hubungi Kami</span></a><div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div></div></div></header><main class="w-full pt-28 bg-background min-h-screen"><div class="flex flex-col w-full">
<section class="w-full bg-surface-container-lowest py-6">
<div class="max-w-7xl mx-auto px-4 lg:px-gutter-desktop">
<nav aria-label="Breadcrumb" class="flex items-center gap-2 font-credential-meta text-credential-meta uppercase">
<a class="text-text-tertiary hover:text-safety-emerald-bright transition-colors" href="#">Beranda</a>
<span class="text-border-grid">/</span>
<a class="text-text-tertiary hover:text-safety-emerald-bright transition-colors" href="#">Artikel &amp; Regulasi K3</a>
<span class="text-border-grid">/</span>
<span class="text-safety-emerald-bright">Panduan Teknis SLF Pabrik</span>
</nav>
</div>
</section>
<header class="w-full bg-surface-dim pt-8 pb-12">
<div class="max-w-7xl mx-auto px-4 lg:px-gutter-desktop">
<div class="flex flex-wrap items-center gap-3 mb-6">
<span class="font-label-caps text-label-caps bg-regulatory-slate-800 text-safety-emerald-bright px-3 py-1 uppercase tracking-wider">
          REGULASI &amp; PERIZINAN GEDUNG (PUPR)
        </span>
<span class="font-label-caps text-label-caps bg-surface-container-high text-primary px-3 py-1 uppercase tracking-wider">
          PP NO. 16 TAHUN 2021
        </span>
<span class="font-credential-meta text-credential-meta text-caution-amber flex items-center gap-1.5 ml-auto">
<span class="material-symbols-outlined text-[15px]">verified_user</span>
          AUDIT STANDAR SIMBG NASIONAL
        </span>
</div>
<h1 class="font-headline-xl text-headline-xl lg:text-[42px] lg:leading-[50px] text-text-primary mb-6 max-w-5xl tracking-tight">
        {{ $article->title }}
      </h1>
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pt-6 bg-surface-container-low p-6 rounded-none">
<div class="flex flex-wrap items-center gap-6">
<div class="flex items-center gap-3">
<div class="w-10 h-10 bg-surface-container-highest flex items-center justify-center text-safety-emerald-bright font-headline-md text-headline-sm">
<span class="material-symbols-outlined text-[20px]">engineering</span>
</div>
<div>
<p class="font-label-caps text-label-caps text-text-tertiary uppercase">Ditinjau Teknis Oleh</p>
<p class="font-headline-sm text-headline-sm text-text-primary">Tim Ahli Kelaikan Struktur TrainingKota</p>
</div>
</div>
<div class="hidden sm:block w-px h-8 bg-surface-container-highest"></div>
<div>
<p class="font-label-caps text-label-caps text-text-tertiary uppercase">Pembaruan Dokumen</p>
<p class="font-tabular-data text-tabular-data text-text-secondary">Kuartal I 2025 (Terverifikasi)</p>
</div>
<div class="hidden sm:block w-px h-8 bg-surface-container-highest"></div>
<div>
<p class="font-label-caps text-label-caps text-text-tertiary uppercase">Waktu Baca</p>
<p class="font-tabular-data text-tabular-data text-text-secondary flex items-center gap-1">
<span class="material-symbols-outlined text-[16px] text-safety-emerald-bright">schedule</span> 8 Menit Kajian
            </p>
</div>
</div>
<div class="flex items-center gap-3 shrink-0">
<a class="flex items-center gap-2 bg-whatsapp-direct text-surface-dim px-4 py-2.5 font-headline-sm text-credential-meta uppercase font-bold hover:bg-safety-emerald-bright transition-colors" href="https://wa.me/?text=Konsultasi%20SLF%20Pabrik%20TrainingKota" target="_blank">
<span class="material-symbols-outlined text-[18px]">share</span>
<span>Bagikan Ringkasan</span>
</a>
<button class="p-2.5 bg-surface-container text-text-secondary hover:text-text-primary transition-colors" id="bookmark-btn" onclick="this.classList.toggle('text-safety-emerald-bright')" title="Simpan Artikel">
<span class="material-symbols-outlined text-[20px]">bookmark</span>
</button>
</div>
</div>
</div>
</header>
<div class="max-w-7xl mx-auto px-4 lg:px-gutter-desktop py-12 w-full">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
<article class="lg:col-span-8 flex flex-col space-y-8 min-w-0 bg-regulatory-slate-800 p-6 lg:p-8 border border-border-grid">
    <!-- TOC Box -->
    <div class="bg-regulatory-slate-900 border border-border-grid p-4">
        <span class="font-headline-sm text-xs font-bold text-text-primary uppercase tracking-wider block mb-2">DAFTAR ISI:</span>
        <ul class="space-y-1.5 text-xs text-text-secondary">
            <li><a href="#art-content" class="hover:text-safety-emerald-bright transition-colors">1. Tinjauan Regulasi &amp; Dasar Hukum Resmi</a></li>
            <li><a href="#art-content" class="hover:text-safety-emerald-bright transition-colors">2. Parameter &amp; Persyaratan Kepatuhan K3</a></li>
        </ul>
    </div>

    <!-- Main Rich Text Content -->
    <div class="article-content space-y-6 text-text-primary leading-relaxed overflow-x-auto [&_table]:w-full [&_table]:border-collapse [&_table]:border [&_table]:border-slate-700 [&_table]:my-4 [&_table]:min-w-[700px] [&_th]:border [&_th]:border-slate-700 [&_th]:bg-slate-800 [&_th]:p-2 [&_th]:overflow-wrap-[anywhere] [&_th]:whitespace-normal [&_td]:border [&_td]:border-slate-700 [&_td]:p-2 [&_td]:overflow-wrap-[anywhere] [&_td]:whitespace-normal" id="art-content">
        {!! $article->content !!}
    </div>
</article>

<!-- Sidebar: Related Articles -->
<aside class="lg:col-span-4 flex flex-col gap-6">
    <div class="bg-regulatory-slate-800 border border-border-grid p-6 space-y-4">
        <span class="font-headline-sm text-xs uppercase font-bold text-text-primary block border-b border-border-grid pb-2">
            ARTIKEL REGULASI TERKAIT
        </span>
        <div class="space-y-4">
            @foreach($relatedArticles ?? [] as $rel)
                <article class="space-y-1">
                    <span class="font-label-caps text-[10px] text-safety-emerald-bright uppercase font-bold">{{ $rel->category }}</span>
                    <a href="{{ route('article.show', $rel->slug) }}" class="font-headline-sm text-xs text-text-primary hover:text-safety-emerald-bright block font-semibold transition-colors">
                        {{ $rel->title }}
                    </a>
                    <span class="text-[11px] text-text-tertiary block">{{ $rel->reading_time }}</span>
                </article>
            @endforeach
        </div>
    </div>
</aside>
</div>
</div>
</main><footer class="w-full bg-regulatory-slate-900 border-t border-border-grid"><div class="max-w-7xl mx-auto px-4 lg:px-gutter-desktop py-12 lg:py-grid-2xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-grid-lg"><div class="flex flex-col gap-4"><div class="flex items-center gap-2"><img alt="TrainingKota Official Logo" class="h-7 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1X800IllBOS-DTwtP3jJA6ufvs3AjgCWUDjJYh5GgG-6YbIzmQw7CCCMj98H5sRY2FFvvg3Wvu45GEvb-mrspXml3QWBJto-SMfQ7Zbd50Wk5Ala6LW6YwkceU83gClgCvyouwiflZ4G7azx5U0dPKQMhgR62POOuCGEJCQX2CX9E5D7M_pbyd6qahcizw3W2fxBevPFSa_KyVr2E_8RbRXLGmZX8KXoIRDvFjACR6RBp_-OjTbcwdRHg"/><span class="font-headline-sm text-headline-sm uppercase text-text-primary">TRAINING<span class="text-safety-emerald-bright">KOTA</span></span></div><p class="font-body-sm text-body-sm text-text-secondary leading-relaxed">Platform direktori dan penyedia sertifikasi K3, kajian risiko teknis, dan perizinan laik fungsi terintegrasi untuk 212 kota se-Indonesia.</p><div class="flex flex-wrap gap-2 pt-2"><span class="font-label-caps text-label-caps bg-regulatory-slate-800 border border-safety-emerald text-safety-emerald-bright px-2 py-1 uppercase">Kemnaker RI Certified</span><span class="font-label-caps text-label-caps bg-regulatory-slate-800 border border-border-grid text-primary px-2 py-1 uppercase">BNSP Accredited</span></div></div><div class="flex flex-col gap-3"><h3 class="font-headline-sm text-headline-sm uppercase text-text-primary border-l-2 border-safety-emerald-bright pl-3">Layanan Unggulan</h3><ul class="flex flex-col gap-2 font-body-sm text-body-sm text-text-secondary"><li class="hover:text-safety-emerald-bright transition-colors cursor-pointer">Ahli K3 Umum (Kemnaker &amp; BNSP)</li><li class="hover:text-safety-emerald-bright transition-colors cursor-pointer">Audit &amp; Sertifikasi SMK3 PP 50/2012</li><li class="hover:text-safety-emerald-bright transition-colors cursor-pointer">Riksa Uji Silo &amp; Lisensi Operator SIA</li><li class="hover:text-safety-emerald-bright transition-colors cursor-pointer">Kajian Safety Culture &amp; Investigasi Insiden</li><li class="hover:text-safety-emerald-bright transition-colors cursor-pointer">Amdal, UKL-UPL, dan Kajian Teknis Lingkungan</li><li class="hover:text-safety-emerald-bright transition-colors cursor-pointer">Sertifikat Laik Fungsi (SLF) &amp; NIDI Elektrikal</li></ul></div><div class="flex flex-col gap-3"><h3 class="font-headline-sm text-headline-sm uppercase text-text-primary border-l-2 border-safety-emerald-bright pl-3">Cakupan Wilayah</h3><div class="grid grid-cols-2 gap-2 font-body-sm text-body-sm text-text-secondary"><span class="hover:text-text-primary transition-colors cursor-pointer">DKI Jakarta</span><span class="hover:text-text-primary transition-colors cursor-pointer">Surabaya</span><span class="hover:text-text-primary transition-colors cursor-pointer">Malang</span><span class="hover:text-text-primary transition-colors cursor-pointer">Balikpapan</span><span class="hover:text-text-primary transition-colors cursor-pointer">Medan</span><span class="hover:text-text-primary transition-colors cursor-pointer">Batam</span><span class="hover:text-text-primary transition-colors cursor-pointer">Makassar</span><span class="hover:text-text-primary transition-colors cursor-pointer">Cilegon</span><span class="hover:text-text-primary transition-colors cursor-pointer">Cikarang</span><span class="text-safety-emerald-bright font-credential-meta text-credential-meta">+ 203 KOTA LAIN</span></div></div><div class="flex flex-col gap-3"><h3 class="font-headline-sm text-headline-sm uppercase text-text-primary border-l-2 border-safety-emerald-bright pl-3">Pusat Informasi</h3><div class="flex flex-col gap-2.5 font-body-sm text-body-sm text-text-secondary"><div class="flex items-start gap-2"><span class="material-symbols-outlined text-text-tertiary text-[18px] shrink-0 mt-0.5">schedule</span><span>Senin - Jumat: 08:00 - 17:00 WIB<br/>Layanan Tanggap Darurat 24 Jam</span></div><div class="flex items-center gap-2"><span class="material-symbols-outlined text-whatsapp-direct text-[18px] shrink-0">chat</span><span>WhatsApp: {{ config('contact.display') }}</span></div><div class="flex items-center gap-2"><span class="material-symbols-outlined text-primary text-[18px] shrink-0">mark_email_read</span><span>verifikasi@trainingkota.my.id</span></div></div></div></div><div class="border-t border-border-grid-subtle bg-regulatory-slate-900 px-4 lg:px-gutter-desktop py-4"><div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 font-body-sm text-body-sm text-text-tertiary"><p>© 2024 TrainingKota (trainingkota.my.id). Hak Cipta Dilindungi Regulasi Kemnaker RI.</p><div class="flex items-center gap-6 font-credential-meta text-credential-meta uppercase"><a class="hover:text-text-primary transition-colors" href="#">Ketentuan Layanan</a><a class="hover:text-text-primary transition-colors" href="#">Kebijakan Privasi</a><a class="hover:text-text-primary transition-colors" href="#">Kepatuhan Hukum</a></div></div></div></footer><div class="fixed bottom-6 right-6 z-50"><a class="flex items-center gap-2 bg-regulatory-slate-900 border-2 border-whatsapp-direct text-whatsapp-direct hover:bg-whatsapp-direct hover:text-regulatory-slate-900 px-4 py-3 shadow-[0_0_20px_rgba(37,211,102,0.2)] font-credential-meta text-credential-meta uppercase tracking-wider transition-all" href="https://wa.me/{{ config('contact.whatsapp') }}" target="_blank"><span class="material-symbols-outlined text-[20px]">support_agent</span><span class="font-bold">Quick Inquiry WA</span></a></div></body></html>
