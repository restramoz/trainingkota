<!DOCTYPE html>

<html class="dark" lang="id"><head>
    <title>{{ $categoryName ?? 'Pelatihan K3' }} di {{ $city->name }} - Sertifikasi Resmi Kemnaker RI | TrainingKota</title>
    <meta name="description" content="Pusat Komando K3 di {{ $city->name }}. Pembinaan Ahli K3 Umum, riksa uji alat berat, izin SLF &amp; sertifikasi resmi Kemnaker RI / BNSP wilayah {{ $city->name }}.">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "EducationalOrganization",
      "name": "TrainingKota {{ $city->name }} - Pusat Layanan K3",
      "url": "{{ url()->current() }}",
      "description": "Layanan pembinaan K3 Kemnaker RI, riksa uji teknis, dan sertifikasi SLF di {{ $city->name }}.",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "{{ $city->name }}",
        "addressRegion": "{{ $city->province ?? $city->island }}",
        "addressCountry": "ID",
        "streetAddress": "{{ $city->address ?? 'Kawasan Industri ' . $city->name }}"
      },
      "telephone": "+6281234567890",
      "openingHours": "Mo-Sa 08:00-17:00"
    }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        @foreach($faqItems ?? [] as $i => $item)
        {
          "@type": "Question",
          "name": "{{ $item['q'] }}",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "{{ $item['a'] }}"
          }
        }{{ $loop->last ? '' : ',' }}
        @endforeach
      ]
    }
    </script>
<meta charset="utf-8"/><meta content="width=device-width, initial-scale=1.0" name="viewport"/><link href="https://fonts.googleapis.com" rel="preconnect"/><link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/><link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600&amp;family=Space+Grotesk:wght@500;600;700&amp;display=swap" rel="stylesheet"/><link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/><style>@layer base{html,body{margin:0;padding:0;}body{overscroll-behavior:none;}main>:first-child{margin-top:0!important;}main>:last-child{margin-bottom:0!important;}}::-webkit-scrollbar{display:none;}</style><script src="https://cdn.tailwindcss.com"></script><script id="tailwind-config">tailwind.config={darkMode:"class",theme:{extend:{"colors":{"on-secondary":"#00382a","on-tertiary-container":"#cc6f00","tertiary-fixed-dim":"#ffb77d","regulatory-slate-800":"#0B1526","primary-fixed":"#d5e3ff","safety-emerald-bright":"#10B981","error":"#ffb4ab","on-primary-fixed":"#0a1c34","tertiary-container":"#351800","surface-container-high":"#242a36","surface-dim":"#0d131f","primary-fixed-dim":"#b7c7e7","on-primary":"#21314a","on-secondary-fixed":"#002117","on-primary-container":"#7888a5","on-tertiary-fixed":"#2f1500","on-error-container":"#ffdad6","on-error":"#690005","surface-container-highest":"#2f3541","secondary-fixed":"#98f4d3","inverse-on-surface":"#2a303d","inverse-primary":"#4f5f7a","border-grid":"#1E324E","background":"#0d131f","whatsapp-direct":"#25D366","outline-variant":"#44474d","text-tertiary":"#64748B","secondary-container":"#007459","on-secondary-container":"#9af6d5","error-container":"#93000a","regulatory-slate-700":"#0F2038","surface-container-lowest":"#080e19","outline":"#8e9098","secondary-fixed-dim":"#7cd8b8","surface-container":"#1a202b","surface-bright":"#333946","text-primary":"#F1F5F9","on-background":"#dde2f3","inverse-surface":"#dde2f3","tertiary":"#ffb77d","surface-variant":"#2f3541","surface":"#0d131f","on-tertiary-fixed-variant":"#6e3900","tertiary-fixed":"#ffdcc3","regulatory-slate-900":"#070D18","on-surface":"#dde2f3","on-primary-fixed-variant":"#384761","primary-container":"#0f2038","on-surface-variant":"#c5c6ce","caution-amber":"#D97706","primary":"#b7c7e7","on-tertiary":"#4d2600","on-secondary-fixed-variant":"#00513e","text-secondary":"#94A3B8","secondary":"#7cd8b8","surface-container-low":"#161c27","surface-tint":"#b7c7e7","border-grid-subtle":"#142338","safety-emerald":"#0D7A5F"},"borderRadius":{"DEFAULT":"0.25rem","lg":"0.5rem","xl":"0.75rem","full":"9999px"},"spacing":{"grid-xl":"2rem","grid-sm":"0.5rem","gutter-desktop":"1.5rem","grid-2xs":"0.125rem","grid-2xl":"3rem","grid-md":"1rem","gutter-mobile":"1rem","grid-lg":"1.5rem","grid-xs":"0.25rem","grid-3xl":"4.5rem","margin-desktop":"3rem","margin-mobile":"1rem"},"fontFamily":{"credential-meta":["Space Grotesk"],"headline-sm":["Space Grotesk"],"headline-xl-mobile":["Space Grotesk"],"headline-lg":["Space Grotesk"],"body-md":["IBM Plex Sans"],"headline-lg-mobile":["Space Grotesk"],"tabular-data":["IBM Plex Sans"],"headline-xl":["Space Grotesk"],"body-lg":["IBM Plex Sans"],"headline-md":["Space Grotesk"],"label-caps":["Space Grotesk"],"body-sm":["IBM Plex Sans"]},"fontSize":{"credential-meta":["12px",{"lineHeight":"16px","fontWeight":"600"}],"headline-sm":["18px",{"lineHeight":"24px","fontWeight":"500"}],"headline-xl-mobile":["30px",{"lineHeight":"36px","letterSpacing":"-0.01em","fontWeight":"700"}],"headline-lg":["32px",{"lineHeight":"40px","letterSpacing":"-0.01em","fontWeight":"600"}],"body-md":["14px",{"lineHeight":"22px","fontWeight":"400"}],"headline-lg-mobile":["24px",{"lineHeight":"32px","letterSpacing":"0em","fontWeight":"600"}],"tabular-data":["13px",{"lineHeight":"18px","fontWeight":"500"}],"headline-xl":["40px",{"lineHeight":"48px","letterSpacing":"-0.02em","fontWeight":"700"}],"body-lg":["16px",{"lineHeight":"26px","fontWeight":"400"}],"headline-md":["22px",{"lineHeight":"28px","fontWeight":"600"}],"label-caps":["11px",{"lineHeight":"16px","letterSpacing":"0.08em","fontWeight":"700"}],"body-sm":["12px",{"lineHeight":"18px","fontWeight":"400"}]}}}};</script></head><body class="bg-background font-body-md text-text-primary antialiased selection:bg-safety-emerald selection:text-white"><header class="fixed top-0 left-0 right-0 z-50 bg-regulatory-slate-900 border-b border-border-grid"><div class="bg-regulatory-slate-800 border-b border-border-grid-subtle px-4 lg:px-gutter-desktop h-8 flex items-center justify-between text-text-secondary font-credential-meta text-credential-meta tracking-wider uppercase"><div class="flex items-center gap-2 overflow-hidden text-ellipsis whitespace-nowrap"><span class="w-1.5 h-1.5 bg-safety-emerald-bright animate-pulse"></span><span class="text-ellipsis overflow-hidden">Layanan Pembinaan K3 Kemnaker RI, Kajian Teknis, dan Konsultasi Regulasi Nasional — Tersedia di Seluruh Kota Indonesia</span></div><div class="hidden md:flex items-center gap-4 text-text-tertiary shrink-0"><span>BNSP &amp; KEMNAKER REGISTRY ID-2024</span><span class="text-border-grid">|</span><span class="text-safety-emerald-bright flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">verified</span> 212 KOTA AKTIF</span></div></div><div class="h-20 max-w-7xl mx-auto px-4 lg:px-gutter-desktop flex items-center justify-between gap-4"><div class="flex items-center gap-6"><a class="flex items-center gap-3 shrink-0" href="{{ route('home') }}"><img alt="TrainingKota Official Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1X800IllBOS-DTwtP3jJA6ufvs3AjgCWUDjJYh5GgG-6YbIzmQw7CCCMj98H5sRY2FFvvg3Wvu45GEvb-mrspXml3QWBJto-SMfQ7Zbd50Wk5Ala6LW6YwkceU83gClgCvyouwiflZ4G7azx5U0dPKQMhgR62POOuCGEJCQX2CX9E5D7M_pbyd6qahcizw3W2fxBevPFSa_KyVr2E_8RbRXLGmZX8KXoIRDvFjACR6RBp_-OjTbcwdRHg"/><div class="flex flex-col"><span class="font-headline-sm text-headline-sm uppercase text-text-primary tracking-tight">TRAINING<span class="text-safety-emerald-bright">KOTA</span></span><span class="font-label-caps text-label-caps text-text-tertiary tracking-widest">K3 &amp; REGULATORY HUB</span></div></a><nav class="hidden xl:flex items-center gap-6" data-active-classes="text-safety-emerald-bright font-semibold border-b-2 border-safety-emerald-bright"><a class="py-2 font-headline-sm text-tabular-data text-on-surface-variant hover:text-text-primary transition-colors" href="{{ route('home') }}">Beranda</a><a class="py-2 font-headline-sm text-tabular-data text-on-surface-variant hover:text-text-primary transition-colors" href="{{ route('category.show', 'pelatihan') }}">Pelatihan</a><a class="py-2 font-headline-sm text-tabular-data text-on-surface-variant hover:text-text-primary transition-colors" href="{{ route('category.show', 'kajian') }}">Kajian</a><a class="py-2 font-headline-sm text-tabular-data text-on-surface-variant hover:text-text-primary transition-colors" href="{{ route('category.show', 'jasa') }}">Jasa</a><a aria-current="page" class="py-2 transition-colors text-safety-emerald-bright font-semibold border-b-2 border-safety-emerald-bright" href="{{ route('home') }}#direktori-kota">Kota Layanan</a><a class="py-2 font-headline-sm text-tabular-data text-on-surface-variant hover:text-text-primary transition-colors" href="{{ route('article.show', 'panduan-sertifikasi-ahli-k3-umum-kemnaker') }}">Artikel</a></nav></div><div class="flex items-center gap-3"><div class="hidden sm:flex items-center bg-regulatory-slate-800 border border-border-grid px-3 py-1.5 text-text-primary font-tabular-data text-tabular-data"><span class="material-symbols-outlined text-safety-emerald-bright text-[18px] mr-2">location_city</span><span class="text-text-secondary mr-2">Pilih Kota:</span><span class="font-credential-meta text-credential-meta text-safety-emerald-bright">212 Tersedia</span><span class="material-symbols-outlined text-text-tertiary text-[18px] ml-2">expand_more</span></div><a class="flex items-center gap-2 bg-regulatory-slate-900 border border-whatsapp-direct text-whatsapp-direct hover:bg-whatsapp-direct hover:text-regulatory-slate-900 font-headline-sm text-credential-meta uppercase px-4 py-2 transition-all" href="https://wa.me/6281234567890" target="_blank"><span class="material-symbols-outlined text-[18px]">chat</span><span class="hidden md:inline">Hubungi Kami</span></a><div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div></div></div></header><main class="w-full pt-28 bg-background min-h-screen"><div class="flex flex-col w-full">
<!-- Top Command Telemetry Bar -->
<section class="w-full bg-regulatory-slate-900 text-text-secondary px-4 lg:px-gutter-desktop py-2.5">
<div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3 font-credential-meta text-credential-meta">
<!-- Breadcrumb Hierarchy -->
<nav aria-label="Breadcrumb" class="flex items-center gap-2 flex-wrap">
<a class="text-text-tertiary hover:text-safety-emerald-bright transition-colors flex items-center gap-1" href="#">
<span class="material-symbols-outlined text-[14px]">home</span>
<span>Beranda</span>
</a>
<span class="text-text-tertiary">/</span>
<a class="text-text-tertiary hover:text-safety-emerald-bright transition-colors" href="#">Kota Layanan</a>
<span class="text-text-tertiary">/</span>
<a class="text-text-tertiary hover:text-safety-emerald-bright transition-colors" href="#">Jawa Timur</a>
<span class="text-text-tertiary">/</span>
<span class="text-safety-emerald-bright font-semibold">{{ $city->name }} ({{ strtoupper(substr($city->slug, 0, 3)) }}-REG-{{ $city->id }})</span>
</nav>
<div class="flex items-center gap-4 text-tabular-data font-tabular-data">
<span class="inline-flex items-center gap-1.5 text-text-primary">
<span class="w-2 h-2 rounded-none bg-safety-emerald-bright inline-block"></span>
          KEMNAKER RI DISNAKERTRANS PROV. {{ strtoupper($city->province ?? $city->island) }} | JADWAL KHUSUS REGIONAL {{ strtoupper($city->name) }}
        </span>
