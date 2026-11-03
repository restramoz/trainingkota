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
                <div class="flex flex-col w-full min-w-0 overflow-x-auto text-slate-300 [&_table]:w-full [&_table]:border-collapse [&_table]:border [&_table]:border-slate-700 [&_table]:my-4 [&_th]:border [&_th]:border-slate-700 [&_th]:bg-slate-800 [&_th]:p-2 [&_th]:overflow-wrap-[anywhere] [&_th]:whitespace-normal [&_td]:border [&_td]:border-slate-700 [&_td]:p-2 [&_td]:overflow-wrap-[anywhere] [&_td]:whitespace-normal">
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
                            @if($article->city_id === null && $article->kecamatan_id === null)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium bg-blue-900/30 text-blue-300 border border-blue-700/50 rounded">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                    Global: Semua Kota & Semua Kecamatan
                                </span>
                            @else
                                {{ $article->city->name ?? 'Nasional' }}
                                @if($article->kecamatan)
                                    <br>→ {{ $article->kecamatan->name }}
                                @endif
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

            <div class="bg-[#0E1726] p-6 rounded-xl border border-[#1E293B]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-[#F1F5F9]">Nano Banana Image Prompts</h3>
                    <button type="button" id="regenerateNanoShowBtn" class="px-3 py-2 text-xs rounded bg-slate-700 hover:bg-slate-600 text-white">Regenerate</button>
                </div>
                <div id="nano-show-status" class="text-xs text-slate-400 mb-3"></div>
                <div id="nano-show-output" class="space-y-3">
                    @php $nano = $article->image_prompts ?? null; @endphp
                    @if(is_array($nano))
                        @if(isset($nano['hero']))
                            <div class="rounded border border-[#1E293B] p-3">
                                <p class="text-sm text-[#F1F5F9] mb-1">{{ $nano['hero']['title'] ?? 'Hero Image' }}</p>
                                <p class="text-xs text-slate-400 mb-2">{{ $nano['hero']['purpose'] ?? '' }} • {{ $nano['hero']['aspect_ratio'] ?? '16:9' }}</p>
                                <textarea readonly rows="5" class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded p-2 text-xs">{{ $nano['hero']['prompt'] ?? '' }}</textarea>
                            </div>
                        @endif
                        @foreach(($nano['supporting'] ?? []) as $idx => $item)
                            <div class="rounded border border-[#1E293B] p-3">
                                <p class="text-sm text-[#F1F5F9] mb-1">{{ $item['title'] ?? 'Supporting Image ' . ($idx + 1) }}</p>
                                <p class="text-xs text-slate-400 mb-2">{{ $item['purpose'] ?? '' }} • {{ $item['aspect_ratio'] ?? '16:9' }}</p>
                                <textarea readonly rows="5" class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded p-2 text-xs">{{ $item['prompt'] ?? '' }}</textarea>
                            </div>
                        @endforeach
                        @if(isset($nano['infographic']))
                            <div class="rounded border border-[#1E293B] p-3">
                                <p class="text-sm text-[#F1F5F9] mb-1">{{ $nano['infographic']['title'] ?? 'Educational Infographic' }}</p>
                                <p class="text-xs text-slate-400 mb-2">{{ $nano['infographic']['purpose'] ?? '' }} • {{ $nano['infographic']['aspect_ratio'] ?? '4:5' }}</p>
                                <textarea readonly rows="5" class="w-full bg-[#070D18] border border-[#1E293B] text-white rounded p-2 text-xs">{{ $nano['infographic']['prompt'] ?? '' }}</textarea>
                            </div>
                        @endif
                    @else
                        <p class="text-sm text-slate-400">Belum ada prompt gambar. Gunakan tombol Regenerate.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('regenerateNanoShowBtn');
    if (!btn) return;
    btn.addEventListener('click', async function () {
        btn.disabled = true;
        btn.innerText = 'Generating...';
        const status = document.getElementById('nano-show-status');
        const output = document.getElementById('nano-show-output');
        status.innerText = 'Membuat prompt gambar Nano Banana...';
        try {
            const response = await fetch('{{ route('admin.articles.generate-image-prompts', $article->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            if (!response.ok || !result.success) {
                status.innerText = 'Gagal: ' + (result.error || JSON.stringify(result));
                return;
            }
            status.innerText = 'Prompt gambar berhasil dibuat. Muat ulang halaman untuk melihat versi tersimpan.';
        } catch (e) {
            status.innerText = 'Koneksi gagal: ' + e;
        } finally {
            btn.disabled = false;
            btn.innerText = 'Regenerate';
        }
    });
});
</script>
@endsection


