<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Kecamatan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class WilayahImportCommand extends Command
{
    protected $signature = 'wilayah:import {--file= : Path to official BPS master wilayah JSON file}';

    protected $description = 'Import official master wilayah data from master_wilayah_bps.json using bps_code';

    public function handle()
    {
        $this->info('Validating database schema for BPS codes...');

        // 1. Check if database has bps_code
        $hasCityBps = Schema::hasColumn('cities', 'bps_code');
        $hasKecBps  = Schema::hasColumn('kecamatans', 'bps_code');

        if (!$hasCityBps || !$hasKecBps) {
            $this->error('Database schema error: bps_code column missing in ' . (!$hasCityBps ? 'cities ' : '') . (!$hasKecBps ? 'kecamatans' : ''));
            return Command::FAILURE;
        }

        $this->info('Database schema verified: bps_code is present in cities and kecamatans tables.');

        $filePath = $this->option('file') ?: base_path('master_wilayah_bps.json');

        if (!file_exists($filePath)) {
            $this->error("BPS JSON file not found at: {$filePath}");
            return Command::FAILURE;
        }

        $rawContent = file_get_contents($filePath);
        $records = json_decode($rawContent, true);

        if (!$records || !is_array($records)) {
            $this->error("Failed to parse JSON file at {$filePath}");
            return Command::FAILURE;
        }

        $this->info("Found " . count($records) . " records in master_wilayah_bps.json.");

        // 2. Deactivate any data in database that came from summary_v4.json (not in official BPS data)
        $officialCityBps = [];
        $officialKecBps = [];

        foreach ($records as $r) {
            $cCode = trim((string)($r['Kode Kab/Kota'] ?? ''));
            $kCode = trim((string)($r['Kode Kecamatan'] ?? ''));
            if ($cCode !== '') {
                $officialCityBps[$cCode] = true;
            }
            if ($kCode !== '') {
                $officialKecBps[$kCode] = true;
            }
        }

        $this->info('Deactivating legacy / summary_v4 records not matching official BPS codes...');

        $deactivatedCities = City::where(function ($query) use ($officialCityBps) {
            $query->whereNotIn('bps_code', array_keys($officialCityBps))
                  ->orWhereNull('bps_code');
        })->update(['status' => 'inactive']);

        $deactivatedKecs = Kecamatan::where(function ($query) use ($officialKecBps) {
            $query->whereNotIn('bps_code', array_keys($officialKecBps))
                  ->orWhereNull('bps_code');
        })->update(['status' => 'inactive']);

        $this->info("Deactivated {$deactivatedCities} non-BPS cities and {$deactivatedKecs} non-BPS kecamatans.");

        // 3. Process official cities and kecamatans from master_wilayah_bps.json
        $hubSlugs = [
            'malang', 'surabaya', 'bandung', 'semarang', 'medan', 'makassar',
            'balikpapan', 'palembang', 'batam', 'denpasar', 'samarinda',
            'pekanbaru', 'yogyakarta', 'banjarmasin', 'padang',
            'bandar-lampung', 'pontianak', 'manado', 'kab-bekasi', 'kab-karawang',
            'kab-bogor', 'kab-tangerang', 'kab-sidoarjo', 'kab-gresik',
            'jakarta-pusat', 'jakarta-selatan', 'jakarta-timur', 'jakarta-barat', 'jakarta-utara',
            'kota-jakarta-pusat', 'kota-jakarta-selatan', 'kota-jakarta-timur', 'kota-jakarta-barat', 'kota-jakarta-utara',
            'kota-surabaya', 'kota-bandung', 'kota-semarang', 'kota-medan', 'kota-makassar',
            'kota-balikpapan', 'kota-palembang', 'kota-batam', 'kota-denpasar', 'kota-samarinda',
            'kota-pekanbaru', 'kota-yogyakarta', 'kota-malang', 'kota-banjarmasin', 'kota-padang',
            'kota-bandar-lampung', 'kota-pontianak', 'kota-manado', 'kabupaten-bekasi', 'kabupaten-karawang',
            'kabupaten-bogor', 'kabupaten-tangerang', 'kabupaten-sidoarjo', 'kabupaten-gresik'
        ];

        $now = now()->toDateTimeString();
        $cityMap = [];

        foreach ($records as $r) {
            $cityBps = trim((string)($r['Kode Kab/Kota'] ?? ''));
            if ($cityBps === '' || isset($cityMap[$cityBps])) {
                continue;
            }

            $type = trim($r['Jenis Wilayah'] ?? ''); // 'Kota' or 'Kabupaten'
            $rawName = trim($r['Kabupaten/Kota'] ?? '');
            $fullName = ($type === 'Kota') ? $rawName : 'Kabupaten ' . $rawName;
            $slug = ($type === 'Kota') ? Str::slug($rawName) : 'kab-' . Str::slug($rawName);
            $provName = trim($r['Provinsi'] ?? '');
            $provBps = trim((string)($r['Kode Provinsi'] ?? ''));
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
                'updated_at' => $now,
            ];
        }

        $this->info("Importing / Updating " . count($cityMap) . " official BPS cities...");

        DB::beginTransaction();
        try {
            $citiesInserted = 0;
            $citiesUpdated = 0;

            foreach ($cityMap as $bpsCode => $data) {
                $city = City::where('bps_code', $bpsCode)->first();
                if ($city) {
                    $city->update($data);
                    $citiesUpdated++;
                } else {
                    $data['created_at'] = $now;
                    City::create($data);
                    $citiesInserted++;
                }
            }

            $this->info("Cities: {$citiesInserted} inserted, {$citiesUpdated} updated.");

            // Build city_id lookup by bps_code
            $cityIdLookup = City::pluck('id', 'bps_code')->toArray();

            $this->info("Importing / Updating official BPS kecamatans...");

            $kecsInserted = 0;
            $kecsUpdated = 0;
            $kecsSkipped = 0;
            $districtSlugTracker = [];

            foreach ($records as $r) {
                $cityBps = trim((string)($r['Kode Kab/Kota'] ?? ''));
                $cityId = $cityIdLookup[$cityBps] ?? null;

                if (!$cityId) {
                    $kecsSkipped++;
                    continue;
                }

                $kecBps = trim((string)($r['Kode Kecamatan'] ?? ''));
                $kecName = trim($r['Kecamatan'] ?? '');

                if ($kecBps === '' || $kecName === '') {
                    $kecsSkipped++;
                    continue;
                }

                $baseSlug = Str::slug($kecName) ?: 'kecamatan-' . $kecBps;
                $kecSlug = $baseSlug;

                $counter = 1;
                while (isset($districtSlugTracker[$cityId][$kecSlug])) {
                    $kecSlug = "{$baseSlug}-{$counter}";
                    $counter++;
                }
                $districtSlugTracker[$cityId][$kecSlug] = true;

                $kecData = [
                    'city_id' => $cityId,
                    'name' => $kecName,
                    'slug' => $kecSlug,
                    'bps_code' => $kecBps,
                    'status' => 'active',
                    'updated_at' => $now,
                ];

                $kec = Kecamatan::where('bps_code', $kecBps)->first();
                if ($kec) {
                    $kec->update($kecData);
                    $kecsUpdated++;
                } else {
                    $kecData['created_at'] = $now;
                    Kecamatan::create($kecData);
                    $kecsInserted++;
                }
            }

            DB::commit();

            $this->info("Kecamatans: {$kecsInserted} inserted, {$kecsUpdated} updated, {$kecsSkipped} skipped.");
            $this->info("Wilayah import from master_wilayah_bps.json completed successfully!");

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('Import failed: ' . $e->getMessage());
            Log::error('WilayahImportCommand Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return Command::FAILURE;
        }
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
