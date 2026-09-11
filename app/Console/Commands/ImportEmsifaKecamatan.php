<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\City;
use App\Models\Kecamatan;

class ImportEmsifaKecamatan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * --dry   : Perform a dry‑run without persisting changes.
     */
    protected $signature = 'emsifa:import-kecamatan {--dry : Run the import in dry‑run mode (no DB changes)}';

    /**
     * The console command description.
     */
    protected $description = 'Import verified EMSIFA district (kecamatan) data into the database (idempotent)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry');
        $this->info($dryRun ? 'Running in dry‑run mode (no DB changes will be persisted)' : 'Starting EMSIFA kecamatan import');

        // Load mapping summary to map EMSIFA regency code -> city id
        $mappingPath = base_path('mapping_summary_v3.json');
        if (!file_exists($mappingPath)) {
            $this->error('mapping_summary_v3.json not found');
            return 1;
        }
        $mappingData = json_decode(file_get_contents($mappingPath), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Failed to parse mapping_summary_v3.json');
            return 1;
        }

        // Build regency code => city model map for VERIFIED entries
        $regencyCodeToCity = [];
        foreach ($mappingData['details'] as $cityInfo) {
            $classification = $cityInfo['classification'] ?? null;
            if (in_array($classification, ['VERIFIED_EXACT', 'VERIFIED_NORMALIZED'])) {
                $matches = $cityInfo['matches'] ?? [];
                if (!empty($matches)) {
                    $code = $matches[0]['code'] ?? null; // EMSIFA / Wilayah.id code
                    if ($code) {
                        $city = City::find($cityInfo['city_id']);
                        if ($city) {
                            $regencyCodeToCity[$code] = $city;
                        }
                    }
                }
            }
        }

        // Load district counts (EMSIFA verified districts)
        $districtPath = base_path('district_counts.json');
        if (!file_exists($districtPath)) {
            $this->error('district_counts.json not found');
            return 1;
        }
        $districtData = json_decode(file_get_contents($districtPath), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Failed to parse district_counts.json');
            return 1;
        }

        $cityUpdates = 0;
        $kecamatanInserted = 0;
        $kecamatanUpdated = 0;
        $kecamatanSkipped = 0;
        $unmappedRegencies = [];

        DB::transaction(function () use (
            $regencyCodeToCity,
            $districtData,
            &$cityUpdates,
            &$kecamatanInserted,
            &$kecamatanUpdated,
            &$kecamatanSkipped,
            &$unmappedRegencies,
            $dryRun
        ) {
            // 1. Update cities with wilayah_code
            foreach ($regencyCodeToCity as $code => $city) {
                if ($city->wilayah_code !== $code) {
                    $city->wilayah_code = $code;
                    $cityUpdates++;
                    if (!$dryRun) {
                        $city->save();
                    }
                }
            }

            // 2. Process districts
            foreach ($districtData['details'] as $regencyCode => $regInfo) {
                if (!isset($regencyCodeToCity[$regencyCode])) {
                    $unmappedRegencies[] = $regencyCode;
                    continue;
                }
                $city = $regencyCodeToCity[$regencyCode];
                $districts = $regInfo['districts'] ?? [];
                foreach ($districts as $district) {
                    $districtName = $district['name'];
                    $districtWilayahCode = $district['id']; // Use EMSIFA district ID directly
                    // Ensure slug uniqueness within the city by appending the EMSIFA district ID
                    $slug = Str::slug($districtName . '-' . $districtWilayahCode);
                
                    // Find existing kecamatan by city_id + wilayah_code (EMSIFA ID)
                    $kecamatan = Kecamatan::where('city_id', $city->id)
                        ->where('wilayah_code', $districtWilayahCode)
                        ->first();
                
                    if ($kecamatan) {
                        // Update mutable fields only if they differ
                        $needsUpdate = false;
                        if ($kecamatan->name !== $districtName) {
                            $kecamatan->name = $districtName;
                            $needsUpdate = true;
                        }
                        if ($kecamatan->slug !== $slug) {
                            $kecamatan->slug = $slug;
                            $needsUpdate = true;
                        }
                        if ($kecamatan->status !== 'active') {
                            $kecamatan->status = 'active';
                            $needsUpdate = true;
                        }
                        // Preserve address, lat, lng, google_maps_url, seo fields – do not overwrite them.
                        if ($needsUpdate) {
                            $kecamatanUpdated++;
                            if (!$dryRun) {
                                $kecamatan->save();
                            }
                        } else {
                            $kecamatanSkipped++;
                        }
                    } else {
                        // Create new kecamatan
                        $new = new Kecamatan();
                        $new->city_id = $city->id;
                        $new->name = $districtName;
                        $new->slug = $slug;
                        $new->status = 'active';
                        $new->wilayah_code = $districtWilayahCode;
                        $kecamatanInserted++;
                        if (!$dryRun) {
                            $new->save();
                        }
                    }
                }
            }
        });

        // Summary output
        $this->info('--- Import Summary ---');
        $this->line('Cities updated (wilayah_code): ' . $cityUpdates);
        $this->line('Kecamatans inserted: ' . $kecamatanInserted);
        $this->line('Kecamatans updated: ' . $kecamatanUpdated);
        $this->line('Kecamatans unchanged (skipped): ' . $kecamatanSkipped);
        if (!empty($unmappedRegencies)) {
            $this->warn('Regency codes without a matching city (manual review needed): ' . implode(', ', $unmappedRegencies));
        }
        return 0;
    }
}