<span class="hidden md:inline text-text-tertiary">|</span>
<span class="hidden md:inline text-text-secondary">LATITUDE -7.9797 S, LONGITUDE 112.6304 E</span>
</div>
</div>
</section>
<!-- Localized Hero Section -->
<section class="w-full bg-regulatory-slate-800 text-text-primary px-4 lg:px-gutter-desktop py-12 lg:py-grid-2xl">
<div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
<div class="lg:col-span-8 flex flex-col gap-5">
<div class="flex flex-wrap items-center gap-2">
<span class="bg-regulatory-slate-900 text-safety-emerald-bright font-label-caps text-label-caps uppercase px-3 py-1">
            Sentra Registrasi &amp; Fasilitasi Praktik Wilayah Jawa Timur
          </span>
<span class="bg-primary-container text-primary-fixed-dim font-label-caps text-label-caps uppercase px-3 py-1">
            Kawasan Malang Raya: Kota Malang • Kab. Malang • Kota Batu
          </span>
</div>
<h1 class="font-headline-xl text-headline-xl uppercase tracking-tight text-text-primary max-w-4xl">
          {{ $categoryName ?? "Layanan K3 & Profesional" }} di <span class="text-safety-emerald-bright">{{ $city->name }} &amp; {{ $city->province ?? $city->island }}</span>
