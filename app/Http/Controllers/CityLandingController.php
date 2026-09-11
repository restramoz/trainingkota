<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\City;
use App\Models\Article;
use App\Models\Faq;
use Illuminate\Http\Request;

class CityLandingController extends Controller
{
    public function show($category, $citySlug)
    {
        $validCategories = ['pelatihan', 'kajian', 'jasa'];
        if (!in_array($category, $validCategories)) {
            abort(404);
        }

        $city = City::with(['kecamatans' => function($q){ $q->distinct(); }])->where('slug', $citySlug)->firstOrFail();
        
        // Business Rule: City Page is a Service Catalog.
        // Show services that have coverage (CityServiceContent) in this city.
        // If no coverage is explicitly defined, we can still show all services but they'll link to the catalog detail.
        $services = Service::where('category', $category)
            ->orderBy('name')
            ->get();
            
        $otherCitiesInIsland = City::where('island', $city->island)
            ->where('id', '!=', $city->id)
            ->take(12)
            ->get();

        $categoryNames = [
            'pelatihan' => 'Pelatihan K3 & Sertifikasi Kemnaker RI',
            'kajian'    => 'Kajian Teknis & Studi Kelayakan K3',
            'jasa'      => 'Jasa Teknis, SLF & Riksa Uji Industri',
        ];
        $categoryName = $categoryNames[$category] ?? ucfirst($category);

        // ── Artikel sebagai konten pendukung (NOT primary)
        $articlesQuery = Article::published()
            ->where('city_id', $city->id)
            ->latest();

        $relatedArticles = $articlesQuery->limit(6)->get();
        $article = $relatedArticles->first();

        // ── FAQ dari DB: prioritaskan per kota, fallback ke per kategori, lalu hardcoded
        $faqItems = $this->getFaqItems($category, $city);

        // ── Training schedules jika kategori pelatihan
        $upcomingSchedules = collect();
        if ($category === 'pelatihan') {
            $upcomingSchedules = \App\Models\TrainingSchedule::with('service')
                ->where('city_id', $city->id)
                ->where('status', 'open')
                ->orderBy('date')
                ->take(3)
                ->get();
        }

        return view('city-landing', compact(
            'category',
            'categoryName',
            'city',
            'services',
            'otherCitiesInIsland',
            'article',
            'relatedArticles',
            'faqItems',
            'upcomingSchedules'
        ));
    }

    /**
     * FAQ: ambil dari DB dulu (per kota/layanan), fallback ke hardcoded per kategori.
     */
    private function getFaqItems(string $category, City $city): array
    {
        // Coba dari DB: FAQ yang terkait kota ini
        $dbFaqs = Faq::published()
            ->where('city_id', $city->id)
            ->orderBy('order')
            ->orderBy('id')
            ->limit(6)
            ->get();

        if ($dbFaqs->isNotEmpty()) {
            return $dbFaqs->map(fn($f) => ['q' => $f->question, 'a' => $f->answer])->toArray();
        }

        // Fallback ke FAQ hardcoded per kategori
        return $this->getHardcodedFaqs($category, $city->name);
    }

