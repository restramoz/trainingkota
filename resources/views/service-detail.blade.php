@extends('layouts.app')

@section('title', "{$service->name} - " . ucfirst($category) . " K3 Nasional & 212 Kota - TrainingKota")

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
                    <span class="badge-kemnaker">{{ $service->badge ?? 'Kemnaker RI' }}</span>
                    @if($category === 'pelatihan' && !empty($service->duration))
                        <span class="badge-bnsp">DURASI: {{ $service->duration }}</span>
                    @endif
                    <span class="badge-warning">LAYANAN NASIONAL &bull; 212 KOTA</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-space text-[#F1F5F9] leading-tight">
                    {{ $service->name }}
                </h1>

                <p class="text-base sm:text-lg text-[#94A3B8] leading-relaxed max-w-3xl font-body">
                    {{ $service->description }}
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    @if($category === 'pelatihan')
                        <a href="https://wa.me/{{ config('contact.whatsapp') }}?text={{ urlencode('Halo Admin TrainingKota, saya berminat mendaftar program pelatihan ' . $service->name) }}" target="_blank" class="btn-primary">
                            Booking Kursi Pelatihan Sekarang
                        </a>
                        <a href="https://wa.me/{{ config('contact.whatsapp') }}?text={{ urlencode('Halo Admin TrainingKota, mohon kirimkan proposal silabus lengkap untuk ' . $service->name) }}" target="_blank" class="btn-whatsapp">
                            Minta Proposal &amp; Silabus
                        </a>
                    @elseif($category === 'kajian')
                        <a href="https://wa.me/{{ config('contact.whatsapp') }}?text={{ urlencode('Halo Admin TrainingKota, kami ingin konsultasi kajian teknis: ' . $service->name) }}" target="_blank" class="btn-primary">
                            Konsultasi Kajian Teknis Fasilitas
                        </a>
                        <a href="https://wa.me/{{ config('contact.whatsapp') }}?text={{ urlencode('Halo Admin TrainingKota, mohon kirimkan Term of Reference (TOR) kajian ' . $service->name) }}" target="_blank" class="btn-whatsapp">
                            Minta Dokumen TOR &amp; Metodologi
                        </a>
                    @else
                        <a href="https://wa.me/{{ config('contact.whatsapp') }}?text={{ urlencode('Halo Admin TrainingKota, kami membutuhkan jasa teknis & riksa uji: ' . $service->name) }}" target="_blank" class="btn-primary">
                            Ajukan Permohonan Jasa / Riksa Uji
                        </a>
                        <a href="https://wa.me/{{ config('contact.whatsapp') }}?text={{ urlencode('Halo Admin TrainingKota, mohon kirimkan penawaran resmi untuk ' . $service->name) }}" target="_blank" class="btn-whatsapp">
                            Minta Penawaran Biaya Resmi
                        </a>
                    @endif
                </div>
            </div>

            <!-- Key Spec Box -->
            <div class="lg:col-span-4">
                <div class="bg-[#0F2038] border border-[#1E324E] p-6 space-y-4">
                    <div class="border-b border-[#1E324E] pb-3">
                        <span class="text-[11px] font-space uppercase tracking-wider text-[#64748B] block">Spesifikasi Layanan</span>
                        <div class="text-xl font-bold font-space text-[#10B981] uppercase">{{ ucfirst($category) }} K3</div>
                        <span class="text-[10px] text-[#94A3B8]">*Sesuai standar perundangan Kemnaker RI</span>
                    </div>

                    <div class="space-y-2 text-xs font-body">
                        <div class="flex justify-between py-1.5 border-b border-[#142338]">
                            <span class="text-[#94A3B8]">Kategori:</span>
                            <span class="text-[#F1F5F9] font-space uppercase font-semibold">{{ $category }}</span>
                        </div>
                        @if($category === 'pelatihan' && !empty($service->duration))
                            <div class="flex justify-between py-1.5 border-b border-[#142338]">
                                <span class="text-[#94A3B8]">Durasi:</span>
                                <span class="text-[#F1F5F9] font-space">{{ $service->duration }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between py-1.5 border-b border-[#142338]">
                            <span class="text-[#94A3B8]">Akreditasi / Lisensi:</span>
                            <span class="text-[#10B981] font-space font-semibold">{{ $service->badge ?? 'Kemnaker RI' }}</span>
                        </div>
                        <div class="flex justify-between py-1.5">
                            <span class="text-[#94A3B8]">Cakupan Wilayah:</span>
                            <span class="text-[#F1F5F9] font-space">212 Kota / In-House Site</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Technical Visual Archetype Component -->
<section class="max-w-7xl mx-auto px-4 lg:px-8">
    <x-service-visual :service="$service" :category="$category" />
</section>

<!-- Content Details: Category-Specific Structure -->
<section class="py-12 border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <div class="lg:col-span-8 space-y-12">

                @if($category === 'pelatihan')
                    <!-- PELATIHAN: Syllabus & Training Curriculum -->
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold font-space text-[#F1F5F9] mb-6 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 bg-[#0D7A5F] inline-block"></span>
                            Silabus &amp; Kurikulum Pelatihan
                        </h2>

                        @if(!empty($service->syllabus) && is_array($service->syllabus))
                            <x-syllabus-table
                                :syllabus="$service->syllabus"
                                description="Pembahasan teori, studi implementasi industri, dan bedah regulasi pemerintah terkait keselamatan kerja operasional."
                            />
                        @else
                            <div class="bg-[#0B1526] border border-[#1E324E] p-4 text-xs text-[#94A3B8] font-body">
                                Kurikulum dirancang sesuai pedoman Kemnaker RI dan standar BNSP terkini. Silabus lengkap mencakup regulasi dasar, manajemen risiko, pengoperasian alat, serta praktik PKL.
                            </div>
                        @endif
                    </div>

                    <!-- Target Audience Section -->
                    @if(!empty($service->target_audience))
                    <div class="bg-[#0F2038] border border-[#1E324E] p-6">
                        <h2 class="text-lg font-bold font-space text-[#F1F5F9] mb-3 flex items-center gap-2">
                            <span class="w-2 h-2 bg-[#10B981] inline-block"></span>
                            Sasaran Peserta &amp; Persyaratan Berkas
                        </h2>
                        <p class="text-xs text-[#c5c6ce] leading-relaxed mb-4 font-body">
                            {{ $service->target_audience }}
                        </p>
                        <ul class="text-xs text-[#94A3B8] space-y-1.5 font-body">
                            <li class="flex items-center gap-2"><span class="text-[#0D7A5F] font-bold">&#10003;</span> Salinan KTP &amp; Ijazah Pendidikan Terakhir (min. SMA/D3/S1 sesuai kelas sertifikasi)</li>
                            <li class="flex items-center gap-2"><span class="text-[#0D7A5F] font-bold">&#10003;</span> Surat Keterangan Kerja atau Utusan Perusahaan (bagi peserta korporat)</li>
                            <li class="flex items-center gap-2"><span class="text-[#0D7A5F] font-bold">&#10003;</span> Surat Keterangan Sehat dari Dokter</li>
                        </ul>
                    </div>
                    @endif

                    <!-- Dynamic Training Schedules (Pelatihan Only) -->
                    @if(!empty($schedules) && $schedules->count() > 0)
                    <div class="space-y-4">
                        <h2 class="text-xl lg:text-2xl font-bold font-space text-[#F1F5F9] flex items-center gap-2">
                            <span class="w-2.5 h-2.5 bg-[#10B981] inline-block"></span>
                            Jadwal Pembinaan Reguler Terdekat (Live Database)
                        </h2>
                        <div class="bg-[#0B1526] border border-[#1E324E] overflow-x-auto">
                            <table class="w-full text-left text-xs font-sans">
                                <thead class="bg-[#0F2038] border-b border-[#1E324E] text-[#94A3B8] font-space uppercase text-[10px] tracking-wider">
                                    <tr>
                                        <th class="p-3">Tanggal Batch</th>
                                        <th class="p-3">Kota / Wilayah</th>
                                        <th class="p-3">Lokasi Sentra</th>
                                        <th class="p-3">Sisa Kursi</th>
                                        <th class="p-3 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#142338]">
                                    @foreach($schedules as $sch)
                                    <tr class="hover:bg-[#070D18] transition">
                                        <td class="p-3 font-space font-bold text-[#F1F5F9] whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($sch->date)->isoFormat('D MMMM Y') }}
                                        </td>
                                        <td class="p-3 font-space text-[#10B981]">
                                            {{ $sch->city->name ?? 'Nasional' }}
                                        </td>
                                        <td class="p-3 text-[#94A3B8]">
                                            {{ $sch->location }}
                                        </td>
                                        <td class="p-3 font-space">
                                            <span class="px-2 py-0.5 border border-[#0D7A5F] text-[#10B981] bg-[#070D18] font-bold">
                                                {{ $sch->available_slots }} Kursi
                                            </span>
                                        </td>
                                        <td class="p-3 text-right">
                                            <a href="https://wa.me/{{ config('contact.whatsapp') }}?text={{ urlencode("Halo Admin TrainingKota, saya ingin booking kursi untuk {$service->name} batch " . \Carbon\Carbon::parse($sch->date)->format('d M Y') . " di {$sch->location}") }}" target="_blank" class="btn-primary py-1 px-3 text-[11px]">
                                                Booking &rarr;
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                @elseif($category === 'kajian')
                    <!-- KAJIAN: Methodology, Scope of Work, Deliverables (NO Syllabus/Schedules) -->
                    <div class="space-y-8">
                        <div>
                            <h2 class="text-xl lg:text-2xl font-bold font-space text-[#F1F5F9] mb-4 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 bg-[#38BDF8] inline-block"></span>
                                Metodologi &amp; Pendekatan Teknis Kajian
                            </h2>
                            <p class="text-sm text-[#94A3B8] leading-relaxed font-body mb-4">
                                Pelaksanaan kajian teknis ini menggunakan standar saintifik dan metodologi asesmen risiko keselamatan industri yang diakui secara nasional dan internasional. Seluruh data diverifikasi langsung oleh Tenaga Ahli K3 bersertifikat madya dan utama.
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-[#0B1526] border border-[#1E324E] p-4 space-y-2">
                                    <div class="font-space font-bold text-xs text-[#38BDF8] uppercase">1. Pengukuran Parameter Lapangan</div>
                                    <p class="text-xs text-[#94A3B8] font-body">Inspeksi langsung menggunakan peralatan uji terkalibrasi untuk memetakan deviasi teknis terhadap baku mutu regulasi.</p>
                                </div>
                                <div class="bg-[#0B1526] border border-[#1E324E] p-4 space-y-2">
                                    <div class="font-space font-bold text-xs text-[#38BDF8] uppercase">2. Pemodelan &amp; Analisis Kuantitatif</div>
                                    <p class="text-xs text-[#94A3B8] font-body">Simulasi skenario bahaya kegagalan struktur, ledakan, kebakaran, serta dispersi kontaminan gas beracun.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Scope of Work & Deliverables -->
                        <div class="bg-[#0F2038] border border-[#1E324E] p-6 space-y-4">
                            <h3 class="font-space font-bold text-base text-[#F1F5F9] uppercase">Ruang Lingkup (Scope of Work) &amp; Deliverables</h3>
                            <ul class="text-xs text-[#94A3B8] space-y-2 font-body">
                                <li class="flex items-start gap-2">
                                    <span class="text-[#38BDF8] font-bold">&#10003;</span>
                                    <span><strong>Desk Study &amp; Audit Dokumen:</strong> Analisis kesesuaian gambar as-built, SOP, dan izin eksisting.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-[#38BDF8] font-bold">&#10003;</span>
                                    <span><strong>Site Inspection &amp; Asesmen Fisik:</strong> Pengujian visual dan pengukuran parameter teknis di tapak pabrik.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-[#38BDF8] font-bold">&#10003;</span>
                                    <span><strong>Laporan Rekomendasi Resmi:</strong> Dokumen kajian teknis komprehensif berlegalisir Tenaga Ahli ber-SKA/SKP resmi.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-[#38BDF8] font-bold">&#10003;</span>
                                    <span><strong>Executive Presentation:</strong> Pemaparan hasil temuan kepada direksi dan manajemen fasilitas.</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                @else
                    <!-- JASA: Workflow, Process, Deliverables, Legal Compliance (NO Syllabus/Schedules) -->
                    <div class="space-y-8">
                        <div>
                            <h2 class="text-xl lg:text-2xl font-bold font-space text-[#F1F5F9] mb-4 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 bg-[#F59E0B] inline-block"></span>
                                Alur Proses Jasa Teknis &amp; Riksa Uji
                            </h2>
                            <p class="text-sm text-[#94A3B8] leading-relaxed font-body mb-4">
                                Layanan jasa teknis dan perizinan kelaikan fungsi operasional dirancang sistematis untuk memastikan pabrik Anda mematuhi seluruh perizinan keteknikan pemerintah tanpa mengganggu jalannya lini produksi.
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-[#0B1526] border border-[#1E324E] p-4 space-y-2">
                                    <div class="font-space font-bold text-xs text-[#F59E0B] uppercase">Tahap 1: Pengujian Teknis (NDT)</div>
                                    <p class="text-xs text-[#94A3B8] font-body">Pemeriksaan menyeluruh peralatan pesawat angkat/angkut, bejana tekan, instalasi listrik dan proteksi petir.</p>
                                </div>
                                <div class="bg-[#0B1526] border border-[#1E324E] p-4 space-y-2">
                                    <div class="font-space font-bold text-xs text-[#F59E0B] uppercase">Tahap 2: Pengawalan Dokumen &amp; Sidang</div>
                                    <p class="text-xs text-[#94A3B8] font-body">Penyusunan Berita Acara Riksa Uji hingga pengawalan proses penerbitan Surat Izin Layak Operasi resmi dari dinas berwenang.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Scope of Inspection & Deliverables -->
                        <div class="bg-[#0F2038] border border-[#1E324E] p-6 space-y-4">
                            <h3 class="font-space font-bold text-base text-[#F1F5F9] uppercase">Cakupan Pemeriksaan &amp; Output Dokumen</h3>
                            <ul class="text-xs text-[#94A3B8] space-y-2 font-body">
                                <li class="flex items-start gap-2">
                                    <span class="text-[#F59E0B] font-bold">&#10003;</span>
                                    <span><strong>Buku Hasil Pemeriksaan dan Pengujian:</strong> Buku laporan teknis bertandatangan Pengawas Ketenagakerjaan Spesialis.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-[#F59E0B] font-bold">&#10003;</span>
                                    <span><strong>Suket / Izin Operasional K3:</strong> Surat Keterangan Laik K3 dari Dinas Ketenagakerjaan Provinsi.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-[#F59E0B] font-bold">&#10003;</span>
                                    <span><strong>Stiker Kelaikan Alat:</strong> Label stiker inspeksi resmi dengan tanggal berlaku riksa uji berkala.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Dynamic FAQs (if exists) with Alpine.js Accordion -->
                @if(!empty($faqs) && $faqs->count() > 0)
                <div class="space-y-4 pt-6" x-data="{ activeAccordion: null }">
                    <h2 class="text-xl lg:text-2xl font-bold font-space text-[#F1F5F9] flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-[#10B981] inline-block"></span>
                        Tanya Jawab Seputar Layanan Ini (FAQ)
                    </h2>
                    <div class="space-y-3 font-space text-xs">
                        @foreach($faqs as $index => $faq)
                            <div class="bg-[#0B1526] border border-[#1E324E]">
                                <button
                                    @click="activeAccordion = (activeAccordion === {{ $index }} ? null : {{ $index }})"
                                    class="w-full text-left p-4 flex items-center justify-between text-[#F1F5F9] font-bold hover:text-[#10B981] transition">
                                    <span>{{ $faq->question }}</span>
                                    <span class="text-base text-[#10B981] ml-4 font-mono" x-text="activeAccordion === {{ $index }} ? '−' : '+'">+</span>
                                </button>
                                <div x-show="activeAccordion === {{ $index }}" x-collapse class="p-4 pt-0 text-[#94A3B8] font-body text-xs leading-relaxed border-t border-[#142338]">
                                    {{ $faq->answer }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            <!-- Sidebar Form -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-[#0B1526] border border-[#1E324E] p-6">
                    <h3 class="font-space font-bold text-sm uppercase text-[#F1F5F9] mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 bg-[#0D7A5F] inline-block"></span>
                        Hubungi Tim Teknis Regional
                    </h3>

                    <form action="#" method="POST" onsubmit="event.preventDefault(); window.open('https://wa.me/{{ config('contact.whatsapp') }}?text=' + encodeURIComponent('Halo Admin TrainingKota, saya berminat konsultasi program ' + '{{ $service->name }}' + ' untuk wilayah: ' + document.getElementById('reg-city').value), '_blank');" class="space-y-4">
                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Pilih Kota Wilayah</label>
                            <select id="reg-city" class="input-k3 w-full">
                                @foreach($hubCities as $hub)
                                    <option value="{{ $hub->name }}">{{ $hub->name }} (Hub Utama)</option>
                                @endforeach
                                <option value="In-House Site Industri">In-House di Pabrik Kami</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Nama Lengkap / Jabatan</label>
                            <input type="text" placeholder="Nama Anda / HSE Lead" class="input-k3 w-full" required>
                        </div>

                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1">Perusahaan / Pabrik</label>
                            <input type="text" placeholder="Nama Perusahaan" class="input-k3 w-full" required>
                        </div>

                        <button type="submit" class="btn-primary w-full py-3 text-xs tracking-wider">
                            Kirim Permohonan via WA &rarr;
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
                                <div class="text-[11px] text-[#64748B] font-space mt-1">{{ $rel->badge }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

