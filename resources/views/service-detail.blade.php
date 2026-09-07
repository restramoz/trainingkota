@extends('layouts.app')

@section('content')
<!-- Breadcrumbs -->
<div class="bg-[#0B1526] border-b border-[#1E324E] py-3 text-xs font-space text-[#94A3B8]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 flex items-center space-x-2">
        <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
        <span>/</span>
        <a href="{{ route('category.show', $category) }}" class="hover:text-white uppercase">{{ $category }}</a>
        <span>/</span>
        <span class="text-[#10B981] font-semibold truncate">{{ $service->name }}</span>
    </div>
</div>

<!-- Header Section -->
<section class="bg-gradient-to-b from-[#0F2038] to-[#070D18] border-b border-[#1E324E] py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <div class="lg:col-span-8 space-y-6">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="badge-kemnaker">{{ $service->badge }}</span>
                    <span class="badge-bnsp">DURASI: {{ $service->duration }}</span>
                    <span class="badge-warning">TERDAFTAR DI 212 KOTA</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-space text-[#F1F5F9] leading-tight">
                    {{ $service->name }}
                </h1>

                <p class="text-base sm:text-lg text-[#94A3B8] leading-relaxed max-w-3xl">
                    {{ $service->description }}
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin TrainingKota, saya berminat mendaftar program ' . $service->name) }}" target="_blank" class="btn-primary">
                        Daftar Program Ini Sekarang
                    </a>
                    <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin TrainingKota, mohon kirimkan proposal silabus lengkap untuk ' . $service->name) }}" target="_blank" class="btn-whatsapp">
                        Minta Proposal &amp; Silabus
                    </a>
                </div>
            </div>

            <!-- Pricing & Key Spec Box -->
            <div class="lg:col-span-4">
                <div class="bg-[#0F2038] border border-[#1E324E] p-6 space-y-4">
                    <div class="border-b border-[#1E324E] pb-3">
                        <span class="text-[11px] font-space uppercase tracking-wider text-[#64748B] block">Investasi / Biaya</span>
                        <div class="text-xl font-bold font-space text-[#10B981]">{{ $service->price_estimate }}</div>
                        <span class="text-[10px] text-[#94A3B8]">*Sudah termasuk sertifikat &amp; modul resmi</span>
                    </div>

                    <div class="space-y-2 text-xs font-body">
                        <div class="flex justify-between py-1.5 border-b border-[#142338]">
                            <span class="text-[#94A3B8]">Kategori:</span>
                            <span class="text-[#F1F5F9] font-space uppercase font-semibold">{{ $service->category }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-[#142338]">
                            <span class="text-[#94A3B8]">Durasi Pelaksanaan:</span>
                            <span class="text-[#F1F5F9] font-space">{{ $service->duration }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-[#142338]">
                            <span class="text-[#94A3B8]">Sertifikasi:</span>
                            <span class="text-[#10B981] font-space font-semibold">{{ $service->badge }}</span>
                        </div>
                        <div class="flex justify-between py-1.5">
                            <span class="text-[#94A3B8]">Cakupan Wilayah:</span>
                            <span class="text-[#F1F5F9] font-space">212 Kota / In-House</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Details: Syllabus & Target Audience -->
<section class="py-16 border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <div class="lg:col-span-8 space-y-12">
                <!-- Syllabus Section -->
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold font-space text-[#F1F5F9] mb-6 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-[#0D7A5F] inline-block"></span>
                        Silabus &amp; Kurikulum Pelatihan
                    </h2>

                    @if(!empty($service->syllabus) && is_array($service->syllabus))
                        <div class="space-y-3">
                            @foreach($service->syllabus as $index => $item)
                                <div class="bg-[#0B1526] border border-[#1E324E] p-4 flex items-start gap-4">
                                    <span class="w-7 h-7 bg-[#0F2038] border border-[#1E324E] text-[#10B981] font-space font-bold flex items-center justify-center text-xs shrink-0">
                                        {{ sprintf('%02d', $index + 1) }}
                                    </span>
                                    <div>
                                        <h3 class="font-space font-bold text-sm text-[#F1F5F9] mb-1">{{ $item }}</h3>
                                        <p class="text-xs text-[#94A3B8]">Pembahasan teori, studi implementasi industri, dan bedah regulasi pemerintah terkait keselamatan kerja operasional.</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Target Audience Section -->
                <div class="bg-[#0F2038] border border-[#1E324E] p-6">
                    <h2 class="text-lg font-bold font-space text-[#F1F5F9] mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 bg-[#10B981] inline-block"></span>
                        Sasaran Peserta &amp; Persyaratan K3
                    </h2>
                    <p class="text-xs text-[#c5c6ce] leading-relaxed mb-4">
                        {{ $service->target_audience }}
                    </p>
                    <ul class="text-xs text-[#94A3B8] space-y-1.5 font-body">
                        <li class="flex items-center gap-2"><span class="text-[#0D7A5F] font-bold">&#10003;</span> Salinan KTP &amp; Ijazah Pendidikan Terakhir</li>
                        <li class="flex items-center gap-2"><span class="text-[#0D7A5F] font-bold">&#10003;</span> Surat Keterangan Kerja atau Utusan Perusahaan (bagi peserta korporat)</li>
                        <li class="flex items-center gap-2"><span class="text-[#0D7A5F] font-bold">&#10003;</span> Surat Keterangan Sehat dari Dokter</li>
                    </ul>
                </div>
            </div>

            <!-- Sidebar Form -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-[#0B1526] border border-[#1E324E] p-6">
                    <h3 class="font-space font-bold text-sm uppercase text-[#F1F5F9] mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 bg-[#0D7A5F] inline-block"></span>
                        Daftar Batch di Kota Pilihan
                    </h3>

                    <form action="#" method="POST" onsubmit="event.preventDefault(); window.open('https://wa.me/6281234567890?text=' + encodeURIComponent('Halo Admin TrainingKota, saya mendaftar ' + '{{ $service->name }}' + ' untuk lokasi: ' + document.getElementById('reg-city').value), '_blank');" class="space-y-4">
                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Kota Pelaksanaan</label>
                            <select id="reg-city" class="input-k3 w-full">
                                @foreach($hubCities as $hub)
                                    <option value="{{ $hub->name }}">{{ $hub->name }} (Hub Utama)</option>
                                @endforeach
                                <option value="Online / Blended">Full Online / Virtual Interactive</option>
                                <option value="In-House Training Perusahaan">In-House Training di Pabrik Kami</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Nama Lengkap</label>
                            <input type="text" placeholder="Nama Peserta / HSE Lead" class="input-k3 w-full" required>
                        </div>

                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Nama Perusahaan / Instansi</label>
                            <input type="text" placeholder="PT / CV / Lembaga" class="input-k3 w-full" required>
                        </div>

                        <button type="submit" class="btn-primary w-full py-3 text-xs tracking-wider">
                            Kirim Formulir Pendaftaran via WA &rarr;
                        </button>
                    </form>
                </div>

                <!-- Related Services -->
                <div class="bg-[#0F2038] border border-[#1E324E] p-6">
                    <h4 class="font-space font-bold text-xs uppercase text-[#F1F5F9] mb-4">Program Terkait</h4>
                    <div class="space-y-3">
                        @foreach($relatedServices as $rel)
                            <a href="{{ route('service.detail', ['category' => $category, 'serviceSlug' => $rel->slug]) }}" class="block p-3 bg-[#0B1526] border border-[#142338] hover:border-[#0D7A5F] transition-colors">
                                <div class="font-space font-bold text-xs text-[#F1F5F9] hover:text-[#10B981]">{{ $rel->name }}</div>
                                <div class="text-[11px] text-[#64748B] font-space mt-1">{{ $rel->badge }} &bull; {{ $rel->duration }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
