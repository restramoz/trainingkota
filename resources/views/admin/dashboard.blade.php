@extends('layouts.app')

@section('title', 'Portal CMS Nasional K3 - Dashboard Super Admin')

@section('content')
<!-- Command Hub Sub-Navigation Bar (Sesuai screen_8.jpg) -->
<div class="w-full bg-[#080E19] border-b border-[#1E324E] px-4 lg:px-8 py-3.5">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="bg-[#0D7A5F]/20 p-2.5 text-[#10B981] border border-[#0D7A5F]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <div class="flex flex-col">
                <div class="flex items-center gap-2">
                    <span class="font-space font-bold text-base text-[#F1F5F9] tracking-tight">PORTAL CMS NASIONAL</span>
                    <span class="font-space font-bold text-[10px] bg-[#0F2038] text-[#10B981] border border-[#0D7A5F] px-2 py-0.5">SUPER ADMIN K3</span>
                </div>
                <span class="font-space text-xs text-[#64748B]">Sinkronisasi Multikota Kemnaker RI v4.8 &bull; Single Sign-On ID: ADM-JKT-001</span>
            </div>
        </div>

        <!-- Scope & Status Indicators -->
        <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center bg-[#0B1526] border border-[#1E324E] px-3 py-1.5 gap-2 text-xs font-space">
                <span class="text-[#94A3B8]">WILAYAH:</span>
                <span class="text-[#10B981] font-bold">212 KOTA/KABUPATEN</span>
            </div>

            <div class="flex items-center gap-2 bg-[#0B1526] border border-[#1E324E] px-3 py-1.5">
                <span class="w-2 h-2 bg-[#10B981] inline-block animate-ping"></span>
                <span class="font-space text-xs text-[#10B981] font-semibold">API KEMNAKER CONNECTED</span>
            </div>

            <div class="flex items-center gap-1.5 bg-[#0F2038] border border-[#1E324E] px-3 py-1.5 text-[#F1F5F9] text-xs font-space">
                <span class="w-2 h-2 bg-[#D97706] inline-block"></span>
                <span class="text-[#F59E0B] font-semibold">WA BOT ONLINE</span>
            </div>
        </div>
    </div>
</div>

<!-- Alert Notifications -->
@if(session('success'))
<div class="max-w-7xl mx-auto px-4 lg:px-8 mt-6">
    <div class="bg-[#0B1526] border border-[#0D7A5F] border-l-4 border-l-[#10B981] p-4 flex items-center justify-between text-xs text-[#10B981] font-space">
        <div class="flex items-center gap-2 font-semibold">
            <span>&#10003;</span>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-[#94A3B8] hover:text-white">&times;</button>
    </div>
</div>
@endif

<!-- Main Shell Layout: Workspace -->
<div class="max-w-7xl mx-auto px-4 lg:px-8 py-8 space-y-8" x-data="{ activeTab: '{{ $activeTab }}', editingService: null, editingCity: null, addingService: false }">
    
    <!-- Top Command Strip: Summary KPIs (Sesuai screen_8.jpg) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- KPI 1 -->
        <div class="bg-[#0F2038] border border-[#1E324E] p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between text-[#94A3B8] font-space text-[10px] uppercase tracking-wider">
                <span>TOTAL LAYANAN AKTIF</span>
                <span class="text-[#10B981] font-bold">&#10003;</span>
            </div>
            <div class="font-space text-3xl font-bold text-[#F1F5F9] my-1">{{ $stats['total_services'] }}</div>
            <div class="flex items-center gap-2 text-[11px] font-space text-[#94A3B8]">
                <span class="text-[#10B981]">{{ $stats['total_pelatihan'] }} Diklat</span>
                <span>&bull;</span>
                <span class="text-[#38BDF8]">{{ $stats['total_kajian'] }} Kajian</span>
                <span>&bull;</span>
                <span class="text-[#F59E0B]">{{ $stats['total_jasa'] }} Riksa</span>
            </div>
        </div>

        <!-- KPI 2 -->
        <div class="bg-[#0F2038] border border-[#1E324E] p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between text-[#94A3B8] font-space text-[10px] uppercase tracking-wider">
                <span>CAKUPAN TERPETAKAN</span>
                <span class="text-[#38BDF8] font-bold">&#9873;</span>
            </div>
            <div class="font-space text-3xl font-bold text-[#F1F5F9] my-1">{{ $stats['total_cities'] }}</div>
            <div class="text-[11px] font-space text-[#10B981] flex items-center gap-1">
                <span>100% Kota &amp; Kab Indonesia ({{ $stats['total_hubs'] }} Hub)</span>
            </div>
        </div>

        <!-- KPI 3 -->
        <div class="bg-[#0F2038] border border-[#1E324E] p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between text-[#94A3B8] font-space text-[10px] uppercase tracking-wider">
                <span>REGISTRASI BATCH AKTIF</span>
                <span class="text-[#F59E0B] font-bold">&#9776;</span>
            </div>
            <div class="font-space text-3xl font-bold text-[#F1F5F9] my-1">{{ number_format($stats['active_batches']) }}</div>
            <div class="text-[11px] font-space text-[#10B981] flex items-center gap-1">
                <span>+18.4% vs bulan sebelumnya</span>
            </div>
        </div>

        <!-- KPI 4 -->
        <div class="bg-[#0F2038] border border-[#1E324E] p-4 flex flex-col justify-between">
            <div class="flex items-center justify-between text-[#94A3B8] font-space text-[10px] uppercase tracking-wider">
                <span>OVERRIDES KONTEN / SEO</span>
                <span class="text-[#7cd8b8] font-bold">&#9733;</span>
            </div>
            <div class="font-space text-3xl font-bold text-[#F1F5F9] my-1">{{ $stats['total_overrides'] }}</div>
            <div class="text-[11px] font-space text-[#94A3B8] flex items-center gap-1">
                <span>Kustomisasi Wilayah Aktif</span>
            </div>
        </div>
    </div>

    <!-- Navigation Tab Bar -->
    <div class="bg-[#0F2038] border border-[#1E324E] p-1.5 flex flex-wrap gap-1 font-space text-xs uppercase">
        <button 
            @click="activeTab = 'services'"
            :class="activeTab === 'services' ? 'bg-[#0D7A5F] text-white font-bold' : 'text-[#94A3B8] hover:text-white hover:bg-[#142338]'"
            class="px-5 py-2.5 transition-colors"
        >
            1. Manajemen Layanan ({{ $stats['total_services'] }})
        </button>

        <button 
            @click="activeTab = 'cities'"
            :class="activeTab === 'cities' ? 'bg-[#0D7A5F] text-white font-bold' : 'text-[#94A3B8] hover:text-white hover:bg-[#142338]'"
            class="px-5 py-2.5 transition-colors"
        >
            2. Alamat Perwakilan &amp; Sentra Kota ({{ $stats['total_cities'] }})
        </button>

        <button 
            @click="activeTab = 'overrides'"
            :class="activeTab === 'overrides' ? 'bg-[#0D7A5F] text-white font-bold' : 'text-[#94A3B8] hover:text-white hover:bg-[#142338]'"
            class="px-5 py-2.5 transition-colors"
        >
            3. Overrides Konten &amp; SEO Wilayah ({{ $stats['total_overrides'] }})
        </button>
    </div>

    <!-- ════════════════════════════════════════════════════════════════════ -->
    <!-- TAB 1: MANAJEMEN LAYANAN                                             -->
    <!-- ════════════════════════════════════════════════════════════════════ -->
    <div x-show="activeTab === 'services'" class="space-y-6">
        
        <!-- Panel Header -->
        <div class="bg-[#0F2038] border border-[#1E324E] p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="font-space font-bold text-base text-[#F1F5F9]">Katalog Master Layanan K3</h2>
                    <span class="font-space text-[10px] bg-[#0B1526] text-[#10B981] border border-[#0D7A5F] px-2 py-0.5">CRUD ENGINE</span>
                </div>
                <p class="text-xs text-[#94A3B8] mt-1">Kelola nama, slug, kategori, akreditasi, estimasi biaya, dan status publikasi layanan.</p>
            </div>

            <div class="flex items-center gap-2">
                <button @click="addingService = !addingService" class="btn-primary text-xs py-2 px-3.5">
                    + Tambah Layanan Baru
                </button>
            </div>
        </div>

        <!-- Form Tambah Layanan Baru (Collapsible) -->
        <div x-show="addingService" x-transition class="bg-[#0B1526] border border-[#0D7A5F] p-6 space-y-4">
            <div class="border-b border-[#1E324E] pb-3 flex justify-between items-center">
                <h3 class="font-space font-bold text-sm text-[#F1F5F9] uppercase text-[#10B981]">+ Form Tambah Layanan K3 Baru</h3>
                <button @click="addingService = false" class="text-xs text-[#94A3B8] hover:text-white">[ Batal ]</button>
            </div>

            <form action="{{ route('admin.services.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-space text-[#94A3B8] mb-1">Nama Layanan *</label>
                    <input type="text" name="name" required placeholder="Contoh: Ahli K3 Listrik" class="input-k3 w-full">
                </div>

                <div>
                    <label class="block text-xs font-space text-[#94A3B8] mb-1">Kategori *</label>
                    <select name="category" required class="input-k3 w-full">
                        <option value="pelatihan">Pelatihan</option>
                        <option value="kajian">Kajian</option>
                        <option value="jasa">Jasa</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-space text-[#94A3B8] mb-1">Status Publikasi *</label>
                    <select name="status" required class="input-k3 w-full">
                        <option value="published">Published (Tayang)</option>
                        <option value="draft">Draft (Disembunyikan)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-space text-[#94A3B8] mb-1">Badge Akreditasi</label>
                    <input type="text" name="badge" placeholder="Kemnaker RI Certified / BNSP" class="input-k3 w-full">
                </div>

                <div>
                    <label class="block text-xs font-space text-[#94A3B8] mb-1">Durasi</label>
                    <input type="text" name="duration" placeholder="Contoh: 12 Hari / 4 Hari" class="input-k3 w-full">
                </div>

                <div>
                    <label class="block text-xs font-space text-[#94A3B8] mb-1">Estimasi Biaya</label>
                    <input type="text" name="price_estimate" placeholder="Contoh: Rp 5.500.000" class="input-k3 w-full">
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs font-space text-[#94A3B8] mb-1">Deskripsi Ringkas Layanan</label>
                    <textarea name="description" rows="2" class="input-k3 w-full h-auto py-2" placeholder="Deskripsi pemenuhan regulasi dan target sertifikasi..."></textarea>
                </div>

                <div class="md:col-span-3 flex justify-end gap-2 pt-2">
                    <button type="button" @click="addingService = false" class="btn-secondary text-xs py-2 px-4">Batal</button>
                    <button type="submit" class="btn-primary text-xs py-2 px-5">Simpan Layanan &rarr;</button>
                </div>
            </form>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-[#0B1526] border border-[#1E324E] p-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.dashboard', ['tab' => 'services']) }}" class="px-3 py-1 font-space text-xs uppercase {{ empty($categoryFilter) ? 'bg-[#0D7A5F] text-white' : 'bg-[#070D18] text-[#94A3B8] border border-[#1E324E]' }}">
                    Semua ({{ $stats['total_services'] }})
                </a>
                <a href="{{ route('admin.dashboard', ['tab' => 'services', 'category' => 'pelatihan']) }}" class="px-3 py-1 font-space text-xs uppercase {{ $categoryFilter === 'pelatihan' ? 'bg-[#0D7A5F] text-white' : 'bg-[#070D18] text-[#94A3B8] border border-[#1E324E]' }}">
                    Pelatihan ({{ $stats['total_pelatihan'] }})
                </a>
                <a href="{{ route('admin.dashboard', ['tab' => 'services', 'category' => 'kajian']) }}" class="px-3 py-1 font-space text-xs uppercase {{ $categoryFilter === 'kajian' ? 'bg-[#0D7A5F] text-white' : 'bg-[#070D18] text-[#94A3B8] border border-[#1E324E]' }}">
                    Kajian ({{ $stats['total_kajian'] }})
                </a>
                <a href="{{ route('admin.dashboard', ['tab' => 'services', 'category' => 'jasa']) }}" class="px-3 py-1 font-space text-xs uppercase {{ $categoryFilter === 'jasa' ? 'bg-[#0D7A5F] text-white' : 'bg-[#070D18] text-[#94A3B8] border border-[#1E324E]' }}">
                    Jasa ({{ $stats['total_jasa'] }})
                </a>
            </div>

            <form action="{{ route('admin.dashboard') }}" method="GET" class="w-full sm:w-80">
                <input type="hidden" name="tab" value="services">
                <input type="hidden" name="category" value="{{ $categoryFilter }}">
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama atau slug..." class="input-k3 w-full text-xs font-space">
            </form>
        </div>

        <!-- Table of Services -->
        <div class="overflow-x-auto border border-[#1E324E]">
            <table class="w-full text-left text-xs font-body border-collapse">
                <thead>
                    <tr class="bg-[#0F2038] text-[#94A3B8] font-space text-[11px] uppercase border-b border-[#1E324E]">
                        <th class="py-3 px-4"># ID</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Nama Layanan</th>
                        <th class="py-3 px-4">Slug URL</th>
                        <th class="py-3 px-4">Akreditasi</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#142338]">
                    @foreach($services as $serv)
                    <tr class="bg-[#070D18] hover:bg-[#0B1526] transition-colors">
                        <td class="py-3 px-4 font-space text-[#64748B]">{{ $serv->id }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 text-[10px] font-space uppercase {{ $serv->category === 'pelatihan' ? 'bg-[#0D7A5F]/20 text-[#10B981] border border-[#0D7A5F]' : ($serv->category === 'kajian' ? 'bg-[#38BDF8]/20 text-[#38BDF8] border border-[#38BDF8]' : 'bg-[#D97706]/20 text-[#F59E0B] border border-[#D97706]') }}">
                                {{ $serv->category }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-medium text-[#F1F5F9]">
                            {{ $serv->name }}
                        </td>
                        <td class="py-3 px-4 font-space text-[#94A3B8]">{{ $serv->slug }}</td>
                        <td class="py-3 px-4 text-[#c5c6ce]">{{ $serv->badge }}</td>
                        <td class="py-3 px-4">
                            <span class="font-space text-[10px] uppercase font-bold {{ $serv->status === 'published' ? 'text-[#10B981]' : 'text-[#64748B]' }}">
                                &bull; {{ $serv->status ?? 'published' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right space-x-2">
                            <button 
                                @click="editingService = {{ json_encode($serv) }}" 
                                class="text-[#38BDF8] hover:underline font-space text-xs"
                            >
                                Edit
                            </button>
                            <a href="{{ route('service.detail', ['category' => $serv->category, 'serviceSlug' => $serv->slug]) }}" target="_blank" class="text-[#10B981] hover:underline font-space text-xs">
                                Preview &rarr;
                            </a>
                            <form action="{{ route('admin.services.delete', $serv->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus layanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[#ffb4ab] hover:underline font-space text-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-xs font-space">
            {{ $services->links() }}
        </div>

        <!-- Modal Edit Layanan -->
        <div x-show="editingService" x-transition class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4">
            <div class="bg-[#0F2038] border border-[#0D7A5F] max-w-2xl w-full p-6 space-y-4 max-h-[90vh] overflow-y-auto">
                <div class="border-b border-[#1E324E] pb-3 flex justify-between items-center">
                    <h3 class="font-space font-bold text-sm text-[#F1F5F9] uppercase">Edit Layanan: <span x-text="editingService ? editingService.name : ''" class="text-[#10B981]"></span></h3>
                    <button @click="editingService = null" class="text-xs text-[#94A3B8] hover:text-white">&times;</button>
                </div>

                <form :action="'/admin/services/' + (editingService ? editingService.id : '')" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-space text-[#94A3B8] mb-1">Nama Layanan *</label>
                            <input type="text" name="name" :value="editingService ? editingService.name : ''" class="input-k3 w-full" required>
                        </div>
                        <div>
                            <label class="block text-xs font-space text-[#94A3B8] mb-1">Slug URL *</label>
                            <input type="text" name="slug" :value="editingService ? editingService.slug : ''" class="input-k3 w-full" required>
                        </div>
                        <div>
                            <label class="block text-xs font-space text-[#94A3B8] mb-1">Kategori *</label>
                            <select name="category" class="input-k3 w-full" :value="editingService ? editingService.category : ''" required>
                                <option value="pelatihan">Pelatihan</option>
                                <option value="kajian">Kajian</option>
                                <option value="jasa">Jasa</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-space text-[#94A3B8] mb-1">Status Publikasi *</label>
                            <select name="status" class="input-k3 w-full" :value="editingService ? editingService.status : 'published'" required>
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-space text-[#94A3B8] mb-1">Akreditasi / Badge</label>
                            <input type="text" name="badge" :value="editingService ? editingService.badge : ''" class="input-k3 w-full">
                        </div>
                        <div>
                            <label class="block text-xs font-space text-[#94A3B8] mb-1">Durasi</label>
                            <input type="text" name="duration" :value="editingService ? editingService.duration : ''" class="input-k3 w-full">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-space text-[#94A3B8] mb-1">Deskripsi Layanan</label>
                        <textarea name="description" rows="3" class="input-k3 w-full h-auto py-2" :value="editingService ? editingService.description : ''"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2 border-t border-[#1E324E]">
                        <button type="button" @click="editingService = null" class="btn-secondary text-xs py-2 px-4">Batal</button>
                        <button type="submit" class="btn-primary text-xs py-2 px-5">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ════════════════════════════════════════════════════════════════════ -->
    <!-- TAB 2: MANAJEMEN ALAMAT PERWAKILAN KOTA                             -->
    <!-- ════════════════════════════════════════════════════════════════════ -->
    <div x-show="activeTab === 'cities'" class="space-y-6">
        
        <div class="bg-[#0F2038] border border-[#1E324E] p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-space font-bold text-base text-[#F1F5F9]">Alamat Perwakilan &amp; Sentra Praktik 212 Kota</h2>
                <p class="text-xs text-[#94A3B8] mt-1">Form input/edit nama sentra, alamat kawasan (tanpa nomor rumah), koordinat, dan embed Google Maps.</p>
            </div>

            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center gap-2">
                <input type="hidden" name="tab" value="cities">
                <select name="island" class="input-k3 text-xs" onchange="this.form.submit()">
                    <option value="">-- Semua Pulau --</option>
                    @foreach($islands as $isl)
                        <option value="{{ $isl }}" {{ $islandFilter === $isl ? 'selected' : '' }}>{{ $isl }}</option>
                    @endforeach
                </select>
                <input type="text" name="city_q" value="{{ $citySearch }}" placeholder="Cari nama / alamat kota..." class="input-k3 w-48 text-xs font-space">
                <button type="submit" class="btn-primary text-xs py-2 px-3">Cari</button>
            </form>
        </div>

        <div class="overflow-x-auto border border-[#1E324E]">
            <table class="w-full text-left text-xs font-body border-collapse">
                <thead>
                    <tr class="bg-[#0F2038] text-[#94A3B8] font-space text-[11px] uppercase border-b border-[#1E324E]">
                        <th class="py-3 px-4"># ID</th>
                        <th class="py-3 px-4">Kota / Kabupaten</th>
                        <th class="py-3 px-4">Sentra Praktik K3</th>
                        <th class="py-3 px-4">Alamat Jalan / Kawasan</th>
                        <th class="py-3 px-4">Koordinat Lat/Lng</th>
                        <th class="py-3 px-4">Status Hub</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#142338]">
                    @foreach($cities as $c)
                    <tr class="bg-[#070D18] hover:bg-[#0B1526] transition-colors">
                        <td class="py-3 px-4 font-space text-[#64748B]">{{ $c->id }}</td>
                        <td class="py-3 px-4 font-medium text-[#F1F5F9]">
                            {{ $c->name }}
                            <span class="text-[10px] text-[#64748B] block font-space">/{{ $c->slug }}</span>
                        </td>
                        <td class="py-3 px-4 text-[#10B981]">
                            {{ $c->sentra_praktik ?? 'Belum diisi' }}
                        </td>
                        <td class="py-3 px-4 text-[#c5c6ce] max-w-xs truncate">
                            {{ $c->address ?? 'Kawasan Industri ' . $c->name }}
                        </td>
                        <td class="py-3 px-4 font-space text-[11px] text-[#94A3B8]">
                            @if($c->lat && $c->lng)
                                {{ $c->lat }}, {{ $c->lng }}
                            @else
                                <span class="text-[#64748B]">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if($c->is_hub)
                                <span class="px-2 py-0.5 text-[10px] font-space uppercase bg-[#10B981]/20 text-[#10B981] border border-[#10B981]">★ Hub</span>
                            @else
                                <span class="text-[#64748B] font-space text-[11px]">Cabang</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right space-x-2">
                            <button 
                                @click="editingCity = {{ json_encode($c) }}" 
                                class="text-[#38BDF8] hover:underline font-space text-xs"
                            >
                                Edit Alamat
                            </button>
                            <a href="{{ route('city.landing', ['category' => 'pelatihan', 'citySlug' => $c->slug]) }}" target="_blank" class="text-[#10B981] hover:underline font-space text-xs">
                                Landing &rarr;
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-xs font-space">
            {{ $cities->links() }}
        </div>

        <!-- Modal Edit Alamat Kota -->
        <div x-show="editingCity" x-transition class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4">
            <div class="bg-[#0F2038] border border-[#0D7A5F] max-w-xl w-full p-6 space-y-4">
                <div class="border-b border-[#1E324E] pb-3 flex justify-between items-center">
                    <h3 class="font-space font-bold text-sm text-[#F1F5F9] uppercase">Edit Alamat Perwakilan: <span x-text="editingCity ? editingCity.name : ''" class="text-[#10B981]"></span></h3>
                    <button @click="editingCity = null" class="text-xs text-[#94A3B8] hover:text-white">&times;</button>
                </div>

                <form :action="'/admin/cities/' + (editingCity ? editingCity.id : '')" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-space text-[#94A3B8] mb-1">Nama Sentra Praktik K3</label>
                        <input type="text" name="sentra_praktik" :value="editingCity ? editingCity.sentra_praktik : ''" placeholder="Contoh: Sentra Praktik K3 Singosari" class="input-k3 w-full">
                    </div>

                    <div>
                        <label class="block text-xs font-space text-[#94A3B8] mb-1">Alamat Jalan / Kawasan (Tanpa Nomor Rumah)</label>
                        <input type="text" name="address" :value="editingCity ? editingCity.address : ''" placeholder="Contoh: Jl. Raya Industri Singosari, Kawasan Industri Malang" class="input-k3 w-full">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-space text-[#94A3B8] mb-1">Latitude</label>
                            <input type="text" name="lat" :value="editingCity ? editingCity.lat : ''" placeholder="-7.983908" class="input-k3 w-full">
                        </div>
                        <div>
                            <label class="block text-xs font-space text-[#94A3B8] mb-1">Longitude</label>
                            <input type="text" name="lng" :value="editingCity ? editingCity.lng : ''" placeholder="112.621391" class="input-k3 w-full">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-space text-[#94A3B8] mb-1">Custom Google Maps Embed URL (Opsional)</label>
                        <input type="text" name="maps_embed_url" :value="editingCity ? editingCity.maps_embed_url : ''" placeholder="https://maps.google.com/maps?..." class="input-k3 w-full">
                    </div>

                    <div class="flex items-center gap-2 pt-1">
                        <input type="checkbox" name="is_hub" id="is_hub_chk" :checked="editingCity && editingCity.is_hub" class="w-4 h-4 bg-[#0B1526] border border-[#1E324E]">
                        <label for="is_hub_chk" class="text-xs font-space text-[#F1F5F9]">Tandai sebagai Hub Sentra K3 Utama</label>
                    </div>

                    <div class="flex justify-end gap-2 pt-3 border-t border-[#1E324E]">
                        <button type="button" @click="editingCity = null" class="btn-secondary text-xs py-2 px-4">Batal</button>
                        <button type="submit" class="btn-primary text-xs py-2 px-5">Simpan Alamat Kota</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ════════════════════════════════════════════════════════════════════ -->
    <!-- TAB 3: MANAJEMEN OVERRIDES KONTEN / SEO PER KOTA                    -->
    <!-- ════════════════════════════════════════════════════════════════════ -->
    <div x-show="activeTab === 'overrides'" class="space-y-6">
        
        <div class="bg-[#0F2038] border border-[#1E324E] p-6 space-y-4">
            <h2 class="font-space font-bold text-base text-[#F1F5F9] flex items-center gap-2">
                <span class="w-2.5 h-2.5 bg-[#0D7A5F] inline-block"></span>
                Form Kustomisasi Konten &amp; SEO Per Kota/Layanan (city_service_contents)
            </h2>
            <p class="text-xs text-[#94A3B8]">Kustomisasi judul meta SEO, meta description, heading utama, dan paragraf pendukung khusus untuk kombinasi kota dan layanan tertentu.</p>

            <form action="{{ route('admin.city-contents.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                @csrf

                <div>
                    <label class="block text-xs font-space text-[#94A3B8] mb-1">Pilih Kota *</label>
                    <select name="city_id" required class="input-k3 w-full">
                        <option value="">-- Pilih Kota / Kabupaten --</option>
                        @foreach($allCities as $ac)
                            <option value="{{ $ac->id }}">{{ $ac->name }} ({{ $ac->island }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-space text-[#94A3B8] mb-1">Pilih Layanan (Opsional)</label>
                    <select name="service_id" class="input-k3 w-full">
                        <option value="">-- Kustomisasi Level Kategori Saja --</option>
                        @foreach($allServices as $as)
                            <option value="{{ $as->id }}">[{{ strtoupper($as->category) }}] {{ $as->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-space text-[#94A3B8] mb-1">Judul SEO Kustom (&lt;title&gt;)</label>
                    <input type="text" name="seo_title" placeholder="Contoh: Sertifikasi Ahli K3 Umum di Malang Terbaik & Resmi Kemnaker" class="input-k3 w-full">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-space text-[#94A3B8] mb-1">Meta Description (&lt;meta name="description"&gt;)</label>
                    <textarea name="meta_description" rows="2" class="input-k3 w-full h-auto py-2" placeholder="Deskripsi meta untuk hasil pencarian Google di kota tersebut..."></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-space text-[#94A3B8] mb-1">Custom Heading (H1 di Landing Page)</label>
                    <input type="text" name="custom_heading" placeholder="Contoh: Pusat Pelatihan Ahli K3 Umum Resmi Wilayah Malang Raya" class="input-k3 w-full">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-space text-[#94A3B8] mb-1">Konten Khusus Wilayah (Paragraf Tambahan)</label>
                    <textarea name="custom_content" rows="3" class="input-k3 w-full h-auto py-2" placeholder="Informasi spesifik regulasi daerah, jadwal lokal khusus, atau fasilitas sentra praktik..."></textarea>
                </div>

                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="btn-primary text-xs py-2.5 px-6">
                        Simpan Kustomisasi SEO Wilayah &rarr;
                    </button>
                </div>
            </form>
        </div>

        <!-- Existing Overrides Table -->
        <div class="bg-[#0F2038] border border-[#1E324E] p-5 space-y-4">
            <h3 class="font-space font-bold text-sm uppercase text-[#F1F5F9]">Daftar Kustomisasi Konten yang Telah Diterapkan ({{ $stats['total_overrides'] }})</h3>

            <div class="overflow-x-auto border border-[#1E324E]">
                <table class="w-full text-left text-xs font-body border-collapse">
                    <thead>
                        <tr class="bg-[#0B1526] text-[#94A3B8] font-space text-[11px] uppercase border-b border-[#1E324E]">
                            <th class="py-3 px-4">Kota</th>
                            <th class="py-3 px-4">Layanan Terkait</th>
                            <th class="py-3 px-4">Judul SEO Kustom</th>
                            <th class="py-3 px-4">Meta Description</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#142338]">
                        @forelse($overrides as $ov)
                        <tr class="bg-[#070D18] hover:bg-[#0B1526] transition-colors">
                            <td class="py-3 px-4 font-space font-bold text-[#10B981]">{{ $ov->city->name }}</td>
                            <td class="py-3 px-4 text-[#F1F5F9]">{{ $ov->service ? $ov->service->name : 'Semua Layanan' }}</td>
                            <td class="py-3 px-4 text-[#c5c6ce]">{{ $ov->seo_title }}</td>
                            <td class="py-3 px-4 text-[#94A3B8] max-w-xs truncate">{{ $ov->meta_description }}</td>
                            <td class="py-3 px-4 text-right">
                                <form action="{{ route('admin.city-contents.delete', $ov->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus override ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[#ffb4ab] hover:underline font-space text-xs">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-[#94A3B8] font-space text-xs">
                                Belum ada kustomisasi konten khusus per kota yang disimpan. Silakan gunakan form di atas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="text-xs font-space">
                {{ $overrides->links() }}
            </div>
        </div>

    </div>

</div>
@endsection
