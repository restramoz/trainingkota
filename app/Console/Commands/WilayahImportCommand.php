<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Kecamatan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WilayahImportCommand extends Command
{
    protected $signature = 'wilayah:import';

    protected $description = 'Import master wilayah data from BPS CSV files';

    public function handle()
    {
        $citiesFile = base_path('cities_bps.csv');
        $kecamatansFile = base_path('kecamatans_bps.csv');

        if (!file_exists($citiesFile) || !file_exists($kecamatansFile)) {
            $this->error(
                'CSV files not found. Please ensure cities_bps.csv and kecamatans_bps.csv exist.'
            );

            return Command::FAILURE;
        }

        $citiesResult = $this->importCities($citiesFile);

        if (!$citiesResult) {
            $this->error('City import failed. Kecamatan import cancelled.');

            return Command::FAILURE;
        }

        $kecamatansResult = $this->importKecamatans($kecamatansFile);

        if (!$kecamatansResult) {
            $this->error('Kecamatan import failed.');

            return Command::FAILURE;
        }

        $this->info('Wilayah import completed successfully!');

        return Command::SUCCESS;
    }

    private function importCities(string $filePath): bool
    {
        $this->info('Importing Cities...');

        $handle = fopen($filePath, 'r');

        if (!$handle) {
            $this->error("Unable to open {$filePath}");

            return false;
        }

        $header = fgetcsv($handle);

        if (!$header) {
            fclose($handle);
            $this->error('Cities CSV header not found.');

            return false;
        }

        $header = array_map('trim', $header);
        $indices = array_flip($header);

        $requiredColumns = [
            'Kode Provinsi',
            'Provinsi',
            'Kode Kab/Kota',
            'Kabupaten/Kota',
            'Jenis Wilayah',
        ];

        foreach ($requiredColumns as $column) {
            if (!isset($indices[$column])) {
                fclose($handle);
                $this->error("Missing cities CSV column: {$column}");

                return false;
            }
        }

        $inserted = 0;
        $updated = 0;

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle)) !== false) {
                if (empty($row)) {
                    continue;
                }

                $bpsCode = trim($row[$indices['Kode Kab/Kota']] ?? '');
                $name = trim($row[$indices['Kabupaten/Kota']] ?? '');
                $classification = trim($row[$indices['Jenis Wilayah']] ?? '');
                $bpsProvinceCode = trim($row[$indices['Kode Provinsi']] ?? '');

                if ($classification !== '') {
                    $name = $classification . ' ' . $name;
                }

                if ($bpsCode === '' || $name === '') {
                    continue;
                }

                $city = City::where('bps_code', $bpsCode)->first();

                $data = [
                    'name' => $name,
                    'slug' => $this->generateUniqueCitySlug($name, $bpsCode),
                    'bps_province_code' => $bpsProvinceCode !== ''
                        ? $bpsProvinceCode
                        : null,
                ];

                if ($city) {
                    $city->update($data);
                    $updated++;
                } else {
                    City::create(array_merge(
                        $data,
                        [
                            'bps_code' => $bpsCode,
                        ]
                    ));

                    $inserted++;
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            fclose($handle);

            $this->error(
                'Error importing cities: ' . $e->getMessage()
            );

            Log::error(
                'Wilayah Import City Error',
                [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );

            return false;
        }

        fclose($handle);

        $this->info(
            "Cities: {$inserted} inserted, {$updated} updated."
        );

        return true;
    }

    private function importKecamatans(string $filePath): bool
    {
        $this->info('Importing Kecamatans...');

        $handle = fopen($filePath, 'r');

        if (!$handle) {
            $this->error("Unable to open {$filePath}");

            return false;
        }

        $header = fgetcsv($handle);

        if (!$header) {
            fclose($handle);
            $this->error('Kecamatan CSV header not found.');

            return false;
        }

        $header = array_map('trim', $header);
        $indices = array_flip($header);

        $requiredColumns = [
            'Kode Provinsi',
            'Kode Kab/Kota',
            'Kabupaten/Kota',
            'Kode Kecamatan',
            'Kecamatan',
        ];

        foreach ($requiredColumns as $column) {
            if (!isset($indices[$column])) {
                fclose($handle);
                $this->error(
                    "Missing kecamatan CSV column: {$column}"
                );

                return false;
            }
        }

        $inserted = 0;
        $updated = 0;
        $skipped = 0;

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle)) !== false) {
                if (empty($row)) {
                    continue;
                }

                $bpsCode = trim(
                    $row[$indices['Kode Kecamatan']] ?? ''
                );

                $bpsCityCode = trim(
                    $row[$indices['Kode Kab/Kota']] ?? ''
                );

                $name = trim(
                    $row[$indices['Kecamatan']] ?? ''
                );

                if (
                    $bpsCode === '' ||
                    $bpsCityCode === '' ||
                    $name === ''
                ) {
                    continue;
                }

                $city = City::where(
                    'bps_code',
                    $bpsCityCode
                )->first();

                if (!$city) {
                    $skipped++;

                    continue;
                }

                $kecamatan = Kecamatan::where(
                    'bps_code',
                    $bpsCode
                )->first();

                $data = [
                    'city_id' => $city->id,
                    'name' => $name,
                    'slug' => $this->generateUniqueKecamatanSlug(
                        $name,
                        $city->id,
                        $bpsCode
                    ),
                    'status' => 'active',
                ];

                if ($kecamatan) {
                    $kecamatan->update($data);
                    $updated++;
                } else {
                    Kecamatan::create(
                        array_merge(
                            $data,
                            [
                                'bps_code' => $bpsCode,
                            ]
                        )
                    );

                    $inserted++;
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            fclose($handle);

            $this->error(
                'Error importing kecamatans: ' . $e->getMessage()
            );

            Log::error(
                'Wilayah Import Kecamatan Error',
                [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );

            return false;
        }

        fclose($handle);

        $this->info(
            "Kecamatans: {$inserted} inserted, {$updated} updated, {$skipped} skipped."
        );

        return true;
    }

    private function generateUniqueCitySlug(
    string $name,
    string $bpsCode
): string {
    $baseSlug = Str::slug($name);

    if ($baseSlug === '') {
        $baseSlug = 'wilayah-' . $bpsCode;
    }

    $slug = $baseSlug;
    $counter = 1;

    while (true) {
        $existing = City::where('slug', $slug)->first();

        if (!$existing) {
            break;
        }

        // Slug sudah dipakai oleh city BPS yang sama.
        // Boleh dipakai kembali.
        if ((string) $existing->bps_code === (string) $bpsCode) {
            break;
        }

        $slug = "{$baseSlug}-{$counter}";
        $counter++;
    }

    return $slug;
}

    private function generateUniqueKecamatanSlug(
        string $name,
        int $cityId,
        string $bpsCode
    ): string {
        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'kecamatan-' . $bpsCode;
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            Kecamatan::where('slug', $slug)
                ->where('bps_code', '!=', $bpsCode)
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