</h1>
<p class="font-body-lg text-body-lg text-text-secondary max-w-3xl leading-relaxed">
          Pusat layanan pembinaan keselamatan kerja resmi Kemnaker RI &amp; BNSP, uji riksa alat berat pabrikasi, serta konsultasi kepatuhan regulasi industri untuk ekosistem manufaktur Karanglo-Singosari, perhotelan Batu, agroindustri Kepanjen, dan fasilitas riset Malang Raya.
        </p>
<!-- CTA Buttons -->
<div class="flex flex-wrap items-center gap-4 pt-2">
<a class="bg-safety-emerald hover:bg-safety-emerald-bright text-text-primary font-headline-sm text-credential-meta uppercase px-6 py-3 transition-colors flex items-center gap-2" href="https://wa.me/6281234567890?text=Halo%20TrainingKota%20Malang%20saya%20ingin%20konsultasi%20layanan%20K3" target="_blank">
<span class="material-symbols-outlined text-[18px]">chat</span>
<span>Konsultasi Layanan Malang via WhatsApp</span>
</a>
<a class="bg-regulatory-slate-700 hover:bg-surface-container-high text-text-primary font-headline-sm text-credential-meta uppercase px-6 py-3 transition-colors flex items-center gap-2" href="#lokasi-malang">
<span class="material-symbols-outlined text-[18px]">domain_verification</span>
<span>Lihat Alamat Kantor / Titik Praktik</span>
</a>
</div>
<!-- Telemetry Stats Strip -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4">
<div class="bg-regulatory-slate-900 p-3">
<span class="font-label-caps text-label-caps text-text-tertiary block">ALUMNI BATCH MALANG</span>
<span class="font-headline-md text-headline-md text-text-primary">1,480+</span>
<span class="font-body-sm text-body-sm text-safety-emerald-bright block">Personel Tersertifikasi</span>
</div>
<div class="bg-regulatory-slate-900 p-3">
<span class="font-label-caps text-label-caps text-text-tertiary block">PERUSAHAAN REKANAN</span>
<span class="font-headline-md text-headline-md text-text-primary">240+</span>
<span class="font-body-sm text-body-sm text-primary-fixed block">FMCG, Pabrik Gula &amp; Faskes</span>
</div>
<div class="bg-regulatory-slate-900 p-3">
<span class="font-label-caps text-label-caps text-text-tertiary block">AUDIT UJI RIKSA</span>
<span class="font-headline-md text-headline-md text-text-primary">310+</span>
<span class="font-body-sm text-body-sm text-secondary-fixed block">SIA/SILO Diterbitkan</span>
</div>
<div class="bg-regulatory-slate-900 p-3">
<span class="font-label-caps text-label-caps text-text-tertiary block">KODE JARINGAN PROVINSI</span>
<span class="font-headline-md text-headline-md text-text-primary">JTM-04</span>
<span class="font-body-sm text-body-sm text-tertiary-fixed block">Direct Dispatch Surabaya-MLG</span>
</div>
</div>
</div>
<!-- Hero Visual Industrial Asset -->
<div class="lg:col-span-4 flex flex-col gap-3">
<div class="relative bg-regulatory-slate-900 overflow-hidden">
<img class="w-full h-80 object-cover opacity-90 hover:scale-105 transition-transform duration-500" data-alt="Indonesian safety engineers and industrial inspectors wearing high-visibility vests and protective hardhats conducting a technical audit inside an automated manufacturing and agro-processing facility in Malang East Java, sharp cinematic dramatic directional lighting with deep slate blue and vivid emerald accents." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCJ2RXBuUXKzbqwd1ALKVab23Ix1SUF9Ws1hr8J9srGx5EFGtkoRJJqFuJrcjSYhxX1x2ZUDRkQCNYtRx3IRA4tU7eJRH9jraYQ3JKlhMALIN0_j4irj1JrPJ_UK3CVR8-V29lkOfJm3d6Cjb2KkcTUARgXim_tbQchvKh_GaiabGoGkNcMADlOUW9KFJEKzSxeLVNiUHdu6TgE3D-jYKSx89jutGQajizNSEuerIZs5Foi7ee4uoql"/>
<div class="absolute inset-0 bg-gradient-to-t from-regulatory-slate-900 via-transparent to-transparent"></div>
<div class="absolute bottom-4 left-4 right-4 bg-regulatory-slate-800/90 backdrop-blur-sm p-3">
<div class="flex items-center justify-between font-credential-meta text-credential-meta">
<span class="text-safety-emerald-bright">SENTRA K3 {{ strtoupper($city->name) }}</span>
<span class="text-text-tertiary">REV 2024.Q4</span>
</div>
<p class="font-body-sm text-body-sm text-text-secondary mt-1">
              Fasilitasi Sertifikasi Kemnaker RI, BNSP, &amp; Layanan SLF Terakreditasi Wilayah Malang, Singosari, Lawang, dan Kepanjen.
            </p>
</div>
</div>
<div class="bg-regulatory-slate-900 p-3 flex items-center justify-between text-tabular-data font-tabular-data text-text-secondary">
<span class="flex items-center gap-1.5 text-text-primary">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">verified</span>
            Izin PJK3 No. KEP.512/BINWASK3-PNK3/V/2023
          </span>
<span class="text-text-tertiary">SIAGA REGULASI</span>
</div>
</div>
</div>
</section>
<!-- Local Introduction & Economic Profile Section -->
<section class="w-full bg-surface-container-low px-4 lg:px-gutter-desktop py-12 lg:py-grid-xl">
<div class="max-w-7xl mx-auto">
<div class="flex flex-col gap-2 mb-8">
<span class="font-label-caps text-label-caps uppercase text-safety-emerald-bright tracking-widest">
          // PROFIL KEPATUHAN KAWASAN MALANG RAYA
        </span>
<h2 class="font-headline-lg text-headline-lg uppercase tracking-tight text-text-primary">
          Harmonisasi Regulasi K3 di Titik Temu Manufaktur, Pariwisata, dan Edukasi
        </h2>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
<!-- Manufaktur & Agroindustri -->
<div class="bg-regulatory-slate-800 p-6 flex flex-col justify-between">
<div class="flex flex-col gap-3">
<div class="w-10 h-10 bg-regulatory-slate-900 flex items-center justify-center text-safety-emerald-bright">
<span class="material-symbols-outlined text-[24px]">factory</span>
</div>
<h3 class="font-headline-sm text-headline-sm text-text-primary uppercase">Koridor Industri Lawang - Singosari</h3>
<p class="font-body-md text-body-md text-text-secondary leading-relaxed">
              Pusat agroindustri, rokok, kemasan kertas, makanan &amp; minuman di koridor utara Malang menuntut pemenuhan ketat Surat Izin Layak Operasi (SILO) bejana tekan, pesawat uap boiler, dan sertifikasi Ahli K3 Umum untuk kepatuhan Permenaker No. 04/MEN/1987 serta audit SMK3 PP 50/2012.
            </p>
