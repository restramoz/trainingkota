<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BpsMasterWilayahSeeder extends Seeder
{
    /**
     * Seed the 514 official cities/regencies and 7,288 districts from master_wilayah_bps.json.
     */
    public function run(): void
    {
        $path = base_path('master_wilayah_bps.json');
        if (!file_exists($path)) {
            $this->command->error("master_wilayah_bps.json not found at: {$path}");
            return;
        }

        $records = json_decode(file_get_contents($path), true);
        if (!$records || !is_array($records)) {
            $this->command->error("Failed to parse master_wilayah_bps.json.");
            return;
        }

        // Disable foreign key checks for clean seeding
        DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('kecamatans')->truncate();
        DB::table('cities')->truncate();
        DB::statement('PRAGMA foreign_keys = ON;');

        $hubSlugs = [
            'kota-jakarta-pusat', 'kota-jakarta-selatan', 'kota-jakarta-timur', 'kota-jakarta-barat', 'kota-jakarta-utara',
            'kota-surabaya', 'kota-bandung', 'kota-semarang', 'kota-medan', 'kota-makassar',
            'kota-balikpapan', 'kota-palembang', 'kota-batam', 'kota-denpasar', 'kota-samarinda',
            'kota-pekanbaru', 'kota-yogyakarta', 'kota-malang', 'kota-banjarmasin', 'kota-padang',
            'kota-bandar-lampung', 'kota-pontianak', 'kota-manado', 'kabupaten-bekasi', 'kabupaten-karawang',
            'kabupaten-bogor', 'kabupaten-tangerang', 'kabupaten-sidoarjo', 'kabupaten-gresik'
        ];

        $now = now()->toDateTimeString();
        $cityMap = [];
        $cityInserts = [];

        // 1. Group records into 514 unique cities
        foreach ($records as $r) {
            $cityBps = trim((string)$r['Kode Kab/Kota']);
            if (isset($cityMap[$cityBps])) {
                continue;
            }

            $type = trim($r['Jenis Wilayah']); // 'Kota' or 'Kabupaten'
            $rawName = trim($r['Kabupaten/Kota']);
            $fullName = ($type === 'Kota') ? $rawName : 'Kabupaten ' . $rawName;
            $slug = ($type === 'Kota') ? Str::slug($rawName) : 'kab-' . Str::slug($rawName);
            $provName = trim($r['Provinsi']);
            $provBps = trim((string)$r['Kode Provinsi']);
            $island = $this->getIsland($provBps);
            $isHub = in_array($slug, $hubSlugs)
                || in_array("kota-{$slug}", $hubSlugs)
                || in_array("kab-" . Str::slug($rawName), $hubSlugs)
                || in_array("kabupaten-" . Str::slug($rawName), $hubSlugs);

            $cityMap[$cityBps] = [
                'name' => $fullName,
                'slug' => $slug,
                'bps_code' => $cityBps,
                'bps_province_code' => $provBps,
                'province' => $provName,
                'island' => $island,
                'classification' => $type,
                'is_hub' => $isHub ? 1 : 0,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert cities in chunks
        $citiesData = array_values($cityMap);
        foreach (array_chunk($citiesData, 100) as $chunk) {
            DB::table('cities')->insert($chunk);
        }

        // Build city id lookup by bps_code
        $cityIdLookup = DB::table('cities')->pluck('id', 'bps_code')->toArray();

        // 2. Insert 7,288 kecamatans
        $kecamatanInserts = [];
        $districtSlugTracker = [];

        foreach ($records as $r) {
            $cityBps = trim((string)$r['Kode Kab/Kota']);
            $cityId = $cityIdLookup[$cityBps] ?? null;
            if (!$cityId) {
                continue;
            }

            $kecBps = trim((string)$r['Kode Kecamatan']);
            $kecName = trim($r['Kecamatan']);
            $baseSlug = Str::slug($kecName) ?: 'kecamatan-' . $kecBps;
            $kecSlug = $baseSlug;

            // Ensure unique slug within the same city
            $counter = 1;
            while (isset($districtSlugTracker[$cityId][$kecSlug])) {
                $kecSlug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $districtSlugTracker[$cityId][$kecSlug] = true;

            $kecamatanInserts[] = [
                'city_id' => $cityId,
                'name' => $kecName,
                'slug' => $kecSlug,
                'bps_code' => $kecBps,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert kecamatans in chunks of 500 for maximum SQLite performance
        foreach (array_chunk($kecamatanInserts, 500) as $chunk) {
            DB::table('kecamatans')->insert($chunk);
        }

        $totalCities = DB::table('cities')->count();
        $totalKecamatans = DB::table('kecamatans')->count();
        $this->command->info("Seeded {$totalCities} Cities/Kabupatens and {$totalKecamatans} Kecamatans successfully.");
    }

    private function getIsland(string $provCode): string
    {
        $prefix = substr($provCode, 0, 2);
        return match ($prefix) {
            '11', '12', '13', '14', '15', '16', '17', '18', '19', '21' => 'Sumatera',
            '31', '32', '33', '34', '35', '36' => 'Jawa',
            '51', '52', '53' => 'Bali & Nusa Tenggara',
            '61', '62', '63', '64', '65' => 'Kalimantan',
            '71', '72', '73', '74', '75', '76' => 'Sulawesi',
            '81', '82' => 'Maluku',
            '91', '92', '94', '95', '96', '97' => 'Papua',
            default => 'Indonesia',
        };
    }
}
