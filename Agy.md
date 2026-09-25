# Dokumentasi Task: Perbaikan PHPUnit Test Suite & Migrasi ke Master Wilayah BPS

Dokumen ini merangkum riwayat investigasi masalah pada test suite Laravel (`php artisan test`), analisis akar permasalahan (*root cause analysis*), fase perbaikan sistematis dari *legacy mapping summary* ke `master_wilayah_bps.json`, serta hal-hal penting yang perlu diperhatikan untuk menjaga integritas data dan kestabilan aplikasi.

---

## 1. Ringkasan Riwayat & Masalah (History & Problem Summary)

Saat menjalankan perintah `php artisan test`, ditemukan 3 kategori permasalahan utama:
1. **14 PHPUnit 12 Deprecation Warnings**: Muncul peringatan bahwa anotasi *doc-comment* `/** @test */` telah didepresiasi dan akan dihapus di PHPUnit 12.
2. **1 Risky Test Warning**: `Tests\Feature\LocalRoutingTest::test_city_landing_page_is_accessible` berstatus *risky* karena output buffer Blade tidak tertutup (`Test code or tested code did not close its own output buffers`).
3. **10 Test Failures**:
   - **3 kegagalan di `Tests\Feature\LocalRoutingTest`**:
     - `test_city_landing_page_includes_seo_article_and_schema`: Gagal menemukan teks `PANDUAN &amp; REGULASI TERKAIT MALANG` dan `DAFTAR ISI ARTIKEL`.
     - `test_sitemap_xml_is_generated_correctly`: Gagal menemukan URL `/pelatihan/ahli-k3-umum/kota-malang` dalam sitemap XML.
     - `test_hyper_specific_city_service_page_is_accessible_with_schemas`: Gagal menemukan `Ahli K3 Umum di Malang` dan `LOKASI: MALANG`.
   - **7 kegagalan di `Tests\Feature\MappingRegressionTest`**:
     - Seluruh pengujian regresi pemetaan gagal karena menguji file *legacy* `mapping_summary_v4.json` yang rusak/invalid JSON (`mapping_summary_v4.json is not valid JSON`). Sesuai arahan, sistem tidak boleh lagi bergantung pada `mapping_summary_*.json`, melainkan menggunakan `master_wilayah_bps.json` secara *end-to-end*.

---

## 2. Analisis Akar Masalah (Root Cause Analysis)

