@extends('layouts.app')

@section('title', 'Portal CMS Nasional K3 - Bento Command Dashboard')

@section('content')
<div x-data="{ 
    activeTab: '{{ $activeTab }}', 
    editingService: null, 
    editingCity: null, 
    addingService: false,
    
    // Alpine reactive state for Real-time Google SERP Live Preview
    selectedCityName: 'Malang',
    selectedServiceName: 'Ahli K3 Umum',
    selectedCategory: 'pelatihan',
    selectedCitySlug: 'malang',
    selectedServiceSlug: 'ahli-k3-umum',
    seoTitle: 'Pelatihan Ahli K3 Umum di Malang Terbaik & Resmi Kemnaker',
    metaDesc: 'Pusat pembinaan dan sertifikasi Ahli K3 Umum Kemnaker RI di Malang. Jadwal batch reguler terdekat, sentra praktik industri, dan sertifikat ber-SKP resmi.',
    customHeading: 'Pusat Pelatihan Ahli K3 Umum Resmi Wilayah Malang Raya',
    editorContent: 'Program pelatihan Ahli K3 Umum di Malang diselenggarakan dengan silabus resmi Kemnaker RI untuk meningkatkan kompetensi personel keselamatan kerja di seluruh kawasan industri Jawa Timur.',
    
    insertTag(openTag, closeTag = '') {
        const textarea = this.$refs.wysiwygTextarea;
        if (!textarea) return;
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selText = textarea.value.substring(start, end) || 'Teks Konten Disini';
        const replacement = openTag + selText + closeTag;
        textarea.setRangeText(replacement, start, end, 'select');
        this.editorContent = textarea.value;
    },
    
    insertTable() {
        const tableHtml = '\n<table class=\"w-full border border-[#1E324E] text-xs my-3\">\n  <thead>\n    <tr class=\"bg-[#0B1526] text-[#10B981]\">\n      <th class=\"p-2 border border-[#1E324E]\">Materi Uji</th>\n      <th class=\"p-2 border border-[#1E324E]\">Durasi</th>\n      <th class=\"p-2 border border-[#1E324E]\">Standar Regulasi</th>\n    </tr>\n  </thead>\n  <tbody>\n    <tr>\n      <td class=\"p-2 border border-[#1E324E]\">Dasar-Dasar K3</td>\n      <td class=\"p-2 border border-[#1E324E]\">8 Jam</td>\n      <td class=\"p-2 border border-[#1E324E]\">UU No. 1 Th 1970</td>\n    </tr>\n  </tbody>\n</table>\n';
        this.insertTag(tableHtml);
    },
    
    insertCallout() {
        const calloutHtml = '\n<div class=\"p-3 bg-[#0B1526] border-l-4 border-[#10B981] text-xs my-3\">\n  <strong class=\"text-[#10B981]\">PENTING:</strong> Seluruh peserta wajib melengkapi berkas ijazah minimal D3/S1 sesuai Permenaker No. 02/1992.\n</div>\n';
        this.insertTag(calloutHtml);
    },

    updatePreviewFromSelection(citySelect, serviceSelect) {
        if (citySelect && citySelect.selectedOptions[0]) {
            this.selectedCityName = citySelect.selectedOptions[0].dataset.name || 'Wilayah Terpilih';
            this.selectedCitySlug = citySelect.selectedOptions[0].dataset.slug || 'malang';
        }
        if (serviceSelect && serviceSelect.selectedOptions[0]) {
            this.selectedServiceName = serviceSelect.selectedOptions[0].dataset.name || 'Semua Layanan';
            this.selectedServiceSlug = serviceSelect.selectedOptions[0].dataset.slug || 'ahli-k3-umum';
            this.selectedCategory = serviceSelect.selectedOptions[0].dataset.category || 'pelatihan';
        }
        this.seoTitle = this.selectedServiceName + ' di ' + this.selectedCityName + ' - Sertifikasi Resmi Kemnaker RI';
        this.metaDesc = 'Pusat layanan resmi ' + this.selectedServiceName + ' di ' + this.selectedCityName + '. Jadwal pembinaan, sertifikat Kemnaker RI/BNSP, dan sentra praktik terdekat.';
        this.customHeading = 'Pusat ' + this.selectedServiceName + ' Resmi Wilayah ' + this.selectedCityName;
    }
}" class="min-h-screen bg-[#070D18] pb-16">

    <!-- 1. Bento Command Header Bar -->
    <div class="w-full bg-[#080E19] border-b border-[#1E324E] px-4 lg:px-8 py-3 sticky top-18 z-40">
        <div class="max-w-[1600px] mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <!-- Left: Logo & Context -->
            <div class="flex items-center gap-3">
                <div class="bg-[#0D7A5F]/20 p-2 text-[#10B981] border border-[#0D7A5F] shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <span class="font-space font-bold text-sm lg:text-base text-[#F1F5F9] tracking-tight">PORTAL CMS NASIONAL</span>
                        <span class="font-space font-bold text-[10px] bg-[#0F2038] text-[#10B981] border border-[#0D7A5F] px-2 py-0.5">BENTO COMMAND v2.4</span>
                    </div>
                    <span class="font-space text-[11px] text-[#64748B]">Sinkronisasi Multikota Kemnaker RI &bull; 212 Kota/Kab Terhubung</span>
                </div>
            </div>

            <!-- Center: Fast Switch Nav -->
            <div class="hidden xl:flex items-center gap-1 bg-[#0F2038] border border-[#1E324E] p-1 font-space text-xs uppercase">
                <a href="{{ route('home') }}" target="_blank" class="px-3 py-1 text-[#94A3B8] hover:text-[#10B981] hover:bg-[#142338] transition">Live Web &nearr;</a>
                <a href="{{ route('category.show', 'pelatihan') }}" target="_blank" class="px-3 py-1 text-[#94A3B8] hover:text-[#10B981] hover:bg-[#142338] transition">Katalog</a>
                <a href="{{ route('sitemap') }}" target="_blank" class="px-3 py-1 text-[#94A3B8] hover:text-[#10B981] hover:bg-[#142338] transition">Sitemap XML</a>
            </div>

            <!-- Right: Status Indicators & Profile Pill + Logout -->
            <div class="flex items-center flex-wrap gap-2.5">
                <div class="hidden sm:flex items-center gap-2 bg-[#0B1526] border border-[#1E324E] px-3 py-1.5">
                    <span class="w-2 h-2 bg-[#10B981] inline-block animate-pulse"></span>
                    <span class="font-space text-[11px] text-[#10B981] font-semibold">SSO AKTIF</span>
                </div>

                <!-- Admin Profile Pill -->
                <div class="flex items-center bg-[#0F2038] border border-[#1E324E] pl-2.5 pr-1.5 py-1 gap-2.5">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 bg-[#10B981] inline-block"></span>
                        <span class="font-space font-bold text-xs text-[#F1F5F9]">{{ session('admin_username', 'admin') }}</span>
                        <span class="text-[10px] font-space text-[#64748B] uppercase">[Superuser]</span>
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0">
                        @csrf
                        <button type="submit" class="bg-[#0B1526] hover:bg-red-900/60 border border-[#1E324E] hover:border-red-500 text-[#94A3B8] hover:text-red-200 text-[11px] font-space font-semibold px-2.5 py-1 transition-colors flex items-center gap-1" title="Sign Out Administrator">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
    <div class="max-w-[1600px] mx-auto px-4 lg:px-8 mt-4">
        <div class="bg-[#0B1526] border border-[#0D7A5F] border-l-4 border-l-[#10B981] p-3.5 flex items-center justify-between text-xs text-[#10B981] font-space">
            <div class="flex items-center gap-2 font-semibold">
                <span>&#10003;</span>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-[#94A3B8] hover:text-white">&times;</button>
        </div>
    </div>
    @endif

    <div class="max-w-[1600px] mx-auto px-4 lg:px-8 py-6 space-y-6">

        <!-- 2. Top Bento Metric Strip (4 Responsive Metric Bento Cards) -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Metric 1: Total Services -->
            <div class="bg-[#0F2038] border border-[#1E324E] p-4 flex flex-col justify-between hover:border-[#0D7A5F] transition relative group">
                <div class="absolute top-0 right-0 w-8 h-8 bg-[#0D7A5F]/10 border-b border-l border-[#1E324E] flex items-center justify-center text-[#10B981] text-xs font-mono">01</div>
                <div class="text-[#94A3B8] font-space text-[10px] uppercase tracking-wider mb-1">TOTAL LAYANAN AKTIF</div>
                <div class="font-space text-3xl font-bold text-[#F1F5F9] my-0.5">{{ $stats['total_services'] }}</div>
                <div class="flex items-center gap-1.5 text-[11px] font-space text-[#94A3B8] pt-2 border-t border-[#1E324E]/60 mt-2">
                    <span class="text-[#10B981] font-semibold">{{ $stats['total_pelatihan'] }} Diklat</span>
                    <span>&bull;</span>
                    <span class="text-[#38BDF8] font-semibold">{{ $stats['total_kajian'] }} Kajian</span>
                    <span>&bull;</span>
                    <span class="text-[#F59E0B] font-semibold">{{ $stats['total_jasa'] }} Jasa</span>
                </div>
            </div>

            <!-- Metric 2: Coverage Target -->
            <div class="bg-[#0F2038] border border-[#1E324E] p-4 flex flex-col justify-between hover:border-[#38BDF8] transition relative group">
                <div class="absolute top-0 right-0 w-8 h-8 bg-[#38BDF8]/10 border-b border-l border-[#1E324E] flex items-center justify-center text-[#38BDF8] text-xs font-mono">02</div>
                <div class="text-[#94A3B8] font-space text-[10px] uppercase tracking-wider mb-1">CAKUPAN TERPETAKAN</div>
                <div class="font-space text-3xl font-bold text-[#F1F5F9] my-0.5">{{ $stats['total_cities'] }} <span class="text-sm font-normal text-[#94A3B8]">Kota</span></div>
                <div class="flex items-center gap-1 text-[11px] font-space text-[#10B981] pt-2 border-t border-[#1E324E]/60 mt-2">
                    <span>100% Terintegrasi ({{ $stats['total_hubs'] }} Hub Sentra)</span>
                </div>
            </div>

            <!-- Metric 3: Active Batches -->
            <div class="bg-[#0F2038] border border-[#1E324E] p-4 flex flex-col justify-between hover:border-[#F59E0B] transition relative group">
                <div class="absolute top-0 right-0 w-8 h-8 bg-[#F59E0B]/10 border-b border-l border-[#1E324E] flex items-center justify-center text-[#F59E0B] text-xs font-mono">03</div>
                <div class="text-[#94A3B8] font-space text-[10px] uppercase tracking-wider mb-1">REGISTRASI BATCH AKTIF</div>
                <div class="font-space text-3xl font-bold text-[#F1F5F9] my-0.5">{{ number_format($stats['active_batches']) }}</div>
                <div class="flex items-center gap-1 text-[11px] font-space text-[#10B981] pt-2 border-t border-[#1E324E]/60 mt-2">
                    <span>+18.4% Matriks Peserta Nasional</span>
                </div>
            </div>

            <!-- Metric 4: Published Articles & Overrides -->
            <div class="bg-[#0F2038] border border-[#1E324E] p-4 flex flex-col justify-between hover:border-[#7cd8b8] transition relative group">
                <div class="absolute top-0 right-0 w-8 h-8 bg-[#0D7A5F]/10 border-b border-l border-[#1E324E] flex items-center justify-center text-[#10B981] text-xs font-mono">04</div>
                <div class="text-[#94A3B8] font-space text-[10px] uppercase tracking-wider mb-1">ARTIKEL &amp; SEO OVERRIDES</div>
                <div class="font-space text-3xl font-bold text-[#F1F5F9] my-0.5">{{ $stats['total_overrides'] }} <span class="text-sm font-normal text-[#94A3B8]">Overrides</span></div>
                <div class="flex items-center gap-1 text-[11px] font-space text-[#94A3B8] pt-2 border-t border-[#1E324E]/60 mt-2">
                    <span class="text-[#10B981]">SEO Wilayah Aktif &amp; Terindeks</span>
                </div>
            </div>
        </div>

        <!-- 3. 12-COLUMN MAIN SECTION SPLIT -->
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">
            
            <!-- ════════════════════════════════════════════════════════════════ -->
            <!-- LEFT 8 COLUMNS: MAIN DATA MANAGEMENT & CRUD                    -->
            <!-- ════════════════════════════════════════════════════════════════ -->
            <div class="xl:col-span-8 space-y-4">
                
                <!-- Tab Switching Bento Bar -->
                <div class="bg-[#0F2038] border border-[#1E324E] p-1.5 flex flex-wrap gap-1 font-space text-xs uppercase">
                    <button 
                        @click="activeTab = 'services'"
                        :class="activeTab === 'services' ? 'bg-[#0D7A5F] text-white font-bold' : 'text-[#94A3B8] hover:text-white hover:bg-[#142338]'"
                        class="px-4 py-2 transition-colors flex items-center gap-2"
                    >
                        <span>1. Layanan Master</span>
                        <span class="bg-[#070D18] px-1.5 py-0.5 text-[10px] text-[#10B981]">{{ $stats['total_services'] }}</span>
                    </button>

                    <button 
                        @click="activeTab = 'cities'"
                        :class="activeTab === 'cities' ? 'bg-[#0D7A5F] text-white font-bold' : 'text-[#94A3B8] hover:text-white hover:bg-[#142338]'"
                        class="px-4 py-2 transition-colors flex items-center gap-2"
                    >
                        <span>2. Sentra Kota</span>
                        <span class="bg-[#070D18] px-1.5 py-0.5 text-[10px] text-[#10B981]">{{ $stats['total_cities'] }}</span>
                    </button>

                    <button 
                        @click="activeTab = 'overrides'"
                        :class="activeTab === 'overrides' ? 'bg-[#0D7A5F] text-white font-bold' : 'text-[#94A3B8] hover:text-white hover:bg-[#142338]'"
                        class="px-4 py-2 transition-colors flex items-center gap-2"
                    >
                        <span>3. Overrides Konten SEO</span>
                        <span class="bg-[#070D18] px-1.5 py-0.5 text-[10px] text-[#10B981]">{{ $stats['total_overrides'] }}</span>
                    </button>
                </div>

                <!-- ── TAB 1: MANAJEMEN LAYANAN ──────────────────────────────── -->
                <div x-show="activeTab === 'services'" class="space-y-4">
                    
                    <div class="bg-[#0F2038] border border-[#1E324E] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="font-space font-bold text-base text-[#F1F5F9]">Katalog Master Layanan K3</h2>
                                <span class="font-space text-[10px] bg-[#0B1526] text-[#10B981] border border-[#0D7A5F] px-2 py-0.5">CRUD ENGINE</span>
                            </div>
                            <p class="text-xs text-[#94A3B8] mt-0.5">Kelola 62 entri layanan nasional (Pelatihan, Kajian, Jasa Perizinan).</p>
                        </div>
                        <button @click="addingService = !addingService" class="btn-primary text-xs py-2 px-3.5 shrink-0">
                            + Tambah Layanan
                        </button>
                    </div>

                    <!-- Form Tambah Layanan Baru -->
                    <div x-show="addingService" x-transition class="bg-[#0B1526] border border-[#0D7A5F] p-5 space-y-4">
                        <div class="border-b border-[#1E324E] pb-2 flex justify-between items-center">
                            <h3 class="font-space font-bold text-xs text-[#10B981] uppercase">+ Form Tambah Layanan K3 Baru</h3>
                            <button @click="addingService = false" class="text-xs text-[#94A3B8] hover:text-white">[ Batal ]</button>
                        </div>

                        <form action="{{ route('admin.services.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-3">
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
                                <input type="text" name="badge" placeholder="Kemnaker RI / BNSP" class="input-k3 w-full">
                            </div>
                            <div>
                                <label class="block text-xs font-space text-[#94A3B8] mb-1">Durasi</label>
                                <input type="text" name="duration" placeholder="Contoh: 12 Hari" class="input-k3 w-full">
                            </div>
                            <div>
                                <label class="block text-xs font-space text-[#94A3B8] mb-1">Estimasi Biaya</label>
                                <input type="text" name="price_estimate" placeholder="Contoh: Rp 5.500.000" class="input-k3 w-full">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-xs font-space text-[#94A3B8] mb-1">Deskripsi Ringkas Layanan</label>
                                <textarea name="description" rows="2" class="input-k3 w-full h-auto py-2" placeholder="Deskripsi pemenuhan regulasi dan sertifikasi..."></textarea>
                            </div>
                            <div class="md:col-span-3 flex justify-end gap-2 pt-1">
                                <button type="button" @click="addingService = false" class="btn-secondary text-xs py-2 px-4">Batal</button>
                                <button type="submit" class="btn-primary text-xs py-2 px-5">Simpan Layanan &rarr;</button>
                            </div>
                        </form>
                    </div>

                    <!-- Filter & Search Bar -->
                    <div class="bg-[#0B1526] border border-[#1E324E] p-3 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="flex flex-wrap items-center gap-1.5">
                            <a href="{{ route('admin.dashboard', ['tab' => 'services']) }}" class="px-2.5 py-1 font-space text-xs uppercase {{ empty($categoryFilter) ? 'bg-[#0D7A5F] text-white' : 'bg-[#070D18] text-[#94A3B8] border border-[#1E324E]' }}">
                                Semua ({{ $stats['total_services'] }})
                            </a>
                            <a href="{{ route('admin.dashboard', ['tab' => 'services', 'category' => 'pelatihan']) }}" class="px-2.5 py-1 font-space text-xs uppercase {{ $categoryFilter === 'pelatihan' ? 'bg-[#0D7A5F] text-white' : 'bg-[#070D18] text-[#94A3B8] border border-[#1E324E]' }}">
                                Pelatihan ({{ $stats['total_pelatihan'] }})
                            </a>
                            <a href="{{ route('admin.dashboard', ['tab' => 'services', 'category' => 'kajian']) }}" class="px-2.5 py-1 font-space text-xs uppercase {{ $categoryFilter === 'kajian' ? 'bg-[#0D7A5F] text-white' : 'bg-[#070D18] text-[#94A3B8] border border-[#1E324E]' }}">
                                Kajian ({{ $stats['total_kajian'] }})
                            </a>
                            <a href="{{ route('admin.dashboard', ['tab' => 'services', 'category' => 'jasa']) }}" class="px-2.5 py-1 font-space text-xs uppercase {{ $categoryFilter === 'jasa' ? 'bg-[#0D7A5F] text-white' : 'bg-[#070D18] text-[#94A3B8] border border-[#1E324E]' }}">
                                Jasa ({{ $stats['total_jasa'] }})
                            </a>
                        </div>

                        <form action="{{ route('admin.dashboard') }}" method="GET" class="w-full sm:w-64">
                            <input type="hidden" name="tab" value="services">
                            <input type="hidden" name="category" value="{{ $categoryFilter }}">
                            <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama / slug..." class="input-k3 w-full text-xs font-space h-8">
                        </form>
                    </div>

                    <!-- Services Table -->
                    <div class="overflow-x-auto border border-[#1E324E] bg-[#070D18]">
                        <table class="w-full text-left text-xs font-body border-collapse">
                            <thead>
                                <tr class="bg-[#0F2038] text-[#94A3B8] font-space text-[11px] uppercase border-b border-[#1E324E]">
                                    <th class="py-2.5 px-3"># ID</th>
                                    <th class="py-2.5 px-3">Kategori</th>
                                    <th class="py-2.5 px-3">Nama Layanan</th>
                                    <th class="py-2.5 px-3">Akreditasi</th>
                                    <th class="py-2.5 px-3">Status</th>
                                    <th class="py-2.5 px-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#142338]">
                                @foreach($services as $serv)
                                <tr class="bg-[#070D18] hover:bg-[#0B1526] transition-colors">
                                    <td class="py-2.5 px-3 font-space text-[#64748B]">{{ $serv->id }}</td>
                                    <td class="py-2.5 px-3">
                                        <span class="px-1.5 py-0.5 text-[9px] font-space uppercase {{ $serv->category === 'pelatihan' ? 'bg-[#0D7A5F]/20 text-[#10B981] border border-[#0D7A5F]' : ($serv->category === 'kajian' ? 'bg-[#38BDF8]/20 text-[#38BDF8] border border-[#38BDF8]' : 'bg-[#D97706]/20 text-[#F59E0B] border border-[#D97706]') }}">
                                            {{ $serv->category }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 font-medium text-[#F1F5F9]">
                                        {{ $serv->name }}
                                        <span class="text-[10px] text-[#64748B] block font-space">/{{ $serv->slug }}</span>
                                    </td>
                                    <td class="py-2.5 px-3 text-[#c5c6ce]">{{ $serv->badge ?? '-' }}</td>
                                    <td class="py-2.5 px-3">
                                        <span class="font-space text-[10px] uppercase font-bold {{ $serv->status === 'published' ? 'text-[#10B981]' : 'text-[#64748B]' }}">
                                            &bull; {{ $serv->status ?? 'published' }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 text-right space-x-2">
                                        <button 
                                            @click="editingService = {{ json_encode($serv) }}" 
                                            class="text-[#38BDF8] hover:underline font-space text-xs"
                                        >
                                            Edit
                                        </button>
                                        <a href="{{ route('service.detail', ['category' => $serv->category, 'serviceSlug' => $serv->slug]) }}" target="_blank" class="text-[#10B981] hover:underline font-space text-xs">
                                            Live &rarr;
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
                        <div class="bg-[#0F2038] border border-[#0D7A5F] max-w-xl w-full p-5 space-y-4 max-h-[90vh] overflow-y-auto">
                            <div class="border-b border-[#1E324E] pb-2 flex justify-between items-center">
                                <h3 class="font-space font-bold text-xs text-[#F1F5F9] uppercase">Edit Layanan: <span x-text="editingService ? editingService.name : ''" class="text-[#10B981]"></span></h3>
                                <button @click="editingService = null" class="text-xs text-[#94A3B8] hover:text-white">&times;</button>
                            </div>

                            <form :action="'/admin/services/' + (editingService ? editingService.id : '')" method="POST" class="space-y-3">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
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

                <!-- ── TAB 2: MANAJEMEN ALAMAT PERWAKILAN KOTA ────────────────── -->
                <div x-show="activeTab === 'cities'" class="space-y-4">
                    
                    <div class="bg-[#0F2038] border border-[#1E324E] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <h2 class="font-space font-bold text-base text-[#F1F5F9]">Alamat Perwakilan &amp; Sentra Praktik 212 Kota</h2>
                            <p class="text-xs text-[#94A3B8] mt-0.5">Kelola nama sentra, alamat kawasan industri (tanpa nomor rumah), dan koordinat geo-lokasi.</p>
                        </div>

                        <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center gap-2">
                            <input type="hidden" name="tab" value="cities">
                            <select name="island" class="input-k3 text-xs h-8" onchange="this.form.submit()">
                                <option value="">-- Semua Pulau --</option>
                                @foreach($islands as $isl)
                                    <option value="{{ $isl }}" {{ $islandFilter === $isl ? 'selected' : '' }}>{{ $isl }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="city_q" value="{{ $citySearch }}" placeholder="Cari kota / alamat..." class="input-k3 w-40 text-xs font-space h-8">
                            <button type="submit" class="btn-primary text-xs py-1.5 px-3">Cari</button>
                        </form>
                    </div>

                    <div class="overflow-x-auto border border-[#1E324E] bg-[#070D18]">
                        <table class="w-full text-left text-xs font-body border-collapse">
                            <thead>
                                <tr class="bg-[#0F2038] text-[#94A3B8] font-space text-[11px] uppercase border-b border-[#1E324E]">
                                    <th class="py-2.5 px-3"># ID</th>
                                    <th class="py-2.5 px-3">Kota / Kabupaten</th>
                                    <th class="py-2.5 px-3">Sentra Praktik K3</th>
                                    <th class="py-2.5 px-3">Alamat Kawasan</th>
                                    <th class="py-2.5 px-3">Hub Status</th>
                                    <th class="py-2.5 px-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#142338]">
                                @foreach($cities as $c)
                                <tr class="bg-[#070D18] hover:bg-[#0B1526] transition-colors">
                                    <td class="py-2.5 px-3 font-space text-[#64748B]">{{ $c->id }}</td>
                                    <td class="py-2.5 px-3 font-medium text-[#F1F5F9]">
                                        {{ $c->name }}
                                        <span class="text-[10px] text-[#64748B] block font-space">{{ $c->island }}</span>
                                    </td>
                                    <td class="py-2.5 px-3 text-[#10B981]">
                                        {{ $c->sentra_praktik ?? 'Belum diisi' }}
                                    </td>
                                    <td class="py-2.5 px-3 text-[#c5c6ce] max-w-xs truncate">
                                        {{ $c->address ?? 'Kawasan Industri ' . $c->name }}
                                    </td>
                                    <td class="py-2.5 px-3">
                                        @if($c->is_hub)
                                            <span class="px-1.5 py-0.5 text-[9px] font-space uppercase bg-[#10B981]/20 text-[#10B981] border border-[#10B981]">★ Hub</span>
                                        @else
                                            <span class="text-[#64748B] font-space text-[10px]">Cabang</span>
                                        @endif
                                    </td>
                                    <td class="py-2.5 px-3 text-right space-x-2">
                                        <button 
                                            @click="editingCity = {{ json_encode($c) }}" 
                                            class="text-[#38BDF8] hover:underline font-space text-xs"
                                        >
                                            Edit
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
                        <div class="bg-[#0F2038] border border-[#0D7A5F] max-w-lg w-full p-5 space-y-4">
                            <div class="border-b border-[#1E324E] pb-2 flex justify-between items-center">
                                <h3 class="font-space font-bold text-xs text-[#F1F5F9] uppercase">Edit Alamat: <span x-text="editingCity ? editingCity.name : ''" class="text-[#10B981]"></span></h3>
                                <button @click="editingCity = null" class="text-xs text-[#94A3B8] hover:text-white">&times;</button>
                            </div>

                            <form :action="'/admin/cities/' + (editingCity ? editingCity.id : '')" method="POST" class="space-y-3">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="block text-xs font-space text-[#94A3B8] mb-1">Nama Sentra Praktik K3</label>
                                    <input type="text" name="sentra_praktik" :value="editingCity ? editingCity.sentra_praktik : ''" placeholder="Contoh: Sentra Praktik K3 Singosari" class="input-k3 w-full">
                                </div>

                                <div>
                                    <label class="block text-xs font-space text-[#94A3B8] mb-1">Alamat Kawasan (Tanpa Nomor Rumah)</label>
                                    <input type="text" name="address" :value="editingCity ? editingCity.address : ''" placeholder="Contoh: Kawasan Industri Karanglo" class="input-k3 w-full">
                                </div>

                                <div class="grid grid-cols-2 gap-3">
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
                                    <label class="block text-xs font-space text-[#94A3B8] mb-1">Custom Maps Embed URL</label>
                                    <input type="text" name="maps_embed_url" :value="editingCity ? editingCity.maps_embed_url : ''" placeholder="https://maps.google.com/..." class="input-k3 w-full">
                                </div>

                                <div class="flex items-center gap-2 pt-1">
                                    <input type="checkbox" name="is_hub" id="is_hub_chk_modal" :checked="editingCity && editingCity.is_hub" class="w-4 h-4 bg-[#0B1526] border border-[#1E324E]">
                                    <label for="is_hub_chk_modal" class="text-xs font-space text-[#F1F5F9]">Tandai sebagai Hub Sentra K3 Utama</label>
                                </div>

                                <div class="flex justify-end gap-2 pt-2 border-t border-[#1E324E]">
                                    <button type="button" @click="editingCity = null" class="btn-secondary text-xs py-2 px-4">Batal</button>
                                    <button type="submit" class="btn-primary text-xs py-2 px-5">Simpan Alamat</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- ── TAB 3: OVERRIDES KONTEN & SEO WILAYAH ───────────────────── -->
                <div x-show="activeTab === 'overrides'" class="space-y-4">
                    <div class="bg-[#0F2038] border border-[#1E324E] p-4 flex justify-between items-center">
                        <div>
                            <h2 class="font-space font-bold text-base text-[#F1F5F9]">Overrides Konten &amp; SEO Wilayah Terdaftar</h2>
                            <p class="text-xs text-[#94A3B8] mt-0.5">Daftar konfigurasi judul &amp; meta description khusus per kombinasi kota/layanan.</p>
                        </div>
                        <span class="text-xs font-space text-[#10B981] bg-[#0B1526] border border-[#0D7A5F] px-2.5 py-1">{{ $stats['total_overrides'] }} Aktif</span>
                    </div>

                    <div class="overflow-x-auto border border-[#1E324E] bg-[#070D18]">
                        <table class="w-full text-left text-xs font-body border-collapse">
                            <thead>
                                <tr class="bg-[#0F2038] text-[#94A3B8] font-space text-[11px] uppercase border-b border-[#1E324E]">
                                    <th class="py-2.5 px-3">Kota</th>
                                    <th class="py-2.5 px-3">Layanan Terkait</th>
                                    <th class="py-2.5 px-3">Judul SEO Kustom</th>
                                    <th class="py-2.5 px-3">Meta Description</th>
                                    <th class="py-2.5 px-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#142338]">
                                @forelse($overrides as $ov)
                                <tr class="bg-[#070D18] hover:bg-[#0B1526] transition-colors">
                                    <td class="py-2.5 px-3 font-space font-bold text-[#10B981]">{{ $ov->city->name }}</td>
                                    <td class="py-2.5 px-3 text-[#F1F5F9]">{{ $ov->service ? $ov->service->name : 'Semua Layanan' }}</td>
                                    <td class="py-2.5 px-3 text-[#c5c6ce]">{{ $ov->seo_title }}</td>
                                    <td class="py-2.5 px-3 text-[#94A3B8] max-w-xs truncate">{{ $ov->meta_description }}</td>
                                    <td class="py-2.5 px-3 text-right">
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
                                        Gunakan form Quick SEO Editor di panel sebelah kanan untuk membuat override konten &amp; SEO baru.
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

            <!-- ════════════════════════════════════════════════════════════════ -->
            <!-- RIGHT 4 COLUMNS: LIVE GOOGLE SERP PREVIEW & WYSIWYG EDITOR     -->
            <!-- ════════════════════════════════════════════════════════════════ -->
            <div class="xl:col-span-4 space-y-5">
                
                <!-- BENTO BOX: LIVE GOOGLE SERP PREVIEW -->
                <div class="bg-[#0F2038] border border-[#1E324E] p-4 space-y-3 relative group">
                    <div class="flex items-center justify-between border-b border-[#1E324E] pb-2.5">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-[#4285F4] inline-block"></span>
                            <span class="font-space font-bold text-xs uppercase text-[#F1F5F9] tracking-wider">Live SERP Preview</span>
                        </div>
                        <span class="text-[10px] font-space bg-[#0B1526] text-[#38BDF8] border border-[#1E324E] px-2 py-0.5">Google Simulator</span>
                    </div>

                    <!-- Simulated Google Search Card (Industrial-Dark Variant) -->
                    <div class="bg-[#202124] border border-[#303134] p-3.5 space-y-1.5 font-sans">
                        <!-- Breadcrumbs -->
                        <div class="flex items-center gap-1.5 text-[11px] text-[#bdc1c6] font-mono truncate">
                            <span class="w-3.5 h-3.5 bg-[#0D7A5F] text-white flex items-center justify-center text-[9px] font-bold">TK</span>
                            <span>https://trainingkota.my.id &rsaquo; <span x-text="selectedCategory"></span> &rsaquo; kota-<span x-text="selectedCitySlug"></span></span>
                        </div>

                        <!-- SERP Title -->
                        <div class="text-[#8ab4f8] text-[15px] font-medium leading-snug hover:underline cursor-pointer">
                            <span x-text="seoTitle"></span>
                        </div>

                        <!-- Snippet Meta Description -->
                        <div class="text-[#bdc1c6] text-[12px] leading-relaxed line-clamp-3">
                            <span x-text="metaDesc"></span>
                        </div>
                    </div>

                    <!-- Counters & Diagnostics -->
                    <div class="grid grid-cols-2 gap-2 text-[10px] font-space pt-1">
                        <div class="bg-[#0B1526] border border-[#1E324E] p-2 flex justify-between items-center">
                            <span class="text-[#94A3B8]">Title Length:</span>
                            <span :class="seoTitle.length <= 60 ? 'text-[#10B981]' : 'text-[#F59E0B]'" class="font-bold">
                                <span x-text="seoTitle.length"></span> / 60
                            </span>
                        </div>
                        <div class="bg-[#0B1526] border border-[#1E324E] p-2 flex justify-between items-center">
                            <span class="text-[#94A3B8]">Meta Desc:</span>
                            <span :class="metaDesc.length <= 160 ? 'text-[#10B981]' : 'text-[#F59E0B]'" class="font-bold">
                                <span x-text="metaDesc.length"></span> / 160
                            </span>
                        </div>
                    </div>

                    <!-- Direct Live Landing Page Button -->
                    <a :href="'/' + selectedCategory + '/' + selectedServiceSlug + '/kota-' + selectedCitySlug" target="_blank" class="btn-secondary w-full py-2 text-xs flex items-center justify-center gap-1.5 text-[#38BDF8] border-[#38BDF8]/40 hover:border-[#38BDF8]">
                        <span>[ Pratinjau Live Landing Page ]</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>

                <!-- BENTO BOX: QUICK SEO EDITOR & WYSIWYG TOOLBAR -->
                <div class="bg-[#0F2038] border border-[#1E324E] p-4 space-y-3">
                    <div class="flex items-center justify-between border-b border-[#1E324E] pb-2.5">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-[#0D7A5F] inline-block"></span>
                            <span class="font-space font-bold text-xs uppercase text-[#F1F5F9] tracking-wider">Quick SEO Editor &amp; Form</span>
                        </div>
                        <span class="text-[10px] font-space text-[#10B981]">Instant Override</span>
                    </div>

                    <form action="{{ route('admin.city-contents.store') }}" method="POST" class="space-y-3">
                        @csrf

                        <!-- City Select -->
                        <div>
                            <label class="block text-[11px] font-space text-[#94A3B8] mb-1">Target Wilayah Kota *</label>
                            <select name="city_id" x-ref="citySelect" @change="updatePreviewFromSelection($refs.citySelect, $refs.serviceSelect)" required class="input-k3 w-full text-xs h-9">
                                @foreach($allCities as $ac)
                                    <option value="{{ $ac->id }}" data-name="{{ $ac->name }}" data-slug="{{ $ac->slug }}" {{ $ac->slug === 'malang' ? 'selected' : '' }}>
                                        {{ $ac->name }} ({{ $ac->island }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Service Select -->
                        <div>
                            <label class="block text-[11px] font-space text-[#94A3B8] mb-1">Target Layanan Spesifik (Opsional)</label>
                            <select name="service_id" x-ref="serviceSelect" @change="updatePreviewFromSelection($refs.citySelect, $refs.serviceSelect)" class="input-k3 w-full text-xs h-9">
                                <option value="" data-name="Pelatihan K3" data-slug="ahli-k3-umum" data-category="pelatihan">-- Seluruh Layanan (Level Kategori) --</option>
                                @foreach($allServices as $as)
                                    <option value="{{ $as->id }}" data-name="{{ $as->name }}" data-slug="{{ $as->slug }}" data-category="{{ $as->category }}" {{ $as->slug === 'ahli-k3-umum' ? 'selected' : '' }}>
                                        [{{ strtoupper($as->category) }}] {{ $as->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Title Field (Bound to SERP Title) -->
                        <div>
                            <label class="block text-[11px] font-space text-[#94A3B8] mb-1">Judul SEO (&lt;title&gt;)</label>
                            <input type="text" name="seo_title" x-model="seoTitle" class="input-k3 w-full text-xs h-9" placeholder="Masukkan judul SEO">
                        </div>

                        <!-- Meta Description (Bound to SERP Desc) -->
                        <div>
                            <label class="block text-[11px] font-space text-[#94A3B8] mb-1">Meta Description</label>
                            <textarea name="meta_description" x-model="metaDesc" rows="2" class="input-k3 w-full text-xs h-auto py-1.5" placeholder="Deskripsi meta untuk pencarian Google..."></textarea>
                        </div>

                        <!-- Custom Heading -->
                        <div>
                            <label class="block text-[11px] font-space text-[#94A3B8] mb-1">Custom Heading (H1)</label>
                            <input type="text" name="custom_heading" x-model="customHeading" class="input-k3 w-full text-xs h-9" placeholder="Heading utama regional">
                        </div>

                        <!-- WYSIWYG Quick Toolbar & Textarea -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-[11px] font-space text-[#94A3B8]">Konten Wilayah / Artikel</label>
                                <span class="text-[10px] font-space text-[#64748B]">WYSIWYG Bar</span>
                            </div>

                            <!-- Industrial Action Toolbar -->
                            <div class="bg-[#0B1526] border border-[#1E324E] border-b-0 p-1 flex flex-wrap gap-1 font-space text-[10px]">
                                <button type="button" @click="insertTag('<h2>', '</h2>')" class="px-2 py-1 bg-[#0F2038] hover:bg-[#142338] text-[#F1F5F9] border border-[#1E324E]" title="Heading 2">[ H2 ]</button>
                                <button type="button" @click="insertTag('<h3>', '</h3>')" class="px-2 py-1 bg-[#0F2038] hover:bg-[#142338] text-[#F1F5F9] border border-[#1E324E]" title="Heading 3">[ H3 ]</button>
                                <button type="button" @click="insertTag('<strong>', '</strong>')" class="px-2 py-1 bg-[#0F2038] hover:bg-[#142338] text-[#F1F5F9] border border-[#1E324E] font-bold" title="Bold Text">[ B ]</button>
                                <button type="button" @click="insertTable()" class="px-2 py-1 bg-[#0F2038] hover:bg-[#142338] text-[#10B981] border border-[#1E324E]" title="Insert Table Matriks">[ + Table Matriks ]</button>
                                <button type="button" @click="insertCallout()" class="px-2 py-1 bg-[#0F2038] hover:bg-[#142338] text-[#F59E0B] border border-[#1E324E]" title="Insert Callout Box">[ + Callout ]</button>
                                <button type="button" @click="insertTag('<ul>\n  <li>', '</li>\n</ul>')" class="px-2 py-1 bg-[#0F2038] hover:bg-[#142338] text-[#38BDF8] border border-[#1E324E]" title="List Points">[ + List ]</button>
                            </div>

                            <textarea 
                                name="custom_content" 
                                x-ref="wysiwygTextarea"
                                x-model="editorContent" 
                                rows="4" 
                                class="input-k3 w-full text-xs h-auto py-2 font-mono" 
                                placeholder="Tulis konten khusus, silabus lokal, atau artikel penunjang..."
                            ></textarea>
                        </div>

                        <div class="pt-1">
                            <button type="submit" class="btn-primary w-full py-2.5 text-xs">
                                Simpan Kustomisasi Konten &amp; SEO &rarr;
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