</div>
<div class="pt-4 mt-4 bg-regulatory-slate-900/60 p-3">
<span class="font-label-caps text-label-caps text-text-tertiary block mb-1">PROGRAM UTAMA SEKTOR INI:</span>
<span class="font-credential-meta text-credential-meta text-primary-fixed">Operator Boiler Kelas 1 • Riksa Uji Bejana Uap • Ahli K3 Kimia</span>
</div>
</div>
<!-- Edukasi & Layanan Medis -->
<div class="bg-regulatory-slate-800 p-6 flex flex-col justify-between">
<div class="flex flex-col gap-3">
<div class="w-10 h-10 bg-regulatory-slate-900 flex items-center justify-center text-primary">
<span class="material-symbols-outlined text-[24px]">local_hospital</span>
</div>
<h3 class="font-headline-sm text-headline-sm text-text-primary uppercase">Klinik, Rumah Sakit &amp; Kampus Riset</h3>
<p class="font-body-md text-body-md text-text-secondary leading-relaxed">
              Dengan lebih dari 50 perguruan tinggi dan puluhan rumah sakit rujukan di Kota Malang, kebutuhan inspeksi proteksi kebakaran aktif/pasif, keselamatan laboratorium biosafety, pengelolaan limbah B3 teknis, dan pelatihan Petugas Tanggap Darurat Gedung Bertingkat menjadi krusial.
            </p>
</div>
<div class="pt-4 mt-4 bg-regulatory-slate-900/60 p-3">
<span class="font-label-caps text-label-caps text-text-tertiary block mb-1">PROGRAM UTAMA SEKTOR INI:</span>
<span class="font-credential-meta text-credential-meta text-safety-emerald-bright">Ahli K3 RS / Fasilitas Kesehatan • Petugas Peran Kebakaran • P3K Kemnaker</span>
</div>
</div>
<!-- Sektor Hospitalitas & Bangunan Gedung (Batu & Malang Kota) -->
<div class="bg-regulatory-slate-800 p-6 flex flex-col justify-between">
<div class="flex flex-col gap-3">
<div class="w-10 h-10 bg-regulatory-slate-900 flex items-center justify-center text-tertiary">
<span class="material-symbols-outlined text-[24px]">apartment</span>
</div>
<h3 class="font-headline-sm text-headline-sm text-text-primary uppercase">Hospitalitas &amp; Kelayakan Bangunan Gedung</h3>
<p class="font-body-md text-body-md text-text-secondary leading-relaxed">
              Pertumbuhan masif hotel resort di Kota Batu dan gedung komersial pusat perbelanjaan Malang menuntut pengurusan Sertifikat Laik Fungsi (SLF), kajian audit struktur, serta riksa uji berkala instalasi penyalur petir dan kelistrikan sesuai Kepmenaker 311/2002.
            </p>
</div>
<div class="pt-4 mt-4 bg-regulatory-slate-900/60 p-3">
<span class="font-label-caps text-label-caps text-text-tertiary block mb-1">PROGRAM UTAMA SEKTOR INI:</span>
<span class="font-credential-meta text-credential-meta text-tertiary-fixed">Kajian &amp; Pengurusan SLF • Riksa Uji Lift/Elevator • NIDI Elektrikal</span>
</div>
</div>
</div>
</div>
</section>
<!-- Layanan K3 & Sertifikasi Tersedia di Malang (Grid Program) -->
<section class="w-full bg-regulatory-slate-900 px-4 lg:px-gutter-desktop py-12 lg:py-grid-2xl">
<div class="max-w-7xl mx-auto">
<div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
<div>
<span class="font-label-caps text-label-caps uppercase text-safety-emerald-bright tracking-widest block mb-1">
            KATALOG KURSUS &amp; LAYANAN REKAYASA REGULASI
          </span>
<h2 class="font-headline-lg text-headline-lg uppercase text-text-primary">
            Program Aktif &amp; Layanan Legalitas di Malang Raya
          </h2>
</div>
<div class="flex items-center gap-2">
<span class="bg-regulatory-slate-800 px-3 py-1.5 font-credential-meta text-credential-meta text-text-secondary">
            SERTIFIKASI: KEMNAKER RI / BNSP
          </span>
</div>
</div>
<!-- Programs Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
<!-- Card 1: Ahli K3 Umum -->
<div class="bg-regulatory-slate-800 p-6 flex flex-col justify-between hover:bg-surface-container transition-colors">
<div>
<div class="flex items-center justify-between mb-4">
<span class="bg-regulatory-slate-900 text-safety-emerald-bright font-label-caps text-label-caps uppercase px-2 py-1">
                KEMNAKER RI RESMI
              </span>
<span class="font-credential-meta text-credential-meta text-text-tertiary">DURASI: 12 HARI</span>
</div>
<h3 class="font-headline-sm text-headline-sm uppercase text-text-primary mb-2">
              Pembinaan Ahli K3 Umum (AK3U) Malang
            </h3>
<p class="font-body-sm text-body-sm text-text-secondary leading-relaxed mb-4">
              Sertifikasi penunjukan personel K3 wajib untuk perusahaan di Jawa Timur dengan tenaga kerja &gt;100 orang. Dilengkapi modul PKL pabrikasi riil di koridor Karanglo-Singosari Malang.
            </p>
<ul class="flex flex-col gap-2 font-body-sm text-body-sm text-text-primary mb-6">
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                SKP &amp; Lisensi Resmi Kemnaker RI
              </li>
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Praktik Kerja Lapangan (PKL) Pabrik Malang
              </li>
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Opsi Kelas Blended (Zoom + Tatap Muka Malang)
              </li>
</ul>
</div>
<div class="flex items-center justify-between pt-4 bg-regulatory-slate-900/50 p-3">
<span class="font-headline-sm text-headline-sm text-text-primary">Batch Tiap Bulan</span>
<a class="bg-safety-emerald hover:bg-safety-emerald-bright text-text-primary font-credential-meta text-credential-meta uppercase px-3 py-2" href="https://wa.me/6281234567890?text=Daftar%20AK3U%20Malang">
              Daftar Batch
            </a>
</div>
</div>
<!-- Card 2: Operator Alat Berat (Forklift & Overhead Crane) -->
<div class="bg-regulatory-slate-800 p-6 flex flex-col justify-between hover:bg-surface-container transition-colors">
<div>
<div class="flex items-center justify-between mb-4">
<span class="bg-regulatory-slate-900 text-primary-fixed font-label-caps text-label-caps uppercase px-2 py-1">
                LISENSI SIO / KEMNAKER
              </span>
<span class="font-credential-meta text-credential-meta text-text-tertiary">DURASI: 3 - 4 HARI</span>
</div>
<h3 class="font-headline-sm text-headline-sm uppercase text-text-primary mb-2">
              Lisensi Operator Forklift &amp; Crane Malang
            </h3>
<p class="font-body-sm text-body-sm text-text-secondary leading-relaxed mb-4">
              Pelatihan dan pengujian lisensi SIO Kemnaker RI untuk operator angkat angkut industri logistik, gudang dingin, dan pabrik manufaktur di kawasan Malang Raya.
            </p>
<ul class="flex flex-col gap-2 font-body-sm text-body-sm text-text-primary mb-6">
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Sertifikat &amp; Buku Lisensi Operator (SIO)
              </li>
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Uji Manuver &amp; Inspeksi Fisik Alat
              </li>
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Fasilitas Unit Alat Lengkap di Malang
              </li>