| Komponen | Gejala / Error | Akar Masalah |
| :--- | :--- | :--- |
| **PHPUnit Metadata** | `Metadata in doc-comments is deprecated` | Metode pengujian di `KecamatanLandingTest`, `TargetingValidationTest`, dan `MappingRegressionTest` masih menggunakan anotasi `/** @test */` alih-alih PHP 8 Attribute `#[Test]`. |
| **Blade Output Buffer** | `did not close its own output buffers` | File [city-landing.blade.php](file:///root/trainingkota/resources/views/city-landing.blade.php) kehilangan tag penutup `@endsection` di akhir file sehingga fungsi `ob_start()` Blade tetap terbuka saat test selesai. |
| **BPS Wilayah Seeder** | `is_hub` bernilai 0 untuk semua kota | Array `$hubSlugs` di [BpsMasterWilayahSeeder.php](file:///root/trainingkota/database/seeders/BpsMasterWilayahSeeder.php) menggunakan format `kota-malang`, `kota-surabaya`, dsb., sedangkan kolom `slug` di-generate hanya berupa `malang`, `surabaya` (tanpa prefiks `kota-`). Akibatnya `in_array($slug, $hubSlugs)` bernilai `false`, Kota Malang tidak masuk ke daftar `$hubCities`, dan tidak digenerate di `sitemap.xml`. |
| **Format Penamaan Kota** | Gagal assert `Ahli K3 Umum di Malang` & `LOKASI: MALANG` | [BpsMasterWilayahSeeder.php](file:///root/trainingkota/database/seeders/BpsMasterWilayahSeeder.php) men-generate nama kota bertipe `Kota` dengan menyisipkan prefiks `"Kota "` (menjadi `"Kota Malang"`). Routing web dan view mengharapkan nama dasar `"Malang"` (klasifikasi jenis wilayah disimpan tersendiri di kolom `classification`). |
| **SEO Article Kota** | Gagal assert `PANDUAN &amp; REGULASI TERKAIT MALANG` & `DAFTAR ISI ARTIKEL` | Bagian artikel panduan K3 sempat terhapus dari [city-landing.blade.php](file:///root/trainingkota/resources/views/city-landing.blade.php), dan [ArticleSeeder.php](file:///root/trainingkota/database/seeders/ArticleSeeder.php) mencari kota dengan `slug = 'kota-malang'` (yang bernilai `null` karena slug resmi adalah `'malang'`). |
| **Mapping Test** | 7 tests failed pada `mapping_summary_v4.json` | Test suite lama masih menguji file perantara `mapping_summary_v4.json`. Proyek kini telah beralih ke sumber data resmi [master_wilayah_bps.json](file:///root/trainingkota/master_wilayah_bps.json) (514 Kab/Kota & 7.288 Kecamatan). |

---

## 3. Fase-Fase Perbaikan (Phases of Implementation)

### Fase 1: Pembersihan Depresiasi PHPUnit 12 (Modernisasi Test Suite)
- **Target File**:
  - `tests/Feature/KecamatanLandingTest.php`
  - `tests/Feature/TargetingValidationTest.php`
  - `tests/Feature/MappingRegressionTest.php`
- **Tindakan**:
  1. Tambahkan `use PHPUnit\Framework\Attributes\Test;` pada namespace *import*.
  2. Ganti semua anotasi `/** @test */` menjadi attribute `#[Test]` di atas setiap metode pengujian.
  3. Memastikan tidak ada lagi peringatan metadata doc-comment saat `php artisan test` dijalankan.

### Fase 2: Transformasi `MappingRegressionTest` Menjadi End-to-End BPS Wilayah
- **Target File**:
  - `tests/Feature/MappingRegressionTest.php`
- **Tindakan**:
  1. Ubah referensi data dari `mapping_summary_v4.json` ke [master_wilayah_bps.json](file:///root/trainingkota/master_wilayah_bps.json).
  2. Validasi struktur JSON `master_wilayah_bps.json` (7.288 record kecamatan, 514 kode kota/kabupaten unik, kelengkapan kode provinsi & jenis wilayah).
  3. Implementasikan validasi *end-to-end* terhadap tabel database `cities` dan `kecamatans`:
     - Memastikan 514 Kab/Kota dan 7.288 Kecamatan ter-seed sempurna di database.
     - Memastikan relasi `kecamatans.city_id` cocok dengan `cities.bps_code`.
     - Memastikan wilayah kembar seperti Malang (Kabupaten Malang kode `3507000` dan Kota Malang kode `3573000`) terpetakan dengan benar dan mandiri.
     - Memastikan tidak ada duplikasi kode wilayah BPS antar entitas berbeda.

### Fase 3: Koreksi Data & Seeder BPS Wilayah
- **Target File**:
  - `database/seeders/BpsMasterWilayahSeeder.php`
  - `database/seeders/ArticleSeeder.php`
- **Tindakan**:
  1. **Di `BpsMasterWilayahSeeder.php`**:
     - Atur nama kota untuk jenis `Kota` menjadi `$rawName` (contoh: `'Malang'`), dan jenis `Kabupaten` menjadi `'Kabupaten ' . $rawName`, dengan kolom `classification` menyimpan `'Kota'` atau `'Kabupaten'`.
     - Perbaiki pencocokan `$isHub`:
       ```php
       $isHub = in_array($slug, $hubSlugs) 
           || in_array("kota-{$slug}", $hubSlugs) 
           || in_array("kabupaten-" . Str::slug($rawName), $hubSlugs);
       ```
       sehingga 29 kota hub utama (termasuk Malang, Surabaya, dsb.) memiliki flag `is_hub = 1`.
  2. **Di `ArticleSeeder.php`**:
     - Temukan Kota Malang dengan `$malang = City::where('slug', 'malang')->first();`.
     - Pastikan artikel panduan K3 terikat pada `city_id` Kota Malang agar muncul di halaman regional landing page.
  3. Jalankan `php artisan db:seed` untuk memperbarui data database.

### Fase 4: Perbaikan Blade View & Penutupan Output Buffer
- **Target File**:
  - `resources/views/city-landing.blade.php`
  - `resources/views/city-service-landing.blade.php`
- **Tindakan**:
  1. Di `resources/views/city-landing.blade.php`:
     - Tambahkan kembali blok konten artikel panduan K3 dengan heading `PANDUAN &amp; REGULASI TERKAIT {{ strtoupper($city->name) }}` dan navigasi `DAFTAR ISI ARTIKEL`.
     - Tambahkan `@endsection` pada baris paling akhir file untuk menutup buffer Blade yang menyebabkan status *risky test*.
  2. Di `resources/views/city-service-landing.blade.php`:
     - Pastikan penulisan judul dan badge `LOKASI: {{ strtoupper($city->name) }}` serta `$heading` tampil harmonis dengan nama kota.

### Fase 5: Pengujian Menyeluruh (Verification & Validation)
- **Tindakan**:
  1. Jalankan `php artisan test`.
  2. Pastikan hasil pengujian:
     - **0 Failures**
     - **0 Warnings**
     - **0 Risky**
     - Semua *assertions* lolos (100% Green).

---

## 4. Hal-Hal yang Perlu Diperhatikan (Key Considerations & Guardrails)

1. **Konsistensi Routing vs Slug Kota**:
   - Route publik menggunakan pola `/{category}/kota-{citySlug}` dan `/{category}/{serviceSlug}/kota-{citySlug}`.
   - Parameter `{citySlug}` yang ditangkap oleh controller adalah slug kota di database (misal: `malang`, bukan `kota-malang`).
   - Prefiks URL `kota-` di sitemap dan tautan view harus selalu konsisten dengan route parameter ini.
2. **Kemandirian Sumber Data BPS**:
   - Jangan lagi menggunakan script atau file turunan `mapping_summary*.json` atau file CSV lama. Sumber tunggal kebenaran data wilayah (*Single Source of Truth*) adalah [master_wilayah_bps.json](file:///root/trainingkota/master_wilayah_bps.json).
3. **Integritas Hirarki Relasi Wilayah**:
   - Setiap entitas `Kecamatan` wajib memiliki `city_id` yang valid ke tabel `cities`.
   - Kode BPS kab/kota berformat 7 digit (misal: `3573000`), dan kode kecamatan berformat 7 digit (misal: `3573010`), di mana 4 digit awal kode kecamatan selalu berkorespondensi dengan kode kabupaten/kota induknya.
4. **Buffer Directive pada Blade**:
   - Selalu pastikan pasangan `@section('content')` ditutup dengan `@endsection` pada seluruh template Blade untuk mencegah *buffer leakage* yang merusak pengujian PHPUnit.

---

## 5. Kebutuhan & Prasyarat (Requirements & Dependencies)

- **Runtime & Framework**:
  - PHP 8.3+
  - Laravel 11.x
  - PHPUnit 11.5+ (siap upgrade ke PHPUnit 12)
  - SQLite Database (`database/database.sqlite`)
- **Aset Data**:
  - `master_wilayah_bps.json` (7.288 baris data BPS)
- **Command Utama yang Diperlukan**:
  - `php artisan db:seed`
  - `php artisan test`
