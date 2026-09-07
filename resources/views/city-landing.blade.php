@extends('layouts.app')

@section('content')
<!-- Regional City Header -->
<section class="bg-gradient-to-b from-[#0F2038] to-[#070D18] border-b border-[#1E324E] py-14 lg:py-18">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center space-x-2 text-xs font-space uppercase text-[#94A3B8] mb-4">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <a href="{{ route('category.show', $category) }}" class="hover:text-white uppercase">{{ $category }}</a>
            <span>/</span>
            <span class="text-[#10B981] font-semibold">{{ $city->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-8 space-y-5">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="badge-kemnaker">WILAYAH OPERASIONAL RESMI</span>
                    <span class="badge-bnsp">PULAU: {{ strtoupper($city->island) }}</span>
                    @if($city->is_hub)
                        <span class="badge-warning">★ HUB K3 UTAMA</span>
                    @endif
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-space text-[#F1F5F9] leading-tight">
                    {{ $categoryName }} di {{ $city->name }}
                </h1>

                <p class="text-base sm:text-lg text-[#94A3B8] leading-relaxed max-w-3xl">
                    Layanan resmi sertifikasi K3, audit SMK3 PP 50/2012, serta kajian teknis SLF dan riksa uji keteknikan untuk fasilitas industri, manufaktur, dan kontraktor di area <strong class="text-[#F1F5F9]">{{ $city->name }}</strong> dan sekitarnya.
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin TrainingKota, saya ingin konsultasi layanan ' . $categoryName . ' untuk area ' . $city->name) }}" target="_blank" class="btn-whatsapp">
                        Hubungi Koordinator Area {{ $city->name }}
                    </a>
                    <a href="#jadwal-kota" class="btn-secondary">
                        Cek Jadwal Batch di {{ $city->name }}
                    </a>
                </div>
            </div>

            <!-- Regional Dispatch Meta Card -->
            <div class="lg:col-span-4">
                <div class="bg-[#0F2038] border border-[#1E324E] p-6 space-y-4">
                    <div class="border-b border-[#1E324E] pb-3 flex items-center justify-between">
                        <span class="font-space font-bold text-xs uppercase text-[#F1F5F9]">STATUS REGIONAL KOTA</span>
                        <span class="w-2 h-2 bg-[#10B981] inline-block animate-ping"></span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between border-b border-[#142338] pb-2">
                            <span class="text-[#94A3B8]">Kota / Kabupaten:</span>
                            <span class="font-space font-bold text-[#F1F5F9]">{{ $city->name }}</span>
                        </div>
                        <div class="flex justify-between border-b border-[#142338] pb-2">
                            <span class="text-[#94A3B8]">Wilayah / Pulau:</span>
                            <span class="font-space text-[#F1F5F9]">{{ $city->island }}</span>
                        </div>
                        <div class="flex justify-between border-b border-[#142338] pb-2">
                            <span class="text-[#94A3B8]">Metode Pelaksanaan:</span>
                            <span class="font-space text-[#10B981]">Tatap Muka &amp; In-House</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[#94A3B8]">Kapasitas Batch:</span>
                            <span class="font-space text-[#F1F5F9]">25 Peserta / Kelas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Jadwal Batch Khusus Kota Ini -->
<section id="jadwal-kota" class="py-14 border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="mb-8">
            <span class="label-caps text-[#0D7A5F] block mb-2">JADWAL KHUSUS REGIONAL</span>
            <h2 class="text-2xl font-bold font-space text-[#F1F5F9]">
                Jadwal Batch {{ $categoryName }} di {{ $city->name }}
            </h2>
            <p class="text-xs text-[#94A3B8] mt-1">Kuota diperbarui secara langsung oleh tim registrasi cabang.</p>
        </div>

        <div class="overflow-x-auto border border-[#1E324E]">
            <table class="w-full text-left text-xs font-body border-collapse">
                <thead>
                    <tr class="bg-[#0F2038] text-[#94A3B8] font-space text-[11px] uppercase tracking-wider border-b border-[#1E324E]">
                        <th class="py-3 px-4 font-semibold">Kode Batch</th>
                        <th class="py-3 px-4 font-semibold">Nama Program Layanan</th>
                        <th class="py-3 px-4 font-semibold">Lokasi Pelaksanaan</th>
                        <th class="py-3 px-4 font-semibold">Tanggal</th>
                        <th class="py-3 px-4 font-semibold">Status Kuota</th>
                        <th class="py-3 px-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#142338]">
                    <tr class="bg-[#070D18]">
                        <td class="py-3.5 px-4 font-space font-bold text-[#F1F5F9]">BAT-{{ strtoupper(substr($city->slug, 0, 3)) }}-01</td>
                        <td class="py-3.5 px-4 font-medium text-[#F1F5F9]">Ahli K3 Umum Kemnaker RI</td>
                        <td class="py-3.5 px-4 text-[#94A3B8]">Hotel Partner di {{ $city->name }}</td>
                        <td class="py-3.5 px-4 text-[#c5c6ce]">Batch Terdekat Bulan Ini</td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1.5 text-[#10B981] font-space font-semibold uppercase text-[11px]">
                                <span class="w-1.5 h-1.5 bg-[#10B981] inline-block"></span>
                                Tersedia 5 Kursi
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin TrainingKota, saya booking kursi Ahli K3 Umum untuk batch di ' . $city->name) }}" target="_blank" class="btn-primary text-[11px] py-1.5 px-3">
                                Booking Slot
                            </a>
                        </td>
                    </tr>
                    <tr class="bg-[#0B1526]">
                        <td class="py-3.5 px-4 font-space font-bold text-[#F1F5F9]">BAT-{{ strtoupper(substr($city->slug, 0, 3)) }}-02</td>
                        <td class="py-3.5 px-4 font-medium text-[#F1F5F9]">Auditor SMK3 PP 50/2012 &amp; Riksa Uji</td>
                        <td class="py-3.5 px-4 text-[#94A3B8]">Pusat Pelatihan {{ $city->name }}</td>
                        <td class="py-3.5 px-4 text-[#c5c6ce]">Minggu Ke-3 Bulan Depan</td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1.5 text-[#F59E0B] font-space font-semibold uppercase text-[11px]">
                                <span class="w-1.5 h-1.5 bg-[#F59E0B] inline-block"></span>
                                Tersisa 3 Kursi
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin TrainingKota, saya booking kursi SMK3 untuk batch di ' . $city->name) }}" target="_blank" class="btn-primary text-[11px] py-1.5 px-3">
                                Booking Slot
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Available Services in this Category for this City -->
<section class="py-14 bg-[#0B1526]/40 border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="mb-8">
            <span class="label-caps text-[#0D7A5F] block mb-2">PILIHAN PROGRAM LENGKAP</span>
            <h2 class="text-2xl font-bold font-space text-[#F1F5F9]">
                Katalog Program {{ $categoryName }} di {{ $city->name }}
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($featuredServices as $serv)
                <div class="bg-[#0B1526] border border-[#1E324E] p-5 flex flex-col justify-between hover:border-[#0D7A5F] transition-colors">
                    <div>
                        <span class="badge-kemnaker text-[10px] mb-2">{{ $serv->badge }}</span>
                        <h3 class="font-space font-bold text-sm text-[#F1F5F9] mb-1">
                            <a href="{{ route('service.detail', ['category' => $category, 'serviceSlug' => $serv->slug]) }}" class="hover:text-[#10B981]">
                                {{ $serv->name }}
                            </a>
                        </h3>
                        <p class="text-[11px] text-[#94A3B8] line-clamp-2">{{ $serv->description }}</p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-[#142338] flex items-center justify-between text-xs">
                        <span class="font-space text-[11px] text-[#10B981]">{{ $serv->duration }}</span>
                        <a href="{{ route('service.detail', ['category' => $category, 'serviceSlug' => $serv->slug]) }}" class="text-[#38BDF8] hover:underline font-space text-[11px]">
                            Detail &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Other Cities in the Same Island/Region -->
@if(count($otherCitiesInIsland) > 0)
<section class="py-12 bg-[#0F2038]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <h3 class="font-space font-bold text-sm uppercase text-[#F1F5F9] mb-4">
            Kota Lainnya di Wilayah {{ $city->island }}
        </h3>
        <div class="flex flex-wrap gap-2">
            @foreach($otherCitiesInIsland as $other)
                <a href="{{ route('city.landing', ['category' => $category, 'citySlug' => $other->slug]) }}" class="px-3 py-1.5 bg-[#070D18] border border-[#1E324E] hover:border-[#0D7A5F] text-[#c5c6ce] hover:text-white text-xs font-space">
                    {{ $other->name }} &rarr;
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
