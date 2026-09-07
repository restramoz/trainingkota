<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\City;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $malang = City::where('slug', 'malang')->first();
        $surabaya = City::where('slug', 'surabaya')->first();

        // ──────────────────────────────────────────────────────────────────
        // ARTIKEL 1: Panduan Ahli K3 Umum — Generic (tidak terikat kota)
        // ──────────────────────────────────────────────────────────────────
        Article::create([
            'category'         => 'pelatihan',
            'city_id'          => null,
            'service_id'       => null,
            'title'            => 'Panduan Lengkap Sertifikasi Ahli K3 Umum Kemnaker RI: Syarat, Materi, dan Prosedur 2024',
            'slug'             => 'panduan-sertifikasi-ahli-k3-umum-kemnaker',
            'excerpt'          => 'Panduan komprehensif untuk memahami persyaratan, alur pendaftaran, materi ujian, dan prosedur sertifikasi Ahli K3 Umum yang diakui Kemnaker RI. Artikel ini membahas tuntas semua yang perlu diketahui sebelum mengikuti program pelatihan K3.',
            'reading_time'     => 8,
            'seo_title'        => 'Panduan Sertifikasi Ahli K3 Umum Kemnaker RI 2024 | TrainingKota',
            'meta_description' => 'Panduan lengkap sertifikasi Ahli K3 Umum Kemnaker RI: syarat pendaftaran, materi ujian komprehensif, durasi pelatihan, biaya, dan cara mempertahankan sertifikat K3 Anda.',
            'focus_keywords'   => 'Ahli K3 Umum, Sertifikasi K3, Kemnaker RI, Pelatihan K3',
            'status'           => 'published',
            'faq_items'        => [
                ['q' => 'Siapa yang wajib memiliki sertifikat Ahli K3 Umum?', 'a' => 'Berdasarkan Permenaker No. 2 Tahun 1992, setiap perusahaan yang mempekerjakan lebih dari 100 orang atau menggunakan bahan/energi berbahaya WAJIB memiliki minimal 1 orang Ahli K3 Umum yang bersertifikat Kemnaker RI.'],
                ['q' => 'Berapa lama sertifikat Ahli K3 Umum berlaku?', 'a' => 'Sertifikat Ahli K3 Umum berlaku selama 3 tahun sejak tanggal penerbitan. Perpanjangan dilakukan melalui program refreshment training minimal 30 jam pelajaran atau mengikuti ujian ulang.'],
                ['q' => 'Apakah ada ujian tertulis untuk mendapatkan sertifikat K3?', 'a' => 'Ya. Peserta wajib mengikuti ujian tertulis yang diselenggarakan oleh Kemnaker RI atau lembaga yang ditunjuk. Peserta juga harus mempresentasikan makalah K3 dan mengikuti wawancara teknis.'],
            ],
            'content' => <<<'HTML'
<h2 id="apa-itu-ahli-k3-umum">Apa Itu Ahli K3 Umum?</h2>
<p>Ahli K3 Umum adalah tenaga profesional bersertifikat yang memiliki kompetensi untuk merencanakan, melaksanakan, dan mengevaluasi sistem manajemen keselamatan dan kesehatan kerja (SMK3) di lingkungan perusahaan. Sertifikasi ini dikeluarkan oleh Kementerian Ketenagakerjaan Republik Indonesia (Kemnaker RI) berdasarkan Undang-Undang No. 1 Tahun 1970 tentang Keselamatan Kerja dan Peraturan Menteri Tenaga Kerja No. PER-02/MEN/1992.</p>

<p>Keberadaan Ahli K3 Umum bukan sekadar formalitas. Mereka adalah ujung tombak perlindungan tenaga kerja — memastikan bahwa setiap aktivitas operasional di tempat kerja berjalan sesuai standar keselamatan yang ditetapkan pemerintah. Di era industri 4.0 yang semakin kompleks, peran Ahli K3 Umum semakin krusial karena risiko kerja yang semakin beragam.</p>

<h2 id="landasan-hukum">Landasan Hukum Kewajiban Ahli K3</h2>
<p>Sebelum memutuskan untuk mengikuti program sertifikasi, penting untuk memahami kerangka regulasi yang menjadi landasan hukum kewajiban penempatan Ahli K3 di perusahaan:</p>

<table>
  <thead>
    <tr>
      <th>Regulasi</th>
      <th>Isi Pokok</th>
      <th>Kewajiban bagi Perusahaan</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>UU No. 1/1970</td>
      <td>Keselamatan Kerja</td>
      <td>Wajib memiliki pengawas K3 internal</td>
    </tr>
    <tr>
      <td>Permenaker PER-02/MEN/1992</td>
      <td>Tata Cara Penunjukan Ahli K3</td>
      <td>Ahli K3 wajib bersertifikat Kemnaker RI</td>
    </tr>
    <tr>
      <td>PP No. 50/2012</td>
      <td>Penerapan SMK3</td>
      <td>Perusahaan &gt;100 karyawan wajib SMK3</td>
    </tr>
    <tr>
      <td>Permenaker No. 26/2014</td>
      <td>Penyelenggaraan Penilaian SMK3</td>
      <td>Audit SMK3 berkala oleh auditor eksternal</td>
    </tr>
  </tbody>
</table>

<h2 id="persyaratan-mendaftar">Persyaratan Mendaftar Program Ahli K3 Umum</h2>
<p>Untuk dapat mengikuti program sertifikasi Ahli K3 Umum, calon peserta harus memenuhi persyaratan administrasi sebagai berikut:</p>

<h3 id="syarat-pendidikan">1. Persyaratan Pendidikan</h3>
<ul>
  <li><strong>Lulusan S1/D4 semua jurusan:</strong> Minimal pengalaman kerja 2 tahun di bidang K3 atau di lingkungan industri.</li>
  <li><strong>Lulusan D3 semua jurusan:</strong> Minimal pengalaman kerja 4 tahun di bidang K3 atau lingkungan industri.</li>
  <li><strong>Lulusan SMA/SMK sederajat:</strong> Minimal pengalaman kerja 8 tahun di bidang K3. Catatan: Kelompok ini mengikuti jalur ujian yang berbeda.</li>
</ul>

<h3 id="syarat-dokumen">2. Dokumen yang Diperlukan</h3>
<p>Siapkan dokumen-dokumen berikut sebelum mendaftar:</p>
<ul>
  <li>Fotokopi KTP (identitas diri)</li>
  <li>Fotokopi ijazah pendidikan terakhir yang dilegalisir</li>
  <li>Fotokopi sertifikat K3 yang telah dimiliki sebelumnya (jika ada)</li>
  <li>Curriculum Vitae / Riwayat Hidup yang mencantumkan pengalaman kerja</li>
  <li>Surat keterangan kerja dari perusahaan yang menyebutkan jabatan dan masa kerja</li>
  <li>Pas foto terbaru ukuran 3×4 sebanyak 4 lembar (latar belakang merah)</li>
  <li>Surat keterangan sehat dari dokter (tidak lebih dari 6 bulan)</li>
</ul>

<div class="callout-box">
  <strong>⚠ PENTING:</strong> Seluruh dokumen fotokopi harus dilegalisir oleh pejabat berwenang. Dokumen tidak lengkap akan menyebabkan penolakan pendaftaran dan tidak dapat dikembalikan.
</div>

<h2 id="materi-pelatihan">Materi Pelatihan Ahli K3 Umum (12 Hari Efektif)</h2>
<p>Program pelatihan Ahli K3 Umum mencakup kurikulum komprehensif yang ditetapkan oleh Kemnaker RI. Berikut adalah breakdown materi yang akan dipelajari selama 12 hari efektif pelatihan:</p>

<h3 id="modul-1-4">Modul 1–4: Fondasi Regulasi K3</h3>
<p><strong>Modul 1: Kebijakan K3 Nasional dan Kerangka Regulasi</strong><br>
Peserta mempelajari sejarah dan filosofi K3 di Indonesia, hierarki peraturan perundang-undangan K3, peran Kemnaker RI dan lembaga K3 nasional, serta kewajiban perusahaan berdasarkan UU No. 1/1970.</p>

<p><strong>Modul 2: Pengawasan K3 dan Peran Ahli K3</strong><br>
Membahas tugas, wewenang, dan tanggung jawab Ahli K3 Umum, hubungan antara Ahli K3 dengan manajemen perusahaan, prosedur pelaporan kecelakaan kerja, dan tata cara pembuatan laporan K3 bulanan/tahunan ke Dinas Tenaga Kerja.</p>

<p><strong>Modul 3: Sistem Manajemen K3 (SMK3 PP 50/2012)</strong><br>
Kajian mendalam 5 elemen dan 166 kriteria SMK3, perbedaan tingkat pencapaian (60%, 85%, 100%), prosedur audit internal SMK3, serta integrasi SMK3 dengan ISO 45001:2018.</p>

<p><strong>Modul 4: Identifikasi Bahaya dan Penilaian Risiko (HIRARC)</strong><br>
Metodologi Hazard Identification, Risk Assessment, and Risk Control (HIRARC), teknik JSA (Job Safety Analysis), analisis HAZOP untuk proses industri kimia, dan penyusunan risk register perusahaan.</p>

<h3 id="modul-5-8">Modul 5–8: Teknis K3 Spesifik</h3>
<p><strong>Modul 5: K3 Kebakaran dan Tanggap Darurat</strong><br>
Klasifikasi kebakaran dan agen pemadam, perancangan sistem proteksi kebakaran (APAR, hydrant, sprinkler), prosedur evakuasi darurat, SCBA dan APD kebakaran, serta persyaratan legalitas sarana pemadam kebakaran.</p>

<p><strong>Modul 6: K3 Konstruksi dan Alat Berat</strong><br>
Regulasi K3 konstruksi (Permenaker No. 1/1980), riksa uji pesawat angkat dan angkut (forklift, crane, scaffolding), persyaratan SIO operator alat berat, dan manajemen K3 proyek konstruksi.</p>

<p><strong>Modul 7: Higiene Industri dan Kesehatan Kerja</strong><br>
Nilai Ambang Batas (NAB) bahan kimia berbahaya, pemantauan lingkungan kerja (kebisingan, debu, panas), program medical check-up berkala, Penyakit Akibat Kerja (PAK) dan pencegahannya, serta pengelolaan Limbah B3.</p>

<p><strong>Modul 8: K3 Listrik dan Instalasi Berbahaya</strong><br>
Regulasi K3 listrik (Permenaker No. 2/1989 dan PUIL 2011), riksa uji instalasi listrik, bahaya listrik statis dan cara penanggulangannya, serta standar keselamatan pemasangan dan pemeliharaan panel listrik.</p>

<h3 id="modul-9-12">Modul 9–12: Manajemen dan Praktikum</h3>
<p><strong>Modul 9: Investigasi Kecelakaan Kerja</strong><br>
Metodologi investigasi kecelakaan (Fault Tree Analysis, Fishbone Diagram, 5-Why Analysis), tata cara pelaporan kecelakaan ke BPJS Ketenagakerjaan dan Disnaker, kalkulasi biaya kecelakaan kerja, dan penyusunan laporan investigasi.</p>

<p><strong>Modul 10: Ergonomi dan Faktor Manusia (Human Factors)</strong><br>
Prinsip ergonomi di tempat kerja, desain stasiun kerja yang ergonomis, beban kerja fisik dan mental, gangguan muskuloskeletal (MSDs) dan pencegahannya.</p>

<p><strong>Modul 11: Pembuatan dan Presentasi Makalah K3</strong><br>
Peserta diwajibkan menyusun makalah K3 minimal 15 halaman berdasarkan studi kasus nyata di lingkungan kerja masing-masing. Makalah dipresentasikan di hadapan tim penguji dari Kemnaker RI.</p>

<p><strong>Modul 12: Ujian Tertulis dan Wawancara Kompetensi</strong><br>
Ujian komprehensif yang mencakup seluruh materi pelatihan. Peserta yang lulus ujian tertulis akan menjalani wawancara mendalam dengan penguji dari Kemnaker RI sebagai tahap akhir sertifikasi.</p>

<h2 id="alur-sertifikasi">Alur Proses Sertifikasi Ahli K3 Umum</h2>
<p>Berikut adalah tahapan lengkap dari pendaftaran hingga terbitnya sertifikat resmi dari Kemnaker RI:</p>

<h3>Tahap 1: Pendaftaran dan Verifikasi Dokumen</h3>
<p>Peserta menyerahkan kelengkapan dokumen. Tim administrasi TrainingKota memverifikasi semua persyaratan dalam 1–2 hari kerja dan mengkonfirmasi keikutsertaan peserta.</p>

<h3>Tahap 2: Pelaksanaan Pelatihan (12 Hari Efektif)</h3>
<p>Pelatihan dilaksanakan di hotel bintang 3/4 rekanan TrainingKota di kota pelaksanaan. Materi disampaikan oleh instruktur bersertifikat dengan pengalaman industri minimal 10 tahun. Setiap hari pembelajaran dimulai pukul 08.00 dan berakhir pukul 17.00 WIB.</p>

<h3>Tahap 3: Penyusunan dan Presentasi Makalah</h3>
<p>Peserta menyusun makalah K3 berdasarkan pengalaman kerja nyata di lingkungan kerjanya. Makalah dipresentasikan di hari ke-10 pelatihan dan dinilai oleh tim penguji.</p>

<h3>Tahap 4: Ujian Tertulis Kemnaker</h3>
<p>Ujian tertulis komprehensif dilaksanakan di hari ke-11 pelatihan. Soal ujian berjumlah 100–150 soal pilihan ganda dan esai yang mencakup seluruh materi pelatihan. Nilai kelulusan minimum adalah 70/100.</p>

<h3>Tahap 5: Penerbitan Sertifikat Kemnaker RI</h3>
<p>Peserta yang dinyatakan lulus akan mendapatkan Surat Keterangan Ahli K3 Umum dari Kemnaker RI dalam waktu 30–45 hari kerja setelah pelatihan. TrainingKota mengirimkan sertifikat langsung ke alamat peserta tanpa biaya tambahan.</p>

<h2 id="tips-persiapan">Tips Persiapan untuk Peserta Baru</h2>
<p>Berdasarkan pengalaman ribuan peserta yang telah kami training selama lebih dari satu dekade, berikut adalah tips praktis untuk memaksimalkan peluang kelulusan Anda:</p>

<ul>
  <li><strong>Pelajari regulasi dasar terlebih dahulu:</strong> Baca UU No. 1/1970, PP No. 50/2012, dan minimal 5 Permenaker K3 sebelum hari pertama pelatihan.</li>
  <li><strong>Siapkan makalah sejak dini:</strong> Mulai identifikasi studi kasus di tempat kerja Anda sebelum pelatihan dimulai. Jangan menunggu sampai hari ke-10.</li>
  <li><strong>Aktif berdiskusi:</strong> Peserta yang aktif bertanya dan berdiskusi cenderung memiliki pemahaman lebih baik saat ujian tertulis.</li>
  <li><strong>Bawa alat tulis dan laptop:</strong> Catatan pribadi sangat membantu saat mempersiapkan makalah dan revisi materi ujian.</li>
  <li><strong>Istirahat cukup:</strong> Pelatihan berlangsung selama 12 hari berturut-turut. Jaga kondisi fisik Anda agar tetap fokus sepanjang program.</li>
</ul>

<h2 id="nilai-investasi">Nilai Investasi dan Apa yang Anda Dapatkan</h2>
<p>Program Ahli K3 Umum adalah salah satu investasi karier dengan Return on Investment (ROI) tertinggi di bidang K3. Dengan sertifikat ini, profesional K3 dapat meningkatkan posisi karier secara signifikan — rata-rata kenaikan gaji 25–40% untuk posisi HSE Officer yang bersertifikat dibandingkan yang tidak bersertifikat.</p>

<p>Fasilitas yang diterima peserta dalam program TrainingKota:</p>
<ul>
  <li>Modul pelatihan lengkap (hardcopy + softcopy PDF)</li>
  <li>Konsumsi pagi, makan siang, dan coffee break selama pelatihan</li>
  <li>Sertifikat keikutsertaan pelatihan dari lembaga</li>
  <li>Sertifikat Ahli K3 Umum dari Kemnaker RI (setelah lulus ujian)</li>
  <li>Pendampingan penyusunan makalah oleh instruktur</li>
  <li>Akses grup alumni TrainingKota untuk update regulasi K3</li>
</ul>

<h2 id="kesimpulan">Kesimpulan</h2>
<p>Sertifikasi Ahli K3 Umum adalah fondasi karier profesional di bidang Keselamatan dan Kesehatan Kerja di Indonesia. Dengan regulasi yang semakin ketat dan perusahaan yang semakin sadar akan pentingnya K3, permintaan tenaga Ahli K3 bersertifikat terus meningkat dari tahun ke tahun.</p>

<p>TrainingKota hadir di lebih dari 212 kota dan kabupaten di seluruh Indonesia untuk memastikan setiap profesional industri dapat mengakses program sertifikasi K3 berkualitas tinggi tanpa harus menempuh perjalanan jauh. Dengan instruktur berpengalaman, fasilitas modern, dan track record kelulusan di atas 92%, kami siap mendampingi perjalanan sertifikasi K3 Anda.</p>

<p>Hubungi tim kami sekarang melalui WhatsApp +62 812-3456-7890 untuk mendapatkan informasi jadwal batch terdekat dan penawaran harga spesial untuk kelompok atau in-house training.</p>
HTML,
        ]);

        // ──────────────────────────────────────────────────────────────────
        // ARTIKEL 2: Panduan SMK3 PP 50/2012 — terikat Kota Malang
        // ──────────────────────────────────────────────────────────────────
        Article::create([
            'category'         => 'pelatihan',
            'city_id'          => $malang?->id,
            'service_id'       => null,
            'title'            => 'Panduan Implementasi SMK3 PP 50/2012 untuk Industri Manufaktur di Malang: Langkah Demi Langkah',
            'slug'             => 'panduan-smk3-pp-50-2012-industri-malang',
            'excerpt'          => 'Panduan praktis penerapan Sistem Manajemen Keselamatan dan Kesehatan Kerja (SMK3) berdasarkan PP No. 50 Tahun 2012 untuk industri manufaktur di Kota Malang dan wilayah sekitarnya, termasuk checklist 166 kriteria dan strategi audit.',
            'reading_time'     => 10,
            'seo_title'        => 'Panduan SMK3 PP 50/2012 untuk Industri Manufaktur di Malang | TrainingKota',
            'meta_description' => 'Panduan lengkap implementasi SMK3 PP 50/2012 di Malang: 5 elemen, 166 kriteria, prosedur audit internal, dan tips mendapatkan sertifikasi SMK3 tingkat emas.',
            'focus_keywords'   => 'SMK3 Malang, PP 50 2012, Audit SMK3, Sertifikasi SMK3, K3 Malang',
            'status'           => 'published',
            'faq_items'        => [
                ['q' => 'Apakah semua perusahaan di Malang wajib menerapkan SMK3 PP 50/2012?', 'a' => 'Berdasarkan PP No. 50/2012, perusahaan yang WAJIB menerapkan SMK3 adalah perusahaan yang mempekerjakan minimal 100 tenaga kerja ATAU menggunakan bahan, proses, dan instalasi yang memiliki risiko bahaya tinggi — terlepas dari jumlah karyawannya. Di kawasan industri Malang, sebagian besar pabrik manufaktur termasuk dalam kategori wajib SMK3.'],
                ['q' => 'Berapa biaya audit SMK3 PP 50/2012 untuk pabrik di Malang?', 'a' => 'Biaya audit SMK3 PP 50/2012 bervariasi tergantung jumlah tenaga kerja dan kompleksitas fasilitas. Estimasi biaya untuk pabrik skala menengah (100-500 karyawan) berkisar Rp 35–65 juta untuk satu siklus audit lengkap termasuk pra-audit, audit utama, dan penerbitan sertifikat.'],
                ['q' => 'Apa konsekuensi hukum jika perusahaan di Malang tidak menerapkan SMK3?', 'a' => 'Sanksi administratif berupa teguran tertulis, pembatasan kegiatan usaha, penghentian sementara, dan pencabutan izin usaha. Selain itu, kecelakaan kerja di perusahaan tanpa SMK3 yang terdokumentasi berpotensi menjadi dasar tuntutan pidana bagi pimpinan perusahaan berdasarkan UU No. 1/1970.'],
            ],
            'content' => <<<'HTML'
<h2 id="mengapa-smk3-penting">Mengapa SMK3 PP 50/2012 Krusial bagi Industri di Malang?</h2>
<p>Kota Malang dan Kabupaten Malang adalah salah satu pusat industri manufaktur terbesar di Jawa Timur, dengan ratusan perusahaan beroperasi di kawasan industri Singosari, Lawang, Pakis, hingga Kepanjen. Di ekosistem industri yang padat ini, penerapan Sistem Manajemen Keselamatan dan Kesehatan Kerja (SMK3) berdasarkan PP No. 50 Tahun 2012 bukan lagi pilihan — ini adalah kewajiban hukum sekaligus kebutuhan operasional bisnis yang tidak dapat ditawar.</p>

<p>Berdasarkan data Dinas Tenaga Kerja Kota Malang, angka kecelakaan kerja di sektor manufaktur masih menjadi perhatian utama. Setiap kecelakaan kerja tidak hanya menimbulkan kerugian kemanusiaan yang tak ternilai, tetapi juga kerugian ekonomi langsung (biaya pengobatan, kompensasi, perbaikan alat) dan kerugian tidak langsung (gangguan produksi, reputasi, moral karyawan) yang jauh lebih besar.</p>

<h2 id="lima-elemen-smk3">5 Elemen Utama SMK3 PP 50/2012</h2>
<p>PP No. 50/2012 mengadopsi pendekatan Plan-Do-Check-Act (PDCA) yang terdiri dari 5 elemen pokok dengan total 166 kriteria yang harus dipenuhi:</p>

<h3 id="elemen-1">Elemen 1: Penetapan Kebijakan K3 (8 Kriteria)</h3>
<p>Elemen pertama menetapkan bahwa pimpinan tertinggi perusahaan harus secara eksplisit menetapkan kebijakan K3 tertulis yang ditandatangani, dikomunikasikan ke seluruh tingkatan perusahaan, dan ditinjau secara berkala. Kebijakan K3 harus mencantumkan:</p>
<ul>
  <li>Komitmen untuk mematuhi peraturan perundangan K3</li>
  <li>Kerangka untuk menetapkan dan meninjau tujuan K3</li>
  <li>Penyediaan sumber daya yang memadai untuk K3</li>
  <li>Komitmen untuk peningkatan berkelanjutan</li>
</ul>

<h3 id="elemen-2">Elemen 2: Perencanaan K3 (15 Kriteria)</h3>
<p>Perencanaan K3 mencakup identifikasi bahaya dan penilaian risiko (HIRARC), pemenuhan perundang-undangan yang berlaku, penetapan tujuan dan program K3 yang terukur (SMART — Specific, Measurable, Achievable, Relevant, Time-bound), serta penetapan anggaran K3 tahunan yang memadai.</p>

<h3 id="elemen-3">Elemen 3: Pelaksanaan Rencana K3 (134 Kriteria)</h3>
<p>Ini adalah elemen terbesar yang mencakup 134 kriteria, meliputi:</p>
<ul>
  <li><strong>Sumber Daya Manusia:</strong> Penunjukan Ahli K3, pembentukan P2K3, program pelatihan K3 berjenjang</li>
  <li><strong>Komunikasi K3:</strong> Safety briefing, safety sign, SOP K3, emergency response plan</li>
  <li><strong>Pengendalian Bahaya:</strong> Inspeksi berkala, pemantauan lingkungan kerja, APD, lock-out tag-out</li>
  <li><strong>K3 Kontraktor:</strong> Persyaratan K3 dalam kontrak, orientasi K3 untuk vendor dan kontraktor</li>
  <li><strong>Tanggap Darurat:</strong> Prosedur evakuasi, fire drill, P3K, tim tanggap darurat terlatih</li>
  <li><strong>Dokumentasi:</strong> Rekaman K3 yang terstruktur, sistem pengendalian dokumen</li>
</ul>

<h3 id="elemen-4">Elemen 4: Pemantauan dan Evaluasi (4 Kriteria)</h3>
<p>Pemantauan mencakup inspeksi rutin, audit internal SMK3, pengukuran kinerja K3 (leading dan lagging indicators), serta penyelidikan setiap insiden dan kecelakaan kerja menggunakan metodologi Root Cause Analysis.</p>

<h3 id="elemen-5">Elemen 5: Peninjauan dan Peningkatan Berkelanjutan (5 Kriteria)</h3>
<p>Management review K3 minimal dilakukan 1 kali per tahun, mencakup evaluasi kinerja K3, tindak lanjut hasil audit, perubahan regulasi yang relevan, dan penetapan target K3 untuk periode berikutnya.</p>

<h2 id="tingkat-pencapaian">Tingkat Pencapaian dan Sertifikasi SMK3</h2>
<p>Berdasarkan PP 50/2012, sertifikasi SMK3 diklasifikasikan dalam 3 tingkat pencapaian:</p>

<table>
  <thead>
    <tr>
      <th>Tingkat</th>
      <th>Jumlah Karyawan</th>
      <th>Jumlah Kriteria</th>
      <th>Nilai Minimum Lulus</th>
      <th>Bendera/Penghargaan</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Awal (Tingkat 1)</td>
      <td>&lt; 100 orang</td>
      <td>64 kriteria</td>
      <td>≥ 64%</td>
      <td>Bendera Hijau</td>
    </tr>
    <tr>
      <td>Transisi (Tingkat 2)</td>
      <td>100–500 orang</td>
      <td>122 kriteria</td>
      <td>≥ 85%</td>
      <td>Bendera Perak (Sertifikat SMK3)</td>
    </tr>
    <tr>
      <td>Lanjut (Tingkat 3)</td>
      <td>&gt; 500 orang</td>
      <td>166 kriteria</td>
      <td>≥ 90%</td>
      <td>Bendera Emas (Penghargaan Zero Accident)</td>
    </tr>
  </tbody>
</table>

<h2 id="roadmap-implementasi">Roadmap Implementasi SMK3 untuk Pabrik di Malang</h2>
<p>Berdasarkan pengalaman pendampingan TrainingKota terhadap lebih dari 50 perusahaan manufaktur di wilayah Malang Raya, berikut adalah roadmap implementasi SMK3 yang terbukti efektif:</p>

<h3>Fase 1: Gap Analysis (Bulan 1)</h3>
<p>Audit pendahuluan untuk mengidentifikasi kesenjangan antara kondisi K3 perusahaan saat ini dengan persyaratan 166 kriteria SMK3. Hasilnya berupa laporan gap analysis yang menjadi baseline rencana tindak lanjut. Tim auditor TrainingKota akan melakukan kunjungan lapangan, review dokumen, dan wawancara dengan manajemen dan karyawan.</p>

<h3>Fase 2: Penyusunan Dokumen SMK3 (Bulan 2–3)</h3>
<p>Penyusunan atau revisi seluruh dokumen K3 yang diperlukan: kebijakan K3, manual SMK3, prosedur operasi standar (SOP) K3, instruksi kerja K3, dan formulir-formulir rekaman K3. TrainingKota menyediakan template dokumen yang telah disesuaikan dengan standar Kemnaker RI.</p>

<h3>Fase 3: Pelatihan dan Sosialisasi (Bulan 3–4)</h3>
<p>Program pelatihan K3 berjenjang untuk semua level jabatan: pelatihan Ahli K3 Umum untuk staf HSE, pelatihan K3 umum untuk supervisor, safety induction untuk semua karyawan, dan pelatihan khusus untuk tugas berisiko tinggi (Hot Work, Confined Space, LOTO, dll).</p>

<h3>Fase 4: Implementasi dan Monitoring (Bulan 4–9)</h3>
<p>Penerapan sistem K3 secara penuh di semua area dan departemen. Tim HSE internal melakukan inspeksi mingguan, safety patrol, dan monitoring kinerja K3 menggunakan dashboard indikator yang disiapkan TrainingKota.</p>

<h3>Fase 5: Audit Internal (Bulan 10)</h3>
<p>Audit internal menggunakan daftar periksa 166 kriteria SMK3. Temuan audit dikelompokkan berdasarkan tingkat kritis (mayor/minor/observasi) dan dijadikan dasar perbaikan sebelum audit eksternal.</p>

<h3>Fase 6: Audit Eksternal Kemnaker (Bulan 11–12)</h3>
<p>Pelaksanaan audit SMK3 oleh auditor eksternal yang ditunjuk Kemnaker RI. TrainingKota mendampingi selama proses audit berlangsung dan membantu pengelolaan temuan pasca-audit hingga penerbitan sertifikat SMK3.</p>

<h2 id="biaya-manfaat">Analisis Biaya-Manfaat Penerapan SMK3</h2>
<p>Sering kali, manajemen perusahaan meragukan pengeluaran untuk implementasi SMK3 karena dianggap tidak menghasilkan pendapatan langsung. Namun, analisis komprehensif menunjukkan hasil yang berbeda:</p>

<p><strong>Contoh kasus nyata:</strong> Sebuah pabrik komponen otomotif di Singosari, Malang dengan 300 karyawan berhasil mengurangi angka kecelakaan kerja dari 12 insiden/tahun menjadi 1 insiden/tahun setelah implementasi SMK3. Biaya implementasi Rp 180 juta berhasil menghemat biaya kecelakaan (pengobatan, kompensasi, perbaikan, gangguan produksi) yang sebelumnya mencapai Rp 850 juta/tahun — penghematan bersih Rp 670 juta/tahun.</p>

<p>Manfaat tidak langsung yang sering diabaikan:</p>
<ul>
  <li>Peningkatan produktivitas tenaga kerja karena lingkungan kerja aman dan nyaman</li>
  <li>Kemudahan dalam tender proyek — banyak BUMN dan perusahaan multinasional mensyaratkan sertifikat SMK3</li>
  <li>Penurunan premi asuransi kecelakaan kerja</li>
  <li>Peningkatan moral dan loyalitas karyawan</li>
  <li>Perlindungan hukum bagi manajemen perusahaan</li>
</ul>

<h2 id="layanan-trainingkota-malang">Layanan TrainingKota untuk Industri Malang</h2>
<p>TrainingKota memiliki kantor perwakilan dan tim teknis yang berbasis di Malang untuk melayani seluruh industri di Malang Raya (Kota Malang, Kabupaten Malang, dan Kota Batu). Layanan kami mencakup:</p>

<ul>
  <li>Pendampingan implementasi SMK3 PP 50/2012 dari A sampai Z</li>
  <li>Pelatihan Ahli K3 Umum, Auditor SMK3, dan berbagai program K3 spesifik</li>
  <li>Jasa pengurusan SLF, SLO, dan riksa uji alat berat</li>
  <li>Konsultasi K3 on-demand untuk permasalahan teknis spesifik</li>
  <li>Training in-house di lokasi fasilitas Anda</li>
</ul>

<p>Hubungi koordinator area Malang kami melalui WhatsApp +62 812-3456-7890 untuk jadwal konsultasi gratis dan site visit assessment K3 tanpa biaya.</p>
HTML,
        ]);

        // ──────────────────────────────────────────────────────────────────
        // ARTIKEL 3: Panduan SLF Pabrik — Generic (terkait kategori jasa)
        // ──────────────────────────────────────────────────────────────────
        Article::create([
            'category'         => 'jasa',
            'city_id'          => null,
            'service_id'       => null,
            'title'            => 'Panduan Lengkap Pengurusan SLF (Sertifikat Laik Fungsi) untuk Bangunan Industri dan Pabrik di Indonesia',
            'slug'             => 'panduan-pengurusan-slf-bangunan-industri-pabrik',
            'excerpt'          => 'Panduan komprehensif pengurusan Sertifikat Laik Fungsi (SLF) untuk bangunan gedung industri, pabrik, dan gudang — mencakup dasar hukum, persyaratan teknis, dokumen yang diperlukan, alur proses, dan timeline pengurusan resmi.',
            'reading_time'     => 9,
            'seo_title'        => 'Panduan SLF Bangunan Industri dan Pabrik 2024 | TrainingKota',
            'meta_description' => 'Panduan lengkap pengurusan SLF (Sertifikat Laik Fungsi) untuk pabrik dan bangunan industri: dasar hukum, persyaratan, dokumen, alur proses, dan biaya estimasi.',
            'focus_keywords'   => 'SLF pabrik, Sertifikat Laik Fungsi, pengurusan SLF, SLF industri',
            'status'           => 'published',
            'faq_items'        => [
                ['q' => 'Apa perbedaan SLF dan IMB (Izin Mendirikan Bangunan)?', 'a' => 'IMB (atau sekarang disebut PBG — Persetujuan Bangunan Gedung) adalah izin yang diterbitkan SEBELUM atau SAAT proses pembangunan bangunan. SLF adalah dokumen yang diterbitkan SETELAH bangunan selesai dibangun, menyatakan bahwa bangunan tersebut telah laik secara teknis untuk difungsikan sesuai peruntukannya.'],
                ['q' => 'Berapa lama masa berlaku SLF untuk bangunan industri?', 'a' => 'Berdasarkan PP No. 16/2021, SLF untuk bangunan fungsi khusus (termasuk industri) berlaku selama 5 tahun dan harus diperbarui melalui proses SLF ulang. Perpanjangan SLF membutuhkan inspeksi ulang oleh tim teknis yang berwenang.'],
                ['q' => 'Apa yang terjadi jika pabrik beroperasi tanpa SLF?', 'a' => 'Pabrik yang beroperasi tanpa SLF dapat dikenakan sanksi administratif berupa teguran, pembatasan operasional, hingga penutupan paksa oleh pemerintah daerah. Selain itu, klaim asuransi bangunan dan asuransi kebakaran berpotensi ditolak karena SLF adalah syarat keabsahan operasional yang fundamental.'],
            ],
            'content' => <<<'HTML'
<h2 id="pengertian-slf">Pengertian dan Dasar Hukum SLF</h2>
<p>Sertifikat Laik Fungsi (SLF) adalah dokumen resmi yang diterbitkan oleh pemerintah daerah (Pemda) sebagai bukti bahwa sebuah bangunan gedung telah memenuhi persyaratan laik fungsi — baik secara teknis maupun administratif — untuk dimanfaatkan sesuai fungsinya. SLF wajib dimiliki oleh setiap bangunan gedung yang akan digunakan, termasuk bangunan industri, pabrik, gudang, dan fasilitas produksi lainnya.</p>

<p>Dasar hukum penyelenggaraan SLF di Indonesia:</p>
<ul>
  <li><strong>UU No. 28 Tahun 2002</strong> tentang Bangunan Gedung — Pasal 38 mewajibkan setiap bangunan memiliki SLF sebelum dimanfaatkan</li>
  <li><strong>PP No. 36 Tahun 2005</strong> tentang Peraturan Pelaksanaan UU Bangunan Gedung</li>
  <li><strong>PP No. 16 Tahun 2021</strong> — regulasi terbaru yang mengatur teknis pelaksanaan SLF pasca-UUCK (Omnibus Law)</li>
  <li><strong>Permen PUPR No. 27/2018</strong> tentang Sertifikat Laik Fungsi Bangunan Gedung</li>
</ul>

<h2 id="bangunan-wajib-slf">Bangunan Industri yang Wajib Memiliki SLF</h2>
<p>Tidak semua bangunan memerlukan proses SLF yang sama. Berikut adalah klasifikasi bangunan industri berdasarkan kompleksitas dan persyaratan SLF-nya:</p>

<table>
  <thead>
    <tr>
      <th>Jenis Bangunan</th>
      <th>Luas / Lantai</th>
      <th>Pemeriksa SLF</th>
      <th>Timeline Estimasi</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Pabrik / Industri Ringan</td>
      <td>&lt; 2.000 m²</td>
      <td>Dinas PU / DPMPTSP Kabupaten/Kota</td>
      <td>30–60 hari kerja</td>
    </tr>
    <tr>
      <td>Pabrik / Industri Menengah</td>
      <td>2.000–5.000 m²</td>
      <td>Penyedia Jasa Pengkajian Teknis (PJPT)</td>
      <td>45–90 hari kerja</td>
    </tr>
    <tr>
      <td>Pabrik / Industri Besar</td>
      <td>&gt; 5.000 m² atau &gt; 8 lantai</td>
      <td>PJPT Terakreditasi + Review Pemda Provinsi</td>
      <td>60–120 hari kerja</td>
    </tr>
    <tr>
      <td>Gudang dan Fasilitas Logistik</td>
      <td>Semua ukuran</td>
      <td>DPMPTSP setempat</td>
      <td>30–75 hari kerja</td>
    </tr>
  </tbody>
</table>

<h2 id="persyaratan-teknis">Persyaratan Teknis Laik Fungsi untuk Pabrik</h2>
<p>Untuk mendapatkan SLF, bangunan pabrik harus memenuhi persyaratan teknis berikut yang akan diverifikasi oleh tim pemeriksa:</p>

<h3 id="struktural">1. Kelaikan Struktural</h3>
<p>Tim pemeriksa akan melakukan verifikasi bahwa konstruksi bangunan telah sesuai dengan gambar as-built drawing yang disetujui. Ini mencakup:</p>
<ul>
  <li>Kekuatan fondasi terhadap beban rencana (dead load + live load + seismic load)</li>
  <li>Kekuatan kolom, balok, dan pelat lantai</li>
  <li>Koneksi antar elemen struktur (welding, bolting)</li>
  <li>Kondisi atap dan dinding penahan (shear wall)</li>
  <li>Kemungkinan retak, korosi, atau perlemahan struktur</li>
</ul>

<h3 id="mep">2. Kelaikan Mekanikal, Elektrikal, dan Plumbing (MEP)</h3>
<p>Instalasi MEP adalah aspek yang paling sering menjadi temuan dalam pemeriksaan SLF pabrik:</p>
<ul>
  <li><strong>Elektrikal:</strong> Instalasi sesuai PUIL 2011, kapasitas panel dan MCB/MCCB memadai, grounding sistem, kabel dan konduit sesuai standar SNI</li>
  <li><strong>Mekanikal:</strong> Sistem ventilasi dan AC industri, lift barang dan passenger (jika ada), sistem pneumatik atau hidrolik terpasang sesuai standar</li>
  <li><strong>Plumbing:</strong> Sistem air bersih, air limbah industri, dan pengolahan limbah sesuai baku mutu lingkungan</li>
  <li><strong>Fire Protection:</strong> APAR, hydrant, sprinkler, detektor asap/panas, jalur evakuasi dan exit sign</li>
</ul>

<h3 id="akses-evakuasi">3. Akses dan Sarana Evakuasi</h3>
<p>Ini adalah persyaratan yang sering terabaikan dalam perencanaan bangunan industri:</p>
<ul>
  <li>Pintu darurat minimum dengan lebar dan tinggi sesuai standar (min 90 cm × 200 cm)</li>
  <li>Jumlah tangga darurat minimal 2 (untuk bangunan lebih dari 3 lantai)</li>
  <li>Kapasitas tangga darurat memadai untuk evakuasi seluruh penghuni dalam 2 menit</li>
  <li>Pencahayaan darurat (emergency lighting) yang berfungsi saat listrik padam</li>
  <li>Muster point yang memadai untuk jumlah karyawan maksimal</li>
</ul>

<h2 id="dokumen-diperlukan">Dokumen yang Diperlukan untuk Pengajuan SLF</h2>
<p>Kelengkapan dokumen adalah kunci keberhasilan dan kecepatan proses SLF. Siapkan seluruh dokumen berikut sebelum mengajukan permohonan:</p>

<h3>Dokumen Legalitas</h3>
<ul>
  <li>IMB / PBG (Persetujuan Bangunan Gedung) yang masih berlaku</li>
  <li>Sertifikat Hak atas Tanah (SHM, HGB, atau Hak Pakai)</li>
  <li>Akta pendirian perusahaan dan NIB (Nomor Induk Berusaha)</li>
  <li>NPWP perusahaan</li>
</ul>

<h3>Dokumen Teknis Bangunan</h3>
<ul>
  <li>Gambar as-built drawing arsitektur, struktur, dan MEP (format DWG + PDF)</li>
  <li>Spesifikasi teknis material bangunan</li>
  <li>Laporan uji beton (Concrete Test Report) dari laboratorium terakreditasi</li>
  <li>Sertifikat material baja struktur (Mill Certificate)</li>
  <li>Laporan pengujian instalasi listrik (SLO sementara atau rekomendasi PLN)</li>
  <li>Laporan pengujian sistem proteksi kebakaran (fire suppression system)</li>
</ul>

<h3>Dokumen K3 dan Lingkungan</h3>
<ul>
  <li>Izin Lingkungan (UKL-UPL atau AMDAL sesuai skala usaha)</li>
  <li>Dokumen SPPL (Surat Pernyataan Pengelolaan Lingkungan) — untuk usaha skala kecil</li>
  <li>Laporan riksa uji alat berat yang terpasang di bangunan (jika ada crane, overhead crane, dll)</li>
  <li>Sertifikat SLO instalasi listrik dari PLN atau lembaga sertifikasi terakreditasi</li>
</ul>

<h2 id="alur-proses">Alur Proses Pengurusan SLF Step-by-Step</h2>
<p>Dengan pemahaman proses yang baik dan kelengkapan dokumen yang sempurna, timeline pengurusan SLF dapat dioptimalkan:</p>

<h3>Langkah 1: Pre-Assessment dan Persiapan (2–4 Minggu)</h3>
<p>Tim teknis TrainingKota melakukan site visit untuk menilai kondisi bangunan dan kelengkapan dokumen. Hasil assessment berupa laporan kesiapan SLF dan daftar dokumen yang masih perlu dilengkapi atau diperbaiki.</p>

<h3>Langkah 2: Penyusunan Laporan Teknis (2–3 Minggu)</h3>
<p>Tim PJPT (Penyedia Jasa Pengkajian Teknis) menyusun laporan pemeriksaan teknis komprehensif yang mencakup semua aspek struktural, MEP, dan keselamatan. Laporan ini menjadi dokumen utama dalam pengajuan SLF.</p>

<h3>Langkah 3: Pengajuan ke DPMPTSP (1 Minggu)</h3>
<p>Pengajuan permohonan SLF secara resmi ke Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu (DPMPTSP) setempat beserta seluruh kelengkapan dokumen.</p>

<h3>Langkah 4: Pemeriksaan Lapangan oleh Tim Pemda (1–2 Minggu)</h3>
<p>Tim pemeriksa dari Pemda (atau PJPT yang ditunjuk Pemda untuk bangunan besar) melakukan pemeriksaan fisik ke lokasi. TrainingKota mendampingi selama proses ini berlangsung.</p>

<h3>Langkah 5: Tindak Lanjut Temuan (1–4 Minggu, kondisional)</h3>
<p>Jika ada temuan teknis yang perlu diperbaiki, pemilik bangunan diberikan waktu untuk melakukan perbaikan sebelum pemeriksaan ulang dilakukan.</p>

<h3>Langkah 6: Penerbitan SLF</h3>
<p>Setelah seluruh persyaratan terpenuhi, DPMPTSP menerbitkan SLF. Masa berlaku SLF adalah 5 tahun untuk bangunan industri dan bangunan fungsi khusus.</p>

<h2 id="tips-memperlancar">Tips Memperlancar Proses SLF Pabrik Anda</h2>
<p>Berdasarkan pengalaman pendampingan ratusan proyek SLF industri di berbagai kota di Indonesia, berikut adalah tips praktis dari tim TrainingKota:</p>

<ul>
  <li><strong>Mulai persiapan sejak awal konstruksi:</strong> Jangan tunggu bangunan selesai untuk memikirkan SLF. Pastikan gambar as-built drawing diperbarui setiap ada perubahan di lapangan.</li>
  <li><strong>Selesaikan SLO listrik sebelum pengajuan SLF:</strong> SLO (Sertifikat Laik Operasi) dari PLN adalah dokumen utama yang paling sering terlambat dan menjadi penghambat proses SLF.</li>
  <li><strong>Lengkapi semua fire protection requirements:</strong> Sistem APAR, hydrant, sprinkler, dan exit sign adalah temuan paling umum dalam pemeriksaan SLF pabrik.</li>
  <li><strong>Gunakan konsultan berpengalaman:</strong> Proses SLF melibatkan banyak instansi dan regulasi teknis yang kompleks. Konsultan berpengalaman dapat menghemat waktu dan biaya secara signifikan.</li>
</ul>

<h2 id="layanan-trainingkota">Layanan SLF TrainingKota: Pendampingan Penuh dari A sampai Z</h2>
<p>TrainingKota menyediakan layanan pengurusan SLF terpadu untuk pabrik dan bangunan industri di seluruh Indonesia. Tim kami terdiri dari arsitek, insinyur sipil, dan konsultan K3 bersertifikat yang memiliki pengalaman luas dalam pengurusan SLF di berbagai kota besar Indonesia.</p>

<p>Apa yang kami kerjakan untuk Anda:</p>
<ul>
  <li>Site visit dan assessment kondisi bangunan</li>
  <li>Identifikasi kekurangan dan rekomendasi perbaikan pra-SLF</li>
  <li>Penyusunan laporan teknis oleh tim PJPT bersertifikat</li>
  <li>Koordinasi dan pengajuan dokumen ke DPMPTSP</li>
  <li>Pendampingan pemeriksaan lapangan oleh tim Pemda</li>
  <li>Pengurusan SLO listrik melalui jalur resmi PLN/LPK</li>
  <li>Follow-up hingga terbitnya SLF</li>
</ul>

<p>Hubungi tim jasa kami sekarang melalui WhatsApp +62 812-3456-7890 untuk konsultasi gratis dan estimasi biaya SLF untuk fasilitas industri Anda.</p>
HTML,
        ]);

        $this->command->info('✅ ArticleSeeder: 3 artikel (1500+ kata) berhasil dibuat.');
    }
}
