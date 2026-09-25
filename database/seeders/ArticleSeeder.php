<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Service;
use App\Models\City;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::truncate();

        $k3Umum = Service::where('slug', 'ahli-k3-umum')->first();
        $smk3 = Service::where('slug', 'smk3')->first();
        $slf = Service::where('slug', 'jasa-sertifikat-laik-fungsi-slf-dan-nomor-induk-data-instalasi-nidi')->first();
        $fireRisk = Service::where('slug', 'kajian-fire-risk-asessment')->first();

        $malang = City::where('slug', 'malang')->first();

        // ──────────────────────────────────────────────────────────────────
        // ARTIKEL 1: Panduan Ahli K3 Umum — Target Layanan Ahli K3 Umum
        // ──────────────────────────────────────────────────────────────────
        Article::create([
            'category'         => 'pelatihan',
            'city_id'          => null,
            'service_id'       => $k3Umum?->id,
            'title'            => 'Panduan Lengkap Sertifikasi Ahli K3 Umum Kemnaker RI: Syarat, Materi, dan Prosedur B2B Nasional',
            'slug'             => 'panduan-sertifikasi-ahli-k3-umum-kemnaker',
            'excerpt'          => 'Panduan komprehensif untuk memahami persyaratan, alur pendaftaran, materi ujian, dan prosedur sertifikasi Ahli K3 Umum yang diakui Kemnaker RI. Artikel ini membahas tuntas semua yang perlu diketahui sebelum mengikuti program pelatihan K3.',
            'reading_time'     => 8,
            'image'            => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=1200&auto=format&fit=crop',
            'seo_title'        => 'Panduan Sertifikasi Ahli K3 Umum Kemnaker RI | TrainingKota',
            'meta_description' => 'Panduan lengkap sertifikasi Ahli K3 Umum Kemnaker RI: syarat pendaftaran, materi ujian komprehensif, durasi pelatihan, biaya, dan cara mempertahankan sertifikat K3 Anda.',
            'focus_keywords'   => 'Ahli K3 Umum, Sertifikasi K3, Kemnaker RI, Pelatihan K3',
            'status'           => 'published',
            'faq_items'        => [
                ['q' => 'Siapa yang wajib memiliki sertifikat Ahli K3 Umum?', 'a' => 'Berdasarkan Permenaker No. 2 Tahun 1992, setiap perusahaan yang mempekerjakan lebih dari 100 orang atau menggunakan bahan/energi berbahaya WAJIB memiliki minimal 1 orang Ahli K3 Umum yang bersertifikat Kemnaker RI.'],
                ['q' => 'Berapa lama sertifikat Ahli K3 Umum berlaku?', 'a' => 'Sertifikat Ahli K3 Umum berlaku selama 3 tahun sejak tanggal penerbitan. Perpanjangan dilakukan melalui program perpanjangan SKP / lisensi Kemnaker RI.'],
                ['q' => 'Apakah sertifikat ini berlaku di seluruh kota di Indonesia?', 'a' => 'Ya. Sertifikat, Surat Keputusan Penunjukan (SKP), dan Lisensi K3 yang diterbitkan oleh Kementerian Ketenagakerjaan RI berlaku sah secara nasional di seluruh 514 kota dan kabupaten.'],
            ],
            'content' => <<<'HTML'
<h2>1. Eksekutif Ringkasan: Signifikansi Ahli K3 Umum dalam Lanskap Kepatuhan Industri</h2>
<p>Dalam ekosistem kepatuhan ketenagakerjaan modern di Indonesia, penunjukan Ahli Keselamatan dan Kesehatan Kerja (Ahli K3 Umum) bukan lagi sekadar formalitas pelengkap berkas administratif. Berdasarkan Undang-Undang No. 1 Tahun 1970 tentang Keselamatan Kerja dan Peraturan Menteri Tenaga Kerja No. PER-02/MEN/1992, sertifikasi Ahli K3 Umum adalah instrumen kepatuhan hukum wajib bagi korporasi yang mempekerjakan lebih dari 100 orang pekerja atau mengoperasikan instalasi berkadar risiko tinggi (seperti bahan kimia, boiler, instalasi listrik tegangan tinggi, bejana tekan, dan sistem mekanikal kompleks).</p>
<p>Kegagalan memenuhi penunjukan personel K3 bersertifikat Kemnaker RI secara langsung mengekspos perusahaan terhadap risiko sanksi administratif, pembekuan izin operasional fasilitas pabrik, pembatalan kepesertaan tender pengadaan B2B/BUMN, hingga potensi pertanggungjawaban pidana korporasi jika terjadi kecelakaan fatal (fatality incident) di tempat kerja.</p>

<h2>2. Landasan Hukum &amp; Matriks Regulasi Ketenagakerjaan</h2>
<p>Setiap entitas bisnis di Indonesia wajib menaati hierarki regulasi K3 berikut:</p>
<table class="w-full text-xs border border-[#1E324E] my-4">
  <thead>
    <tr class="bg-[#0F2038] text-white">
      <th class="p-2 border border-[#1E324E]">Dasar Regulasi</th>
      <th class="p-2 border border-[#1E324E]">Klausul Esensial</th>
      <th class="p-2 border border-[#1E324E]">Kewajiban Pengusaha</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="p-2 border border-[#1E324E]"><strong>UU No. 1 Tahun 1970</strong></td>
      <td class="p-2 border border-[#1E324E]">Pasal 1 ayat 6 &amp; Pasal 10</td>
      <td class="p-2 border border-[#1E324E]">Wajib membentuk P2K3 dan menempatkan personel pengawas K3 bersertifikat di setiap tempat kerja.</td>
    </tr>
    <tr>
      <td class="p-2 border border-[#1E324E]"><strong>Permenaker No. 02/MEN/1992</strong></td>
      <td class="p-2 border border-[#1E324E]">Tata Cara Penunjukan Ahli K3</td>
      <td class="p-2 border border-[#1E324E]">Menetapkan kualifikasi minimum (D3/S1 pengalaman kerja) dan mekanisme pengusulan SKP Ahli K3 ke Direktur PNK3 Kemnaker RI.</td>
    </tr>
    <tr>
      <td class="p-2 border border-[#1E324E]"><strong>PP No. 50 Tahun 2012</strong></td>
      <td class="p-2 border border-[#1E324E]">Penerapan SMK3</td>
      <td class="p-2 border border-[#1E324E]">Integrasi sistem manajemen K3 ke dalam strategi operasional korporasi secara terukur dan diaudit berkala.</td>
    </tr>
  </tbody>
</table>

<h2>3. Metodologi Implementasi K3 Terapan: Siklus PDCA &amp; HIRADC</h2>
<p>Kompetensi yang diasah dalam sertifikasi Ahli K3 Umum difokuskan pada kemampuan praktis membangun kerangka kerja pengendalian bahaya dengan siklus <em>Plan-Do-Check-Act (PDCA)</em>:</p>
<ul>
  <li><strong>Hazard Identification, Risk Assessment, and Determining Control (HIRADC):</strong> Pemetaan bahaya fisik, kimia, biologi, ergonomi, dan psikososial pada setiap stasiun kerja.</li>
  <li><strong>Job Safety Analysis (JSA) &amp; Permit to Work (PTW):</strong> Penerbitan izin kerja khusus untuk pekerjaan berisiko tinggi (pekerjaan panas, ruang terbatas/confined space, ketinggian, dan isolasi energi berbahaya LOTO).</li>
  <li><strong>Penyelidikan Insiden &amp; Root Cause Analysis:</strong> Menyelidiki akar masalah insiden dengan metodologi 5-Why Analysis dan Fishbone Diagram guna mencegah berulangnya kecelakaan serupa.</li>
</ul>

<h2>4. Kurikulum &amp; Silabus Pembinaan Kemnaker RI (120 Jam Pelajaran)</h2>
<p>Materi pembinaan Ahli K3 Umum diselenggarakan secara intensif selama 12 hari efektif kerja, mencakup 4 kelompok modul utama:</p>
<ol>
  <li><strong>Kelompok Dasar:</strong> Kebijakan Nasional K3, UU No. 1/1970, Konsep Dasar SMK3 PP 50/2012.</li>
  <li><strong>Kelompok Inti Teknis:</strong> K3 Mekanik, Pesawat Uap &amp; Bejana Tekan, K3 Listrik &amp; Petir, K3 Konstruksi &amp; Bangunan, K3 Penanggulangan Kebakaran, K3 Lingkungan Kerja &amp; Bahan Berbahaya (B3), serta Kesehatan Kerja &amp; Ergonomi.</li>
  <li><strong>Kelompok Keahlian Manajemen:</strong> Manajemen Risiko K3, Audit SMK3, Analisis Kecelakaan &amp; Statistik K3, serta Kelembagaan &amp; Program Kerja P2K3.</li>
  <li><strong>Praktek Kerja Lapangan (PKL) &amp; Ujian:</strong> Kunjungan inspeksi ke pabrik manufaktur mitra, penyusunan laporan observasi PKL, ujian tertulis komprehensif dari tim penguji Kemnaker RI, dan evaluasi presentasi seminar.</li>
</ol>

<h2>5. Mekanisme Penerbitan SKP &amp; Lisensi K3</h2>
<p>Setelah peserta dinyatakan lulus ujian oleh Dewan Penguji Kemnaker RI, Kementerian Ketenagakerjaan akan menerbitkan paket legalitas resmi yang terdiri dari:</p>
<ul>
  <li><strong>Sertifikat Ahli K3 Umum:</strong> Berlaku seumur hidup sebagai bukti kompetensi kelulusan pembinaan.</li>
  <li><strong>Surat Keputusan Penunjukan (SKP):</strong> Berlaku selama 3 tahun atas nama perusahaan tempat peserta bekerja.</li>
  <li><strong>Lisensi Kewenangan Ahli K3 (Kartu Lisensi):</strong> Tanda pengenal kewenangan resmi yang wajib dibawa saat menjalankan tugas inspeksi K3 di lapangan.</li>
</ul>

<h2>6. Solusi Pelaksanaan Nasional dari TrainingKota</h2>
<p>TrainingKota menyediakan fasilitas pembinaan Ahli K3 Umum berstandar nasional yang dapat diakses dari seluruh 514 kota dan kabupaten di Indonesia. Program kami didukung instruktur senior berlisensi master trainer, modul pembelajaran interaktif, simulasi audit pabrik terpadu, serta jaminan kelulusan di atas 95% dengan pendampingan intensif hingga SKP resmi terbit.</p>
HTML,
        ]);

        // ──────────────────────────────────────────────────────────────────
        // ARTIKEL 2: Panduan SMK3 PP 50/2012 — Target Layanan SMK3
        // ──────────────────────────────────────────────────────────────────
        Article::create([
            'category'         => 'pelatihan',
            'city_id'          => null,
            'service_id'       => $smk3?->id,
            'title'            => 'Strategi Implementasi & Audit SMK3 PP No. 50 Tahun 2012: Menuju Sertifikasi Bendera Emas',
            'slug'             => 'strategi-implementasi-audit-smk3-pp-50-2012',
            'excerpt'          => 'Panduan praktis penerapan Sistem Manajemen Keselamatan dan Kesehatan Kerja (SMK3) berdasarkan PP No. 50 Tahun 2012 untuk industri manufaktur dan konstruksi, termasuk checklist 166 kriteria dan strategi menghadapi audit resmi.',
            'reading_time'     => 10,
            'image'            => 'https://images.unsplash.com/photo-1504917599217-d4dc5ebe6122?q=80&w=1200&auto=format&fit=crop',
            'seo_title'        => 'Strategi Implementasi & Audit SMK3 PP 50/2012 | TrainingKota',
            'meta_description' => 'Panduan lengkap implementasi SMK3 PP 50/2012: 5 prinsip, 166 kriteria audit, prosedur internal audit, dan tips mendapatkan sertifikasi SMK3 tingkat emas.',
            'focus_keywords'   => 'SMK3 PP 50 2012, Audit SMK3, Sertifikasi SMK3, Sistem Manajemen K3',
            'status'           => 'published',
            'faq_items'        => [
                ['q' => 'Apakah perusahaan wajib menerapkan SMK3?', 'a' => 'Berdasarkan PP No. 50/2012 Pasal 5, perusahaan yang mempekerjakan pekerja/buruh paling sedikit 100 orang ATAU mempunyai tingkat potensi bahaya tinggi WAJIB menerapkan SMK3.'],
                ['q' => 'Apa kriteria penilaian untuk meraih Sertifikat Emas SMK3?', 'a' => 'Tingkat Pencapaian Emas diraih jika perusahaan memenuhi pencapaian 85% - 100% dari total 166 kriteria audit tingkat lanjutan tanpa adanya temuan kategori Mayor.'],
                ['q' => 'Berapa masa berlaku sertifikat audit SMK3?', 'a' => 'Sertifikat dan penghargaan bendera SMK3 berlaku selama 3 tahun sejak diterbitkan oleh Kemnaker RI.'],
            ],
            'content' => <<<'HTML'
<h2>1. Mengapa SMK3 PP No. 50 Tahun 2012 Merupakan Kewajiban Mutlak Korporasi?</h2>
<p>Sistem Manajemen Keselamatan dan Kesehatan Kerja (SMK3) yang diundangkan melalui Peraturan Pemerintah No. 50 Tahun 2012 merupakan rujukan hukum tertinggi implementasi sistem proteksi ketenagakerjaan di Indonesia. Berbeda dengan standar internasional ISO 45001 yang bersifat sukarela (voluntary), PP 50/2012 bersifat wajib (mandatory) bagi seluruh entitas bisnis yang memenuhi kriteria ambang batas.</p>
<p>Di era modern persaingan industri, sertifikasi SMK3 bukan hanya instrumen kepatuhan, melainkan prasayarat mutlak (pre-qualification) dalam kualifikasi vendor EPC, oil &amp; gas, manufaktur otomotif, logistik pelabuhan, serta tender proyek infrastruktur pemerintah pusat maupun daerah.</p>

<h2>2. Lima Prinsip Dasar Penerapan SMK3</h2>
<p>Penerapan SMK3 mengikuti 5 tahapan berkesinambungan yang terintegrasi secara menyeluruh:</p>
<ol>
  <li><strong>Penetapan Kebijakan K3:</strong> Komitmen tertulis direksi tertinggi yang disosialisasikan ke seluruh tingkatan organisasi dan dipajang di area publik pabrik.</li>
  <li><strong>Perencanaan K3:</strong> Penyusunan matriks HIRADC, pemenuhan inventaris regulasi perundangan, penetapan sasaran K3 SMART (Specific, Measurable, Achievable, Relevant, Time-bound), dan alokasi anggaran operasional K3 tahunan.</li>
  <li><strong>Pelaksanaan Rencana K3:</strong> Penyediaan sarana proteksi, penunjukan personel kompeten (Ahli K3, Petugas P3K, Regu Pemadam), prosedur tanggap darurat, dan manajemen keselamatan vendor/kontraktor.</li>
  <li><strong>Pemantauan dan Evaluasi Kinerja K3:</strong> Pelaksanaan inspeksi rutin tempat kerja, pemantauan higienitas lingkungan kerja (kebisingan, pencahayaan, kualitas udara), dan audit internal berkala minimal setahun sekali.</li>
  <li><strong>Peninjauan dan Peningkatan Kinerja K3:</strong> Rapat Tinjauan Manajemen (RTM) tahunan untuk mengevaluasi efektivitas sistem dan merumuskan langkah perbaikan berkelanjutan (continuous improvement).</li>
</ol>

<h2>3. Klasifikasi Kriteria Audit: Menuju Penghargaan Bendera Emas</h2>
<p>Audit SMK3 dilakukan oleh Lembaga Audit Independen yang ditunjuk Kemnaker RI dengan 3 tingkatan penerapan:</p>
<ul>
  <li><strong>Tingkat Awal:</strong> Terdiri dari 64 kriteria audit (untuk usaha kecil/menengah dengan potensi bahaya rendah).</li>
  <li><strong>Tingkat Transisi:</strong> Terdiri dari 122 kriteria audit.</li>
  <li><strong>Tingkat Lanjutan:</strong> Terdiri dari 166 kriteria audit (wajib bagi industri manufaktur besar, pertambangan, kimia, dan proyek berisiko tinggi).</li>
</ul>
<p>Penghargaan resmi Kemnaker RI terbagi atas:</p>
<ul>
  <li><em>Bendera Perak (Tingkat Baik):</em> Pemenuhan 60% - 84% kriteria.</li>
  <li><em>Bendera Emas (Tingkat Memuaskan):</em> Pemenuhan 85% - 100% kriteria.</li>
</ul>

<h2>4. Pendampingan Teknis End-to-End dari TrainingKota</h2>
<p>TrainingKota mendampingi tim HSE dan manajemen perusahaan dalam merancang SOP, dokumen manual SMK3, formulir operasional, pra-audit gap analysis, hingga mendampingi saat audit resmi dari auditor eksternal Kemnaker RI di seluruh kota/kabupaten se-Indonesia.</p>
HTML,
        ]);

        // ──────────────────────────────────────────────────────────────────
        // ARTIKEL 3: Panduan SLF Pabrik — Target Layanan SLF & NIDI
        // ──────────────────────────────────────────────────────────────────
        Article::create([
            'category'         => 'jasa',
            'city_id'          => null,
            'service_id'       => $slf?->id,
            'title'            => 'Panduan Lengkap Sertifikat Laik Fungsi (SLF) Bangunan Gedung Industri & Pabrik di Indonesia',
            'slug'             => 'panduan-sertifikat-laik-fungsi-slf-pabrik-industri',
            'excerpt'          => 'Panduan komprehensif pengurusan Sertifikat Laik Fungsi (SLF) untuk bangunan gedung industri, pabrik, dan gudang — mencakup dasar hukum, persyaratan teknis struktur & MEP, alur PBG/SIMBG, dan timeline perizinan resmi.',
            'reading_time'     => 9,
            'image'            => 'https://images.unsplash.com/photo-1513828583688-c52646db42da?q=80&w=1200&auto=format&fit=crop',
            'seo_title'        => 'Panduan SLF Bangunan Pabrik & Industri | TrainingKota',
            'meta_description' => 'Panduan lengkap pengurusan SLF (Sertifikat Laik Fungsi) untuk pabrik dan bangunan industri: dasar hukum, persyaratan teknis, dokumen, alur SIMBG, dan biaya estimasi.',
            'focus_keywords'   => 'SLF pabrik, Sertifikat Laik Fungsi, pengurusan SLF, SLF industri',
            'status'           => 'published',
            'faq_items'        => [
                ['q' => 'Apa perbedaan PBG dan SLF?', 'a' => 'PBG (Persetujuan Bangunan Gedung) adalah izin yang diterbitkan sebelum konstruksi dimulai. Sedangkan SLF (Sertifikat Laik Fungsi) adalah sertifikasi kelaikan yang diterbitkan setelah konstruksi selesai dan diuji secara teknis sebelum bangunan boleh dioperasikan.'],
                ['q' => 'Berapa lama masa berlaku SLF untuk pabrik industri?', 'a' => 'Berdasarkan PP No. 16 Tahun 2021, SLF untuk bangunan gedung fungsi khusus/industri berlaku selama 5 tahun dan wajib diperpanjang melalui kajian teknis berkala.'],
                ['q' => 'Apakah SLF wajib untuk seluruh wilayah di Indonesia?', 'a' => 'Wajib. Berdasarkan UU No. 28/2002 dan PP 16/2021, setiap bangunan industri di seluruh 514 kabupaten dan kota di Indonesia wajib mengantongi SLF.'],
            ],
            'content' => <<<'HTML'
<h2>1. Pengertian dan Kedudukan Hukum Sertifikat Laik Fungsi (SLF)</h2>
<p>Sertifikat Laik Fungsi (SLF) adalah sertifikat yang diterbitkan oleh Pemerintah Daerah melalui Dinas Pekerjaan Umum dan Penataan Ruang (PUPR) dan DPMPTSP untuk menyatakan kelaikan fungsi suatu bangunan gedung sebelum dapat dimanfaatkan secara legal. Berdasarkan Peraturan Pemerintah No. 16 Tahun 2021 tentang Peraturan Pelaksanaan Undang-Undang No. 28 Tahun 2002 tentang Bangunan Gedung pasca integrasi sistem SIMBG (Sistem Informasi Manajemen Bangunan Gedung), operasional pabrik atau gudang komersial tanpa kepemilikan SLF merupakan pelanggaran hukum berat.</p>

<h2>2. Resiko Hukum dan Bisnis Beroperasi Tanpa SLF</h2>
<p>Banyak pengelola pabrik menunda pengurusan SLF karena ketidaktahuan prosedur teknis. Namun, konsekuensi beroperasi tanpa SLF berdampak masif pada kelangsungan bisnis:</p>
<ul>
  <li><strong>Penolakan Klaim Asuransi:</strong> Polis asuransi kerugian properti dan asuransi kebakaran mensyaratkan kelaikan legalitas bangunan. Klaim asuransi saat terjadi kebakaran atau bencana dapat ditolak total jika fasilitas tidak ber-SLF.</li>
  <li><strong>Pemblokiran Izin Lingkungan &amp; OSS:</strong> Sistem OSS-RBA mengintegrasikan pemenuhan komitmen perizinan dasar dengan data SIMBG. Ketiadaan SLF dapat menghambat penerbitan izin operasional komersial.</li>
  <li><strong>Sanksi Administratif hingga Penyegelan:</strong> Satpol PP dan Dinas Tata Ruang berwenang menyegel serta menghentikan seluruh aktivitas operasional pabrik yang tidak ber-SLF.</li>
</ul>

<h2>3. Lingkup Pengujian Teknis Kelaikan Bangunan Pabrik</h2>
<p>Kajian teknis SLF mencakup 3 pilar pengujian mendalam yang dilakukan oleh tim ahli terakreditasi (PJPT):</p>
<ol>
  <li><strong>Kelaikan Arsitektur &amp; Keselamatan:</strong> Tata ruang fasilitas, kelengkapan jalur evakuasi darurat, lebar pintu darurat, titik kumpul (assembly point), proteksi pasif kebakaran, dan sarana aksesibilitas.</li>
  <li><strong>Kelaikan Struktur Bangunan:</strong> Pengujian nondestruktif (NDT hammer test, ultrasonik beton, ketebalan baja ultrasonic thickness gauge), verifikasi lendutan balok, kelaikan pondasi, dan ketahanan gempa berdasarkan SNI 1726 terbaru.</li>
  <li><strong>Kelaikan Mekanikal, Elektrikal &amp; Plumbing (MEP):</strong> Sertifikasi Laik Operasi (SLO) instalasi listrik dan NIDI, proteksi penangkal petir, sistem proteksi aktif kebakaran (hydrant, sprinkler, alarm, pompa pemadam kebakaran), ventilasi industri, dan pengolahan limbah air.</li>
</ol>

<h2>4. Solusi Pengurusan SLF Terpadu dari TrainingKota</h2>
<p>TrainingKota menghadirkan layanan One-Stop Solution pengurusan SLF untuk pabrik, gudang logistik, dan gedung komersial di seluruh wilayah Indonesia. Didukung tenaga ahli bersertifikat SKA Madya/Utama arsitektur, struktur, MEP, serta kemitraan resmi dengan laboratorium pengujian terakreditasi KAN, kami menjamin proses pengurusan SLF berlangsung transparan, tepat waktu, dan akuntabel.</p>
HTML,
        ]);

        // ──────────────────────────────────────────────────────────────────
        // ARTIKEL 4: City‑specific article for Malang
        // ──────────────────────────────────────────────────────────────────
        $malang = City::where('slug', 'malang')->first();
        if ($malang) {
            Article::create([
                'category' => 'pelatihan',
                'city_id' => $malang->id,
                'service_id' => null,
                'title' => 'Panduan & Regulasi Malang',
                'slug' => 'panduan-regulasi-malang',
                'excerpt' => 'Panduan dan regulasi terkait kota Malang.',
                'reading_time' => 5,
                'image' => 'https://images.unsplash.com/photo-1488167603315-785d1968960c?q=80&w=1200&auto=format&fit=crop',
                'seo_title' => 'Panduan & Regulasi Malang | TrainingKota',
                'meta_description' => 'Artikel panduan dan regulasi khusus kota Malang.',
                'focus_keywords' => 'Malang, regulasi, panduan',
                'status' => 'published',
                'content' => '<p>Content for Malang city article.</p>',
            ]);
        }

        $this->command->info('✅ ArticleSeeder: 3 artikel authoritative berhasil ditautkan ke layanan.');
    }
}