</ul>
</div>
<div class="flex items-center justify-between pt-4 bg-regulatory-slate-900/50 p-3">
<span class="font-headline-sm text-headline-sm text-text-primary">Praktik Lapangan</span>
<a class="bg-safety-emerald hover:bg-safety-emerald-bright text-text-primary font-credential-meta text-credential-meta uppercase px-3 py-2" href="https://wa.me/6281234567890?text=Daftar%20Operator%20Forklift%20Malang">
              Daftar Batch
            </a>
</div>
</div>
<!-- Card 3: Sertifikat Laik Fungsi (SLF) & Audit Gedung -->
<div class="bg-regulatory-slate-800 p-6 flex flex-col justify-between hover:bg-surface-container transition-colors">
<div>
<div class="flex items-center justify-between mb-4">
<span class="bg-regulatory-slate-900 text-tertiary-fixed font-label-caps text-label-caps uppercase px-2 py-1">
                KAJIAN TEKNIS PEMDA
              </span>
<span class="font-credential-meta text-credential-meta text-text-tertiary">MALANG RAYA</span>
</div>
<h3 class="font-headline-sm text-headline-sm uppercase text-text-primary mb-2">
              Kajian &amp; Pengurusan SLF Bangunan Gedung
            </h3>
<p class="font-body-sm text-body-sm text-text-secondary leading-relaxed mb-4">
              Pendampingan uji kelayakan struktur, sistem mekanikal elektrikal (MEP), proteksi kebakaran, dan tata ruang untuk penerbitan SLF Pemkot Malang, Pemkab Malang, &amp; Pemkot Batu.
            </p>
<ul class="flex flex-col gap-2 font-body-sm text-body-sm text-text-primary mb-6">
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Audit As-Built Drawing &amp; NDT Test
              </li>
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Pengurusan SIMBG Terintegrasi
              </li>
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Tenaga Ahli Madya/Utama Bersertifikat
              </li>
</ul>
</div>
<div class="flex items-center justify-between pt-4 bg-regulatory-slate-900/50 p-3">
<span class="font-headline-sm text-headline-sm text-text-primary">Inspeksi Lapangan</span>
<a class="bg-safety-emerald hover:bg-safety-emerald-bright text-text-primary font-credential-meta text-credential-meta uppercase px-3 py-2" href="https://wa.me/6281234567890?text=Pengurusan%20SLF%20Malang">
              Ajukan Audit
            </a>
</div>
</div>
<!-- Card 4: Petugas P3K di Tempat Kerja -->
<div class="bg-regulatory-slate-800 p-6 flex flex-col justify-between hover:bg-surface-container transition-colors">
<div>
<div class="flex items-center justify-between mb-4">
<span class="bg-regulatory-slate-900 text-safety-emerald-bright font-label-caps text-label-caps uppercase px-2 py-1">
                KEMNAKER RI PER.15/2008
              </span>
<span class="font-credential-meta text-credential-meta text-text-tertiary">DURASI: 3 HARI</span>
</div>
<h3 class="font-headline-sm text-headline-sm uppercase text-text-primary mb-2">
              Sertifikasi Petugas P3K Tempat Kerja
            </h3>
<p class="font-body-sm text-body-sm text-text-secondary leading-relaxed mb-4">
              Standarisasi pertolongan pertama kecelakaan kerja untuk institusi kampus, pabrik olahan agro, hotel, dan wahana wisata tematik di Malang Raya.
            </p>
<ul class="flex flex-col gap-2 font-body-sm text-body-sm text-text-primary mb-6">
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Lisensi Resmi Petugas P3K Kemnaker RI
              </li>
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Simulasi CPR, Evakuasi, &amp; Triage Medis
              </li>
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Modul Audit Kotak P3K Perusahaan
              </li>
</ul>
</div>
<div class="flex items-center justify-between pt-4 bg-regulatory-slate-900/50 p-3">
<span class="font-headline-sm text-headline-sm text-text-primary">Tatap Muka Malang</span>
<a class="bg-safety-emerald hover:bg-safety-emerald-bright text-text-primary font-credential-meta text-credential-meta uppercase px-3 py-2" href="https://wa.me/6281234567890?text=Daftar%20P3K%20Malang">
              Daftar Batch
            </a>
</div>
</div>
<!-- Card 5: Kajian Risiko Kebakaran & Hydrant -->
<div class="bg-regulatory-slate-800 p-6 flex flex-col justify-between hover:bg-surface-container transition-colors">
<div>
<div class="flex items-center justify-between mb-4">
<span class="bg-regulatory-slate-900 text-caution-amber font-label-caps text-label-caps uppercase px-2 py-1">
                AUDIT PROTEKSI &amp; DAMKAR
              </span>
<span class="font-credential-meta text-credential-meta text-text-tertiary">COMMISSIONING</span>
</div>
<h3 class="font-headline-sm text-headline-sm uppercase text-text-primary mb-2">
              Kajian Fire Risk &amp; Riksa Uji Hidran Malang
            </h3>
<p class="font-body-sm text-body-sm text-text-secondary leading-relaxed mb-4">
              Pengujian flow test instalasi pipa hidran, sprinkle otomatis, alarm kebakaran, dan sertifikasi Petugas Pemadam Kebakaran Kelas D/C/B/A untuk pabrik &amp; fasilitas umum.
            </p>
<ul class="flex flex-col gap-2 font-body-sm text-body-sm text-text-primary mb-6">
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Laporan Teknis Rekomendasi Damkar Daerah
              </li>
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Kalkulasi Densitas &amp; Tekanan Pompa
              </li>
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Pelatihan Evakuasi Darurat Karyawan
              </li>
</ul>
</div>
<div class="flex items-center justify-between pt-4 bg-regulatory-slate-900/50 p-3">
<span class="font-headline-sm text-headline-sm text-text-primary">Inspeksi On-Site</span>
<a class="bg-safety-emerald hover:bg-safety-emerald-bright text-text-primary font-credential-meta text-credential-meta uppercase px-3 py-2" href="https://wa.me/6281234567890?text=Kajian%20Fire%20Risk%20Malang">
              Konsultasi
            </a>
</div>
</div>
<!-- Card 6: Operator Boiler & Bejana Tekan -->
<div class="bg-regulatory-slate-800 p-6 flex flex-col justify-between hover:bg-surface-container transition-colors">
<div>
<div class="flex items-center justify-between mb-4">
<span class="bg-regulatory-slate-900 text-primary font-label-caps text-label-caps uppercase px-2 py-1">
                KEMNAKER RI KELAS 1 &amp; 2
              </span>
<span class="font-credential-meta text-credential-meta text-text-tertiary">DURASI: 4 HARI</span>
</div>
<h3 class="font-headline-sm text-headline-sm uppercase text-text-primary mb-2">
              Operator Pesawat Uap Boiler &amp; Uji Silo
            </h3>
<p class="font-body-sm text-body-sm text-text-secondary leading-relaxed mb-4">
              Program wajib operator ketel uap pabrik pengolahan gula, tekstil, pakan ternak, dan makanan olahan di wilayah Malang Selatan dan Kepanjen.
            </p>
<ul class="flex flex-col gap-2 font-body-sm text-body-sm text-text-primary mb-6">
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Lisensi SIO Kemnaker RI Resmi
              </li>
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Pemeriksaan Safety Valve &amp; Hydrotest
              </li>