    /**
     * Hardcoded FAQ fallback saat DB kosong — tetap dinamis (pakai nama kota).
     */
    private function getHardcodedFaqs(string $category, string $cityName): array
    {
        $base = [
            'pelatihan' => [
                [
                    'q' => "Berapa lama durasi pelatihan K3 yang diselenggarakan di {$cityName}?",
                    'a' => "Durasi pelatihan K3 bervariasi tergantung program yang dipilih. Program Ahli K3 Umum berlangsung 12 hari efektif (termasuk ujian), sementara program operator alat berat bisa 5–8 hari. Semua program yang kami selenggarakan di {$cityName} sesuai standar Kemnaker RI.",
                ],
                [
                    'q' => "Apakah sertifikat K3 yang diperoleh di {$cityName} berlaku secara nasional?",
                    'a' => "Ya. Seluruh sertifikat yang diterbitkan melalui program TrainingKota bersifat nasional — dikeluarkan oleh Kemnaker RI dan/atau BNSP. Sertifikat ini diakui di seluruh wilayah Indonesia tanpa batasan wilayah operasional.",
                ],
                [
                    'q' => "Apakah tersedia program In-House Training K3 di {$cityName}?",
                    'a' => "Tersedia. TrainingKota menyediakan layanan In-House Training langsung di lokasi pabrik atau kantor Anda di {$cityName} dan sekitarnya. Tim instruktur bersertifikasi kami siap datang ke fasilitas Anda dengan minimum peserta 15 orang.",
                ],
                [
                    'q' => "Apa saja dokumen yang perlu disiapkan untuk mendaftar pelatihan K3?",
                    'a' => "Dokumen yang diperlukan: (1) Fotokopi KTP, (2) Fotokopi ijazah pendidikan terakhir, (3) Pas foto 3×4 latar merah, (4) Surat keterangan kerja dari perusahaan, (5) Surat keterangan sehat dari dokter. Semua dokumen diserahkan saat registrasi ulang di hari pertama pelatihan.",
                ],
                [
                    'q' => "Bagaimana cara booking kursi pelatihan K3 di {$cityName}?",
                    'a' => "Proses booking sangat mudah: (1) Pilih program dari katalog, (2) Hubungi tim kami via WhatsApp atau klik tombol Booking Slot, (3) Tim registrasi akan mengirimkan formulir pendaftaran dan invoice DP, (4) Konfirmasi pembayaran untuk penguncian kursi.",
                ],
            ],
            'kajian' => [
                [
                    'q' => "Apa yang dimaksud dengan Kajian Risiko K3 untuk fasilitas industri di {$cityName}?",
                    'a' => "Kajian Risiko K3 adalah asesmen sistematis terhadap potensi bahaya di lingkungan kerja — mencakup identifikasi hazard, analisis konsekuensi, penilaian probabilitas, dan rekomendasi pengendalian risiko. Kajian ini wajib dilakukan sebelum commissioning fasilitas baru atau perluasan kapasitas industri di {$cityName}.",
                ],
                [
                    'q' => "Berapa lama proses kajian teknis SLF untuk pabrik di {$cityName}?",
                    'a' => "Proses kajian teknis SLF umumnya berlangsung 14–30 hari kerja tergantung luas bangunan dan kompleksitas instalasi. Tim kami akan melakukan site visit, pengukuran, analisis dokumen, dan menyusun laporan kajian yang diperlukan untuk pengajuan SLF ke Dinas PU setempat di {$cityName}.",
                ],
                [
                    'q' => "Apakah kajian UKL-UPL wajib untuk semua jenis industri di {$cityName}?",
                    'a' => "Kewajiban UKL-UPL bergantung pada skala dan jenis usaha. Industri dengan dampak lingkungan menengah diwajibkan menyusun UKL-UPL, sementara industri berskala besar wajib AMDAL penuh. Tim konsultan kami akan membantu menentukan instrumen lingkungan yang tepat untuk usaha Anda di {$cityName}.",
                ],
                [
                    'q' => "Bagaimana prosedur audit SMK3 PP 50/2012 di {$cityName}?",
                    'a' => "Audit SMK3 PP 50/2012 dilaksanakan oleh auditor eksternal yang terdaftar di Kemnaker RI. Proses meliputi: (1) Pre-audit assessment, (2) Audit dokumentasi (130+ kriteria), (3) Audit lapangan dan wawancara, (4) Laporan temuan, (5) Tindakan perbaikan, (6) Sertifikasi SMK3. TrainingKota menyediakan pendampingan penuh proses ini di {$cityName}.",
                ],
            ],
            'jasa' => [
                [
                    'q' => "Apa itu SLF (Sertifikat Laik Fungsi) dan apakah wajib untuk pabrik di {$cityName}?",
                    'a' => "SLF adalah dokumen resmi pemerintah yang menyatakan bahwa bangunan gedung telah memenuhi persyaratan laik fungsi secara teknis dan administratif. Berdasarkan UU No. 28/2002 tentang Bangunan Gedung, SLF WAJIB dimiliki oleh seluruh bangunan industri/komersial sebelum dioperasikan, termasuk pabrik di {$cityName}.",
                ],
                [
                    'q' => "Berapa biaya pengurusan SLF pabrik di {$cityName}?",
                    'a' => "Biaya pengurusan SLF bervariasi tergantung luas bangunan, jumlah lantai, dan kompleksitas instalasi MEP. Hubungi tim kami untuk mendapatkan estimasi biaya yang akurat untuk fasilitas spesifik Anda di {$cityName}. Kami menjamin transparansi biaya tanpa biaya tersembunyi.",
                ],
                [
                    'q' => "Apa itu Riksa Uji dan alat apa saja yang wajib diperiksa secara berkala?",
                    'a' => "Riksa Uji adalah pemeriksaan dan pengujian berkala terhadap alat berat dan instalasi berdasarkan Permenaker. Alat yang wajib riksa uji antara lain: Pesawat Angkat/Angkut (forklift, crane, overhead crane), Pesawat Uap (boiler), Bejana Tekan (pressure vessel, tangki LPG), dan Instalasi Listrik. Izin Riksa Uji harus diperbarui setiap 1–2 tahun.",
                ],
                [
                    'q' => "Apakah TrainingKota dapat membantu pengurusan SLO Instalasi Listrik di {$cityName}?",
                    'a' => "Ya. TrainingKota menyediakan layanan lengkap pengurusan SLO (Sertifikat Laik Operasi) untuk instalasi listrik industri di {$cityName}, mulai dari riksa uji teknis oleh tim inspektur, pembuatan laporan teknis, hingga pendampingan proses penerbitan SLO di PLN setempat.",
                ],
            ],
        ];

        return $base[$category] ?? [];
    }
}
