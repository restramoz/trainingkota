<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::truncate();

        $services = array (
  0 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Ahli K3 Umum',
    'slug' => 'ahli-k3-umum',
    'badge' => 'Kemnaker RI Certified',
    'duration' => '12 Hari',
    'price_estimate' => 'Rp 5.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Ahli K3 Umum berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  1 => 
  array (
    'category' => 'pelatihan',
    'name' => 'SMK3',
    'slug' => 'smk3',
    'badge' => 'BNSP Accredited',
    'duration' => '3 - 6 Hari',
    'price_estimate' => 'Mulai Rp 4.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional SMK3 berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  2 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Operator Forklift',
    'slug' => 'operator-forklift',
    'badge' => 'Kemnaker RI Lisensi K3',
    'duration' => '3 - 4 Hari',
    'price_estimate' => 'Mulai Rp 3.250.000',
    'description' => 'Layanan pemenuhan regulasi profesional Operator Forklift berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  3 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Operator Alat Berat Excavator Bulldozer Vibro Dump Truck Wheel Loader',
    'slug' => 'operator-alat-berat-excavator-bulldozer-vibro-dump-truck-wheel-loader',
    'badge' => 'Kemnaker RI Lisensi K3',
    'duration' => '3 - 4 Hari',
    'price_estimate' => 'Mulai Rp 3.250.000',
    'description' => 'Layanan pemenuhan regulasi profesional Operator Alat Berat Excavator Bulldozer Vibro Dump Truck Wheel Loader berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  4 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Operator Gondola',
    'slug' => 'operator-gondola',
    'badge' => 'Kemnaker RI Lisensi K3',
    'duration' => '3 - 4 Hari',
    'price_estimate' => 'Mulai Rp 3.250.000',
    'description' => 'Layanan pemenuhan regulasi profesional Operator Gondola berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  5 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Operator Lifter, Manlift, Boomlift, Scissor Lift',
    'slug' => 'operator-lifter-manlift-boomlift-scissor-lift',
    'badge' => 'Kemnaker RI Lisensi K3',
    'duration' => '3 - 4 Hari',
    'price_estimate' => 'Mulai Rp 3.250.000',
    'description' => 'Layanan pemenuhan regulasi profesional Operator Lifter, Manlift, Boomlift, Scissor Lift berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  6 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Operator Pallet Mover, Liftstacker, Reachstacker',
    'slug' => 'operator-pallet-mover-liftstacker-reachstacker',
    'badge' => 'Kemnaker RI Lisensi K3',
    'duration' => '3 - 4 Hari',
    'price_estimate' => 'Mulai Rp 3.250.000',
    'description' => 'Layanan pemenuhan regulasi profesional Operator Pallet Mover, Liftstacker, Reachstacker berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  7 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Operator Tower Crane',
    'slug' => 'operator-tower-crane',
    'badge' => 'Kemnaker RI Lisensi K3',
    'duration' => '3 - 4 Hari',
    'price_estimate' => 'Mulai Rp 3.250.000',
    'description' => 'Layanan pemenuhan regulasi profesional Operator Tower Crane berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  8 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Operator Overhead Crane Mobile Crane Pedestal Crane',
    'slug' => 'operator-overhead-crane-mobile-crane-pedestal-crane',
    'badge' => 'Kemnaker RI Lisensi K3',
    'duration' => '3 - 4 Hari',
    'price_estimate' => 'Mulai Rp 3.250.000',
    'description' => 'Layanan pemenuhan regulasi profesional Operator Overhead Crane Mobile Crane Pedestal Crane berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  9 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Operator Pita Transport (Conveyor) Kompressor',
    'slug' => 'operator-pita-transport-conveyor-kompressor',
    'badge' => 'Kemnaker RI Lisensi K3',
    'duration' => '3 - 4 Hari',
    'price_estimate' => 'Mulai Rp 3.250.000',
    'description' => 'Layanan pemenuhan regulasi profesional Operator Pita Transport (Conveyor) Kompressor berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  10 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Rigger (Juru Ikat)',
    'slug' => 'rigger-juru-ikat',
    'badge' => 'Kemnaker RI Lisensi K3',
    'duration' => '3 - 4 Hari',
    'price_estimate' => 'Mulai Rp 3.250.000',
    'description' => 'Layanan pemenuhan regulasi profesional Rigger (Juru Ikat) berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  11 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Operator K3 Cargo Hoist Crane Kelas 3 (Lift Barang)',
    'slug' => 'operator-k3-cargo-hoist-crane-kelas-3-lift-barang',
    'badge' => 'Kemnaker RI Lisensi K3',
    'duration' => '3 - 4 Hari',
    'price_estimate' => 'Mulai Rp 3.250.000',
    'description' => 'Layanan pemenuhan regulasi profesional Operator K3 Cargo Hoist Crane Kelas 3 (Lift Barang) berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  12 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Pesawat Angkat & Pesawat Angkut',
    'slug' => 'pesawat-angkat-pesawat-angkut',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Pesawat Angkat & Pesawat Angkut berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  13 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Lift & Eskalator',
    'slug' => 'lift-eskalator',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Lift & Eskalator berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  14 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Operator Genset',
    'slug' => 'operator-genset',
    'badge' => 'Kemnaker RI Lisensi K3',
    'duration' => '3 - 4 Hari',
    'price_estimate' => 'Mulai Rp 3.250.000',
    'description' => 'Layanan pemenuhan regulasi profesional Operator Genset berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  15 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Turbin Uap & Gas',
    'slug' => 'turbin-uap-gas',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Turbin Uap & Gas berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  16 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Operator Mesin Produksi & Perkakas',
    'slug' => 'operator-mesin-produksi-perkakas',
    'badge' => 'Kemnaker RI Lisensi K3',
    'duration' => '3 - 4 Hari',
    'price_estimate' => 'Mulai Rp 3.250.000',
    'description' => 'Layanan pemenuhan regulasi profesional Operator Mesin Produksi & Perkakas berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  17 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Operator Tanur',
    'slug' => 'operator-tanur',
    'badge' => 'Kemnaker RI Lisensi K3',
    'duration' => '3 - 4 Hari',
    'price_estimate' => 'Mulai Rp 3.250.000',
    'description' => 'Layanan pemenuhan regulasi profesional Operator Tanur berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  18 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Pesawat Tenaga & Produksi',
    'slug' => 'pesawat-tenaga-produksi',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Pesawat Tenaga & Produksi berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  19 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Pesawat Uap Boiler',
    'slug' => 'pesawat-uap-boiler',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Pesawat Uap Boiler berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  20 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Teknisi Bejana Tekan & Tangki Timbun',
    'slug' => 'teknisi-bejana-tekan-tangki-timbun',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Teknisi Bejana Tekan & Tangki Timbun berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  21 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Petugas P3K',
    'slug' => 'petugas-p3k',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Petugas P3K berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  22 => 
  array (
    'category' => 'pelatihan',
    'name' => 'K3 Rumah Sakit',
    'slug' => 'k3-rumah-sakit',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional K3 Rumah Sakit berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  23 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Hiperkes Paramedic / Perawat',
    'slug' => 'hiperkes-paramedic-perawat',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Hiperkes Paramedic / Perawat berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  24 => 
  array (
    'category' => 'pelatihan',
    'name' => 'HIPERKES DOKTER',
    'slug' => 'hiperkes-dokter',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional HIPERKES DOKTER berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  25 => 
  array (
    'category' => 'pelatihan',
    'name' => 'K3 Kebakaran DAMKAR DCBA',
    'slug' => 'k3-kebakaran-damkar-dcba',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional K3 Kebakaran DAMKAR DCBA berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  26 => 
  array (
    'category' => 'pelatihan',
    'name' => 'K3 Kimia',
    'slug' => 'k3-kimia',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional K3 Kimia berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  27 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Ahli K3 Muda Lingkungan Kerja',
    'slug' => 'ahli-k3-muda-lingkungan-kerja',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Ahli K3 Muda Lingkungan Kerja berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  28 => 
  array (
    'category' => 'pelatihan',
    'name' => 'K3 Ruang Terbatas (Confined Space)',
    'slug' => 'k3-ruang-terbatas-confined-space',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional K3 Ruang Terbatas (Confined Space) berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  29 => 
  array (
    'category' => 'pelatihan',
    'name' => 'K3 Listrik',
    'slug' => 'k3-listrik',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional K3 Listrik berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  30 => 
  array (
    'category' => 'pelatihan',
    'name' => 'K3 Konstruksi',
    'slug' => 'k3-konstruksi',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional K3 Konstruksi berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  31 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Perancah (Scaffolding)',
    'slug' => 'perancah-scaffolding',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Perancah (Scaffolding) berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  32 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Juru Las (Welder)',
    'slug' => 'juru-las-welder',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Juru Las (Welder) berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  33 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Tenaga Kerja Bangunan Tinggi (TKBT)',
    'slug' => 'tenaga-kerja-bangunan-tinggi-tkbt',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Tenaga Kerja Bangunan Tinggi (TKBT) berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  34 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Tenaga Kerja Pada Ketinggian (TKPK)',
    'slug' => 'tenaga-kerja-pada-ketinggian-tkpk',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Tenaga Kerja Pada Ketinggian (TKPK) berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  35 => 
  array (
    'category' => 'pelatihan',
    'name' => 'WAH (Working at Height)',
    'slug' => 'wah-working-at-height',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional WAH (Working at Height) berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  36 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Pipe Fitter',
    'slug' => 'pipe-fitter',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Pipe Fitter berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  37 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Supervisi K3 Konstruksi',
    'slug' => 'supervisi-k3-konstruksi',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Supervisi K3 Konstruksi berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  38 => 
  array (
    'category' => 'pelatihan',
    'name' => 'H2S JSA ERGONOMI PERMIT TO WORK BBS HACCP HAZMAT LOTO',
    'slug' => 'h2s-jsa-ergonomi-permit-to-work-bbs-haccp-hazmat-loto',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional H2S JSA ERGONOMI PERMIT TO WORK BBS HACCP HAZMAT LOTO berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  39 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Authorizer Gas tester',
    'slug' => 'authorizer-gas-tester',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Authorizer Gas tester berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  40 => 
  array (
    'category' => 'pelatihan',
    'name' => 'DDT (Defensive Driving Training)',
    'slug' => 'ddt-defensive-driving-training',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional DDT (Defensive Driving Training) berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  41 => 
  array (
    'category' => 'pelatihan',
    'name' => 'K3 Migas',
    'slug' => 'k3-migas',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional K3 Migas berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  42 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Penanggung Jawab Operasional Pertama (POP) POM POU',
    'slug' => 'penanggung-jawab-operasional-pertama-pop-pom-pou',
    'badge' => 'BNSP Accredited',
    'duration' => '3 - 6 Hari',
    'price_estimate' => 'Mulai Rp 4.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Penanggung Jawab Operasional Pertama (POP) POM POU berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  43 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Insiden Investigator',
    'slug' => 'insiden-investigator',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Insiden Investigator berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  44 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Penanggungjawab Operasional Pengolahan Air Limbah (POPAL)',
    'slug' => 'penanggungjawab-operasional-pengolahan-air-limbah-popal',
    'badge' => 'BNSP Accredited',
    'duration' => '3 - 6 Hari',
    'price_estimate' => 'Mulai Rp 4.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Penanggungjawab Operasional Pengolahan Air Limbah (POPAL) berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  45 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Penanggungjawab Pengendalian Pencemaran Air (PPPA)',
    'slug' => 'penanggungjawab-pengendalian-pencemaran-air-pppa',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Penanggungjawab Pengendalian Pencemaran Air (PPPA) berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  46 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Penanggungjawab Pengendalian Pencemaran Udara (PPPU) & POIPPU',
    'slug' => 'penanggungjawab-pengendalian-pencemaran-udara-pppu-poippu',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Penanggungjawab Pengendalian Pencemaran Udara (PPPU) & POIPPU berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  47 => 
  array (
    'category' => 'pelatihan',
    'name' => 'PLB3 (Penanggung Jawab Pengelolaan B3) & OLB3 (Operator Pengelola Limbah B3)',
    'slug' => 'plb3-penanggung-jawab-pengelolaan-b3-olb3-operator-pengelola-limbah-b3',
    'badge' => 'Kemnaker RI Lisensi K3',
    'duration' => '3 - 4 Hari',
    'price_estimate' => 'Mulai Rp 3.250.000',
    'description' => 'Layanan pemenuhan regulasi profesional PLB3 (Penanggung Jawab Pengelolaan B3) & OLB3 (Operator Pengelola Limbah B3) berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  48 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Pengambil Contoh Uji Air (PCUA)',
    'slug' => 'pengambil-contoh-uji-air-pcua',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Pengambil Contoh Uji Air (PCUA) berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  49 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Training Manajemen Risiko',
    'slug' => 'training-manajemen-risiko',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Training Manajemen Risiko berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  50 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Sea Survival HUET BOSIET & T-BOSIET',
    'slug' => 'sea-survival-huet-bosiet-t-bosiet',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Sea Survival HUET BOSIET & T-BOSIET berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  51 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Compressor',
    'slug' => 'compressor',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Compressor berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  52 => 
  array (
    'category' => 'pelatihan',
    'name' => 'Drilling',
    'slug' => 'drilling',
    'badge' => 'Sertifikasi Kemnaker/BNSP',
    'duration' => '2 - 5 Hari',
    'price_estimate' => 'Mulai Rp 3.500.000',
    'description' => 'Layanan pemenuhan regulasi profesional Drilling berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  53 => 
  array (
    'category' => 'kajian',
    'name' => 'Kajian Safety Culture Maturity Level',
    'slug' => 'kajian-safety-culture-maturity-level',
    'badge' => 'Kajian Teknis PJK3',
    'duration' => '14 - 30 Hari Kerja',
    'price_estimate' => 'Proposal Sesuai Ruang Lingkup',
    'description' => 'Layanan pemenuhan regulasi profesional Kajian Safety Culture Maturity Level berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  54 => 
  array (
    'category' => 'kajian',
    'name' => 'Kajian Fire Risk Asessment',
    'slug' => 'kajian-fire-risk-asessment',
    'badge' => 'Kajian Teknis PJK3',
    'duration' => '14 - 30 Hari Kerja',
    'price_estimate' => 'Proposal Sesuai Ruang Lingkup',
    'description' => 'Layanan pemenuhan regulasi profesional Kajian Fire Risk Asessment berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  55 => 
  array (
    'category' => 'kajian',
    'name' => 'Kajian Lingkungan Transportasi Maritim Budaya Kesehatan Ekonomi Sosial Pendidikan',
    'slug' => 'kajian-lingkungan-transportasi-maritim-budaya-kesehatan-ekonomi-sosial-pendidikan',
    'badge' => 'Kajian Teknis PJK3',
    'duration' => '14 - 30 Hari Kerja',
    'price_estimate' => 'Proposal Sesuai Ruang Lingkup',
    'description' => 'Layanan pemenuhan regulasi profesional Kajian Lingkungan Transportasi Maritim Budaya Kesehatan Ekonomi Sosial Pendidikan berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  56 => 
  array (
    'category' => 'jasa',
    'name' => 'Jasa UKL-UPL Amdal Pertek Rintek',
    'slug' => 'jasa-ukl-upl-amdal-pertek-rintek',
    'badge' => 'Izin & Riksa Uji Resmi',
    'duration' => 'Sesuai Proyek',
    'price_estimate' => 'Penawaran Teknis Korporasi',
    'description' => 'Layanan pemenuhan regulasi profesional Jasa UKL-UPL Amdal Pertek Rintek berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  57 => 
  array (
    'category' => 'jasa',
    'name' => 'Jasa Sertifikat Laik Fungsi (SLF) dan Nomor Induk Data Instalasi (NIDI)',
    'slug' => 'jasa-sertifikat-laik-fungsi-slf-dan-nomor-induk-data-instalasi-nidi',
    'badge' => 'Izin & Riksa Uji Resmi',
    'duration' => 'Sesuai Proyek',
    'price_estimate' => 'Penawaran Teknis Korporasi',
    'description' => 'Layanan pemenuhan regulasi profesional Jasa Sertifikat Laik Fungsi (SLF) dan Nomor Induk Data Instalasi (NIDI) berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  58 => 
  array (
    'category' => 'jasa',
    'name' => 'Jasa Sertifikat Laik Operasi (SLO)',
    'slug' => 'jasa-sertifikat-laik-operasi-slo',
    'badge' => 'Izin & Riksa Uji Resmi',
    'duration' => 'Sesuai Proyek',
    'price_estimate' => 'Penawaran Teknis Korporasi',
    'description' => 'Layanan pemenuhan regulasi profesional Jasa Sertifikat Laik Operasi (SLO) berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  59 => 
  array (
    'category' => 'jasa',
    'name' => 'Jasa Riksa Uji SILO (Surat Izin Layak Operasi) SIA (Surat Izin Alat)',
    'slug' => 'jasa-riksa-uji-silo-surat-izin-layak-operasi-sia-surat-izin-alat',
    'badge' => 'Izin & Riksa Uji Resmi',
    'duration' => 'Sesuai Proyek',
    'price_estimate' => 'Penawaran Teknis Korporasi',
    'description' => 'Layanan pemenuhan regulasi profesional Jasa Riksa Uji SILO (Surat Izin Layak Operasi) SIA (Surat Izin Alat) berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  60 => 
  array (
    'category' => 'jasa',
    'name' => 'Jasa Transportasi & Pengelolaan Limbah B3',
    'slug' => 'jasa-transportasi-pengelolaan-limbah-b3',
    'badge' => 'Izin & Riksa Uji Resmi',
    'duration' => 'Sesuai Proyek',
    'price_estimate' => 'Penawaran Teknis Korporasi',
    'description' => 'Layanan pemenuhan regulasi profesional Jasa Transportasi & Pengelolaan Limbah B3 berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
  61 => 
  array (
    'category' => 'jasa',
    'name' => 'Jasa Audit Keuangan Perusahaan',
    'slug' => 'jasa-audit-keuangan-perusahaan',
    'badge' => 'Izin & Riksa Uji Resmi',
    'duration' => 'Sesuai Proyek',
    'price_estimate' => 'Penawaran Teknis Korporasi',
    'description' => 'Layanan pemenuhan regulasi profesional Jasa Audit Keuangan Perusahaan berstandar nasional untuk menjamin keselamatan kerja, legalitas, dan kelaikan operasional industri.',
    'syllabus' => 
    array (
      0 => 'Dasar Hukum & Regulasi Teknis Terkini',
      1 => 'Identifikasi Bahaya & Pengendalian Risiko Terapan',
      2 => 'Standar Prosedur Operasional & Studi Kasus Lapangan',
      3 => 'Evaluasi Kepatuhan & Ujian Sertifikasi Resmi',
    ),
    'target_audience' => 'Safety Officer, HSE Manager, Supervisor Teknis, Manajer Pabrik, dan Tim Operasional Lapangan.',
  ),
);

        foreach ($services as $s) {
            Service::create($s);
        }
    }
}
