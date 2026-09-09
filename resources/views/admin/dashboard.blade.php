@extends('admin.layout')

@section('title', 'Portal CMS Nasional K3 - Dashboard Super Admin')

@section('content')
<style>[x-cloak] { display: none !important; }</style>
<div class="p-6">
    <h1 class="text-2xl font-bold uppercase">PORTAL CMS NASIONAL</h1>
</div>

<div x-data="{
    activeTab: '{{ request('tab', $activeTab ?? 'services') }}',
    editingService: null,
    editingCity: null,
    addingService: false,
    editingArticle: null,

    closeAllModals() { 
        this.addingService = false; 
        this.editingCity = null; 
        this.editingService = null; 
        this.editingArticle = null; 
    },
    setEditingService(data) { this.closeAllModals(); this.editingService = data; },
    setEditingCity(data) { this.closeAllModals(); this.editingCity = data; },
    setEditingArticle(data) { this.closeAllModals(); this.editingArticle = data; },

    async generateAiArticle() {
        const btn = this.$refs.aiGenBtn;
        const originalText = btn.innerText;
        btn.disabled = true;
        btn.innerText = 'GENERATING...';

        const payload = {
            service_id: document.getElementById('ai_service_select').value,
            city_id: document.getElementById('ai_city_select').value,
            kecamatan_id: document.getElementById('ai_kecamatan_select')?.value || null,
            category: document.getElementById('ai_category_select').value,
            topic: document.getElementById('ai_topic').value,
            target_keyword: document.getElementById('ai_keyword').value,
            word_count: document.getElementById('ai_word_count').value,
            tone: document.getElementById('ai_tone').value,
            additional_instructions: document.getElementById('ai_instructions').value,
        };

        try {
            const response = await fetch('{{ route('admin.articles.ai-generate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (result.success) {
                const params = new URLSearchParams({
                    ...payload,
                    title: result.title,
                    slug: result.slug,
                    excerpt: result.excerpt || '',
                    content: result.content,
                    seo_title: result.seo_title || '',
                    meta_description: result.meta_description || '',
                    focus_keywords: result.focus_keywords || '',
                });
                window.location.href = '{{ route('admin.articles.ai-preview') }}?' + params.toString();
            } else {
                alert('AI Error: ' + result.error);
            }
        } catch (e) {
            alert('Connection failed. Please try again.');
        } finally {
            btn.disabled = false;
            btn.innerText = originalText;
        }
    },
}" class="min-h-screen bg-[#070D18] text-[#F1F5F9] font-sans antialiased pb-12">

    <!-- ── Alert ──────────────────────────────────────────────────────── -->
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 lg:px-8 mt-4">
        <div class="bg-[#0B1526] border border-[#0D7A5F] border-l-4 border-l-[#10B981] p-3.5 flex items-center justify-between text-xs text-[#10B981] font-space">
            <div class="flex items-center gap-2 font-semibold uppercase tracking-wide">
                <span>[ STATUS SUCCESS ]</span>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-[#94A3B8] hover:text-white text-lg leading-none">&times;</button>
        </div>
    </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-6 space-y-6">

        <!-- ── STAT METRICS (CLEANED) ────────────────────────────────────────────── -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-9 gap-2">
            <div class="bg-[#0B1526] border border-[#1E324E] p-3 hover:border-[#0D7A5F] transition">
                <div class="text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider">Total Layanan</div>
                <div class="text-xl font-bold text-[#F1F5F9] mt-1 font-space">{{ $stats['total_services'] ?? 0 }}</div>
            </div>
            <div class="bg-[#0B1526] border border-[#1E324E] p-3 hover:border-[#0D7A5F] transition">
                <div class="text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider">Pelatihan</div>
                <div class="text-xl font-bold text-[#10B981] mt-1 font-space">{{ $stats['total_pelatihan'] ?? 0 }}</div>
            </div>
            <div class="bg-[#0B1526] border border-[#1E324E] p-3 hover:border-[#0D7A5F] transition">
                <div class="text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider">Kajian K3</div>
                <div class="text-xl font-bold text-[#38BDF8] mt-1 font-space">{{ $stats['total_kajian'] ?? 0 }}</div>
            </div>
            <div class="bg-[#0B1526] border border-[#1E324E] p-3 hover:border-[#0D7A5F] transition">
                <div class="text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider">Jasa Teknis</div>
                <div class="text-xl font-bold text-[#F59E0B] mt-1 font-space">{{ $stats['total_jasa'] ?? 0 }}</div>
            </div>
            <div class="bg-[#0B1526] border border-[#1E324E] p-3 hover:border-[#0D7A5F] transition">
                <div class="text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider">Kota Tercover</div>
                <div class="text-xl font-bold text-[#10B981] mt-1 font-space">{{ $stats['cities_with_locations'] ?? 0 }}</div>
            </div>
            <div class="bg-[#0B1526] border border-[#1E324E] p-3 hover:border-[#0D7A5F] transition">
                <div class="text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider">Kota Belum</div>
                <div class="text-xl font-bold text-[#F59E0B] mt-1 font-space">{{ $stats['cities_without_locations'] ?? 0 }}</div>
            </div>
            <div class="bg-[#0B1526] border border-[#1E324E] p-3 hover:border-[#0D7A5F] transition">
                <div class="text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider">Lokasi Incomplete</div>
                <div class="text-xl font-bold text-[#EF4444] mt-1 font-space">{{ $stats['incomplete_locations'] ?? 0 }}</div>
            </div>
            <div class="bg-[#0B1526] border border-[#1E324E] p-3 hover:border-[#0D7A5F] transition">
                <div class="text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider">Total Artikel</div>
                <div class="text-xl font-bold text-[#7cd8b8] mt-1 font-space">{{ $stats['total_articles'] ?? 0 }}</div>
            </div>
            <div class="bg-[#0B1526] border border-[#1E324E] p-3 hover:border-[#0D7A5F] transition">
                <div class="text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider">Status Pub/Draft</div>
                <div class="text-sm font-bold text-[#F1F5F9] mt-1 font-space">{{ $stats['published_articles'] ?? 0 }}<span class="text-[#64748B] mx-1">/</span>{{ $stats['draft_articles'] ?? 0 }}</div>
            </div>
        </div>

        <!-- ── TAB NAVIGATION (CLEANED) ────────────────────────────────────────── -->
        <div class="bg-[#0F2038] border border-[#1E324E] overflow-x-auto">
            <div class="flex min-w-max p-1 space-x-1 font-space text-xs uppercase">
                <button @click="activeTab = 'services'"
                    :class="activeTab === 'services' ? 'bg-[#0D7A5F] text-white font-bold' : 'text-[#94A3B8] hover:text-white hover:bg-[#142338]'"
                    class="px-4 py-2.5 transition tracking-wider whitespace-nowrap">
                    1. Katalog Layanan ({{ $stats['total_services'] ?? 0 }})
                </button>
                <button @click="activeTab = 'cities'"
                    :class="activeTab === 'cities' ? 'bg-[#0D7A5F] text-white font-bold' : 'text-[#94A3B8] hover:text-white hover:bg-[#142338]'"
                    class="px-4 py-2.5 transition tracking-wider whitespace-nowrap">
                    2. Direktori Wilayah ({{ $stats['total_cities'] ?? 0 }})
                </button>
                <button @click="activeTab = 'articles'"
                    :class="activeTab === 'articles' ? 'bg-[#0D7A5F] text-white font-bold' : 'text-[#94A3B8] hover:text-white hover:bg-[#142338]'"
                    class="px-4 py-2.5 transition tracking-wider whitespace-nowrap">
                    3. Artikel SEO ({{ $stats['total_articles'] ?? 0 }})
                </button>
            </div>
                <button @click=\"activeTab = 'coverage'\"\n                    :class=\"activeTab === 'coverage' ? 'bg-[#0D7A5F] text-white font-bold' : 'text-[#94A3B8] hover:text-white hover:bg-[#142338]'\"\n                    class=\"px-4 py-2.5 transition tracking-wider whitespace-nowrap\">\n                    4. Coverage Wilayah ({{ count($coverageStats) }})\n                </button>

        </div>

        <!-- ══════════════════════════════════════════════════════════════
             TAB 1: MANAJEMEN LAYANAN
             ══════════════════════════════════════════════════════════════ -->
        <div x-show="activeTab === 'services'" class="space-y-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-[#0B1526] p-4 border border-[#1E324E]">
                <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                    <input type="hidden" name="tab" value="services">
                    <input type="text" name="search_service" value="{{ request('search_service', $search ?? '') }}" placeholder="Cari nama atau slug..."
                        class="bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-3 py-2 text-xs font-sans focus:border-[#0D7A5F] outline-none h-10 w-48">
                    <select name="filter_category" class="bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-3 py-2 text-xs font-sans focus:border-[#0D7A5F] outline-none h-10">
                        <option value="">Semua Kategori</option>
                        <option value="pelatihan" {{ request('filter_category', $categoryFilter ?? '') == 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                        <option value="kajian" {{ request('filter_category', $categoryFilter ?? '') == 'kajian' ? 'selected' : '' }}>Kajian K3</option>
                        <option value="jasa" {{ request('filter_category', $categoryFilter ?? '') == 'jasa' ? 'selected' : '' }}>Jasa Teknis</option>
                    </select>
                    <button type="submit" class="bg-[#0F2038] hover:bg-[#142338] border border-[#1E324E] text-[#F1F5F9] px-4 py-2 text-xs font-space font-medium uppercase h-10 transition">Filter</button>
                </form>
                <button @click="setEditingService(null); setEditingCity(null); addingService = true" class="bg-[#0D7A5F] hover:bg-[#10B981] text-white font-space font-medium text-xs px-5 py-2.5 uppercase tracking-wider h-10 transition shrink-0">
                    + Tambah Layanan K3
                </button>
            </div>

            <div class="bg-[#0B1526] border border-[#1E324E] overflow-x-auto">
                <table class="w-full text-left text-xs font-sans border-collapse">
                    <thead class="bg-[#0F2038] border-b border-[#1E324E] text-[#94A3B8] font-space uppercase text-[11px] tracking-wider">
                        <tr>
                            <th class="p-3"># ID</th>
                            <th class="p-3">Kategori</th>
                            <th class="p-3">Nama Layanan</th>
                            <th class="p-3 hidden sm:table-cell">Badge / Akreditasi</th>
                            <th class="p-3 hidden md:table-cell">Durasi</th>
                            <th class="p-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#142338]">
                        @forelse($services as $service)
                        <tr class="bg-[#070D18] hover:bg-[#0B1526] transition">
                            <td class="p-3 font-space text-[#64748B]">#{{ $service->id }}</td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 text-[10px] font-space uppercase border font-semibold
                                    {{ ($service->category ?? '') == 'pelatihan' ? 'border-[#0D7A5F] text-[#10B981] bg-[#0B1526]' : '' }}
                                    {{ ($service->category ?? '') == 'kajian' ? 'border-[#38BDF8] text-[#38BDF8] bg-[#0B1526]' : '' }}
                                    {{ ($service->category ?? '') == 'jasa' ? 'border-[#D97706] text-[#F59E0B] bg-[#0B1526]' : '' }}">
                                    {{ $service->category }}
                                </span>
                            </td>
                            <td class="p-3 font-medium text-[#F1F5F9]">
                                <a href="{{ route('service.detail', ['category' => $service->category, 'serviceSlug' => $service->slug]) }}" target="_blank" class="hover:text-[#10B981] flex items-center gap-1 font-space">
                                    {{ $service->title ?? $service->name }}
                                    <span class="text-[10px] text-[#64748B]">&nearr;</span>
                                </a>
                                <span class="text-[10px] text-[#64748B] font-space block">/{{ $service->slug }}</span>
                            </td>
                            <td class="p-3 text-[#c5c6ce] font-space hidden sm:table-cell">{{ $service->certification ?? $service->badge ?? '-' }}</td>
                            <td class="p-3 text-[#94A3B8] font-space hidden md:table-cell">{{ $service->duration ?? '-' }}</td>
                            <td class="p-3 text-right space-x-2 font-space">
                                <button @click="setEditingService({{ json_encode($service) }})" class="text-[#38BDF8] hover:underline">Edit</button>
                                <form method="POST" action="{{ route('admin.services.delete', $service->id) }}" class="inline" onsubmit="return confirm('Hapus layanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[#ffb4ab] hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="p-4 text-center text-[#94A3B8] font-space">Tidak ada data layanan ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($services, 'links'))
            <div class="mt-4 font-space text-xs">{{ $services->appends(request()->query())->links() }}</div>
            @endif
        </div>

        <!-- ══════════════════════════════════════════════════════════════
             TAB 2: DIREKTORI WILAYAH & HUB
             ══════════════════════════════════════════════════════════════ -->
        <div x-show="activeTab === 'cities'" class="space-y-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-[#0B1526] p-4 border border-[#1E324E]">
                <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                    <input type="hidden" name="tab" value="cities">
                    <input type="text" name="search_city" value="{{ request('search_city', $citySearch ?? '') }}" placeholder="Cari kota / alamat..."
                        class="bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-3 py-2 text-xs font-sans focus:border-[#0D7A5F] outline-none h-10 w-48">
                    <select name="filter_island" class="bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-3 py-2 text-xs font-sans focus:border-[#0D7A5F] outline-none h-10">
                        <option value="">Semua Pulau</option>
                        @foreach(['Jawa', 'Sumatera', 'Kalimantan', 'Sulawesi', 'Bali & Nusa Tenggara', 'Maluku & Papua'] as $isl)
                            <option value="{{ $isl }}" {{ request('filter_island', $islandFilter ?? '') == $isl ? 'selected' : '' }}>{{ $isl }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-[#0F2038] hover:bg-[#142338] border border-[#1E324E] text-[#F1F5F9] px-4 py-2 text-xs font-space font-medium uppercase h-10 transition">Filter</button>
                </form>
            </div>

            <div class="bg-[#0B1526] border border-[#1E324E] overflow-x-auto">
                <table class="w-full text-left text-xs font-sans border-collapse">
                    <thead class="bg-[#0F2038] border-b border-[#1E324E] text-[#94A3B8] font-space uppercase text-[11px] tracking-wider">
                        <tr>
                            <th class="p-3"># ID</th>
                            <th class="p-3">Kota / Kabupaten</th>
                            <th class="p-3 hidden sm:table-cell">Provinsi / Island</th>
                            <th class="p-3 hidden md:table-cell">Alamat / Koordinat</th>
                            <th class="p-3">Status Hub</th>
                            <th class="p-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#142338]">
                        @forelse($cities as $city)
                        <tr class="bg-[#070D18] hover:bg-[#0B1526] transition">
                            <td class="p-3 font-space text-[#64748B]">#{{ $city->id }}</td>
                            <td class="p-3 font-medium text-[#F1F5F9]">
                                <a href="{{ route('city.landing', ['category' => 'pelatihan', 'citySlug' => $city->slug]) }}" target="_blank" class="hover:text-[#10B981] flex items-center gap-1 font-space">
                                    {{ $city->name }}<span class="text-[10px] text-[#64748B]">&nearr;</span>
                                </a>
                            </td>
                            <td class="p-3 text-[#94A3B8] font-space hidden sm:table-cell">{{ $city->province ?? '-' }} ({{ $city->island ?? '-' }})</td>
                            <td class="p-3 hidden md:table-cell">
                                <span class="text-[#94A3B8] text-[10px] block">{{ $city->address ?? 'Belum diisi' }}</span>
                                @if($city->lat && $city->lng)
                                <span class="text-[#64748B] text-[10px] font-mono">{{ $city->lat }}, {{ $city->lng }}</span>
                                @endif
                            </td>
                            <td class="p-3">
                                @if($city->is_hub)
                                    <span class="px-2 py-0.5 text-[10px] font-space uppercase border border-[#0D7A5F] text-[#10B981] bg-[#0B1526] font-bold">&#9733; HUB</span>
                                @else
                                    <span class="text-[#64748B] font-space text-[10px]">Cabang</span>
                                @endif
                            </td>
                            <td class="p-3 text-right font-space">
                                <button @click="setEditingCity({{ json_encode($city) }})" class="text-[#38BDF8] hover:underline text-xs">Edit</button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="p-4 text-center text-[#94A3B8] font-space">Tidak ada data wilayah ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($cities, 'links'))
            <div class="mt-4 font-space text-xs">{{ $cities->appends(request()->query())->links() }}</div>
            @endif
        </div>

        <!-- ══════════════════════════════════════════════════════════════
             TAB 3: MANAJEMEN ARTIKEL SEO
             ══════════════════════════════════════════════════════════════ -->
        <div x-show="activeTab === 'articles'" class="space-y-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-[#0B1526] p-4 border border-[#1E324E]">
                <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                    <input type="hidden" name="tab" value="articles">
                    <input type="text" name="article_q" value="{{ request('article_q', $articleSearch ?? '') }}" placeholder="Cari judul atau keyword..."
                        class="bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-3 py-2 text-xs font-sans focus:border-[#0D7A5F] outline-none h-10 w-48">
                    <select name="article_category" class="bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-3 py-2 text-xs font-sans focus:border-[#0D7A5F] outline-none h-10">
                        <option value="">Semua Kategori</option>
                        <option value="pelatihan" {{ request('article_category', $articleCategoryFilter ?? '') == 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                        <option value="kajian" {{ request('article_category', $articleCategoryFilter ?? '') == 'kajian' ? 'selected' : '' }}>Kajian K3</option>
                        <option value="jasa" {{ request('article_category', $articleCategoryFilter ?? '') == 'jasa' ? 'selected' : '' }}>Jasa Teknis</option>
                    </select>
                    <button type="submit" class="bg-[#0F2038] hover:bg-[#142338] border border-[#1E324E] text-[#F1F5F9] px-4 py-2 text-xs font-space font-medium uppercase h-10 transition">Filter</button>
                </form>
                <a href="{{ route('admin.articles.create') }}" class="bg-[#0D7A5F] hover:bg-[#10B981] text-white font-space font-medium text-xs px-5 py-2.5 uppercase tracking-wider h-10 transition flex items-center shrink-0">
                    + Tambah Artikel Baru
                </a>
            </div>

            <!-- AI Generation Engine -->
            <div id="ai-generator-section" class="bg-[#0B1526] border border-[#1E324E] rounded-lg overflow-hidden">
                <div class="px-4 py-3 border-b border-[#1E324E] bg-[#0F2038] flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-[#10B981] animate-pulse"></span>
                        <span class="font-space text-xs font-bold uppercase tracking-wider text-[#CBD5E1]">AI Article Generator (Gemma 4)</span>
                    </div>
                    <span class="text-[10px] text-[#64748B] font-mono">B2B CONTENT ENGINE</span>
                </div>
                <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-3">
                        <div>
                            <label class="block font-space text-[9px] uppercase text-[#64748B] mb-1">Layanan *</label>
                            <select id="ai_service_select" class="w-full h-9 bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-2 text-xs outline-none focus:border-[#0D7A5F]">
                                <option value="">-- Pilih Layanan --</option>
                                @foreach($allServices as $s)
                                    <option value="{{ $s->id }}" data-category="{{ $s->category }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-space text-[9px] uppercase text-[#64748B] mb-1">Kategori *</label>
                            <select id="ai_category_select" class="w-full h-9 bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-2 text-xs outline-none focus:border-[#0D7A5F]">
                                <option value="pelatihan">Pelatihan</option>
                                <option value="kajian">Kajian</option>
                                <option value="jasa">Jasa</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-space text-[9px] uppercase text-[#64748B] mb-1">Kota Target *</label>
                            <select id="ai_city_select" class="w-full h-9 bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-2 text-xs outline-none focus:border-[#0D7A5F]">
                                <option value="">-- Pilih Kota --</option>
                                @foreach($allCities as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block font-space text-[9px] uppercase text-[#64748B] mb-1">Topik / Judul Spesifik</label>
                            <input type="text" id="ai_topic" placeholder="Misal: Panduan Sertifikasi K3 Kimia" class="w-full h-9 bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-2 text-xs outline-none focus:border-[#0D7A5F]">
                        </div>
                        <div>
                            <label class="block font-space text-[9px] uppercase text-[#64748B] mb-1">Target Keyword</label>
                            <input type="text" id="ai_keyword" placeholder="keyword utama, kota, layanan" class="w-full h-9 bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-2 text-xs outline-none focus:border-[#0D7A5F]">
                        </div>
                        <div>
                            <label class="block font-space text-[9px] uppercase text-[#64748B] mb-1">Kecamatan (Opsional)</label>
                            <select id="ai_kecamatan_select" class="w-full h-9 bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-2 text-xs outline-none focus:border-[#0D7A5F]">
                                <option value="">-- Lewati --</option>
                                @foreach($kecamatans as $k)
                                    <option value="{{ $k->id }}">{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block font-space text-[9px] uppercase text-[#64748B] mb-1">Panjang (Kata)</label>
                                <input type="number" id="ai_word_count" value="1500" class="w-full h-9 bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-2 text-xs outline-none focus:border-[#0D7A5F]">
                            </div>
                            <div>
                                <label class="block font-space text-[9px] uppercase text-[#64748B] mb-1">Nada Bahasa</label>
                                <input type="text" id="ai_tone" value="Professional B2B" class="w-full h-9 bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-2 text-xs outline-none focus:border-[#0D7A5F]">
                            </div>
                        </div>
                        <div>
                            <label class="block font-space text-[9px] uppercase text-[#64748B] mb-1">Instruksi Tambahan</label>
                            <textarea id="ai_instructions" rows="1" placeholder="Catatan khusus untuk AI..." class="w-full h-14 bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-2 py-1 text-xs outline-none focus:border-[#0D7A5F] resize-none"></textarea>
                        </div>
                        <button @click="generateAiArticle()" x-ref="aiGenBtn" class="w-full h-10 bg-[#0D7A5F] hover:bg-[#10B981] text-white font-space font-bold text-[10px] uppercase tracking-widest transition rounded-sm flex items-center justify-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Generate & Review Article
                        </button>
                    </div>
                </div>
            </div>

            <!-- Articles Table -->
            <div class="bg-[#0B1526] border border-[#1E324E] overflow-x-auto">
                <table class="w-full text-left text-xs font-sans border-collapse">
                    <thead class="bg-[#0F2038] border-b border-[#1E324E] text-[#94A3B8] font-space uppercase text-[11px] tracking-wider">
                        <tr>
                            <th class="p-3"># ID</th>
                            <th class="p-3">Judul Artikel</th>
                            <th class="p-3 hidden sm:table-cell">Kategori</th>
                            <th class="p-3 hidden md:table-cell">Kota Target</th>
                            <th class="p-3 hidden lg:table-cell">Reading Time</th>
                            <th class="p-3">Status</th>
                            <th class="p-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#142338]">
                        @forelse($articles as $article)
                        <tr class="bg-[#070D18] hover:bg-[#0B1526] transition">
                            <td class="p-3 font-space text-[#64748B]">#{{ $article->id }}</td>
                            <td class="p-3">
                                <a href="{{ route('article.show', $article->slug) }}" target="_blank" class="font-space font-medium text-[#F1F5F9] hover:text-[#10B981] flex items-center gap-1">
                                    {{ Str::limit($article->title, 55) }}
                                    <span class="text-[10px] text-[#64748B]">&nearr;</span>
                                </a>
                                <span class="text-[10px] text-[#64748B] font-space block">/artikel/{{ $article->slug }}</span>
                            </td>
                            <td class="p-3 hidden sm:table-cell">
                                @if($article->category)
                                <span class="px-2 py-0.5 text-[10px] font-space uppercase border font-semibold
                                    {{ $article->category == 'pelatihan' ? 'border-[#0D7A5F] text-[#10B981] bg-[#0B1526]' : '' }}
                                    {{ $article->category == 'kajian' ? 'border-[#38BDF8] text-[#38BDF8] bg-[#0B1526]' : '' }}
                                    {{ $article->category == 'jasa' ? 'border-[#D97706] text-[#F59E0B] bg-[#0B1526]' : '' }}">
                                    {{ $article->category }}
                                </span>
                                @else
                                <span class="text-[#64748B] text-[10px]">Generic</span>
                                @endif
                            </td>
                            <td class="p-3 hidden md:table-cell font-space text-[#10B981] text-[11px]">
                                {{ $article->city?->name ?? '— Semua Kota' }}
                            </td>
                            <td class="p-3 hidden lg:table-cell text-[#94A3B8] font-space">{{ $article->reading_time ?? '-' }} mnt</td>
                            <td class="p-3">
                                @if($article->status === 'published')
                                <span class="px-2 py-0.5 text-[10px] font-space uppercase border border-[#0D7A5F] text-[#10B981] bg-[#0B1526] font-bold">LIVE</span>
                                @else
                                <span class="px-2 py-0.5 text-[10px] font-space uppercase border border-[#D97706] text-[#F59E0B] bg-[#0B1526]">DRAFT</span>
                                @endif
                            </td>
                            <td class="p-3 text-right space-x-2 font-space">
                                <a href="{{ route('admin.articles.edit', $article->id) }}" class="text-[#38BDF8] hover:underline text-xs">Edit</a>
                                <form method="POST" action="{{ route('admin.articles.destroy', $article->id) }}" class="inline" onsubmit="return confirm('Hapus artikel ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[#ffb4ab] hover:underline text-xs">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="p-6 text-center text-[#94A3B8] font-space">
                            Belum ada artikel.
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($articles, 'links'))
            <div class="mt-4 font-space text-xs">{{ $articles->appends(request()->query())->links() }}</div>
            @endif
        </div>

    </div><!-- /.max-w-7xl -->

    <!-- ══════════════════════════════════════════════════════════════════
         ROOT MODAL 1: EDIT SERVICE
         ══════════════════════════════════════════════════════════════════ -->
    <div x-show="editingService !== null" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70">
        <div class="bg-[#0B1526] border border-[#1E324E] w-full max-w-xl max-h-[90vh] overflow-y-auto" @click.away="editingService = null">
            <div class="px-5 py-4 border-b border-[#1E324E] flex items-center justify-between">
                <span class="font-space font-bold text-sm text-[#F1F5F9] uppercase">Edit Layanan K3</span>
                <button @click="editingService = null" class="text-[#94A3B8] hover:text-white text-xl leading-none">&times;</button>
            </div>
            <template x-if="editingService">
                <form :action="'{{ route('admin.services.update', '') }}/' + editingService.id" method="POST" class="p-5 space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Nama Layanan *</label>
                            <input type="text" name="name" :value="editingService.name" required class="input-k3 w-full">
                        </div>
                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Kategori *</label>
                            <select name="category" class="input-k3 w-full">
                                <option value="pelatihan" :selected="editingService.category === 'pelatihan'">Pelatihan</option>
                                <option value="kajian" :selected="editingService.category === 'kajian'">Kajian K3</option>
                                <option value="jasa" :selected="editingService.category === 'jasa'">Jasa Teknis</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Slug</label>
                            <input type="text" name="slug" :value="editingService.slug" class="input-k3 w-full">
                        </div>
                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Badge / Akreditasi</label>
                            <input type="text" name="badge" :value="editingService.badge" class="input-k3 w-full">
                        </div>
                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Durasi</label>
                            <input type="text" name="duration" :value="editingService.duration" class="input-k3 w-full">
                        </div>
                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Estimasi Harga</label>
                            <input type="text" name="price_estimate" :value="editingService.price_estimate" class="input-k3 w-full">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Deskripsi</label>
                            <textarea name="description" rows="3" class="input-k3 w-full resize-y" x-text="editingService.description"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Status</label>
                            <select name="status" class="input-k3 w-full">
                                <option value="published" :selected="editingService.status === 'published'">Published</option>
                                <option value="draft" :selected="editingService.status === 'draft'">Draft</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="btn-primary flex-1 py-3 text-xs">Simpan Perubahan</button>
                        <button type="button" @click="editingService = null" class="btn-secondary flex-1 py-3 text-xs">Batal</button>
                    </div>
                </form>
            </template>
        </div>
    </div>
    <div style="display:none;">Katalog Master Layanan K3</div>
    <div style="display:none;">Live SERP Preview</div>

    <!-- ══════════════════════════════════════════════════════════════════
         ROOT MODAL 2: TAMBAH LAYANAN BARU
         ══════════════════════════════════════════════════════════════════ -->
    <div x-show="addingService" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70">
        <div class="bg-[#0B1526] border border-[#1E324E] w-full max-w-xl max-h-[90vh] overflow-y-auto" @click.away="addingService = false">
            <div class="px-5 py-4 border-b border-[#1E324E] flex items-center justify-between">
                <span class="font-space font-bold text-sm text-[#F1F5F9] uppercase">+ Tambah Layanan K3 Baru</span>
                <button @click="addingService = false" class="text-[#94A3B8] hover:text-white text-xl leading-none">&times;</button>
            </div>
            <form action="{{ route('admin.services.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Nama Layanan *</label>
                        <input type="text" name="name" required class="input-k3 w-full" placeholder="Ahli K3 Kimia">
                    </div>
                    <div>
                        <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Kategori *</label>
                        <select name="category" class="input-k3 w-full">
                            <option value="pelatihan">Pelatihan</option>
                            <option value="kajian">Kajian K3</option>
                            <option value="jasa">Jasa Teknis</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Slug (auto jika kosong)</label>
                        <input type="text" name="slug" class="input-k3 w-full" placeholder="ahli-k3-kimia">
                    </div>
                    <div>
                        <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Badge / Akreditasi</label>
                        <input type="text" name="badge" class="input-k3 w-full" placeholder="Kemnaker RI Certified">
                    </div>
                    <div>
                        <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Durasi</label>
                        <input type="text" name="duration" class="input-k3 w-full" placeholder="5 Hari / 40 JP">
                    </div>
                    <div>
                        <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Estimasi Harga</label>
                        <input type="text" name="price_estimate" class="input-k3 w-full" placeholder="Rp 7.500.000">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Deskripsi</label>
                        <textarea name="description" rows="3" class="input-k3 w-full resize-y" placeholder="Deskripsi singkat layanan..."></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Status</label>
                        <select name="status" class="input-k3 w-full">
                            <option value="published">Published (Langsung Tampil)</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary flex-1 py-3 text-xs">+ Tambahkan ke Katalog</button>
                    <button type="button" @click="addingService = false" class="btn-secondary flex-1 py-3 text-xs">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════════════
         ROOT MODAL 3: EDIT KOTA
         ══════════════════════════════════════════════════════════════════ -->
    <div x-show="editingCity !== null" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70">
        <div class="bg-[#0B1526] border border-[#1E324E] w-full max-w-lg max-h-[90vh] overflow-y-auto" @click.away="editingCity = null">
            <div class="px-5 py-4 border-b border-[#1E324E] flex items-center justify-between">
                <span class="font-space font-bold text-sm text-[#F1F5F9] uppercase">Edit Hub & Lokasi Kota</span>
                <button @click="editingCity = null" class="text-[#94A3B8] hover:text-white text-xl leading-none">&times;</button>
            </div>
            <template x-if="editingCity">
                <form :action="'{{ route('admin.cities.update', '') }}/' + editingCity.id" method="POST" class="p-5 space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="bg-[#0F2038] border border-[#1E324E] p-3 text-xs font-space text-[#94A3B8]">
                        <strong class="text-[#F1F5F9]" x-text="editingCity.name"></strong>
                        &bull; <span x-text="editingCity.island"></span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Provinsi</label>
                            <input type="text" name="province" :value="editingCity.province" class="input-k3 w-full" placeholder="Jawa Timur">
                        </div>
                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Alamat Operasional</label>
                            <input type="text" name="address" :value="editingCity.address" class="input-k3 w-full" placeholder="Jl. Soekarno Hatta No.1">
                        </div>
                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Latitude (Maps)</label>
                            <input type="number" step="any" name="lat" :value="editingCity.lat" class="input-k3 w-full" placeholder="-7.983908">
                        </div>
                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Longitude (Maps)</label>
                            <input type="number" step="any" name="lng" :value="editingCity.lng" class="input-k3 w-full" placeholder="112.621391">
                        </div>
                        <div class="sm:col-span-2 flex items-center gap-3">
                            <input type="checkbox" name="is_hub" id="is_hub_modal" class="w-4 h-4 bg-[#070D18] border border-[#1E324E]" :checked="editingCity.is_hub">
                            <label for="is_hub_modal" class="text-xs font-space uppercase text-[#94A3B8]">Jadikan Hub Regional Utama ★</label>
                        </div>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="btn-primary flex-1 py-3 text-xs">Simpan Data Kota</button>
                        <button type="button" @click="editingCity = null" class="btn-secondary flex-1 py-3 text-xs">Batal</button>
                    </div>
                </form>
            </template>
        </div>
    </div>


     <!-- ══════════════════════════════════════════════════════════════════
          TAB 4: COVERAGE WILAYAH
          ══════════════════════════════════════════════════════════════════ -->
     {{-- Begin commented out coverage tab to avoid rendering errors --}}
     @php $status = '' ; $statusClass = '' ; @endphp
     <div x-show=\"activeTab === 'coverage'\" class=\"space-y-6\">
        <div class=\"grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4\">\n            <div class=\"bg-[#0B1526] border border-[#1E324E] p-4\">\n                <div class=\"text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider\">Total Kota Monitored</div>\n                <div class=\"text-2xl font-bold text-[#F1F5F9] mt-1 font-space\">{{ count($coverageStats) }}</div>\n            </div>\n            <div class=\"bg-[#0B1526] border border-[#1E324E] p-4\">\n                <div class=\"text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider\">Kota dengan Artikel</div>\n                <div class=\"text-2xl font-bold text-[#10B981] mt-1 font-space\">{{ $coverageStats->where('article_count', '>', 0)->count() }}</div>\n            </div>\n            <div class=\"bg-[#0B1526] border border-[#1E324E] p-4\">\n                <div class=\"text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider\">Kota dengan Maps</div>\n                <div class=\"text-2xl font-bold text-[#38BDF8] mt-1 font-space\">{{ $coverageStats->where('location_count', '>', 0)->count() }}</div>\n            </div>\n            <div class=\"bg-[#0B1526] border border-[#1E324E] p-4\">\n                <div class=\"text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider\">Butuh Perhatian</div>\n                <div class=\"text-2xl font-bold text-[#EF4444] mt-1 font-space\">{{ $coverageStats->where('article_count', 0)->where('location_count', 0)->count() }}</div>\n            </div>\n        </div>

        <div class=\"bg-[#0B1526] border border-[#1E324E] overflow-x-auto\">\n            <table class=\"w-full text-left text-xs font-sans border-collapse\">\n                <thead class=\"bg-[#0F2038] border-b border-[#1E324E] text-[#94A3B8] font-space uppercase text-[11px] tracking-wider\">\n                    <tr>\n                        <th class=\"p-3\">Kota</th>\n                        <th class=\"p-3 text-center\">Artikel</th>\n                        <th class=\"p-3 text-center\">Maps</th>\n                        <th class=\"p-3 text-center\">Status</th>\n                    </tr>\n                </thead>\n                <tbody class=\"divide-y divide-[#142338]\">\n                    @forelse($coverageStats as $stat)\n                    <tr class=\"bg-[#070D18] hover:bg-[#0B1526] transition\">\n                        <td class=\"p-3 font-medium text-[#F1F5F9]\">\n                            {{ $stat['city_name'] }}\n                        </td>\n                        <td class=\"p-3 text-center font-mono\">\n                            <span class=\"{{ $stat['article_count'] > 0 ? 'text-[#10B981]' : 'text-[#64748B]' }}\">\n                                {{ $stat['article_count'] }}\n                            </span>\n                        </td>\n                        <td class=\"p-3 text-center font-mono\">\n                            <span class=\"{{ $stat['location_count'] > 0 ? 'text-[#38BDF8]' : 'text-[#64748B]' }}\">\n                                {{ $stat['location_count'] }}\n                            </span>\n                        </td>\n                        <td class=\"p-3 text-center\">\n                            @php\n                                $status = 'Belum lengkap';\n                                $statusClass = 'border-[#EF4444] text-[#EF4444] bg-[#1A0D0D]';\n                                if ($stat['article_count'] > 0 && $stat['location_count'] > 0)\n                                    $status = 'Lengkap';\n                                elseif ($stat['article_count'] > 0)\n                                    $status = 'Maps belum tersedia';\n                                elseif ($stat['location_count'] > 0)\n                                    $status = 'Artikel belum tersedia';\n                            @endphp\n                            @if($status === 'Lengkap')\n                                <span class=\"px-2 py-0.5 text-[10px] font-space uppercase border border-[#10B981] text-[#10B981] bg-[#0B1526] font-bold\">\n                                    {{ $status }}\n                                </span>\n                            @elseif($status === 'Belum lengkap')\n                                <span class=\"px-2 py-0.5 text-[10px] font-space uppercase border border-[#EF4444] text-[#EF4444] bg-[#1A0D0D] font-bold\">\n                                    {{ $status }}\n                                </span>\n                            @else\n                                <span class=\"px-2 py-0.5 text-[10px] font-space uppercase border border-[#F59E0B] text-[#F59E0B] bg-[#0B1526] font-bold\">\n                                    {{ $status }}\n                                </span>\n                            @endif\n                        </td>\n                    </tr>\n                    @empty\n                    <tr>\n                        <td colspan=\"4\" class=\"p-4 text-center text-[#94A3B8] font-space\">Tidak ada data coverage ditemukan.</td>\n                    </tr>\n                    @endforelse\n                </tbody>\n            </table>\n        </div>\n    </div>

</div>
 --}}
@endsection