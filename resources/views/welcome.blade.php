@extends('layouts.app')

@section('content')
<!-- Hero Section: Industrial Command & Operational Status -->
<section class="border-b border-[#1E324E] bg-gradient-to-b from-[#0F2038] to-[#070D18] py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Column: Command & Compliance Headline -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Status Badges / Chips -->
                <div class="flex flex-wrap items-center gap-2">
                    <span class="badge-kemnaker">Kemnaker RI Certified</span>
                    <span class="badge-bnsp">BNSP Accredited</span>
                    <span class="badge-warning">Jadwal Audit Q3 2026 Dibuka</span>
                </div>

                <!-- Main Headline in Space Grotesk -->
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-space text-[#F1F5F9] leading-tight tracking-tight">
                    Komando Kepatuhan K3 &amp; Sertifikasi Teknis Industri Terpercaya
                </h1>

                <!-- Body in IBM Plex Sans -->
                <p class="text-base sm:text-lg text-[#94A3B8] leading-relaxed max-w-2xl font-body">
                    Platform operasional resmi pemenuhan regulasi keselamatan kerja (K3), sertifikasi personel Kemnaker RI / BNSP, serta jasa teknis SLF dan riksa uji keteknikan di seluruh Indonesia.
                </p>

                <!-- Action Triggers / Buttons (DESIGN.md specification) -->
                <div class="pt-4 flex flex-wrap items-center gap-4">
                    <a href="#katalog" class="btn-primary">
                        Jelajahi Sertifikasi K3
                    </a>
                    <a href="#jadwal" class="btn-secondary">
                        Cek Jadwal & Kuota Kota
                    </a>
                    <a href="https://wa.me/6281234567890" target="_blank" class="btn-whatsapp">
                        Konsultasi Cepat
                    </a>
                </div>

                <!-- Technical Parameter Notes -->
                <div class="pt-4 flex items-center gap-6 text-xs text-[#64748B] font-space uppercase tracking-wider">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-[#0D7A5F] inline-block"></span>
                        Terakreditasi PJK3 Resmi
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-[#0D7A5F] inline-block"></span>
                        Jaminan Sertifikat Asli
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-[#0D7A5F] inline-block"></span>
                        Sistem Validasi QR Nasional
                    </div>
                </div>
            </div>

            <!-- Right Column: Operational Quick Status Panel -->
            <div class="lg:col-span-5">
                <div class="bg-[#0F2038] border border-[#1E324E] p-6 space-y-6">
                    <div class="border-b border-[#1E324E] pb-4 flex items-center justify-between">
                        <div class="font-space font-bold text-xs uppercase tracking-wider text-[#F1F5F9] flex items-center gap-2">
                            <span class="w-2.5 h-2.5 bg-[#10B981] inline-block"></span>
                            STATUS OPERASIONAL REGIONAL
                        </div>
                        <span class="text-[11px] font-space text-[#10B981] uppercase font-semibold">SERVER LIVE</span>
                    </div>

                    <!-- Quick Registration Checklist / Form -->
                    <form action="#" method="POST" class="space-y-4" onsubmit="event.preventDefault();">
                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1.5 tracking-wider">Kategori Program K3</label>
                            <select class="input-k3 w-full">
                                <option>Ahli K3 Umum (Kemnaker RI) - Sertifikasi Penuh</option>
                                <option>Auditor SMK3 PP 50/2012</option>
                                <option>Ahli K3 Konstruksi (Muda / Madya / Utama)</option>
                                <option>Petugas K3 Kimia &amp; Ruang Terbatas (Confined Space)</option>
                                <option>Kajian SLF (Sertifikat Laik Fungsi Pabrik)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1.5 tracking-wider">Pilih Kota / Lokasi Pelaksanaan</label>
                            <div class="grid grid-cols-3 gap-1">
                                <button type="button" class="px-3 py-2 text-xs font-space uppercase bg-[#0D7A5F] text-white border border-[#0D7A5F] font-semibold text-center">Malang</button>
                                <button type="button" class="px-3 py-2 text-xs font-space uppercase bg-[#0B1526] text-[#94A3B8] hover:text-[#F1F5F9] border border-[#1E324E] text-center">Surabaya</button>
                                <button type="button" class="px-3 py-2 text-xs font-space uppercase bg-[#0B1526] text-[#94A3B8] hover:text-[#F1F5F9] border border-[#1E324E] text-center">Jakarta</button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1.5 tracking-wider">Nama Lengkap / Instansi</label>
                            <input type="text" placeholder="Contoh: PT Industri Maju Bersama / Ir. Budi" class="input-k3 w-full">
                        </div>

                        <div>
                            <label class="block text-xs font-space uppercase text-[#94A3B8] mb-1.5 tracking-wider">Nomor WhatsApp Aktif</label>
                            <input type="tel" placeholder="08xxxxxxxxxx" class="input-k3 w-full">
                        </div>

                        <button type="submit" class="btn-primary w-full py-3 text-xs tracking-wider">
                            Cek Ketersediaan Kuota &amp; Silabus
                        </button>
                    </form>

                    <div class="border-t border-[#1E324E] pt-3 text-[11px] text-[#64748B] flex items-center justify-between font-space">
                        <span>ESTIMASI RESPON: &lt; 5 MENIT</span>
                        <span class="text-[#10B981]">TERENKRIPSI 256-BIT</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Metrics & Verification Bar -->
<section class="border-b border-[#1E324E] bg-[#0B1526]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="border-l-2 border-[#0D7A5F] pl-4">
                <div class="font-space text-2xl lg:text-3xl font-bold text-[#F1F5F9]">24.850+</div>
                <div class="text-xs uppercase font-space tracking-wider text-[#94A3B8] mt-1">Alumni Tersertifikasi</div>
            </div>
            <div class="border-l-2 border-[#38BDF8] pl-4">
                <div class="font-space text-2xl lg:text-3xl font-bold text-[#F1F5F9]">1.420+</div>
                <div class="text-xs uppercase font-space tracking-wider text-[#94A3B8] mt-1">Klien Korporat B2B</div>
            </div>
            <div class="border-l-2 border-[#D97706] pl-4">
                <div class="font-space text-2xl lg:text-3xl font-bold text-[#F1F5F9]">38 Kota</div>
                <div class="text-xs uppercase font-space tracking-wider text-[#94A3B8] mt-1">Cakupan Pelatihan RI</div>
            </div>
            <div class="border-l-2 border-[#10B981] pl-4">
                <div class="font-space text-2xl lg:text-3xl font-bold text-[#F1F5F9]">100%</div>
                <div class="text-xs uppercase font-space tracking-wider text-[#94A3B8] mt-1">Legalitas &amp; Terverifikasi</div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Program Sertifikasi Unggulan (Compliance Cards) -->
<section id="katalog" class="py-16 lg:py-24 border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <div class="label-caps text-[#0D7A5F] mb-2 flex items-center gap-2">
                    <span class="w-2 h-2 bg-[#0D7A5F] inline-block"></span>
                    STANDAR KEMNAKER RI &amp; BNSP
                </div>
                <h2 class="text-2xl lg:text-3xl font-bold font-space text-[#F1F5F9]">
                    Katalog Sertifikasi K3 &amp; Keselamatan Industri
                </h2>
            </div>
            <div class="text-xs font-space text-[#94A3B8]">
                DIUPDATE SECARA REALTIME SESUAI REGULASI TERBARU
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="bg-[#0B1526] border border-[#1E324E] border-t-2 border-t-[#0D7A5F] p-6 flex flex-col justify-between hover:border-[#0D7A5F] transition-colors">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="badge-kemnaker">KEMNAKER RI</span>
                        <span class="text-xs font-space text-[#10B981] font-semibold">12 HARI INTENSIF</span>
                    </div>
                    <h3 class="text-lg font-bold font-space text-[#F1F5F9]">Ahli K3 Umum (AK3U)</h3>
                    <p class="text-xs text-[#94A3B8] leading-relaxed">
                        Mempersiapkan personel sebagai sekretaris P2K3 yang mampu mengawasi kepatuhan UU No. 1 Tahun 1970 di lingkungan kerja perusahaan.
                    </p>
                    <ul class="text-xs text-[#c5c6ce] space-y-2 border-t border-[#142338] pt-4 font-body">
                        <li class="flex items-center gap-2"><span class="text-[#0D7A5F]">&#10003;</span> SKP &amp; Lisensi K3 Resmi Kemnaker RI</li>
                        <li class="flex items-center gap-2"><span class="text-[#0D7A5F]">&#10003;</span> Modul Regulasi &amp; Praktik PKL Pabrik</li>
                        <li class="flex items-center gap-2"><span class="text-[#0D7A5F]">&#10003;</span> Akses Database Template Audit K3</li>
                    </ul>
                </div>
                <div class="pt-6 mt-6 border-t border-[#1E324E] flex items-center justify-between">
                    <div>
                        <span class="text-[10px] uppercase font-space text-[#64748B] block">Investasi Mulai</span>
                        <span class="font-space font-bold text-sm text-[#F1F5F9]">Rp 5.500.000</span>
                    </div>
                    <a href="#daftar" class="btn-primary text-xs py-2 px-4">Daftar Slot</a>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-[#0B1526] border border-[#1E324E] border-t-2 border-t-[#38BDF8] p-6 flex flex-col justify-between hover:border-[#38BDF8] transition-colors">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="badge-bnsp">BNSP SERTIFIKASI</span>
                        <span class="text-xs font-space text-[#38BDF8] font-semibold">4 HARI ASESMEN</span>
                    </div>
                    <h3 class="text-lg font-bold font-space text-[#F1F5F9]">Auditor SMK3 PP 50/2012</h3>
                    <p class="text-xs text-[#94A3B8] leading-relaxed">
                        Kualifikasi kompetensi profesional untuk mengevaluasi implementasi Sistem Manajemen Keselamatan dan Kesehatan Kerja 166 kriteria.
                    </p>
                    <ul class="text-xs text-[#c5c6ce] space-y-2 border-t border-[#142338] pt-4 font-body">
                        <li class="flex items-center gap-2"><span class="text-[#38BDF8]">&#10003;</span> Sertifikat Kompetensi BNSP Berlaku 3 Tahun</li>
                        <li class="flex items-center gap-2"><span class="text-[#38BDF8]">&#10003;</span> Metodologi Audit Lapangan Terstandar</li>
                        <li class="flex items-center gap-2"><span class="text-[#38BDF8]">&#10003;</span> Pelatihan Asesmen Gap Analysis</li>
                    </ul>
                </div>
                <div class="pt-6 mt-6 border-t border-[#1E324E] flex items-center justify-between">
                    <div>
                        <span class="text-[10px] uppercase font-space text-[#64748B] block">Investasi Mulai</span>
                        <span class="font-space font-bold text-sm text-[#F1F5F9]">Rp 4.250.000</span>
                    </div>
                    <a href="#daftar" class="btn-primary text-xs py-2 px-4">Daftar Slot</a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-[#0B1526] border border-[#1E324E] border-t-2 border-t-[#D97706] p-6 flex flex-col justify-between hover:border-[#D97706] transition-colors">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="badge-warning">AUDIT FISIK &amp; TEKNIS</span>
                        <span class="text-xs font-space text-[#F59E0B] font-semibold">KONSULTANSI INDUSTRI</span>
                    </div>
                    <h3 class="text-lg font-bold font-space text-[#F1F5F9]">Kajian SLF &amp; Riksa Uji Teknis</h3>
                    <p class="text-xs text-[#94A3B8] leading-relaxed">
                        Pemeriksaan kelaikan struktur bangunan pabrik, bejana tekan, pesawat uap, instalasi listrik, serta proteksi kebakaran gedung.
                    </p>
                    <ul class="text-xs text-[#c5c6ce] space-y-2 border-t border-[#142338] pt-4 font-body">
                        <li class="flex items-center gap-2"><span class="text-[#D97706]">&#10003;</span> Sertifikat Laik Fungsi Pabrik &amp; Gudang</li>
                        <li class="flex items-center gap-2"><span class="text-[#D97706]">&#10003;</span> Pengujian NDT Struktur &amp; Ketebalan Logam</li>
                        <li class="flex items-center gap-2"><span class="text-[#D97706]">&#10003;</span> Laporan Resmi Berita Acara Uji</li>
                    </ul>
                </div>
                <div class="pt-6 mt-6 border-t border-[#1E324E] flex items-center justify-between">
                    <div>
                        <span class="text-[10px] uppercase font-space text-[#64748B] block">Konsultasi Proposal</span>
                        <span class="font-space font-bold text-sm text-[#10B981]">Kajian Menyeluruh</span>
                    </div>
                    <a href="#daftar" class="btn-secondary text-xs py-2 px-4">Ajukan Audit</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Jadwal & Matriks Kuota Pelatihan (Data Table - DESIGN.md) -->
<section id="jadwal" class="py-16 lg:py-24 bg-[#0B1526]/40 border-b border-[#1E324E]">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="mb-10">
            <div class="label-caps text-[#0D7A5F] mb-2 flex items-center gap-2">
                <span class="w-2 h-2 bg-[#0D7A5F] inline-block"></span>
                MATRIKS JADWAL TERKINI
            </div>
            <h2 class="text-2xl lg:text-3xl font-bold font-space text-[#F1F5F9]">
                Jadwal Pelatihan &amp; Ketersediaan Kuota Kota
            </h2>
            <p class="text-sm text-[#94A3B8] mt-2">
                Pembaruan otomatis sistem registrasi pusat per 24 jam untuk koordinasi batch pelatihan.
            </p>
        </div>

        <!-- Strict Rectilinear Data Table -->
        <div class="overflow-x-auto border border-[#1E324E]">
            <table class="w-full text-left text-xs font-body border-collapse">
                <thead>
                    <tr class="bg-[#0F2038] text-[#94A3B8] font-space text-[11px] uppercase tracking-wider border-b border-[#1E324E]">
                        <th class="py-3 px-4 font-semibold">Kode Batch</th>
                        <th class="py-3 px-4 font-semibold">Nama Program</th>
                        <th class="py-3 px-4 font-semibold">Lokasi / Mode</th>
                        <th class="py-3 px-4 font-semibold">Tanggal Pelaksanaan</th>
                        <th class="py-3 px-4 font-semibold">Status Kuota</th>
                        <th class="py-3 px-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#142338]">
                    <!-- Row 1 -->
                    <tr class="bg-[#070D18] hover:bg-[#0F2038]/60 transition-colors">
                        <td class="py-3.5 px-4 font-space font-bold text-[#F1F5F9]">AK3U-MLG-84</td>
                        <td class="py-3.5 px-4 font-medium text-[#F1F5F9]">Ahli K3 Umum Kemnaker RI</td>
                        <td class="py-3.5 px-4 text-[#94A3B8]">Malang (Blended / Tatap Muka)</td>
                        <td class="py-3.5 px-4 text-[#c5c6ce]">15 - 28 Sept 2026</td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1.5 text-[#10B981] font-space font-semibold uppercase text-[11px]">
                                <span class="w-1.5 h-1.5 bg-[#10B981] inline-block"></span>
                                Tersisa 4 Kursi
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <a href="#daftar" class="btn-primary text-[11px] py-1.5 px-3">Ambil Slot</a>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr class="bg-[#0B1526] hover:bg-[#0F2038]/60 transition-colors">
                        <td class="py-3.5 px-4 font-space font-bold text-[#F1F5F9]">SMK3-SBY-42</td>
                        <td class="py-3.5 px-4 font-medium text-[#F1F5F9]">Auditor SMK3 PP 50/2012</td>
                        <td class="py-3.5 px-4 text-[#94A3B8]">Surabaya (Tatap Muka)</td>
                        <td class="py-3.5 px-4 text-[#c5c6ce]">22 - 25 Sept 2026</td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1.5 text-[#F59E0B] font-space font-semibold uppercase text-[11px]">
                                <span class="w-1.5 h-1.5 bg-[#F59E0B] inline-block"></span>
                                Tersisa 2 Kursi (Kritis)
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <a href="#daftar" class="btn-primary text-[11px] py-1.5 px-3">Ambil Slot</a>
                        </td>
                    </tr>
                    <!-- Row 3 -->
                    <tr class="bg-[#070D18] hover:bg-[#0F2038]/60 transition-colors">
                        <td class="py-3.5 px-4 font-space font-bold text-[#F1F5F9]">KIM-JKT-19</td>
                        <td class="py-3.5 px-4 font-medium text-[#F1F5F9]">Petugas K3 Kimia Industri</td>
                        <td class="py-3.5 px-4 text-[#94A3B8]">Jakarta (Full Online)</td>
                        <td class="py-3.5 px-4 text-[#c5c6ce]">05 - 09 Okt 2026</td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1.5 text-[#10B981] font-space font-semibold uppercase text-[11px]">
                                <span class="w-1.5 h-1.5 bg-[#10B981] inline-block"></span>
                                Tersisa 8 Kursi
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <a href="#daftar" class="btn-primary text-[11px] py-1.5 px-3">Ambil Slot</a>
                        </td>
                    </tr>
                    <!-- Row 4 -->
                    <tr class="bg-[#0B1526] hover:bg-[#0F2038]/60 transition-colors">
                        <td class="py-3.5 px-4 font-space font-bold text-[#F1F5F9]">SLF-JTM-08</td>
                        <td class="py-3.5 px-4 font-medium text-[#F1F5F9]">Kajian Teknis SLF Bangunan Industri</td>
                        <td class="py-3.5 px-4 text-[#94A3B8]">Jawa Timur (On-site Audit)</td>
                        <td class="py-3.5 px-4 text-[#c5c6ce]">Jadwal Fleksibel Perusahaan</td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1.5 text-[#38BDF8] font-space font-semibold uppercase text-[11px]">
                                <span class="w-1.5 h-1.5 bg-[#38BDF8] inline-block"></span>
                                Jadwal Terbuka
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <a href="#daftar" class="btn-secondary text-[11px] py-1.5 px-3">Ajukan Audit</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Section: Registration & Consultation Trigger -->
<section id="daftar" class="py-16 lg:py-24">
    <div class="max-w-5xl mx-auto px-4 lg:px-8">
        <div class="bg-[#0F2038] border border-[#1E324E] p-8 lg:p-12">
            <div class="max-w-2xl">
                <span class="label-caps text-[#0D7A5F] block mb-2">HUBUNGI COMMAND DESK TRAININGKOTA</span>
                <h2 class="text-2xl lg:text-3xl font-bold font-space text-[#F1F5F9] mb-4">
                    Konsultasikan Kebutuhan K3 Perusahaan Anda
                </h2>
                <p class="text-sm text-[#94A3B8] leading-relaxed mb-8">
                    Dapatkan silabus komprehensif, rincian biaya resmi, serta konsultasi kesiapan audit SMK3 dan SLF bersama tim konsultan ahli kami.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-[#1E324E]">
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-[#0D7A5F] flex items-center justify-center text-white text-xs font-bold font-space mt-0.5">1</div>
                        <div>
                            <div class="text-xs font-bold font-space uppercase text-[#F1F5F9]">Inquiry &amp; Konsultasi Kebutuhan</div>
                            <p class="text-xs text-[#94A3B8] mt-0.5">Hubungi representatif teknis kami untuk pemetaan sertifikasi K3 yang dibutuhkan instansi.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-[#0D7A5F] flex items-center justify-center text-white text-xs font-bold font-space mt-0.5">2</div>
                        <div>
                            <div class="text-xs font-bold font-space uppercase text-[#F1F5F9]">Penerbitan Surat Penawaran &amp; Jadwal</div>
                            <p class="text-xs text-[#94A3B8] mt-0.5">Kami menerbitkan proposal resmi, jadwal batch, dan syarat administrasi peserta Kemnaker RI.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-[#070D18] border border-[#1E324E] p-6 flex flex-col justify-between">
                    <div>
                        <div class="text-[11px] font-space uppercase tracking-wider text-[#64748B] mb-2">Fast Response Corporate Desk</div>
                        <div class="text-lg font-bold font-space text-[#25D366] mb-1">+62 812-3456-7890</div>
                        <div class="text-xs text-[#94A3B8]">Email: halo@trainingkota.my.id</div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-[#1E324E] flex flex-wrap gap-3">
                        <a href="https://wa.me/6281234567890" target="_blank" class="btn-whatsapp text-xs py-2.5 px-4 w-full text-center">
                            Chat via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
