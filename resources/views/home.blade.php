@extends('layouts.app')

@section('content')
<!-- Hero Section: Industrial Command & Compliance Center -->
<section class="border-b border-[#1E324E] bg-gradient-to-b from-[#0F2038] to-[#070D18] py-16 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-7 space-y-6">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="badge-kemnaker">Kemnaker RI Certified</span>
                    <span class="badge-bnsp">BNSP Accredited</span>
                    <span class="badge-warning">62 Program Layanan Terdaftar</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-space text-[#F1F5F9] leading-tight tracking-tight">
                    Pusat Komando K3 &amp; Kepatuhan Industri Nasional
                </h1>

                <p class="text-base sm:text-lg text-[#94A3B8] leading-relaxed max-w-2xl font-body">
                    Platform terpadu pelatihan keselamatan kerja, kajian kelayakan teknis, dan jasa perizinan SLF/AMDAL untuk perusahaan di <strong class="text-[#10B981]">212 Kota/Kabupaten</strong> di seluruh Indonesia.
                </p>

                <!-- Quick Action Buttons -->
                <div class="pt-2 flex flex-wrap items-center gap-4">
                    <a href="#tiga-pilar" class="btn-primary">
                        Jelajahi 3 Pilar Layanan
                    </a>
                    <a href="#widget-kota" class="btn-secondary">
                        Pilih 212 Kota Pelaksanaan
                    </a>
                    <a href="https://wa.me/{{ config('contact.whatsapp') }}" target="_blank" class="btn-whatsapp">
                        Hubungi Hotline WhatsApp
                    </a>
                </div>

                <div class="pt-4 flex flex-wrap items-center gap-6 text-xs text-[#64748B] font-space uppercase tracking-wider">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-[#0D7A5F] inline-block"></span>
                        53 Pelatihan K3
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-[#0D7A5F] inline-block"></span>
                        3 Kajian Risiko
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-[#0D7A5F] inline-block"></span>
                        6 Jasa SLF &amp; Izin
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-[#0D7A5F] inline-block"></span>
                        212 Kota Se-Indonesia
                    </div>
                </div>
            </div>

            <!-- Quick Inquiry Card -->
            <div class="lg:col-span-5">
                <div class="bg-[#0F2038] border border-[#1E324E] p-6 space-y-5">
                    <div class="border-b border-[#1E324E] pb-3 flex items-center justify-between">
                        <div class="font-space font-bold text-xs uppercase tracking-wider text-[#F1F5F9] flex items-center gap-2">
                            <span class="w-2.5 h-2.5 bg-[#10B981] inline-block"></span>
                            FAST DISPATCH INQUIRY
                        </div>
                        <span class="text-[11px] font-space text-[#10B981] uppercase font-semibold">RESPON &lt; 5 MENIT</span>
                    </div>

                    <form action="#" method="POST" onsubmit="event.preventDefault(); window.open('https://wa.me/{{ config('contact.whatsapp') }}?text=' + encodeURIComponent('Halo Admin TrainingKota, saya ingin konsultasi program K3 di kota saya.'), '_blank');" class="space-y-4">
                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1 tracking-wider">Pilih Kategori Kebutuhan</label>
                            <select id="quick-category" class="input-k3 w-full" onchange="window.location.href='/' + this.value">
                                <option value="pelatihan">1. Program Pelatihan K3 (53 Program)</option>
                                <option value="kajian">2. Kajian Teknis &amp; Risiko (3 Program)</option>
                                <option value="jasa">3. Jasa SLF, SLO &amp; Riksa Uji (6 Program)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1 tracking-wider">Pilih Kota Wilayah Anda</label>
                            <select id="quick-city" class="input-k3 w-full" onchange="if(this.value) window.location.href='/pelatihan/kota-' + this.value">
                                <option value="">-- Cari atau Pilih dari 212 Kota --</option>
                                @foreach($hubCities as $hub)
                                    <option value="{{ $hub->slug }}">★ {{ $hub->name }} (Hub Regional)</option>
                                @endforeach
                                <optgroup label="Kota Lainnya (Cek Widget 212 Kota di bawah)">
                                    <option value="malang">Kota Malang</option>
                                    <option value="surabaya">Surabaya</option>
                                    <option value="jakarta">Jakarta</option>
                                    <option value="balikpapan">Balikpapan</option>
                                </optgroup>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1 tracking-wider">Nama &amp; Perusahaan</label>
                            <input type="text" placeholder="PT Industri Sejahtera / Bapak Andy" class="input-k3 w-full">
                        </div>

                        <button type="submit" class="btn-primary w-full py-3 text-xs tracking-wider">
                            Hubungkan ke Tim Teknis via WhatsApp
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Section: 3 Pilar Layanan Utama -->
<section id="tiga-pilar" class="py-16 lg:py-24 border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="mb-12">
            <div class="label-caps text-[#0D7A5F] mb-2 flex items-center gap-2">
                <span class="w-2 h-2 bg-[#0D7A5F] inline-block"></span>
                KERANGKA KERJA K3 LENGKAP
            </div>
            <h2 class="text-2xl lg:text-3xl font-bold font-space text-[#F1F5F9]">
                3 Pilar Layanan TrainingKota
            </h2>
            <p class="text-sm text-[#94A3B8] mt-2 max-w-2xl">
                Solusi hulu ke hilir untuk sertifikasi personel, studi kelaikan risiko, dan pemenuhan perizinan wajib industri di seluruh Indonesia.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Pilar 1: Pelatihan -->
            <div class="bg-[#0B1526] border border-[#1E324E] border-t-4 border-t-[#0D7A5F] p-6 flex flex-col justify-between hover:border-[#0D7A5F] transition-all">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="badge-kemnaker">PILAR 1 &bull; 53 PROGRAM</span>
                        <span class="text-xs font-space text-[#10B981] font-semibold">SERTIFIKASI RESMI</span>
                    </div>
                    <h3 class="text-xl font-bold font-space text-[#F1F5F9]">Pelatihan &amp; Sertifikasi K3</h3>
                    <p class="text-xs text-[#94A3B8] leading-relaxed">
                        Sertifikasi kompetensi Ahli K3 Umum, SMK3, Operator Alat Berat, Boiler, K3 Kimia, DAMKAR, hingga POP Migas dan Lingkungan.
                    </p>
                    <div class="border-t border-[#142338] pt-4 space-y-2">
                        @foreach($pelatihanServices->take(4) as $s)
                            <a href="{{ route('service.detail', ['category' => 'pelatihan', 'serviceSlug' => $s->slug]) }}" class="block text-xs text-[#c5c6ce] hover:text-[#10B981] flex items-center justify-between">
                                <span>&bull; {{ $s->name }}</span>
                                <span class="text-[10px] text-[#64748B] font-space">{{ $s->duration }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="pt-6 mt-6 border-t border-[#1E324E]">
                    <a href="{{ route('category.show', 'pelatihan') }}" class="btn-primary w-full text-xs py-2.5 text-center">
                        Lihat 53 Program Pelatihan &rarr;
                    </a>
                </div>
            </div>

            <!-- Pilar 2: Kajian -->
            <div class="bg-[#0B1526] border border-[#1E324E] border-t-4 border-t-[#38BDF8] p-6 flex flex-col justify-between hover:border-[#38BDF8] transition-all">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="badge-bnsp">PILAR 2 &bull; 3 KAJIAN</span>
                        <span class="text-xs font-space text-[#38BDF8] font-semibold">AUDIT &amp; ANALISIS</span>
                    </div>
                    <h3 class="text-xl font-bold font-space text-[#F1F5F9]">Kajian Teknis &amp; Risiko K3</h3>
                    <p class="text-xs text-[#94A3B8] leading-relaxed">
                        Studi mendalam kelaikan keselamatan kerja, audit fire risk, maturity level budaya keselamatan perusahaan, dan dampak lingkungan industri.
                    </p>
                    <div class="border-t border-[#142338] pt-4 space-y-2">
                        @foreach($kajianServices as $s)
                            <a href="{{ route('service.detail', ['category' => 'kajian', 'serviceSlug' => $s->slug]) }}" class="block text-xs text-[#c5c6ce] hover:text-[#38BDF8] flex items-center justify-between">
                                <span>&bull; {{ $s->name }}</span>
                                <span class="text-[10px] text-[#64748B] font-space">{{ $s->duration }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="pt-6 mt-6 border-t border-[#1E324E]">
                    <a href="{{ route('category.show', 'kajian') }}" class="btn-secondary w-full text-xs py-2.5 text-center">
                        Lihat 3 Kajian Teknis &rarr;
                    </a>
                </div>
            </div>

            <!-- Pilar 3: Jasa -->
            <div class="bg-[#0B1526] border border-[#1E324E] border-t-4 border-t-[#D97706] p-6 flex flex-col justify-between hover:border-[#D97706] transition-all">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="badge-warning">PILAR 3 &bull; 6 JASA</span>
                        <span class="text-xs font-space text-[#F59E0B] font-semibold">LEGALITAS PABRIK</span>
                    </div>
                    <h3 class="text-xl font-bold font-space text-[#F1F5F9]">Jasa Teknis, SLF &amp; Izin</h3>
                    <p class="text-xs text-[#94A3B8] leading-relaxed">
                        Pendampingan pengurusan SLF pabrik, SLO instalasi listrik/genset, riksa uji SILO/SIA, UKL-UPL AMDAL, dan perizinan limbah B3.
                    </p>
                    <div class="border-t border-[#142338] pt-4 space-y-2">
                        @foreach($jasaServices->take(4) as $s)
                            <a href="{{ route('service.detail', ['category' => 'jasa', 'serviceSlug' => $s->slug]) }}" class="block text-xs text-[#c5c6ce] hover:text-[#F59E0B] flex items-center justify-between">
                                <span>&bull; {{ $s->name }}</span>
                                <span class="text-[10px] text-[#64748B] font-space">{{ $s->duration }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="pt-6 mt-6 border-t border-[#1E324E]">
                    <a href="{{ route('category.show', 'jasa') }}" class="btn-primary w-full text-xs py-2.5 text-center">
                        Lihat 6 Layanan Jasa Teknis &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Interactive Widget 212 Kota (Dynamic Search & Filter) -->
<section id="widget-kota" class="py-16 lg:py-24 bg-[#0B1526]/50 border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
            <div>
                <div class="label-caps text-[#0D7A5F] mb-2 flex items-center gap-2">
                    <span class="w-2 h-2 bg-[#0D7A5F] inline-block"></span>
                    JARINGAN OPERASIONAL NASIONAL
                </div>
                <h2 class="text-2xl lg:text-3xl font-bold font-space text-[#F1F5F9]">
                    Widget 212 Kota &amp; Kabupaten
                </h2>
                <p class="text-sm text-[#94A3B8] mt-1">
                    Cari kota Anda untuk membuka landing page kepatuhan K3 dan jadwal pelaksanaan lokal.
                </p>
            </div>
            
            <!-- Instant Live Search Bar -->
            <div class="w-full md:w-96">
                <label for="city-search-input" class="sr-only">Cari Kota</label>
                <div class="relative">
                    <input 
                        type="text" 
                        id="city-search-input" 
                        placeholder="Ketik nama kota (misal: Malang, Cikarang, Balikpapan)..." 
                        class="input-k3 w-full pl-10 pr-4 text-xs font-space"
                        oninput="filterCities(this.value)"
                    >
                    <div class="absolute left-3 top-3 text-[#64748B]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hub Regional Cities Quick Highlights -->
        <div class="mb-6 p-4 bg-[#0F2038] border border-[#1E324E] flex flex-wrap items-center gap-2">
            <span class="text-xs font-space font-bold uppercase text-[#F1F5F9] mr-2">Hub Utama:</span>
            @foreach($hubCities as $hub)
                <a href="{{ route('city.landing', ['category' => 'pelatihan', 'citySlug' => $hub->slug]) }}" class="px-3 py-1 bg-[#070D18] border border-[#0D7A5F] text-[#10B981] hover:bg-[#0D7A5F] hover:text-white transition-colors text-xs font-space uppercase">
                    ★ {{ $hub->name }}
                </a>
            @endforeach
        </div>

        <!-- Cities Grid Grouped by Island -->
        <div id="cities-container" class="space-y-8">
            @foreach($citiesGrouped as $island => $cities)
                <div class="island-group bg-[#070D18] border border-[#1E324E] p-6">
                    <div class="border-b border-[#1E324E] pb-3 mb-4 flex items-center justify-between">
                        <h3 class="font-space font-bold text-sm uppercase text-[#10B981] tracking-wider flex items-center gap-2">
                            <span class="w-2 h-2 bg-[#10B981] inline-block"></span>
                            Pulau / Wilayah: {{ $island }} ({{ count($cities) }} Kota)
                        </h3>
                        <span class="text-xs font-space text-[#64748B]">JADWAL AKTIF</span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2">
                        @foreach($cities as $city)
                            <a 
                                href="{{ route('city.landing', ['category' => 'pelatihan', 'citySlug' => $city->slug]) }}" 
                                class="city-item block px-3 py-2 bg-[#0B1526] hover:bg-[#0F2038] border border-[#142338] hover:border-[#0D7A5F] text-xs text-[#c5c6ce] hover:text-white transition-colors font-body truncate"
                                data-name="{{ strtolower($city->name) }}"
                            >
                                @if($city->is_hub)
                                    <span class="text-[#10B981] font-semibold">★</span>
                                @endif
                                {{ $city->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty search state -->
        <div id="no-city-found" class="hidden p-8 bg-[#0F2038] border border-[#1E324E] text-center text-[#94A3B8] font-space text-sm">
            Tidak ditemukan kota dengan kata kunci tersebut. Silakan hubungi admin kami untuk permintaan pelaksanaan in-house training di kota Anda.
        </div>
    </div>
</section>

<!-- Client-side City Filter Script (Zero dependency, instantaneous) -->
<script>
function filterCities(query) {
    query = query.toLowerCase().trim();
    const cityItems = document.querySelectorAll('.city-item');
    const islandGroups = document.querySelectorAll('.island-group');
    let totalVisible = 0;

    cityItems.forEach(item => {
        const name = item.getAttribute('data-name');
        if (!query || name.includes(query)) {
            item.style.display = 'block';
            totalVisible++;
        } else {
            item.style.display = 'none';
        }
    });

    islandGroups.forEach(group => {
        const visibleInGroup = group.querySelectorAll('.city-item:not([style*="display: none"])').length;
        group.style.display = visibleInGroup > 0 ? 'block' : 'none';
    });

    document.getElementById('no-city-found').classList.toggle('hidden', totalVisible > 0);
}
</script>
@endsection

