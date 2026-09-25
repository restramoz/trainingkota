<!DOCTYPE html>
<html class="dark" lang="id">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0"
    >

    <title>{{ $article->title }} - TrainingKota</title>

    <meta
        name="description"
        content="{{ Str::limit(strip_tags($article->content), 160) }}"
    >

    {{-- =========================================================
         SCHEMA.ORG
    ========================================================== --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Article",
        "headline": @json($article->title),
        "author": {
            "@@type": "Organization",
            "name": @json($article->author ?? 'TrainingKota')
        },
        "publisher": {
            "@@type": "Organization",
            "name": "TrainingKota"
        },
        "datePublished": "{{ $article->created_at ? $article->created_at->toISOString() : date('c') }}",
        "description": @json(Str::limit(strip_tags($article->content), 160))
    }
    </script>


    {{-- =========================================================
         FONTS
    ========================================================== --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet"
    >


    {{-- =========================================================
         TAILWIND
    ========================================================== --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: "class",

            theme: {
                extend: {
                    colors: {
                        "regulatory-slate-800": "#0B1526",
                        "regulatory-slate-900": "#070D18",

                        "background": "#0d131f",
                        "surface": "#0d131f",
                        "surface-dim": "#0d131f",
                        "surface-container": "#1a202b",
                        "surface-container-low": "#161c27",
                        "surface-container-lowest": "#080e19",
                        "surface-container-high": "#242a36",
                        "surface-container-highest": "#2f3541",

                        "border-grid": "#1E324E",
                        "border-grid-subtle": "#142338",

                        "primary": "#b7c7e7",
                        "text-primary": "#F1F5F9",
                        "text-secondary": "#94A3B8",
                        "text-tertiary": "#64748B",

                        "safety-emerald": "#0D7A5F",
                        "safety-emerald-bright": "#10B981",

                        "whatsapp-direct": "#25D366",
                        "caution-amber": "#D97706",

                        "on-primary": "#21314a",
                        "on-surface": "#dde2f3",
                        "on-surface-variant": "#c5c6ce"
                    },

                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },

                    spacing: {
                        "grid-xl": "2rem",
                        "grid-sm": "0.5rem",
                        "gutter-desktop": "1.5rem",
                        "grid-2xs": "0.125rem",
                        "grid-2xl": "3rem",
                        "grid-md": "1rem",
                        "gutter-mobile": "1rem",
                        "grid-lg": "1.5rem",
                        "grid-xs": "0.25rem",
                        "grid-3xl": "4.5rem",
                        "margin-desktop": "3rem",
                        "margin-mobile": "1rem"
                    },

                    fontFamily: {
                        "credential-meta": ["Space Grotesk"],
                        "headline-sm": ["Space Grotesk"],
                        "headline-xl-mobile": ["Space Grotesk"],
                        "headline-lg": ["Space Grotesk"],
                        "body-md": ["IBM Plex Sans"],
                        "headline-lg-mobile": ["Space Grotesk"],
                        "tabular-data": ["IBM Plex Sans"],
                        "headline-xl": ["Space Grotesk"],
                        "body-lg": ["IBM Plex Sans"],
                        "headline-md": ["Space Grotesk"],
                        "label-caps": ["Space Grotesk"],
                        "body-sm": ["IBM Plex Sans"]
                    },

                    fontSize: {
                        "credential-meta": [
                            "12px",
                            {
                                lineHeight: "16px",
                                fontWeight: "600"
                            }
                        ],

                        "headline-sm": [
                            "18px",
                            {
                                lineHeight: "24px",
                                fontWeight: "500"
                            }
                        ],

                        "headline-xl-mobile": [
                            "30px",
                            {
                                lineHeight: "36px",
                                letterSpacing: "-0.01em",
                                fontWeight: "700"
                            }
                        ],

                        "headline-lg": [
                            "32px",
                            {
                                lineHeight: "40px",
                                letterSpacing: "-0.01em",
                                fontWeight: "600"
                            }
                        ],

                        "body-md": [
                            "14px",
                            {
                                lineHeight: "22px",
                                fontWeight: "400"
                            }
                        ],

                        "headline-lg-mobile": [
                            "24px",
                            {
                                lineHeight: "32px",
                                fontWeight: "600"
                            }
                        ],

                        "tabular-data": [
                            "13px",
                            {
                                lineHeight: "18px",
                                fontWeight: "500"
                            }
                        ],

                        "headline-xl": [
                            "40px",
                            {
                                lineHeight: "48px",
                                letterSpacing: "-0.02em",
                                fontWeight: "700"
                            }
                        ],

                        "body-lg": [
                            "16px",
                            {
                                lineHeight: "26px",
                                fontWeight: "400"
                            }
                        ],

                        "headline-md": [
                            "22px",
                            {
                                lineHeight: "28px",
                                fontWeight: "600"
                            }
                        ],

                        "label-caps": [
                            "11px",
                            {
                                lineHeight: "16px",
                                letterSpacing: "0.08em",
                                fontWeight: "700"
                            }
                        ],

                        "body-sm": [
                            "12px",
                            {
                                lineHeight: "18px",
                                fontWeight: "400"
                            }
                        ]
                    }
                }
            }
        };
    </script>


    {{-- =========================================================
         GLOBAL / RESPONSIVE FIX
    ========================================================== --}}
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-width: 0;
            max-width: 100%;
        }

        html {
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        body {
            overflow-x: hidden;
            width: 100%;
            min-height: 100vh;
            overscroll-behavior-y: auto;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        img,
        video,
        iframe,
        embed,
        object {
            max-width: 100%;
        }

        /*
         * ========================================================
         * ARTICLE RICH TEXT
         * ========================================================
         */

        .article-content {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            overflow-wrap: anywhere;
            word-break: normal;
        }

        .article-content > * {
            max-width: 100%;
        }

        .article-content p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        .article-content h1,
        .article-content h2,
        .article-content h3,
        .article-content h4,
        .article-content h5,
        .article-content h6 {
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: normal;
        }

        .article-content img {
            display: block;
            width: auto;
            max-width: 100%;
            height: auto;
        }

        /*
         * Tabel harus scroll sendiri.
         */
        .article-content table {
            width: max-content;
            min-width: 700px;
            max-width: none;
            border-collapse: collapse;
            margin: 1rem 0;
        }

        .article-content th,
        .article-content td {
            border: 1px solid #334155;
            padding: 0.625rem;
            vertical-align: top;
            overflow-wrap: anywhere;
            white-space: normal;
        }

        /*
         * Jika content editor menghasilkan div yang membungkus tabel,
         * jangan biarkan wrapper tersebut memperlebar halaman.
         */
        .article-content table {
            display: flex-wrap;
            
        }

        /*
         * Code/pre jangan membuat halaman horizontal overflow.
         */
        .article-content pre {
            max-width: 100%;
            overflow-x: auto;
            white-space: pre;
        }

        .article-content iframe {
            width: 100%;
            max-width: 100%;
        }

        /*
         * Link panjang / URL panjang.
         */
        .article-content a {
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        /*
         * List tetap berada di dalam container.
         */
        .article-content ul,
        .article-content ol {
            max-width: 100%;
            padding-left: 1.5rem;
        }

        /*
         * Mobile.
         */
        @media (max-width: 1023px) {
            .article-content {
                font-size: 15px;
                line-height: 1.8;
            }

            .article-content table {
                min-width: 700px;
            }
        }

        /*
         * Hilangkan scrollbar visual tetapi tetap bisa scroll.
         */
        ::-webkit-scrollbar {
            width: 0;
            height: 0;
        }
    </style>
</head>


<body class="bg-background font-body-md text-text-primary antialiased selection:bg-safety-emerald selection:text-white">


    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <header class="fixed inset-x-0 top-0 z-50 w-full bg-regulatory-slate-900 border-b border-border-grid">

        {{-- Top information bar --}}
        <div class="h-8 w-full bg-regulatory-slate-800 border-b border-border-grid-subtle px-4 lg:px-gutter-desktop flex items-center justify-between text-text-secondary font-credential-meta text-credential-meta tracking-wider uppercase">

            <div class="flex min-w-0 items-center gap-2">
                <span class="w-1.5 h-1.5 shrink-0 bg-safety-emerald-bright animate-pulse"></span>

                <span class="truncate">
                    Layanan Pembinaan K3 Kemnaker RI, Kajian Teknis, dan Konsultasi Regulasi Nasional — Tersedia di Seluruh Kota Indonesia
                </span>
            </div>

            <div class="hidden md:flex shrink-0 items-center gap-4 text-text-tertiary">
                <span>BNSP &amp; KEMNAKER REGISTRY ID-2024</span>

                <span class="text-border-grid">|</span>

                <span class="flex items-center gap-1 text-safety-emerald-bright">
                    <span class="material-symbols-outlined text-[14px]">verified</span>
                    514 KOTA AKTIF
                </span>
            </div>

        </div>


        {{-- Main header --}}
        <div class="mx-auto flex h-20 w-full max-w-7xl min-w-0 items-center justify-between gap-4 px-4 lg:px-gutter-desktop">

            {{-- Logo --}}
            <div class="flex min-w-0 items-center gap-6">

                <a
                    class="flex shrink-0 items-center gap-3"
                    href="{{ route('home') }}"
                >
                    <img
                        alt="TrainingKota Official Logo"
                        class="h-8 w-auto object-contain"
                        src="https://lh3.googleusercontent.com/aida/AEtjO1X800IllBOS-DTwtP3jJA6ufvs3AjgCWUDjJYh5GgG-6YbIzmQw7CCCMj98H5sRY2FFvvg3Wvu45GEvb-mrspXml3QWBJto-SMfQ7Zbd50Wk5Ala6LW6YwkceU83gClgCvyouwiflZ4G7azx5U0dPKQMhgR62POOuCGEJCQX2CX9E5D7M_pbyd6qahcizw3W2fxBevPFSa_KyVr2E_8RbRXLGmZX8KXoIRDvFjACR6RBp_-OjTbcwdRHg"
                    >
                    <div class="hidden min-w-0 flex-col sm:flex">
                        <span class="font-headline-sm text-headline-sm uppercase text-text-primary tracking-tight">
                            TRAINING<span class="text-safety-emerald-bright">KOTA</span>
                        </span>

                        <span class="font-label-caps text-label-caps text-text-tertiary tracking-widest">
                            K3 &amp; REGULATORY HUB
                        </span>
                    </div>
                </a>


                {{-- Desktop navigation --}}
                <nav class="hidden xl:flex items-center gap-6">
                    <a class="py-2 font-headline-sm text-tabular-data text-on-surface-variant hover:text-text-primary transition-colors" href="{{ route('home') }}">
                        Beranda
                    </a>

                    <a class="py-2 font-headline-sm text-tabular-data text-on-surface-variant hover:text-text-primary transition-colors" href="{{ route('category.show', 'pelatihan') }}">
                        Pelatihan
                    </a>

                    <a class="py-2 font-headline-sm text-tabular-data text-on-surface-variant hover:text-text-primary transition-colors" href="{{ route('category.show', 'kajian') }}">
                        Kajian
                    </a>

                    <a class="py-2 font-headline-sm text-tabular-data text-on-surface-variant hover:text-text-primary transition-colors" href="{{ route('category.show', 'jasa') }}">
                        Jasa
                    </a>

                    <a class="py-2 font-headline-sm text-tabular-data text-on-surface-variant hover:text-text-primary transition-colors" href="{{ route('home') }}#direktori-kota">
                        Kota Layanan
                    </a>

                    <a
                        aria-current="page"
                        class="py-2 text-safety-emerald-bright font-semibold border-b-2 border-safety-emerald-bright"
                        href="{{ route('article.show', 'panduan-sertifikasi-ahli-k3-umum-kemnaker') }}"
                    >
                        Artikel
                    </a>
                </nav>

            </div>


            {{-- Header actions --}}
            <div class="flex shrink-0 items-center gap-2 sm:gap-3">

                <div class="hidden sm:flex items-center bg-regulatory-slate-800 border border-border-grid px-3 py-1.5 text-text-primary font-tabular-data text-tabular-data">
                    <span class="material-symbols-outlined text-safety-emerald-bright text-[18px] mr-2">
                        location_city
                    </span>

                    <span class="text-text-secondary mr-2">
                        Pilih Kota:
                    </span>

                    <span class="font-credential-meta text-credential-meta text-safety-emerald-bright">
                        514 Tersedia
                    </span>

                    <span class="material-symbols-outlined text-text-tertiary text-[18px] ml-2">
                        expand_more
                    </span>
                </div>


                <a
                    class="flex items-center gap-2 bg-regulatory-slate-900 border border-whatsapp-direct text-whatsapp-direct hover:bg-whatsapp-direct hover:text-regulatory-slate-900 font-headline-sm text-credential-meta uppercase px-3 sm:px-4 py-2 transition-all"
                    href="https://wa.me/{{ config('contact.whatsapp') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <span class="material-symbols-outlined text-[18px]">
                        chat
                    </span>

                    <span class="hidden md:inline">
                        Hubungi Kami
                    </span>
                </a>


                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary">
                    <span class="material-symbols-outlined text-on-primary text-[18px]">
                        person
                    </span>
                </div>

            </div>

        </div>

    </header>


    {{-- =========================================================
         MAIN
    ========================================================== --}}
    <main class="w-full min-w-0 max-w-full overflow-x-hidden bg-background pt-28">

        <div class="flex w-full min-w-0 flex-col">


            {{-- =================================================
                 BREADCRUMB
            ================================================== --}}
            <section class="w-full bg-surface-container-lowest py-6">
                <div class="mx-auto w-full max-w-7xl min-w-0 px-4 lg:px-gutter-desktop">

                    <nav
                        aria-label="Breadcrumb"
                        class="flex min-w-0 flex-wrap items-center gap-2 font-credential-meta text-credential-meta uppercase"
                    >
                        <a
                            class="text-text-tertiary hover:text-safety-emerald-bright transition-colors"
                            href="{{ route('home') }}"
                        >
                            Beranda
                        </a>

                        <span class="text-border-grid">/</span>

                        <span class="text-text-tertiary">
                            Artikel &amp; Regulasi K3
                        </span>

                        <span class="text-border-grid">/</span>

                        <span class="max-w-full break-words text-safety-emerald-bright">
                            {{ $article->title }}
                        </span>
                    </nav>

                </div>
            </section>


            {{-- =================================================
                 ARTICLE HERO
            ================================================== --}}
            <section class="w-full bg-surface-dim pt-8 pb-12">

                <div class="mx-auto w-full max-w-7xl min-w-0 px-4 lg:px-gutter-desktop">

                    <div class="mb-6 flex min-w-0 flex-wrap items-center gap-3">

                        <span class="font-label-caps text-label-caps bg-regulatory-slate-800 text-safety-emerald-bright px-3 py-1 uppercase tracking-wider">
                            REGULASI &amp; PERIZINAN GEDUNG (PUPR)
                        </span>

                        <span class="font-label-caps text-label-caps bg-surface-container-high text-primary px-3 py-1 uppercase tracking-wider">
                            PP NO. 16 TAHUN 2021
                        </span>

                        <span class="font-credential-meta text-credential-meta text-caution-amber flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[15px]">
                                verified_user
                            </span>

                            AUDIT STANDAR SIMBG NASIONAL
                        </span>

                    </div>


                    <h1 class="max-w-5xl break-words font-headline-xl text-headline-xl-mobile lg:text-[42px] lg:leading-[50px] text-text-primary mb-6 tracking-tight">
                        {{ $article->title }}
                    </h1>


                    {{-- Metadata --}}
                    <div class="flex min-w-0 flex-col gap-6 bg-surface-container-low p-4 sm:p-6 lg:flex-row lg:items-center lg:justify-between">

                        <div class="flex min-w-0 flex-wrap items-center gap-5 lg:gap-6">

                            <div class="flex min-w-0 items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center bg-surface-container-highest text-safety-emerald-bright">
                                    <span class="material-symbols-outlined text-[20px]">
                                        engineering
                                    </span>
                                </div>

                                <div class="min-w-0">
                                    <p class="font-label-caps text-label-caps text-text-tertiary uppercase">
                                        Ditinjau Teknis Oleh
                                    </p>

                                    <p class="break-words font-headline-sm text-headline-sm text-text-primary">
                                        Tim Ahli Kelaikan Struktur TrainingKota
                                    </p>
                                </div>
                            </div>


                            <div class="hidden sm:block h-8 w-px bg-surface-container-highest"></div>


                            <div>
                                <p class="font-label-caps text-label-caps text-text-tertiary uppercase">
                                    Pembaruan Dokumen
                                </p>

                                <p class="font-tabular-data text-tabular-data text-text-secondary">
                                    Kuartal I 2025 (Terverifikasi)
                                </p>
                            </div>


                            <div class="hidden sm:block h-8 w-px bg-surface-container-highest"></div>


                            <div>
                                <p class="font-label-caps text-label-caps text-text-tertiary uppercase">
                                    Waktu Baca
                                </p>

                                <p class="flex items-center gap-1 font-tabular-data text-tabular-data text-text-secondary">
                                    <span class="material-symbols-outlined text-[16px] text-safety-emerald-bright">
                                        schedule
                                    </span>

                                    8 Menit Kajian
                                </p>
                            </div>

                        </div>


                        <div class="flex shrink-0 items-center gap-3">

                            <a
                                class="flex items-center gap-2 bg-whatsapp-direct text-surface-dim px-4 py-2.5 font-headline-sm text-credential-meta uppercase font-bold hover:bg-safety-emerald-bright transition-colors"
                                href="https://wa.me/?text=Konsultasi%20SLF%20Pabrik%20TrainingKota"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <span class="material-symbols-outlined text-[18px]">
                                    share
                                </span>

                                <span>
                                    Bagikan Ringkasan
                                </span>
                            </a>

                            <button
                                type="button"
                                class="p-2.5 bg-surface-container text-text-secondary hover:text-text-primary transition-colors"
                                id="bookmark-btn"
                                onclick="this.classList.toggle('text-safety-emerald-bright')"
                                title="Simpan Artikel"
                            >
                                <span class="material-symbols-outlined text-[20px]">
                                    bookmark
                                </span>
                            </button>

                        </div>

                    </div>

                </div>

            </section>


            {{-- =================================================
                 ARTICLE BODY
            ================================================== --}}
            <section class="w-full">

                <div class="mx-auto w-full max-w-7xl min-w-0 px-4 py-8 sm:py-12 lg:px-gutter-desktop">

                    {{-- IMPORTANT:
                         w-full + min-w-0 mencegah grid menjadi sempit
                    --}}
                    <div class="grid w-full min-w-0 grid-cols-1 items-start gap-8 lg:grid-cols-12 lg:gap-12">


                        {{-- =================================================
                             ARTICLE
                        ================================================== --}}
                        <article class="w-full min-w-0 overflow-hidden bg-regulatory-slate-800 border border-border-grid p-4 sm:p-6 lg:col-span-8 lg:p-8">


                            {{-- TOC --}}
                            <div class="mb-8 w-full min-w-0 bg-regulatory-slate-900 border border-border-grid p-4">

                                <span class="mb-2 block font-headline-sm text-xs font-bold uppercase tracking-wider text-text-primary">
                                    DAFTAR ISI:
                                </span>

                                <ul class="space-y-1.5 text-xs text-text-secondary">
                                    <li>
                                        <a
                                            href="#art-content"
                                            class="hover:text-safety-emerald-bright transition-colors"
                                        >
                                            1. Tinjauan Regulasi &amp; Dasar Hukum Resmi
                                        </a>
                                    </li>

                                    <li>
                                        <a
                                            href="#art-content"
                                            class="hover:text-safety-emerald-bright transition-colors"
                                        >
                                            2. Parameter &amp; Persyaratan Kepatuhan K3
                                        </a>
                                    </li>
                                </ul>

                            </div>


                            {{-- =================================================
                                 RICH TEXT
                            ================================================== --}}
                            <div
                                id="art-content"
                                class="article-content w-full min-w-0 max-w-full space-y-6 text-text-primary leading-relaxed"
                            >
                                {!! $article->content !!}
                            </div>

                        </article>


                        {{-- =================================================
                             RELATED ARTICLES
                        ================================================== --}}
                        <aside class="w-full min-w-0 lg:col-span-4">

                            <div class="w-full min-w-0 bg-regulatory-slate-800 border border-border-grid p-5 sm:p-6">

                                <span class="block border-b border-border-grid pb-2 font-headline-sm text-xs uppercase font-bold text-text-primary">
                                    ARTIKEL REGULASI TERKAIT
                                </span>

                                <div class="mt-4 space-y-4">

                                    @forelse($relatedArticles ?? [] as $rel)

                                        <article class="min-w-0 space-y-1">

                                            <span class="font-label-caps text-[10px] text-safety-emerald-bright uppercase font-bold">
                                                {{ $rel->category }}
                                            </span>

                                            <a
                                                href="{{ route('article.show', $rel->slug) }}"
                                                class="block break-words font-headline-sm text-xs font-semibold text-text-primary hover:text-safety-emerald-bright transition-colors"
                                            >
                                                {{ $rel->title }}
                                            </a>

                                            <span class="block text-[11px] text-text-tertiary">
                                                {{ $rel->reading_time }}
                                            </span>

                                        </article>

                                    @empty

                                        <p class="text-xs text-text-tertiary">
                                            Belum ada artikel terkait.
                                        </p>

                                    @endforelse

                                </div>

                            </div>

                        </aside>

                    </div>

                </div>

            </section>

        </div>

    </main>


    {{-- =========================================================
         FOOTER
    ========================================================== --}}
    <footer class="w-full bg-regulatory-slate-900 border-t border-border-grid">

        <div class="mx-auto grid w-full max-w-7xl min-w-0 grid-cols-1 gap-8 px-4 py-12 md:grid-cols-2 lg:grid-cols-4 lg:px-gutter-desktop lg:py-grid-2xl lg:gap-grid-lg">

            {{-- Brand --}}
            <div class="flex min-w-0 flex-col gap-4">

                <div class="flex items-center gap-2">
                    <img
                        alt="TrainingKota Official Logo"
                        class="h-7 w-auto object-contain"
                        src="https://lh3.googleusercontent.com/aida/AEtjO1X800IllBOS-DTwtP3jJA6ufvs3AjgCWUDjJYh5GgG-6YbIzmQw7CCCMj98H5sRY2FFvvg3Wvu45GEvb-mrspXml3QWBJto-SMfQ7Zbd50Wk5Ala6LW6YwkceU83gClgCvyouwiflZ4G7azx5U0dPKQMhgR62POOuCGEJCQX2CX9E5D7M_pbyd6qahcizw3W2fxBevPFSa_KyVr2E_8RbRXLGmZX8KXoIRDvFjACR6RBp_-OjTbcwdRHg"
                    >

                    <span class="font-headline-sm text-headline-sm uppercase text-text-primary">
                        TRAINING<span class="text-safety-emerald-bright">KOTA</span>
                    </span>
                </div>

                <p class="font-body-sm text-body-sm text-text-secondary leading-relaxed">
                    Platform direktori dan penyedia sertifikasi K3, kajian risiko teknis,
                    dan perizinan laik fungsi terintegrasi untuk 212 kota se-Indonesia.
                </p>

                <div class="flex flex-wrap gap-2 pt-2">
                    <span class="font-label-caps text-label-caps bg-regulatory-slate-800 border border-safety-emerald text-safety-emerald-bright px-2 py-1 uppercase">
                        Kemnaker RI Certified
                    </span>

                    <span class="font-label-caps text-label-caps bg-regulatory-slate-800 border border-border-grid text-primary px-2 py-1 uppercase">
                        BNSP Accredited
                    </span>
                </div>

            </div>


            {{-- Services --}}
            <div class="flex flex-col gap-3">

                <h3 class="border-l-2 border-safety-emerald-bright pl-3 font-headline-sm text-headline-sm uppercase text-text-primary">
                    Layanan Unggulan
                </h3>

                <ul class="flex flex-col gap-2 font-body-sm text-body-sm text-text-secondary">
                    <li>Ahli K3 Umum (Kemnaker &amp; BNSP)</li>
                    <li>Audit &amp; Sertifikasi SMK3 PP 50/2012</li>
                    <li>Riksa Uji Silo &amp; Lisensi Operator SIA</li>
                    <li>Kajian Safety Culture &amp; Investigasi Insiden</li>
                    <li>Amdal, UKL-UPL, dan Kajian Teknis Lingkungan</li>
                    <li>Sertifikat Laik Fungsi (SLF) &amp; NIDI Elektrikal</li>
                </ul>

            </div>


            {{-- Coverage --}}
            <div class="flex flex-col gap-3">

                <h3 class="border-l-2 border-safety-emerald-bright pl-3 font-headline-sm text-headline-sm uppercase text-text-primary">
                    Cakupan Wilayah
                </h3>

                <div class="grid grid-cols-2 gap-2 font-body-sm text-body-sm text-text-secondary">
                    <span>DKI Jakarta</span>
                    <span>Surabaya</span>
                    <span>Malang</span>
                    <span>Balikpapan</span>
                    <span>Medan</span>
                    <span>Batam</span>
                    <span>Makassar</span>
                    <span>Cilegon</span>
                    <span>Cikarang</span>

                    <span class="font-credential-meta text-credential-meta text-safety-emerald-bright">
                        + 203 KOTA LAIN
                    </span>
                </div>

            </div>


            {{-- Information --}}
            <div class="flex flex-col gap-3">

                <h3 class="border-l-2 border-safety-emerald-bright pl-3 font-headline-sm text-headline-sm uppercase text-text-primary">
                    Pusat Informasi
                </h3>

                <div class="flex flex-col gap-2.5 font-body-sm text-body-sm text-text-secondary">

                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-text-tertiary text-[18px] shrink-0">
                            schedule
                        </span>

                        <span>
                            Senin - Jumat: 08:00 - 17:00 WIB<br>
                            Layanan Tanggap Darurat 24 Jam
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-whatsapp-direct text-[18px] shrink-0">
                            chat
                        </span>

                        <span>
                            WhatsApp: {{ config('contact.display') }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[18px] shrink-0">
                            mark_email_read
                        </span>

                        <span>
                            verifikasi@trainingkota.my.id
                        </span>
                    </div>

                </div>

            </div>

        </div>


        {{-- Footer bottom --}}
        <div class="border-t border-border-grid-subtle bg-regulatory-slate-900 px-4 py-4 lg:px-gutter-desktop">

            <div class="mx-auto flex w-full max-w-7xl min-w-0 flex-col items-center justify-between gap-3 font-body-sm text-body-sm text-text-tertiary sm:flex-row">

                <p class="text-center sm:text-left">
                    © 2024 TrainingKota (trainingkota.my.id). Hak Cipta Dilindungi Regulasi Kemnaker RI.
                </p>

                <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6 font-credential-meta text-credential-meta uppercase">
                    <a href="#" class="hover:text-text-primary transition-colors">
                        Ketentuan Layanan
                    </a>

                    <a href="#" class="hover:text-text-primary transition-colors">
                        Kebijakan Privasi
                    </a>

                    <a href="#" class="hover:text-text-primary transition-colors">
                        Kepatuhan Hukum
                    </a>
                </div>

            </div>

        </div>

    </footer>


    {{-- =========================================================
         FLOATING WHATSAPP
    ========================================================== --}}
    <div class="fixed bottom-4 right-4 z-50 sm:bottom-6 sm:right-6">

        <a
            class="flex items-center gap-2 border-2 border-whatsapp-direct bg-regulatory-slate-900 px-3 py-3 font-credential-meta text-credential-meta uppercase tracking-wider text-whatsapp-direct shadow-[0_0_20px_rgba(37,211,102,0.2)] transition-all hover:bg-whatsapp-direct hover:text-regulatory-slate-900 sm:px-4"
            href="https://wa.me/{{ config('contact.whatsapp') }}"
            target="_blank"
            rel="noopener noreferrer"
        >
            <span class="material-symbols-outlined text-[20px]">
                support_agent
            </span>

            <span class="hidden font-bold sm:inline">
                Quick Inquiry WA
            </span>
        </a>

    </div>

</body>
</html>