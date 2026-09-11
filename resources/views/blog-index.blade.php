@extends('layouts.app')

@section('meta_seo')
<title>{{ $title }}</title>
<meta name="description" content="{{ $meta_description }}">
<link rel="canonical" href="{{ url()->current() }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $meta_description }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
@endsection

@section('content')
<div class="bg-[#070D18] min-h-screen pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <h1 class="text-4xl md:text-5xl font-space font-bold text-white mb-4">
                Blog <span class="text-[#10B981]">&amp;</span> Wawasan K3
            </h1>
            <p class="text-[#94A3B8] max-w-2xl mx-auto text-lg">
                Eksplorasi panduan teknis, regulasi terbaru, dan artikel edukasi untuk meningkatkan standar keselamatan kerja di industri.
            </p>
        </div>

        <!-- Filter & Search Bar -->
        <div class="flex flex-col md:flex-row gap-4 mb-10 items-center justify-between bg-[#0F2038] p-4 rounded-xl border border-[#1E324E]">
            <div class="flex flex-wrap justify-center gap-2">
                <a href="{{ route('blog.index') }}" 
                   class="px-4 py-2 rounded-full text-xs font-space font-semibold transition-all {{ !$category ? 'bg-[#10B981] text-white' : 'bg-[#1E324E] text-[#94A3B8] hover:bg-[#2A3F5F]' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat]) }}" 
                       class="px-4 py-2 rounded-full text-xs font-space font-semibold transition-all {{ $category == $cat ? 'bg-[#10B981] text-white' : 'bg-[#1E324E] text-[#94A3B8] hover:bg-[#2A3F5F]' }}">
                        {{ ucfirst($cat) }}
                    </a>
                @endforeach
            </div>

            <form action="{{ route('blog.index') }}" method="GET" class="relative w-full md:w-64">
                <input type="text" name="search" value="{{ $search }}" 
                       placeholder="Cari artikel..." 
                       class="w-full bg-[#070D18] border border-[#1E324E] text-white text-sm rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#10B981] transition-all">
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-[#94A3B8] hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 0114 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- Articles Grid -->
        @if($articles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $article)
                    <article class="group bg-[#0F2038] border border-[#1E324E] rounded-2xl overflow-hidden hover:border-[#10B981] transition-all duration-300 hover:-translate-y-1 flex flex-col">
                        <!-- Thumbnail -->
                        <div class="relative h-48 overflow-hidden bg-[#1E324E]">
                            @if($article->thumbnail)
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-[#475569]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-[#10B981] text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">
                                    {{ $article->category }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex items-center gap-2 text-xs text-[#64748B] mb-3">
                                <span>{{ \Carbon\Carbon::parse($article->created_at)->format('d M Y') }}</span>
                                <span>&bull;</span>
                                <span>{{ $article->reading_time ?? '5' }} min read</span>
                            </div>
                            <h3 class="text-xl font-space font-bold text-white mb-3 group-hover:text-[#10B981] transition-colors line-clamp-2">
                                {{ $article->title }}
                            </h3>
                            <p class="text-[#94A3B8] text-sm line-clamp-3 mb-6 flex-grow">
                                {{ $article->excerpt }}
                            </p>
                            <a href="{{ route('article.show', $article->slug) }}" 
                               class="inline-flex items-center text-[#10B981] text-sm font-bold hover:text-white transition-colors group/link">
                                Baca Selengkapnya 
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $articles->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20 bg-[#0F2038] rounded-3xl border border-dashed border-[#1E324E]">
                <div class="mb-4 flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-[#1E324E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12v6m-6 6h12" />
                    </svg>
                </div>
                <h3 class="text-xl font-space font-bold text-white mb-2">Tidak Ada Artikel</h3>
                <p class="text-[#94A3B8]">Kami tidak menemukan artikel yang sesuai dengan kriteria pencarian atau kategori Anda.</p>
                <a href="{{ route('blog.index') }}" class="inline-block mt-6 px-6 py-2 bg-[#10B981] text-white rounded-lg font-semibold hover:bg-[#0D7A5F] transition-colors">
                    Lihat Semua Artikel
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