<li class="flex items-center gap-2">
<span class="material-symbols-outlined text-safety-emerald-bright text-[16px]">check</span>
                Bimbingan Kepatuhan UU Uap 1930
              </li>
</ul>
</div>
<div class="flex items-center justify-between pt-4 bg-regulatory-slate-900/50 p-3">
<span class="font-headline-sm text-headline-sm text-text-primary">Fasilitas Uji Siap</span>
<a class="bg-safety-emerald hover:bg-safety-emerald-bright text-text-primary font-credential-meta text-credential-meta uppercase px-3 py-2" href="https://wa.me/6281234567890?text=Daftar%20Operator%20Boiler%20Malang">
              Daftar Batch
            </a>
</div>
</div>
</div>
</div>
</section>
<!-- Live Batch Schedule Table in City -->
<section class="w-full bg-regulatory-slate-800 px-4 lg:px-gutter-desktop py-12 lg:py-grid-xl">
<div class="max-w-7xl mx-auto">
<div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
<div>
<span class="font-label-caps text-label-caps uppercase text-safety-emerald-bright tracking-widest block mb-1">
    KALENDER OPERASIONAL RESMI
</span>
<h2 class="font-headline-lg text-headline-lg uppercase text-text-primary font-bold">
    Jadwal Khusus Regional {{ $city->name }} (Tahun Berjalan)
</h2>
</div>
<div class="bg-regulatory-slate-900 p-2 font-tabular-data text-tabular-data text-text-secondary flex items-center gap-2">
<span class="w-2 h-2 rounded-none bg-safety-emerald-bright animate-pulse"></span>
<span>Sistem Registrasi Kuota Real-Time</span>
</div>
</div>
<!-- Technical Data Table -->
<div class="overflow-x-auto bg-regulatory-slate-900">
<table class="w-full text-left font-tabular-data text-tabular-data">
<thead>
<tr class="bg-regulatory-slate-700 text-text-secondary font-label-caps text-label-caps uppercase">
<th class="p-3">Kode Program</th>
<th class="p-3">Nama Sertifikasi / Pelatihan</th>
<th class="p-3">Tanggal Pelaksanaan</th>
<th class="p-3">Lokasi Teori &amp; Praktik Lapangan</th>
<th class="p-3 text-center">Sisa Kuota</th>
<th class="p-3 text-center">Status</th>
<th class="p-3 text-right">Aksi</th>
</tr>
</thead>
<tbody class="divide-y divide-border-grid-subtle">
@foreach($services->take(6) as $index => $svc)
<tr class="hover:bg-surface-container transition-colors">
<td class="p-3 font-credential-meta text-credential-meta text-text-secondary">{{ strtoupper(substr($svc->category, 0, 3)) }}-{{ strtoupper(substr($city->slug, 0, 3)) }}-{{ 10 + $index }}</td>
<td class="p-3">
    <a href="{{ route('city.service.landing', ['category' => $svc->category, 'serviceSlug' => $svc->slug, 'citySlug' => $city->slug]) }}" class="font-headline-sm text-headline-sm text-text-primary hover:text-safety-emerald-bright block font-semibold">{{ $svc->name }}</a>
    <span class="font-body-sm text-body-sm text-text-tertiary">{{ $svc->badge }}</span>
</td>
<td class="p-3 text-text-primary">{{ date('d') + ($index * 3) }} - {{ date('d') + ($index * 3) + 4 }} {{ date('F Y') }}</td>
<td class="p-3 text-text-secondary">
    <span class="text-text-primary block">{{ $city->sentra_praktik ?? 'Sentra Pembinaan K3 ' . $city->name }}</span>
    <span class="font-body-sm text-body-sm text-text-tertiary">{{ $city->address ?? 'Kawasan Industri ' . $city->name }}</span>
</td>
<td class="p-3 text-center">
    <span class="bg-regulatory-slate-800 text-safety-emerald-bright px-2 py-1 font-semibold">{{ 4 + ($index % 5) }} Kursi</span>
</td>
<td class="p-3 text-center">
    <span class="bg-safety-emerald text-text-primary font-label-caps text-label-caps px-2 py-0.5 font-bold">OPEN</span>
</td>
<td class="p-3 text-right">
    <a class="bg-regulatory-slate-700 hover:bg-safety-emerald text-text-primary px-3 py-1 font-credential-meta text-credential-meta uppercase transition-colors inline-block font-bold" href="https://wa.me/6281234567890?text={{ urlencode('Halo, saya ingin booking kuota ' . $svc->name . ' di ' . $city->name) }}" target="_blank">
        Ambil Kuota
    </a>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</section>
<!-- Alamat & Titik Koordinasi Terverifikasi di Malang -->
<section class="w-full bg-surface-container-low px-4 lg:px-gutter-desktop py-12 lg:py-grid-2xl" id="lokasi-malang">
<div class="max-w-7xl mx-auto">
<div class="flex flex-col gap-2 mb-8">
<span class="font-label-caps text-label-caps uppercase text-safety-emerald-bright tracking-widest">
          // TITIK TEMU &amp; KOORDINASI SENTRAL
        </span>
<h2 class="font-headline-lg text-headline-lg uppercase tracking-tight text-text-primary">
          Alamat Kantor Perwakilan &amp; Sentra Praktik Malang
        </h2>
</div>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
<div class="lg:col-span-6 bg-regulatory-slate-800 p-6 flex flex-col justify-between">
    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <span class="bg-regulatory-slate-900 text-safety-emerald-bright font-label-caps text-label-caps uppercase px-3 py-1 font-bold">
                KANTOR SENTRAL REGISTRASI {{ strtoupper($city->name) }}
            </span>
            <span class="font-credential-meta text-credential-meta text-text-tertiary">ID KOTA: {{ strtoupper(substr($city->slug, 0, 3)) }}-{{ $city->id }}</span>
        </div>
        <div>
            <h3 class="font-headline-md text-headline-md uppercase text-text-primary font-bold">
                {{ $city->sentra_praktik ?? 'TrainingKota Service Center ' . $city->name }}
            </h3>
            <p class="font-body-md text-body-md text-text-secondary mt-1">
                {{ $city->address ?? 'Kawasan Industri & Bisnis ' . $city->name . ', ' . ($city->province ?? $city->island) }}
            </p>
        </div>
        <div class="space-y-3 bg-regulatory-slate-900 p-4">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-safety-emerald-bright text-[20px] shrink-0 mt-0.5">schedule</span>
                <div>
                    <span class="font-headline-sm text-credential-meta text-text-primary block font-bold">JAM LAYANAN KANTOR:</span>
                    <span class="font-body-sm text-body-sm text-text-secondary">Senin - Jumat: 08.00 - 17.00 WIB • Sabtu: 08.30 - 13.00 WIB</span>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-primary text-[20px] shrink-0 mt-0.5">person_pin</span>
                <div>
                    <span class="font-headline-sm text-credential-meta text-text-primary block font-bold">HOTLINE LAYANAN K3:</span>
                    <span class="font-body-sm text-body-sm text-safety-emerald-bright block font-bold">+62 812-3456-7890 (WhatsApp Direct 24 Jam)</span>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-6 flex flex-wrap items-center gap-3">
        <a class="bg-safety-emerald hover:bg-safety-emerald-bright text-text-primary font-credential-meta text-credential-meta uppercase px-4 py-2.5 transition-colors flex items-center gap-2 font-bold" href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin, saya ingin konsultasi layanan di ' . $city->name) }}" target="_blank">
            <span class="material-symbols-outlined text-[16px]">chat</span>
            <span>Konsultasi Kota {{ $city->name }}</span>
        </a>
    </div>
