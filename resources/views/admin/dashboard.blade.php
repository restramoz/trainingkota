@extends('layouts.app')

@section('content')
<!-- Admin Command Bar -->
<section class="bg-[#0B1526] border-b border-[#1E324E] py-6">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2.5 h-2.5 bg-[#10B981] inline-block"></span>
                    <span class="font-space font-bold text-xs uppercase text-[#10B981] tracking-wider">CMS MANAGEMENT CONSOLE</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-bold font-space text-[#F1F5F9]">
                    Katalog &amp; Manajemen Lokasi Kota
                </h1>
                <p class="text-xs text-[#94A3B8] font-body mt-0.5">
                    Monitoring operasional 62 layanan K3 nasional dan 212 kota/kabupaten di seluruh Indonesia.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="btn-secondary text-xs py-2 px-4">
                    &larr; Lihat Website Utama
                </a>
            </div>
        </div>
    </div>
</section>

<!-- System Statistics Metrics Grid -->
<section class="py-8 bg-[#070D18] border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
            <div class="bg-[#0F2038] border border-[#1E324E] border-l-2 border-l-[#10B981] p-4">
                <span class="text-[10px] font-space uppercase tracking-wider text-[#94A3B8] block">Total Layanan</span>
                <span class="font-space text-2xl font-bold text-[#F1F5F9]">{{ $stats['total_services'] }}</span>
                <span class="text-[10px] text-[#10B981] block font-space">100% Aktif</span>
            </div>

            <div class="bg-[#0F2038] border border-[#1E324E] border-l-2 border-l-[#0D7A5F] p-4">
                <span class="text-[10px] font-space uppercase tracking-wider text-[#94A3B8] block">Pelatihan K3</span>
                <span class="font-space text-2xl font-bold text-[#F1F5F9]">{{ $stats['total_pelatihan'] }}</span>
                <span class="text-[10px] text-[#94A3B8] block font-space">Kemnaker / BNSP</span>
            </div>

            <div class="bg-[#0F2038] border border-[#1E324E] border-l-2 border-l-[#38BDF8] p-4">
                <span class="text-[10px] font-space uppercase tracking-wider text-[#94A3B8] block">Kajian Teknis</span>
                <span class="font-space text-2xl font-bold text-[#F1F5F9]">{{ $stats['total_kajian'] }}</span>
                <span class="text-[10px] text-[#38BDF8] block font-space">Studi Risiko</span>
            </div>

            <div class="bg-[#0F2038] border border-[#1E324E] border-l-2 border-l-[#D97706] p-4">
                <span class="text-[10px] font-space uppercase tracking-wider text-[#94A3B8] block">Jasa SLF/Izin</span>
                <span class="font-space text-2xl font-bold text-[#F1F5F9]">{{ $stats['total_jasa'] }}</span>
                <span class="text-[10px] text-[#F59E0B] block font-space">Legalitas Pabrik</span>
            </div>

            <div class="bg-[#0F2038] border border-[#1E324E] border-l-2 border-l-[#10B981] p-4">
                <span class="text-[10px] font-space uppercase tracking-wider text-[#94A3B8] block">Total Kota/Kab</span>
                <span class="font-space text-2xl font-bold text-[#F1F5F9]">{{ $stats['total_cities'] }}</span>
                <span class="text-[10px] text-[#10B981] block font-space">Se-Indonesia</span>
            </div>

            <div class="bg-[#0F2038] border border-[#1E324E] border-l-2 border-l-[#7cd8b8] p-4">
                <span class="text-[10px] font-space uppercase tracking-wider text-[#94A3B8] block">Hub Regional</span>
                <span class="font-space text-2xl font-bold text-[#F1F5F9]">{{ $stats['total_hubs'] }}</span>
                <span class="text-[10px] text-[#7cd8b8] block font-space">Titik Sentral</span>
            </div>
        </div>
    </div>
</section>

<!-- Admin Management Tables: Services & Cities -->
<section class="py-10">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 space-y-12">
        
        <!-- 1. Katalog Layanan Management -->
        <div class="bg-[#0F2038] border border-[#1E324E] p-6 space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-[#1E324E] pb-4">
                <div>
                    <h2 class="font-space font-bold text-lg text-[#F1F5F9] flex items-center gap-2">
                        <span class="w-2 h-2 bg-[#0D7A5F] inline-block"></span>
                        Katalog Layanan Terdaftar ({{ $stats['total_services'] }} Program)
                    </h2>
                    <p class="text-xs text-[#94A3B8]">Daftar seluruh program pelatihan, kajian, dan jasa teknis industri.</p>
                </div>

                <!-- Filters -->
                <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-wrap items-center gap-2">
                    <input type="hidden" name="city_q" value="{{ $citySearch }}">
                    <input type="hidden" name="island" value="{{ $islandFilter }}">
                    
                    <select name="category" class="input-k3 text-xs" onchange="this.form.submit()">
                        <option value="">-- Semua Kategori --</option>
                        <option value="pelatihan" {{ $categoryFilter === 'pelatihan' ? 'selected' : '' }}>Pelatihan (53)</option>
                        <option value="kajian" {{ $categoryFilter === 'kajian' ? 'selected' : '' }}>Kajian (3)</option>
                        <option value="jasa" {{ $categoryFilter === 'jasa' ? 'selected' : '' }}>Jasa (6)</option>
                    </select>

                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama layanan..." class="input-k3 text-xs w-48">
                    <button type="submit" class="btn-primary text-xs py-2 px-3">Cari</button>
                    @if($categoryFilter || $search)
                        <a href="{{ route('admin.dashboard') }}" class="text-xs text-[#94A3B8] hover:text-white underline">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto border border-[#1E324E]">
                <table class="w-full text-left text-xs font-body border-collapse">
                    <thead>
                        <tr class="bg-[#0B1526] text-[#94A3B8] font-space text-[11px] uppercase border-b border-[#1E324E]">
                            <th class="py-3 px-4"># ID</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Nama Layanan</th>
                            <th class="py-3 px-4">Akreditasi / Badge</th>
                            <th class="py-3 px-4">Durasi</th>
                            <th class="py-3 px-4">Estimasi Biaya</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#142338]">
                        @forelse($services as $serv)
                            <tr class="bg-[#070D18] hover:bg-[#142338] transition-colors">
                                <td class="py-3 px-4 font-space text-[#64748B]">{{ $serv->id }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 text-[10px] font-space uppercase {{ $serv->category === 'pelatihan' ? 'bg-[#0D7A5F]/20 text-[#10B981] border border-[#0D7A5F]' : ($serv->category === 'kajian' ? 'bg-[#38BDF8]/20 text-[#38BDF8] border border-[#38BDF8]' : 'bg-[#D97706]/20 text-[#F59E0B] border border-[#D97706]') }}">
                                        {{ $serv->category }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-medium text-[#F1F5F9]">{{ $serv->name }}</td>
                                <td class="py-3 px-4 text-[#c5c6ce] text-[11px]">{{ $serv->badge }}</td>
                                <td class="py-3 px-4 font-space text-[11px] text-[#94A3B8]">{{ $serv->duration }}</td>
                                <td class="py-3 px-4 font-space text-[11px] text-[#F1F5F9]">{{ $serv->price_estimate }}</td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('service.detail', ['category' => $serv->category, 'serviceSlug' => $serv->slug]) }}" target="_blank" class="text-[#38BDF8] hover:underline font-space text-xs">
                                        Buka Landing Page &rarr;
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 text-center text-[#94A3B8] font-space text-xs">
                                    Tidak ada layanan ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pt-2 text-xs font-space">
                {{ $services->links() }}
            </div>
        </div>

        <!-- 2. Lokasi Kota/Kabupaten Management -->
        <div class="bg-[#0F2038] border border-[#1E324E] p-6 space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-[#1E324E] pb-4">
                <div>
                    <h2 class="font-space font-bold text-lg text-[#F1F5F9] flex items-center gap-2">
                        <span class="w-2 h-2 bg-[#38BDF8] inline-block"></span>
                        Daftar 212 Kota/Kabupaten Wilayah Pelaksanaan
                    </h2>
                    <p class="text-xs text-[#94A3B8]">Cakupan regional untuk dynamic city landing pages se-Indonesia.</p>
                </div>

                <!-- Filters -->
                <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-wrap items-center gap-2">
                    <input type="hidden" name="q" value="{{ $search }}">
                    <input type="hidden" name="category" value="{{ $categoryFilter }}">
                    
                    <select name="island" class="input-k3 text-xs" onchange="this.form.submit()">
                        <option value="">-- Semua Pulau --</option>
                        @foreach($islands as $isl)
                            <option value="{{ $isl }}" {{ $islandFilter === $isl ? 'selected' : '' }}>{{ $isl }}</option>
                        @endforeach
                    </select>

                    <input type="text" name="city_q" value="{{ $citySearch }}" placeholder="Cari nama kota..." class="input-k3 text-xs w-48">
                    <button type="submit" class="btn-primary text-xs py-2 px-3">Cari Kota</button>
                    @if($islandFilter || $citySearch)
                        <a href="{{ route('admin.dashboard') }}" class="text-xs text-[#94A3B8] hover:text-white underline">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto border border-[#1E324E]">
                <table class="w-full text-left text-xs font-body border-collapse">
                    <thead>
                        <tr class="bg-[#0B1526] text-[#94A3B8] font-space text-[11px] uppercase border-b border-[#1E324E]">
                            <th class="py-3 px-4"># ID</th>
                            <th class="py-3 px-4">Nama Kota / Kabupaten</th>
                            <th class="py-3 px-4">Slug URL</th>
                            <th class="py-3 px-4">Wilayah / Pulau</th>
                            <th class="py-3 px-4">Status Hub</th>
                            <th class="py-3 px-4 text-right">Tautan Publik K3</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#142338]">
                        @forelse($cities as $c)
                            <tr class="bg-[#070D18] hover:bg-[#142338] transition-colors">
                                <td class="py-3 px-4 font-space text-[#64748B]">{{ $c->id }}</td>
                                <td class="py-3 px-4 font-medium text-[#F1F5F9]">{{ $c->name }}</td>
                                <td class="py-3 px-4 font-space text-[#94A3B8]">{{ $c->slug }}</td>
                                <td class="py-3 px-4 font-space text-[#c5c6ce]">{{ $c->island }}</td>
                                <td class="py-3 px-4">
                                    @if($c->is_hub)
                                        <span class="px-2 py-0.5 text-[10px] font-space uppercase bg-[#10B981]/20 text-[#10B981] border border-[#10B981]">
                                            ★ Hub Utama
                                        </span>
                                    @else
                                        <span class="text-[#64748B] font-space text-[11px]">Cabang</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right space-x-3">
                                    <a href="{{ route('city.landing', ['category' => 'pelatihan', 'citySlug' => $c->slug]) }}" target="_blank" class="text-[#10B981] hover:underline font-space text-xs">
                                        Pelatihan &rarr;
                                    </a>
                                    <a href="{{ route('city.landing', ['category' => 'jasa', 'citySlug' => $c->slug]) }}" target="_blank" class="text-[#F59E0B] hover:underline font-space text-xs">
                                        Jasa SLF &rarr;
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-[#94A3B8] font-space text-xs">
                                    Tidak ada kota ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pt-2 text-xs font-space">
                {{ $cities->links() }}
            </div>
        </div>

    </div>
</section>
@endsection
