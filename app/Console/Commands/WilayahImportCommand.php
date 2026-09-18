<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\City;
use App\Models\Kecamatan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WilayahImportCommand extends Command
{
    protected $signature = "wilayah:import";
    protected $description = "Import master wilayah data from BPS CSV files";

    public function handle()
    {
        $citiesFile = base_path("cities_bps.csv");
        $kecamatansFile = base_path("kecamatans_bps.csv");

        if (!file_exists($citiesFile) || !file_exists($kecamatansFile)) {
            $this->error("CSV files not found. Please ensure cities_bps.csv and kecamatans_bps.csv exist.");
            return Command::FAILURE;
        }

        $this->importCities($citiesFile);
        $this->importKecamatans($kecamatansFile);

        $this->info("Wilayah import completed successfully!");
        return Command::SUCCESS;
    }

    private function importCities($filePath)
    {
        $this->info("Importing Cities...");
        $handle = fopen($filePath, "r");
        $header = fgetcsv($handle);
        $indices = array_flip($header);
        
        $inserted = 0;
        $updated = 0;

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== FALSE) {
                if (empty($row[0])) continue;
                
                $bpsCode = $row[$indices["Kode Kab/Kota"]] ?? null;
                if (!$bpsCode) continue;

                $name = $row[$indices["Kabupaten/Kota"]] ?? "";
                $bpsProvinceCode = $row[$indices["Kode Provinsi"]] ?? null;
                $classification = $row[$indices["Jenis Wilayah"]] ?? null;

                $city = City::updateOrCreate(
                    ["bps_code" => (string)$bpsCode],
                    [
                        "name" => $name,
                        "slug" => $this->generateUniqueSlug(City::class, $name, $bpsCode),
                        "bps_province_code" => (string)$bpsProvinceCode,
                        "classification" => $classification,
                        "status" => "active",
                    ]
                );
                $city->wasRecentlyCreated ? $inserted++ : $updated++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Error importing cities: " . $e->getMessage());
            Log::error("Wilayah Import City Error: " . $e->getMessage());
            return;
        }
        fclose($handle);
        $this->info("Cities: {$inserted} inserted, {$updated} updated.");
    }

    private function importKecamatans($filePath)
    {
        $this->info("Importing Kecamatans...");
        $handle = fopen($filePath, "r");
        $header = fgetcsv($handle);
        $indices = array_flip($header);

        $inserted = 0;
        $updated = 0;

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== FALSE) {
                if (empty($row[0])) continue;
                
                $bpsCode = $row[$indices["Kode Kecamatan"]] ?? null;
                $bpsCityCode = $row[$indices["Kode Kab/Kota"]] ?? null;
                if (!$bpsCode || !$bpsCityCode) continue;

                $city = City::where("bps_code", (string)$bpsCityCode)->first();
                if (!$city) {
                    $this->warn("City not found for BPS code {$bpsCityCode}, skipping kecamatan {$row[$indices["Kecamatan"]]}");
                    continue;
                }

                $name = $row[$indices["Kecamatan"]] ?? "";
                $kecamatan = Kecamatan::updateOrCreate(
                    ["city_id" => $city->id, "bps_code" => (string)$bpsCode],
                    ["name" => $name, "slug" => $this->generateUniqueSlug(Kecamatan::class, $name, $city->id), "status" => "active"]
                );
                $kecamatan->wasRecentlyCreated ? $inserted++ : $updated++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Error importing kecamatans: " . $e->getMessage());
            Log::error("Wilayah Import Kecamatan Error: " . $e->getMessage());
            return;
        }
        fclose($handle);
        $this->info("Kecamatans: {$inserted} inserted, {$updated} updated.");
    }

    private function generateUniqueSlug($modelClass, $name, $identifier)
    {
        $baseSlug = Str::slug($name) ?: Str::random(8);
        $slug = $baseSlug;
        $counter = 1;

        while (true) {
            if ($modelClass === City::class) {
                $exists = City::where("slug", $slug)->where("bps_code", "!=", (string)$identifier)->exists();
            } else {
                $exists = Kecamatan::where("slug", $slug)->where("city_id", "!=", $identifier)->exists();
            }
            if (!$exists) break;
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }
        return $slug;
    }
}
