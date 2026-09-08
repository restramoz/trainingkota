<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Kecamatan;
use App\Models\Location;
use App\Models\Service;
use App\Models\Faq;
use App\Models\TrainingSchedule;

class KecamatanAndScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $malang = City::where('slug', 'malang')->first();
        $surabaya = City::where('slug', 'surabaya')->first();
        $jakarta = City::where('slug', 'jakarta-selatan')->orWhere('slug', 'jakarta')->first();

        // 1. Seed Kecamatan Lowokwaru (Malang)
        if ($malang) {
            $lowokwaru = Kecamatan::updateOrCreate(
                ['city_id' => $malang->id, 'slug' => 'lowokwaru'],
                [
                    'name' => 'Lowokwaru',
                    'address' => 'Jl. Soekarno Hatta No. 45, Lowokwaru, Kota Malang',
                    'lat' => -7.9458,
                    'lng' => 112.6152,
                    'google_maps_url' => 'https://maps.google.com/maps?q=-7.9458,112.6152&z=15&output=embed',
                    'seo_title' => 'Pelatihan & Sertifikasi K3 Resmi Kecamatan Lowokwaru Malang',
                    'meta_description' => 'Pusat layanan pembinaan K3, riksa uji alat industri, dan sertifikasi Kemnaker RI di kawasan Lowokwaru, Kota Malang.',
                    'status' => 'active',
                ]
            );

            $klojen = Kecamatan::updateOrCreate(
                ['city_id' => $malang->id, 'slug' => 'klojen'],
                [
                    'name' => 'Klojen',
                    'address' => 'Jl. Ijen No. 12, Klojen, Kota Malang',
                    'lat' => -7.9786,
                    'lng' => 112.6253,
                    'google_maps_url' => 'https://maps.google.com/maps?q=-7.9786,112.6253&z=15&output=embed',
                    'seo_title' => 'Layanan K3 & Kajian Teknis Kecamatan Klojen Malang',
                    'meta_description' => 'Layanan inspeksi keselamatan kerja, audit SMK3, dan pelatihan K3 Kemnaker di Klojen Malang.',
                    'status' => 'active',
                ]
            );

            // Locations
            Location::updateOrCreate(
                ['city_id' => $malang->id, 'location_name' => 'Sentra Praktik K3 Lowokwaru (Lab Ergonomi & Simulator)'],
                [
                    'kecamatan_id' => $lowokwaru->id,
                    'address' => 'Kawasan Sentra Bisnis Soekarno Hatta Kav. 9-11, Lowokwaru, Malang',
                    'lat' => -7.9458,
                    'lng' => 112.6152,
                    'google_maps_url' => 'https://maps.google.com/maps?q=-7.9458,112.6152&z=15&output=embed',
                    'status' => 'active',
                ]
            );

            Location::updateOrCreate(
                ['city_id' => $malang->id, 'location_name' => 'Pusat Simulasi Tanggap Darurat & Fire Drill Klojen'],
                [
                    'kecamatan_id' => $klojen->id,
                    'address' => 'Kompleks Industri Kreatif Klojen, Kota Malang',
                    'lat' => -7.9786,
                    'lng' => 112.6253,
                    'google_maps_url' => 'https://maps.google.com/maps?q=-7.9786,112.6253&z=15&output=embed',
                    'status' => 'active',
                ]
            );
        }

        // 2. Seed Surabaya Kecamatan Gubeng
        if ($surabaya) {
            $gubeng = Kecamatan::updateOrCreate(
                ['city_id' => $surabaya->id, 'slug' => 'gubeng'],
                [
                    'name' => 'Gubeng',
                    'address' => 'Jl. Sumatra No. 88, Gubeng, Surabaya',
                    'lat' => -7.2754,
                    'lng' => 112.7538,
                    'seo_title' => 'Sertifikasi K3 Kemnaker RI Kecamatan Gubeng Surabaya',
                    'meta_description' => 'Layanan sertifikasi resmi Kemnaker RI dan inspeksi teknis industri wilayah Gubeng Surabaya.',
                    'status' => 'active',
                ]
            );

            Location::updateOrCreate(
                ['city_id' => $surabaya->id, 'location_name' => 'Training Center Surabaya Timur (Gubeng)'],
                [
                    'kecamatan_id' => $gubeng->id,
                    'address' => 'Gedung K3 Hub Lt. 3, Jl. Raya Gubeng No. 102, Surabaya',
                    'lat' => -7.2754,
                    'lng' => 112.7538,
                    'status' => 'active',
                ]
            );
        }

        // 3. Seed FAQs
        $ahliK3 = Service::where('slug', 'ahli-k3-umum')->first();
        if ($ahliK3 && $malang) {
            Faq::updateOrCreate(
                ['question' => 'Apakah sertifikat Ahli K3 Umum di Malang resmi Kemnaker RI?'],
                [
                    'service_id' => $ahliK3->id,
                    'city_id' => $malang->id,
                    'answer' => 'Ya, seluruh sertifikat Ahli K3 Umum diterbitkan langsung oleh Kementerian Ketenagakerjaan RI (Kemnaker RI) lengkap dengan SKP (Surat Keputusan Penunjukan) dan Lisensi K3 resmi nasional.',
                    'order' => 1,
                    'status' => 'published',
                ]
            );

            Faq::updateOrCreate(
                ['question' => 'Di mana lokasi sentra praktik sertifikasi K3 di wilayah Malang?'],
                [
                    'service_id' => $ahliK3->id,
                    'city_id' => $malang->id,
                    'answer' => 'Sentra praktik diselenggarakan di fasilitas laboratorium mitra resmi kawasan Lowokwaru dan sentra industri Karanglo Malang dengan peralatan simulator standar Kemnaker RI.',
                    'order' => 2,
                    'status' => 'published',
                ]
            );
        }

        // General Kecamatan FAQs
        if (isset($lowokwaru) && $malang) {
            Faq::updateOrCreate(
                ['question' => 'Apakah perusahaan di Lowokwaru bisa meminta sesi In-House Training K3?'],
                [
                    'city_id' => $malang->id,
                    'kecamatan_id' => $lowokwaru->id,
                    'answer' => 'Sangat bisa. Kami menyediakan in-house training langsung di fasilitas industri, rumah sakit, maupun pabrik di kawasan Lowokwaru dengan jadwal yang disesuaikan kebutuhan shift kerja.',
                    'order' => 1,
                    'status' => 'published',
                ]
            );
        }

        // 4. Seed Training Schedules for Pelatihan
        $pelatihanServices = Service::where('category', 'pelatihan')->take(5)->get();
        $targetCity = $malang ?? City::first();

        if ($targetCity && $pelatihanServices->count() > 0) {
            $dates = [
                now()->addDays(10)->toDateString(),
                now()->addDays(24)->toDateString(),
                now()->addDays(40)->toDateString(),
            ];

            foreach ($pelatihanServices as $srv) {
                foreach ($dates as $idx => $d) {
                    TrainingSchedule::updateOrCreate(
                        [
                            'service_id' => $srv->id,
                            'city_id' => $targetCity->id,
                            'date' => $d,
                        ],
                        [
                            'start_time' => '08:30',
                            'end_time' => '16:30',
                            'location' => 'Hotel Sentral & Sentra Praktik K3 ' . $targetCity->name,
                            'available_slots' => 15 - ($idx * 3),
                            'status' => 'open',
                            'notes' => 'Batch Reguler ' . date('F Y', strtotime($d)) . ' — Kuota Terbatas.',
                        ]
                    );
                }
            }
        }
    }
}
