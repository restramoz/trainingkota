@extends('layouts.app')

@section('title', 'Portal CMS Nasional K3 - Dashboard Super Admin')

@section('content')
<style>[x-cloak] { display: none !important; }</style>

<div x-data="{
    activeTab: '{{ request('tab', $activeTab ?? 'services') }}',
    editingService: null,
    editingCity: null,
    addingService: false,
    editingArticle: null,

    // State Live Google SERP Preview
    selectedCityName: 'Malang',
    selectedServiceName: 'Ahli K3 Umum',
    selectedCategory: 'pelatihan',
    selectedCitySlug: 'malang',
    selectedServiceSlug: 'ahli-k3-umum',
    seoTitle: 'Pelatihan Ahli K3 Umum di Malang Terbaik & Resmi Kemnaker',
    metaDesc: 'Pusat pembinaan dan sertifikasi Ahli K3 Umum Kemnaker RI di Malang. Jadwal batch reguler terdekat, sentra praktik industri, dan sertifikat ber-SKP resmi.',
    customHeading: 'Pusat Pelatihan Ahli K3 Umum Resmi Wilayah Malang Raya',
    editorContent: 'Program pelatihan Ahli K3 Umum di Malang diselenggarakan dengan silabus resmi Kemnaker RI.',

    closeAllModals() { 
        this.addingService = false; 
        this.editingCity = null; 
        this.editingService = null; 
        this.editingArticle = null; 
    },
    setEditingService(data) { this.closeAllModals(); this.editingService = data; },
    setEditingCity(data) { this.closeAllModals(); this.editingCity = data; },
    setEditingArticle(data) { this.closeAllModals(); this.editingArticle = data; },

    updatePreviewFromSelection() {
        let citySelect = document.getElementById('seo_city_select');
        let serviceSelect = document.getElementById('seo_service_select');
        if (citySelect && citySelect.selectedIndex > 0) {
            let opt = citySelect.options[citySelect.selectedIndex];
            this.selectedCityName = opt.getAttribute('data-name') || 'Kota/Kab';
            this.selectedCitySlug = opt.getAttribute('data-slug') || 'kota';
        }
        if (serviceSelect && serviceSelect.selectedIndex > 0) {
            let opt = serviceSelect.options[serviceSelect.selectedIndex];
            this.selectedServiceName = opt.getAttribute('data-title') || 'Layanan K3';
            this.selectedServiceSlug = opt.getAttribute('data-slug') || 'layanan';
            this.selectedCategory = opt.getAttribute('data-category') || 'pelatihan';
        }
        this.seoTitle = this.selectedServiceName + ' di ' + this.selectedCityName + ' - Sertifikasi Resmi Kemnaker RI';
        this.metaDesc = 'Pusat layanan resmi ' + this.selectedServiceName + ' di ' + this.selectedCityName + '. Jadwal pembinaan, sertifikat Kemnaker RI/BNSP, dan sentra praktik terdekat.';
        this.customHeading = 'Pusat ' + this.selectedServiceName + ' Resmi Wilayah ' + this.selectedCityName;
    },

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

    insertTag(tag) {
        let textarea = this.$refs.wysiwygEditor;
        if (!textarea) return;
        let start = textarea.selectionStart;
        let end = textarea.selectionEnd;
        let selected = textarea.value.substring(start, end);
        let replacement = '';
        if (tag === 'h2') replacement = `\n<h2>${selected || 'Subjudul H2'}</h2>\n`;
        else if (tag === 'h3') replacement = `\n<h3>${selected || 'Subjudul H3'}</h3>\n`;
        else if (tag === 'b') replacement = `<strong>${selected || 'teks tebal'}</strong>`;
        else if (tag === 'list') replacement = `\n<ul>\n  <li>${selected || 'Item daftar'}</li>\n</ul>\n`;
        textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);
        this.editorContent = textarea.value;
        textarea.focus();
    },

    insertTable() {
        let textarea = this.$refs.wysiwygEditor;
        if (!textarea) return;
        let t = `\n<table>\n  <thead><tr><th>Fitur</th><th>Detail</th></tr></thead>\n  <tbody><tr><td>Durasi</td><td>3 Hari</td></tr></tbody>\n</table>\n`;
        let start = textarea.selectionStart;
        textarea.value = textarea.value.substring(0, start) + t + textarea.value.substring(textarea.selectionEnd);
        this.editorContent = textarea.value;
        textarea.focus();
    },

    insertCallout() {
        let textarea = this.$refs.wysiwygEditor;
        if (!textarea) return;
        let c = `\n> **PENTING**: Seluruh peserta wajib melengkapi berkas ijazah minimal D3/S1 sesuai Permenaker No. 02/1992.\n`;
        let start = textarea.selectionStart;
        textarea.value = textarea.value.substring(0, start) + c + textarea.value.substring(textarea.selectionEnd);
        this.editorContent = textarea.value;
        textarea.focus();
    },

    launchAiGenerator(serviceId, cityId, category) {
        this.activeTab = 'articles';
        this.$nextTick(() => {
            const sSel = document.getElementById('ai_service_select');
            const cSel = document.getElementById('ai_city_select');
            const catSel = document.getElementById('ai_category_select');
            
            if (sSel) sSel.value = serviceId;
            if (cSel) cSel.value = cityId;
            if (catSel) catSel.value = category;
            
            const aiSection = document.getElementById('ai-generator-section');
            if (aiSection) {
                aiSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    },
}" class="min-h-screen bg-[#070D18] text-[#F1F5F9] font-sans antialiased pb-12">

    <!-- ── Header Control Bar ───────────────────────────────────────────── -->
    <div class="w-full bg-[#080E19] border-b border-[#1E324E] px-4 lg:px-8 py-3.5 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="bg-[#0D7A5F]/20 p-2 text-[#10B981] border border-[#0D7A5F] shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <div class="flex flex-col">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="font-space font-bold text-sm lg:text-base text-[#F1F5F9] tracking-tight">PORTAL CMS NASIONAL K3</span>
                    <span class="font-space font-bold text-[10px] bg-[#0F2038] text-[#10B981] border border-[#0D7A5F] px-2 py-0.5 uppercase tracking-wider">COMMAND & COMPLIANCE v2.5</span>
                </div>
                <span class="font-space text-[11px] text-[#64748B]">Sinkronisasi Multikota Kemnaker RI &bull; 212 Kota/Kab Terhubung</span>
            </div>
        </div>
        <div class="flex items-center gap-4 text-xs font-space">
            <div class="hidden sm:flex items-center gap-2 bg-[#0B1526] border border-[#1E324E] px-3 py-1.5">
                <span class="w-2 h-2 bg-[#10B981] inline-block animate-pulse"></span>
                <span class="text-[#10B981] font-semibold">SISTEM AKTIF</span>
            </div>
            <div class="flex items-center bg-[#0F2038] border border-[#1E324E] px-3 py-1.5 gap-2">
                <span class="text-[#94A3B8]">OPERATOR:</span>
                <span class="text-[#F1F5F9] font-bold uppercase">{{ auth()->user()->name ?? session('admin_username', 'SUPER ADMIN') }}</span>
            </div>
            <a href="{{ route('home') }}" target="_blank" class="hidden sm:flex items-center gap-1.5 text-[#38BDF8] hover:underline font-semibold text-[11px]">
                <span class="w-1.5 h-1.5 bg-[#38BDF8] inline-block"></span>
                LIHAT WEBSITE
            </a>
        </div>
    </div>

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

        <!-- ── STAT METRICS ────────────────────────────────────────────── -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-10 gap-2">
            <div class="bg-[#0B1526] border border-[#1E324E] p-3 hover:border-[#0D7A5F] transition col-span-1">
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
                <div class="text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider">Cakupan Kota</div>
                <div class="text-xl font-bold text-[#F1F5F9] mt-1 font-space">{{ $stats['total_cities'] ?? 0 }}</div>
            </div>
            <div class="bg-[#0B1526] border border-[#1E324E] p-3 hover:border-[#0D7A5F] transition">
                <div class="text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider">Sentra Hub</div>
                <div class="text-xl font-bold text-[#10B981] mt-1 font-space">{{ $stats['total_hubs'] ?? 0 }}</div>
            </div>
            <div class="bg-[#0B1526] border border-[#1E324E] p-3 hover:border-[#0D7A5F] transition">
                <div class="text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider">SEO Overrides</div>
                <div class="text-xl font-bold text-[#38BDF8] mt-1 font-space">{{ $stats['total_overrides'] ?? 0 }}</div>
            </div>
            <div class="bg-[#0B1526] border border-[#1E324E] p-3 hover:border-[#0D7A5F] transition">
                <div class="text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider">Total Artikel</div>
                <div class="text-xl font-bold text-[#7cd8b8] mt-1 font-space">{{ $stats['total_articles'] ?? 0 }}</div>
            </div>
            <div class="bg-[#0B1526] border border-[#1E324E] p-3 hover:border-[#0D7A5F] transition">
                <div class="text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider">Published</div>
                <div class="text-xl font-bold text-[#10B981] mt-1 font-space">{{ $stats['published_articles'] ?? 0 }}</div>
            </div>
            <div class="bg-[#0B1526] border border-[#1E324E] p-3 hover:border-[#0D7A5F] transition">
                <div class="text-[10px] uppercase font-space font-bold text-[#94A3B8] tracking-wider">Draft</div>
                <div class="text-xl font-bold text-[#F59E0B] mt-1 font-space">{{ $stats['draft_articles'] ?? 0 }}</div>
            </div>
        </div>

        <!-- ── TAB NAVIGATION ────────────────────────────────────────── -->
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
                <button @click="activeTab = 'overrides'"
                    :class="activeTab === 'overrides' ? 'bg-[#0D7A5F] text-white font-bold' : 'text-[#94A3B8] hover:text-white hover:bg-[#142338]'"
                    class="px-4 py-2.5 transition tracking-wider whitespace-nowrap">
                    4. Overrides SEO ({{ $stats['total_overrides'] ?? 0 }})
                </button>
                    <a href="{{ route('admin.content-matrix') }}"
                        :class="activeTab === 'matrix' ? 'bg-[#0D7A5F] text-white font-bold' : 'text-[#94A3B8] hover:text-white hover:bg-[#142338]'"
                        class="px-4 py-2.5 transition tracking-wider whitespace-nowrap inline-block text-xs uppercase font-space">
                        5. Coverage Matrix
                    </a>
            </div>
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
                <div class="flex items-center gap-2 text-xs font-space text-[#94A3B8]">
                    <span class="w-1.5 h-1.5 bg-[#10B981] inline-block animate-pulse"></span>
                    ARTIKEL LANGSUNG TAMPIL DI CITY LANDING PAGE
                </div>
            </div>

            <div class="bg-[#0F2038] border border-[#1E324E] border-l-4 border-l-[#38BDF8] p-4 text-xs font-space text-[#94A3B8] leading-relaxed">
                <strong class="text-[#38BDF8]">[ INFO SINKRONISASI ]</strong> Artikel yang ditambahkan akan <strong class="text-[#F1F5F9]">langsung muncul</strong> di halaman city landing page terkait.
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
                                <a href="{{ route('article.show', $article->slug) }}" target="_blank" class="text-[#38BDF8] hover:underline text-xs">View</a>
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

        <!-- ══════════════════════════════════════════════════════════════
             TAB 4: SEO OVERRIDES & QUICK EDITOR
             ══════════════════════════════════════════════════════════════ -->
        <div x-show="activeTab === 'overrides'" class="space-y-6">
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-5 items-start">
                <!-- LEFT: Override Registry -->
                <div class="xl:col-span-7 space-y-4">
                    <div class="bg-[#0B1526] border border-[#1E324E]">
                        <div class="px-5 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-[#1E324E]">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="w-2 h-2 bg-[#10B981]"></span>
                                    <span class="font-space font-bold text-sm text-[#F1F5F9] uppercase tracking-wider">Overrides Konten &amp; SEO</span>
                                    <span class="font-space text-[8px] uppercase tracking-widest font-bold px-2 py-1 bg-[#10B981]/10 border border-[#0D7A5F] text-[#10B981]">LIVE</span>
                                </div>
                                <p class="text-[11px] text-[#64748B] font-sans">Konfigurasi SEO khusus untuk kombinasi wilayah dan layanan.</p>
                            </div>
                            <div class="text-right">
                                <div class="font-space font-bold text-2xl text-[#10B981]">{{ $overrides->total() }}</div>
                                <div class="font-space text-[9px] uppercase text-[#475569] mt-1">Active Override</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#070D18] border border-[#1E324E] overflow-x-auto">
                        <div class="px-4 py-3 border-b border-[#1E324E] flex items-center justify-between">
                            <span class="font-space text-[10px] font-bold uppercase tracking-wider text-[#CBD5E1]">Active SEO Overrides</span>
                            <span class="font-space text-[8px] uppercase text-[#475569]">Registry View</span>
                        </div>
                        <table class="w-full min-w-[700px] border-collapse">
                            <thead>
                                <tr class="bg-[#0B1526] border-b border-[#1E324E]">
                                    <th class="w-[55px] px-3 py-3 text-left font-space text-[8px] uppercase tracking-widest text-[#475569]">ID</th>
                                    <th class="w-[140px] px-3 py-3 text-left font-space text-[8px] uppercase tracking-widest text-[#475569]">Wilayah</th>
                                    <th class="w-[160px] px-3 py-3 text-left font-space text-[8px] uppercase tracking-widest text-[#475569]">Layanan</th>
                                    <th class="px-3 py-3 text-left font-space text-[8px] uppercase tracking-widest text-[#475569]">SEO Content</th>
                                    <th class="w-[60px] px-3 py-3 text-right font-space text-[8px] uppercase tracking-widest text-[#475569]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#142338]">
                                @forelse($overrides as $ov)
                                <tr class="bg-[#070D18] hover:bg-[#0B1526] transition-colors">
                                    <td class="px-3 py-3 align-top"><span class="font-mono text-[9px] text-[#475569]">#{{ $ov->id }}</span></td>
                                    <td class="px-3 py-3 align-top">
                                        <div class="font-space text-[10px] font-bold text-[#10B981]">{{ optional($ov->city)->name ?? 'Semua Kota' }}</div>
                                        @if(optional($ov->city)->slug)
                                        <div class="font-mono text-[8px] text-[#475569] mt-1">/{{ $ov->city->slug }}</div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 align-top">
                                        <div class="font-sans text-[10px] text-[#E2E8F0]">{{ optional($ov->service)->title ?? optional($ov->service)->name ?? 'Semua Layanan' }}</div>
                                        @if(optional($ov->service)->category)
                                        <span class="inline-flex mt-1 px-1.5 py-0.5 border border-[#38BDF8]/20 text-[#38BDF8] font-space text-[7px] uppercase">{{ $ov->service->category }}</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 align-top">
                                        <div class="font-sans text-[10px] text-[#CBD5E1]">{{ Str::limit($ov->seo_title ?? '-', 70) }}</div>
                                        @if(!empty($ov->meta_description))
                                        <div class="mt-1 font-sans text-[8px] text-[#475569]">{{ Str::limit($ov->meta_description, 100) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 align-top text-right">
                                        <form method="POST" action="{{ route('admin.city-contents.delete', $ov->id) }}" class="inline" onsubmit="return confirm('Hapus override ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[10px] font-space text-[#64748B] hover:text-[#ffb4ab] transition">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center">
                                        <div class="font-space text-[10px] uppercase tracking-widest text-[#64748B]">No Active Override</div>
                                        <p class="font-sans text-[10px] text-[#475569] mt-1">Gunakan SEO Injection Engine di panel kanan.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($overrides, 'links'))
                    <div class="bg-[#0B1526] border border-[#1E324E] px-3 py-2">
                        <div class="font-space text-[9px]">{{ $overrides->appends(request()->query())->links() }}</div>
                    </div>
                    @endif
                </div>

                <!-- RIGHT: SEO Command Panel -->
                <div class="xl:col-span-5 space-y-5">
                    <!-- SERP Preview -->
                    <div class="bg-[#0B1526] border border-[#1E324E]">
                        <div class="px-4 py-3 border-b border-[#1E324E] flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-[#4285F4]"></span>
                                <div>
                                    <div class="font-space text-[10px] font-bold uppercase tracking-wider text-[#F1F5F9]">Live SERP Preview</div>
                                    <div class="font-space text-[8px] text-[#475569] mt-0.5">Google Search Simulator</div>
                                </div>
                            </div>
                            <span class="px-2 py-1 bg-[#38BDF8]/5 border border-[#38BDF8]/20 text-[#38BDF8] font-space text-[8px] font-bold uppercase">LIVE</span>
                        </div>
                        <div class="p-4">
                            <div class="bg-[#202124] border border-[#303134] p-4">
                                <div class="flex items-center gap-2 text-[10px] text-[#bdc1c6] font-mono truncate">
                                    <span class="w-4 h-4 shrink-0 bg-[#0D7A5F] text-white flex items-center justify-center text-[8px] font-bold">TK</span>
                                    <span class="truncate">trainingkota.com › <span x-text="selectedCategory || 'kategori'"></span> › kota-<span x-text="selectedCitySlug || 'kota'"></span></span>
                                </div>
                                <div class="text-[17px] leading-snug text-[#8ab4f8] hover:underline cursor-pointer mt-2 break-words" x-text="seoTitle"></div>
                                <div class="text-[12px] leading-relaxed text-[#bdc1c6] mt-2 break-words" x-text="metaDesc"></div>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-3">
                                <div class="bg-[#070D18] border border-[#1E324E] px-3 py-2.5">
                                    <div class="flex items-center justify-between">
                                        <span class="font-space text-[8px] uppercase text-[#475569]">Title Length</span>
                                        <span :class="seoTitle.length <= 60 ? 'text-[#10B981]' : 'text-[#F59E0B]'" class="font-space text-[10px] font-bold"><span x-text="seoTitle.length"></span>/60</span>
                                    </div>
                                    <div class="h-1 mt-2 bg-[#1E324E] overflow-hidden">
                                        <div class="h-full transition-all" :class="seoTitle.length <= 60 ? 'bg-[#10B981]' : 'bg-[#F59E0B]'" :style="'width:' + Math.min((seoTitle.length / 60) * 100, 100) + '%'"></div>
                                    </div>
                                </div>
                                <div class="bg-[#070D18] border border-[#1E324E] px-3 py-2.5">
                                    <div class="flex items-center justify-between">
                                        <span class="font-space text-[8px] uppercase text-[#475569]">Meta Desc</span>
                                        <span :class="metaDesc.length <= 160 ? 'text-[#10B981]' : 'text-[#F59E0B]'" class="font-space text-[10px] font-bold"><span x-text="metaDesc.length"></span>/160</span>
                                    </div>
                                    <div class="h-1 mt-2 bg-[#1E324E] overflow-hidden">
                                        <div class="h-full transition-all" :class="metaDesc.length <= 160 ? 'bg-[#10B981]' : 'bg-[#F59E0B]'" :style="'width:' + Math.min((metaDesc.length / 160) * 100, 100) + '%'"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Injection Engine Form -->
                    <div class="bg-[#0B1526] border border-[#1E324E]">
                        <div class="px-4 py-3 border-b border-[#1E324E] flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-[#10B981]"></span>
                                <div>
                                    <div class="font-space text-[10px] font-bold uppercase tracking-wider text-[#F1F5F9]">SEO Injection Engine</div>
                                    <div class="font-space text-[8px] text-[#475569] mt-0.5">Regional landing page override</div>
                                </div>
                            </div>
                            <span class="font-space text-[8px] uppercase text-[#10B981]">Instant Override</span>
                        </div>

                        <form method="POST" action="{{ route('admin.city-contents.store') }}" class="p-4 space-y-4">
                            @csrf
                            <div class="bg-[#070D18] border border-[#1E324E] p-3">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="font-space text-[8px] uppercase text-[#64748B]">Target Matrix</span>
                                    <span class="font-space text-[8px] font-bold text-[#10B981]">REQUIRED</span>
                                </div>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block font-space text-[8px] uppercase tracking-widest text-[#64748B] mb-1.5">Target Wilayah Kota *</label>
                                        <select name="city_id" id="seo_city_select" @change="updatePreviewFromSelection()" required
                                            class="w-full h-10 bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-3 text-[11px] font-sans outline-none focus:border-[#0D7A5F] transition">
                                            <option value="">-- Pilih Kota --</option>
                                            @foreach($allCities as $c)
                                                <option value="{{ $c->id }}" data-name="{{ $c->name }}" data-slug="{{ $c->slug }}">{{ $c->name }} ({{ $c->province }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block font-space text-[8px] uppercase tracking-widest text-[#64748B] mb-1.5">Target Layanan K3 *</label>
                                        <select name="service_id" id="seo_service_select" @change="updatePreviewFromSelection()" required
                                            class="w-full h-10 bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-3 text-[11px] font-sans outline-none focus:border-[#0D7A5F] transition">
                                            <option value="">-- Pilih Layanan --</option>
                                            @foreach($allServices as $s)
                                                <option value="{{ $s->id }}" data-title="{{ $s->title ?? $s->name }}" data-slug="{{ $s->slug }}" data-category="{{ $s->category }}">
                                                    {{ $s->title ?? $s->name }} [{{ $s->category }}]
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <label class="font-space text-[8px] uppercase tracking-widest text-[#64748B]">Judul Meta SEO Override</label>
                                        <span :class="seoTitle.length <= 60 ? 'text-[#10B981]' : 'text-[#F59E0B]'" class="font-space text-[8px] font-bold"><span x-text="seoTitle.length"></span>/60</span>
                                    </div>
                                    <input type="text" name="seo_title" x-model="seoTitle" placeholder="Pelatihan Ahli K3 Umum Resmi Kemnaker di ..."
                                        class="w-full h-10 bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-3 text-[11px] font-sans outline-none focus:border-[#0D7A5F] transition">
                                </div>
                                <div>
                                    <label class="block font-space text-[8px] uppercase tracking-widest text-[#64748B] mb-1.5">Custom Heading (H1)</label>
                                    <input type="text" name="custom_heading" x-model="customHeading" placeholder="Pusat Sertifikasi K3 Terbaik ..."
                                        class="w-full h-10 bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] px-3 text-[11px] font-sans outline-none focus:border-[#0D7A5F] transition">
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <label class="font-space text-[8px] uppercase tracking-widest text-[#64748B]">Meta Description Override</label>
                                        <span :class="metaDesc.length <= 160 ? 'text-[#10B981]' : 'text-[#F59E0B]'" class="font-space text-[8px] font-bold"><span x-text="metaDesc.length"></span>/160</span>
                                    </div>
                                    <textarea name="meta_description" x-model="metaDesc" rows="3"
                                        placeholder="Deskripsi ringkas untuk snippet Google Search..."
                                        class="w-full bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] p-3 text-[11px] font-sans outline-none focus:border-[#0D7A5F] transition resize-none"></textarea>
                                </div>
                            </div>

                            <div>
                                <div class="flex flex-wrap items-center justify-between gap-2 mb-1.5">
                                    <label class="font-space text-[8px] uppercase tracking-widest text-[#64748B]">Konten Kustom Landing Page</label>
                                    <span class="font-space text-[8px] uppercase text-[#475569]">HTML TOOLKIT</span>
                                </div>
                                <div class="bg-[#070D18] border border-[#1E324E] border-b-0 p-1.5 flex flex-wrap gap-1">
                                    <button type="button" @click="insertTag('h2')" class="h-7 px-2.5 bg-[#0B1526] border border-[#1E324E] hover:border-[#0D7A5F] hover:text-[#10B981] text-[#CBD5E1] text-[8px] font-space uppercase transition">H2</button>
                                    <button type="button" @click="insertTag('h3')" class="h-7 px-2.5 bg-[#0B1526] border border-[#1E324E] hover:border-[#0D7A5F] hover:text-[#10B981] text-[#CBD5E1] text-[8px] font-space uppercase transition">H3</button>
                                    <button type="button" @click="insertTag('b')" class="h-7 px-2.5 bg-[#0B1526] border border-[#1E324E] hover:border-[#0D7A5F] hover:text-[#10B981] text-[#CBD5E1] text-[8px] font-space font-bold transition">B</button>
                                    <button type="button" @click="insertTable()" class="h-7 px-2.5 bg-[#0B1526] border border-[#1E324E] hover:border-[#0D7A5F] hover:text-[#10B981] text-[#10B981] text-[8px] font-space uppercase transition">+ TABLE</button>
                                    <button type="button" @click="insertCallout()" class="h-7 px-2.5 bg-[#0B1526] border border-[#1E324E] hover:border-[#D97706] hover:text-[#F59E0B] text-[#F59E0B] text-[8px] font-space uppercase transition">+ CALLOUT</button>
                                </div>
                                <textarea name="custom_content" x-ref="wysiwygEditor" x-model="editorContent" rows="7"
                                    placeholder="Tuliskan materi kustom khusus kota ini..."
                                    class="w-full bg-[#080E19] border border-[#1E324E] text-[#F1F5F9] p-3 text-[11px] font-mono outline-none focus:border-[#0D7A5F] transition resize-y"></textarea>
                            </div>

                            <button type="submit" class="w-full min-h-[44px] bg-[#0D7A5F] hover:bg-[#10B981] text-white font-space font-bold text-[10px] uppercase tracking-widest transition flex items-center justify-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Simpan Override SEO
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- ══════════════════════════════════════════════════════════════
             TAB 5: CONTENT COVERAGE MATRIX
             ══════════════════════════════════════════════════════════════ -->
        <div x-show="activeTab === 'matrix'" class="space-y-6">
            @if(isset($matrixCities) && isset($matrixServices))
            <div class="bg-[#0B1526] border border-[#1E324E] p-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="text-[#F1F5F9] font-space font-bold uppercase tracking-wider">Content Coverage Matrix</h3>
                    <p class="text-[11px] text-[#64748B]">Visualisasi ketersediaan landing page per kombinasi Layanan & Kota.</p>
                </div>
                <div class="flex items-center gap-4 text-[10px] font-space">
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 bg-[#10B981] rounded-full"></span>
                        <span class="text-[#CBD5E1]">Covered</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 bg-[#1E324E] border border-[#475569] rounded-full"></span>
                        <span class="text-[#64748B]">Missing</span>
                    </div>
                </div>
            </div>

            <div class="bg-[#0B1526] border border-[#1E324E] overflow-hidden rounded-sm">
                <div class="overflow-x-auto overflow-y-auto max-h-[600px]">
                    <table class="w-full text-left text-[10px] font-sans border-collapse">
                        <thead class="bg-[#0F2038] sticky top-0 z-20 shadow-sm">
                            <tr>
                                <th class="p-3 border-b border-[#1E324E] bg-[#0F2038] sticky left-0 z-30 min-w-[200px] font-space uppercase text-[#94A3B8] tracking-wider">Layanan / Kota</th>
                                @foreach($matrixCities as $city)
                                    <th class="p-3 border-b border-[#1E324E] border-r border-[#1E324E] min-w-[120px] text-center font-space uppercase text-[#94A3B8] tracking-wider whitespace-nowrap">
                                        {{ $city->name }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#142338]">
                            @foreach($matrixServices as $service)
                            <tr class="bg-[#070D18] hover:bg-[#0B1526] transition">
                                <td class="p-3 sticky left-0 z-10 bg-[#070D18] border-r border-[#1E324E] font-medium text-[#F1F5F9] whitespace-nowrap">
                                    {{ $service->title ?? $service->name }}
                                    <span class="text-[8px] text-[#64748B] block uppercase">{{ $service->category }}</span>
                                </td>
                                @foreach($matrixCities as $city)
                                     @php
                                         $coverage = $coverageMatrix[$service->id][$city->id] ?? [];
                                         $article = $coverage['article'] ?? false;
                                     @endphp
                                     <td class="p-3 border-r border-[#1E324E] text-center">
                                         @if($article)
                                             <a href="{{ route('article.show', $article['slug']) }}" target="_blank" 
                                                class="text-[10px] font-bold text-[#10B981] hover:underline uppercase">
                                                Edit/View
                                             </a>
                                         @else
                                             <button @click="launchAiGenerator({{ $service->id }}, {{ $city->id }}, '{{ $service->category }}')" 
                                                     class="bg-[#0D7A5F] hover:bg-[#10B981] text-white text-[9px] font-bold px-2 py-1 rounded uppercase transition">
                                                 Gen AI
                                             </button>
                                         @endif
                                     </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="p-8 text-center bg-[#0B1526] border border-[#1E324E] rounded-sm">
                <p class="text-[#64748B] font-space text-sm">Sistem matriks dimuat langsung dari AdminController@contentMatrix.</p>
            </div>
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

</div>
@endsection