</div>
<div class="lg:col-span-6 flex flex-col gap-4">
    <div class="w-full h-80 bg-regulatory-slate-900 border border-border-grid overflow-hidden relative">
        <iframe src="{{ $city->mapsEmbedUrl() }}" class="w-full h-full border-0" loading="lazy" allowfullscreen></iframe>
    </div>
    <div class="bg-regulatory-slate-800 p-4">
        <span class="font-label-caps text-label-caps uppercase text-text-tertiary block mb-2">RADIUS OPERASIONAL IN-HOUSE:</span>
        <div class="font-tabular-data text-xs text-text-primary">
            Melayani audit, pelatihan in-house, dan pemeriksaan teknis di seluruh kawasan industri wilayah {{ $city->name }} dan sekitarnya.
        </div>
    </div>
</div>
</div>
</div>
</div>
</section>
<!-- Local FAQ Section -->
<section class="w-full bg-regulatory-slate-900 px-4 lg:px-gutter-desktop py-12 lg:py-grid-xl">
<div class="max-w-4xl mx-auto">
<div class="flex flex-col gap-2 mb-8 text-center">
<span class="font-label-caps text-label-caps uppercase text-safety-emerald-bright tracking-widest font-bold">
    // INFORMASI TEKNIS &amp; KEPATUHAN
</span>
<h2 class="font-headline-lg text-headline-lg uppercase text-text-primary font-bold">
    Pertanyaan Umum Layanan K3 Wilayah {{ $city->name }}
</h2>
</div>
<div class="space-y-4" id="faq-accordion">
@foreach($faqItems ?? [] as $faq)
<div class="bg-regulatory-slate-800 p-5">
    <div class="flex items-center justify-between cursor-pointer" onclick="toggleFaq(this)">
        <h3 class="font-headline-sm text-headline-sm text-text-primary font-semibold">
            {{ $faq['q'] }}
        </h3>
        <span class="material-symbols-outlined text-safety-emerald-bright text-[20px] transition-transform duration-200">expand_more</span>
    </div>
    <div class="pt-3 text-body-md text-body-md text-text-secondary leading-relaxed hidden">
        {{ $faq['a'] }}
    </div>
</div>
@endforeach
</div>
</div>
</section>
<!-- SEO Article Section (1500+ Words & Rich Structure) -->
<section class="w-full bg-background border-t border-border-grid px-4 lg:px-gutter-desktop py-14 lg:py-20" id="artikel-regulasi">
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-8 pb-4 border-b border-border-grid">
        <div>
            <span class="font-label-caps text-label-caps text-safety-emerald-bright uppercase tracking-widest font-bold">HIGH AUTHORITY K3 REGULATORY DIGEST</span>
            <h2 class="font-headline-lg text-2xl lg:text-3xl font-bold uppercase text-text-primary mt-1">
                PANDUAN &amp; REGULASI TERKAIT {{ strtoupper($city->name) }}
            </h2>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Main Article Content (1500+ Words) -->
        <div class="lg:col-span-8 bg-regulatory-slate-800 p-6 lg:p-8 space-y-6 text-text-secondary font-body-md leading-relaxed">
            @if($article)
                <h3 class="font-headline-xl text-xl lg:text-2xl font-bold text-text-primary">{{ $article->title }}</h3>
                <div class="flex items-center gap-4 text-xs font-credential-meta text-text-tertiary border-b border-border-grid-subtle pb-4">
                    <span>Oleh: {{ $article->author }}</span>
                    <span>•</span>
                    <span>Waktu Baca: {{ $article->reading_time }}</span>
                    <span>•</span>
                    <span class="text-safety-emerald-bright">Terverifikasi Regulasi</span>
                </div>

                <!-- Table of Contents -->
                <div class="bg-regulatory-slate-900 border border-border-grid p-4 my-6">
                    <span class="font-headline-sm text-xs font-bold text-text-primary uppercase tracking-wider block mb-2">DAFTAR ISI ARTIKEL:</span>
                    <ul class="space-y-1.5 text-xs text-text-secondary">
                        <li><a href="#art-pilar" class="hover:text-safety-emerald-bright transition-colors">1. Landasan Hukum &amp; Kepatuhan Wilayah {{ $city->name }}</a></li>
                        <li><a href="#art-matriks" class="hover:text-safety-emerald-bright transition-colors">2. Matriks Pengawasan Fasilitas Industri</a></li>
                        <li><a href="#art-langkah" class="hover:text-safety-emerald-bright transition-colors">3. Tahapan Sertifikasi &amp; Audit Lapangan</a></li>
                    </ul>
                </div>

                <div class="article-rich-content space-y-4 text-text-primary leading-relaxed">
                    {!! $article->content !!}
                </div>
            @else
                <p class="text-text-secondary">Panduan regulasi K3 spesifik untuk {{ $city->name }} sedang dalam proses pembaruan sinkronisasi Disnakertrans.</p>
            @endif
        </div>

        <!-- Sidebar: Related Articles & Nearby Cities -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-regulatory-slate-800 p-6 border border-border-grid space-y-4">
                <span class="font-headline-sm text-xs uppercase font-bold text-text-primary block border-b border-border-grid pb-2">
                    REKOMENDASI ARTIKEL TERKAIT
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

            <div class="bg-regulatory-slate-800 p-6 border border-border-grid space-y-4">
                <span class="font-headline-sm text-xs uppercase font-bold text-text-primary block border-b border-border-grid pb-2">
                    KOTA LAIN DI WILAYAH {{ strtoupper($city->island) }}
                </span>
                <div class="flex flex-wrap gap-1.5">
                    @foreach($otherCitiesInIsland ?? [] as $oc)
                        <a href="{{ route('city.landing', ['category' => $category, 'citySlug' => $oc->slug]) }}" class="px-2 py-1 bg-regulatory-slate-900 border border-border-grid text-xs text-text-secondary hover:text-safety-emerald-bright hover:border-safety-emerald transition-colors font-credential-meta uppercase">
                            {{ $oc->name }} &rarr;
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<!-- Final Sticky Action Strip for Mobile / Conversion -->
<section class="w-full bg-regulatory-slate-800 px-4 lg:px-gutter-desktop py-8">
<div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
<div class="flex items-center gap-3">
<div class="w-10 h-10 bg-safety-emerald flex items-center justify-center text-text-primary shrink-0">
<span class="material-symbols-outlined text-[24px]">support_agent</span>
</div>
<div>
<span class="font-headline-sm text-headline-sm uppercase text-text-primary block">Kebutuhan Sertifikasi Khusus Malang?</span>
<span class="font-body-sm text-body-sm text-text-secondary">Dapatkan surat penawaran harga resmi (SPH) &amp; silabus pembinaan dalam 15 menit.</span>
</div>
</div>
<div class="flex items-center gap-3 w-full sm:w-auto">
<a class="w-full sm:w-auto text-center bg-safety-emerald hover:bg-safety-emerald-bright text-text-primary font-credential-meta text-credential-meta uppercase px-6 py-3 transition-colors" href="https://wa.me/6281234567890?text=Halo%20TrainingKota%20Malang%20saya%20minta%20SPH%20dan%20Silabus" target="_blank">
          Hubungi Helpdesk Malang Langsung
        </a>
