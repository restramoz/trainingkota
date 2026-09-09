@extends('admin.layout')

@section('title', 'Detail Artikel')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.articles.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg transition">
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-[#F1F5F9]">Detail Artikel</h1>
        </div>
        <a href="{{ route('admin.articles.edit', $article->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
            Edit Artikel
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-[#0E1726] p-6 rounded-xl border border-[#1E293B]">
                <h2 class="text-xl font-bold text-[#F1F5F9] mb-4">{{ $article->title }}</h2>
                <div class="prose prose-invert max-w-none text-slate-300">
                    {!! $article->content !!}
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-[#0E1726] p-6 rounded-xl border border-[#1E293B]">
                <h3 class="text-lg font-semibold text-[#F1F5F9] mb-4">Informasi Artikel</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs text-slate-500 uppercase font-bold">Kategori</label>
                        <p class="text-sm text-slate-300">{{ ucfirst($article->category) }}</p>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 uppercase font-bold">Status</label>
                        <p class="text-sm text-slate-300">
                            @if($article->status == 'published')
                                <span class="text-green-400">Published</span>
                            @else
                                <span class="text-yellow-400">Draft</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 uppercase font-bold">Target Geografis</label>
                        <p class="text-sm text-slate-300">
                            {{ $article->city->name ?? 'Nasional' }}
                            @if($article->kecamatan)
                                <br>→ {{ $article->kecamatan->name }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-[#0E1726] p-6 rounded-xl border border-[#1E293B]">
                <h3 class="text-lg font-semibold text-[#F1F5F9] mb-4">SEO Metadata</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs text-slate-500 uppercase font-bold">SEO Title</label>
                        <p class="text-sm text-slate-300">{{ $article->seo_title ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 uppercase font-bold">SEO Description</label>
                        <p class="text-sm text-slate-300">{{ $article->meta_description ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 uppercase font-bold">Focus Keywords</label>
                        <p class="text-sm text-slate-300">{{ $article->focus_keywords ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