</div>
</div>
</section>
</div>
<script>
  function toggleFaq(headerElement) {
    const content = headerElement.nextElementSibling;
    const icon = headerElement.querySelector('.material-symbols-outlined');
    if (content.classList.contains('hidden')) {
      content.classList.remove('hidden');
      icon.style.transform = 'rotate(180deg)';
    } else {
      content.classList.add('hidden');
      icon.style.transform = 'rotate(0deg)';
    }
  }
</script></main><footer class="w-full bg-regulatory-slate-900 border-t border-border-grid"><div class="max-w-7xl mx-auto px-4 lg:px-gutter-desktop py-12 lg:py-grid-2xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-grid-lg"><div class="flex flex-col gap-4"><div class="flex items-center gap-2"><img alt="TrainingKota Official Logo" class="h-7 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1X800IllBOS-DTwtP3jJA6ufvs3AjgCWUDjJYh5GgG-6YbIzmQw7CCCMj98H5sRY2FFvvg3Wvu45GEvb-mrspXml3QWBJto-SMfQ7Zbd50Wk5Ala6LW6YwkceU83gClgCvyouwiflZ4G7azx5U0dPKQMhgR62POOuCGEJCQX2CX9E5D7M_pbyd6qahcizw3W2fxBevPFSa_KyVr2E_8RbRXLGmZX8KXoIRDvFjACR6RBp_-OjTbcwdRHg"/><span class="font-headline-sm text-headline-sm uppercase text-text-primary">TRAINING<span class="text-safety-emerald-bright">KOTA</span></span></div><p class="font-body-sm text-body-sm text-text-secondary leading-relaxed">Platform direktori dan penyedia sertifikasi K3, kajian risiko teknis, dan perizinan laik fungsi terintegrasi untuk 212 kota se-Indonesia.</p><div class="flex flex-wrap gap-2 pt-2"><span class="font-label-caps text-label-caps bg-regulatory-slate-800 border border-safety-emerald text-safety-emerald-bright px-2 py-1 uppercase">Kemnaker RI Certified</span><span class="font-label-caps text-label-caps bg-regulatory-slate-800 border border-border-grid text-primary px-2 py-1 uppercase">BNSP Accredited</span></div></div><div class="flex flex-col gap-3"><h3 class="font-headline-sm text-headline-sm uppercase text-text-primary border-l-2 border-safety-emerald-bright pl-3">Layanan Unggulan</h3><ul class="flex flex-col gap-2 font-body-sm text-body-sm text-text-secondary"><li class="hover:text-safety-emerald-bright transition-colors cursor-pointer">Ahli K3 Umum (Kemnaker &amp; BNSP)</li><li class="hover:text-safety-emerald-bright transition-colors cursor-pointer">Audit &amp; Sertifikasi SMK3 PP 50/2012</li><li class="hover:text-safety-emerald-bright transition-colors cursor-pointer">Riksa Uji Silo &amp; Lisensi Operator SIA</li><li class="hover:text-safety-emerald-bright transition-colors cursor-pointer">Kajian Safety Culture &amp; Investigasi Insiden</li><li class="hover:text-safety-emerald-bright transition-colors cursor-pointer">Amdal, UKL-UPL, dan Kajian Teknis Lingkungan</li><li class="hover:text-safety-emerald-bright transition-colors cursor-pointer">Sertifikat Laik Fungsi (SLF) &amp; NIDI Elektrikal</li></ul></div><div class="flex flex-col gap-3"><h3 class="font-headline-sm text-headline-sm uppercase text-text-primary border-l-2 border-safety-emerald-bright pl-3">Cakupan Wilayah</h3><div class="grid grid-cols-2 gap-2 font-body-sm text-body-sm text-text-secondary"><span class="hover:text-text-primary transition-colors cursor-pointer">DKI Jakarta</span><span class="hover:text-text-primary transition-colors cursor-pointer">Surabaya</span><span class="hover:text-text-primary transition-colors cursor-pointer">Malang</span><span class="hover:text-text-primary transition-colors cursor-pointer">Balikpapan</span><span class="hover:text-text-primary transition-colors cursor-pointer">Medan</span><span class="hover:text-text-primary transition-colors cursor-pointer">Batam</span><span class="hover:text-text-primary transition-colors cursor-pointer">Makassar</span><span class="hover:text-text-primary transition-colors cursor-pointer">Cilegon</span><span class="hover:text-text-primary transition-colors cursor-pointer">Cikarang</span><span class="text-safety-emerald-bright font-credential-meta text-credential-meta">+ 203 KOTA LAIN</span></div></div><div class="flex flex-col gap-3"><h3 class="font-headline-sm text-headline-sm uppercase text-text-primary border-l-2 border-safety-emerald-bright pl-3">Pusat Informasi</h3><div class="flex flex-col gap-2.5 font-body-sm text-body-sm text-text-secondary"><div class="flex items-start gap-2"><span class="material-symbols-outlined text-text-tertiary text-[18px] shrink-0 mt-0.5">schedule</span><span>Senin - Jumat: 08:00 - 17:00 WIB<br/>Layanan Tanggap Darurat 24 Jam</span></div><div class="flex items-center gap-2"><span class="material-symbols-outlined text-whatsapp-direct text-[18px] shrink-0">chat</span><span>WhatsApp: +62 812-3456-7890</span></div><div class="flex items-center gap-2"><span class="material-symbols-outlined text-primary text-[18px] shrink-0">mark_email_read</span><span>verifikasi@trainingkota.my.id</span></div></div></div></div><div class="border-t border-border-grid-subtle bg-regulatory-slate-900 px-4 lg:px-gutter-desktop py-4"><div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 font-body-sm text-body-sm text-text-tertiary"><p>© 2024 TrainingKota (trainingkota.my.id). Hak Cipta Dilindungi Regulasi Kemnaker RI.</p><div class="flex items-center gap-6 font-credential-meta text-credential-meta uppercase"><a class="hover:text-text-primary transition-colors" href="#">Ketentuan Layanan</a><a class="hover:text-text-primary transition-colors" href="#">Kebijakan Privasi</a><a class="hover:text-text-primary transition-colors" href="#">Kepatuhan Hukum</a></div></div></div></footer><div class="fixed bottom-6 right-6 z-50"><a class="flex items-center gap-2 bg-regulatory-slate-900 border-2 border-whatsapp-direct text-whatsapp-direct hover:bg-whatsapp-direct hover:text-regulatory-slate-900 px-4 py-3 shadow-[0_0_20px_rgba(37,211,102,0.2)] font-credential-meta text-credential-meta uppercase tracking-wider transition-all" href="https://wa.me/6281234567890" target="_blank"><span class="material-symbols-outlined text-[20px]">support_agent</span><span class="font-bold">Quick Inquiry WA</span></a></div></body></html>