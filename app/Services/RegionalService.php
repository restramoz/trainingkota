<?php

namespace App\Services;

use Illuminate\Support\Str;

/**
 * Indexes the BPS master_wilayah_bps.json dataset into a fast, in-memory
 * lookup structure. The compiled index is cached as a PHP return file in
 * storage/framework/cache/ and is only rebuilt when the source JSON changes.
 *
 * Dataset source: BPS (Badan Pusat Statistik) Indonesia – public administrative data.
 * File: master_wilayah_bps.json  (7,288 rows × 7 fields)
 *
 * Hierarchy: Province → City/Kabupaten (514) → District/Kecamatan (7,288)
 */
class RegionalService
{
    private static ?array $cities = null;

    private static ?array $provinces = null;

    private static ?array $citySlugMap = null;

    private static ?array $provinceSlugMap = null;

    private static ?array $districtSlugMap = null;

    private static function cachePath(): string
    {
        return storage_path('framework/cache/tlaning_wilayah_cache.php');
    }

    private static function initialize(): void
    {
        if (self::$cities !== null) {
            return;
        }

        $cacheFile = self::cachePath();
        $sourceFile = base_path('master_wilayah_bps.json');

        if (file_exists($cacheFile) && file_exists($sourceFile) && filemtime($cacheFile) >= filemtime($sourceFile)) {
            $cached = require $cacheFile;
            if (is_array($cached) && isset($cached['cities'])) {
                self::$cities = $cached['cities'];
                self::$provinces = $cached['provinces'];
                self::$citySlugMap = $cached['citySlugMap'];
                self::$provinceSlugMap = $cached['provinceSlugMap'];
                self::$districtSlugMap = $cached['districtSlugMap'];

                return;
            }
        }

        self::buildIndex($sourceFile, $cacheFile);
    }

    private static function buildIndex(string $sourceFile, string $cacheFile): void
    {
        if (! file_exists($sourceFile)) {
            self::$cities = [];
            self::$provinces = [];
            self::$citySlugMap = [];
            self::$provinceSlugMap = [];
            self::$districtSlugMap = [];

            return;
        }

        $records = json_decode(file_get_contents($sourceFile), true);

        if (! is_array($records)) {
            self::$cities = [];
            self::$provinces = [];
            self::$citySlugMap = [];
            self::$provinceSlugMap = [];
            self::$districtSlugMap = [];

            return;
        }

        $cities = [];
        $provinces = [];
        $citySlugMap = [];
        $provinceSlugMap = [];
        $districtSlugMap = [];

        foreach ($records as $r) {
            $provCode = trim((string) $r['Kode Provinsi']);
            $provName = trim((string) $r['Provinsi']);
            $cityCode = trim((string) $r['Kode Kab/Kota']);
            $rawName = trim((string) $r['Kabupaten/Kota']);
            $type = trim((string) $r['Jenis Wilayah']);
            $distName = trim((string) $r['Kecamatan']);
            $distCode = trim((string) $r['Kode Kecamatan']);

            $fullName = ($type === 'Kota') ? "Kota {$rawName}" : "Kabupaten {$rawName}";
            $rawSlug = Str::slug($rawName);
            $citySlug = ($type === 'Kota') ? $rawSlug : "kab-{$rawSlug}";
            $provSlug = Str::slug($provName);
            $island = self::resolveIsland($provCode);

            // Province index
            if (! isset($provinces[$provCode])) {
                $provinces[$provCode] = [
                    'code' => $provCode,
                    'name' => $provName,
                    'slug' => $provSlug,
                    'island' => $island,
                    'total_cities' => 0,
                    'cities' => [],
                ];
                $provinceSlugMap[$provSlug] = $provCode;
            }

            // City index
            if (! isset($cities[$cityCode])) {
                $cities[$cityCode] = [
                    'code' => $cityCode,
                    'name' => $fullName,
                    'raw_name' => $rawName,
                    'type' => $type,
                    'province' => $provName,
                    'province_code' => $provCode,
                    'province_slug' => $provSlug,
                    'island' => $island,
                    'slug' => $citySlug,
                    'districts' => [],
                ];

                $cities[$cityCode]['slug'] = $citySlug;
                $citySlugMap[$citySlug] = $cityCode;

                // Also map aliases
                if ($type === 'Kota') {
                    $citySlugMap["kota-{$rawSlug}"] = $cityCode;
                    if (! isset($citySlugMap[$rawSlug])) {
                        $citySlugMap[$rawSlug] = $cityCode;
                    }
                } else {
                    $citySlugMap["kabupaten-{$rawSlug}"] = $cityCode;
                    if (! isset($citySlugMap[$rawSlug])) {
                        $citySlugMap[$rawSlug] = $cityCode;
                    }
                }

                // Track city in province
                $provinces[$provCode]['cities'][] = $cityCode;
                $provinces[$provCode]['total_cities']++;
            }

            // District
            $distSlug = Str::slug($distName);
            $distItem = [
                'name' => $distName,
                'code' => $distCode,
                'slug' => $distSlug,
                'city_code' => $cityCode,
            ];

            $cities[$cityCode]['districts'][] = $distItem;

            // Global district slug map (can have collisions; city-scoped key preferred)
            if (! isset($districtSlugMap[$distSlug])) {
                $districtSlugMap[$distSlug] = [];
            }
            $districtSlugMap[$distSlug][] = $distItem;

            // City-scoped key: {citySlug}/{distSlug}
            $districtSlugMap["{$citySlug}/{$distSlug}"] = [$distItem];
        }

        ksort($provinces);

        self::$cities = $cities;
        self::$provinces = $provinces;
        self::$citySlugMap = $citySlugMap;
        self::$provinceSlugMap = $provinceSlugMap;
        self::$districtSlugMap = $districtSlugMap;

        // Write compiled PHP cache
        $cacheDir = dirname($cacheFile);
        if (! is_dir($cacheDir)) {
            @mkdir($cacheDir, 0755, true);
        }

        @file_put_contents($cacheFile, '<?php return ' . var_export([
            'cities' => $cities,
            'provinces' => $provinces,
            'citySlugMap' => $citySlugMap,
            'provinceSlugMap' => $provinceSlugMap,
            'districtSlugMap' => $districtSlugMap,
        ], true) . ';');
    }

    private static function resolveIsland(string $provCode): string
    {
        return match (substr($provCode, 0, 2)) {
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

    // ─── Public API ──────────────────────────────────────────────────────────

    public function findCity(string $slug): ?array
    {
        self::initialize();
        $clean = Str::slug($slug);

        if (isset(self::$citySlugMap[$clean])) {
            return self::$cities[self::$citySlugMap[$clean]] ?? null;
        }

        // Strip alias prefixes
        foreach (['kota-', 'kabupaten-', 'kab-'] as $prefix) {
            if (str_starts_with($clean, $prefix)) {
                $sub = substr($clean, strlen($prefix));
                if ($prefix === 'kabupaten-') {
                    foreach (['kab-' . $sub, $sub] as $alt) {
                        if (isset(self::$citySlugMap[$alt])) {
                            return self::$cities[self::$citySlugMap[$alt]] ?? null;
                        }
                    }
                } elseif (isset(self::$citySlugMap[$sub])) {
                    return self::$cities[self::$citySlugMap[$sub]] ?? null;
                }
            }
        }

        return null;
    }

    public function findProvince(string $slug): ?array
    {
        self::initialize();
        $clean = Str::slug($slug);

        if (isset(self::$provinceSlugMap[$clean])) {
            $code = self::$provinceSlugMap[$clean];
            $prov = self::$provinces[$code] ?? null;
            if ($prov === null) {
                return null;
            }

            // Resolve city codes to city arrays
            $citiesResolved = [];
            foreach ($prov['cities'] as $cityCode) {
                if (isset(self::$cities[$cityCode])) {
                    $citiesResolved[] = self::$cities[$cityCode];
                }
            }
            $prov['cities'] = $citiesResolved;

            return $prov;
        }

        return null;
    }

    public function findDistrict(string $districtSlug, ?string $citySlug = null): ?array
    {
        self::initialize();
        $cleanDist = Str::slug($districtSlug);

        if ($citySlug !== null) {
            $city = $this->findCity($citySlug);
            if (! $city) {
                return null;
            }
            foreach ($city['districts'] as $dist) {
                if ($dist['slug'] === $cleanDist) {
                    return $this->enrichDistrict($dist, $city);
                }
            }

            return null;
        }

        if (isset(self::$districtSlugMap[$cleanDist])) {
            $matches = self::$districtSlugMap[$cleanDist];
            if (! empty($matches)) {
                $first = $matches[0];
                $city = self::$cities[$first['city_code']] ?? null;
                if ($city) {
                    return $this->enrichDistrict($first, $city);
                }
            }
        }

        return null;
    }

    private function enrichDistrict(array $district, array $city): array
    {
        $siblings = array_filter(
            $city['districts'],
            fn ($d) => $d['code'] !== $district['code']
        );

        return array_merge($district, [
            'city_name' => $city['name'],
            'city_raw_name' => $city['raw_name'],
            'city_slug' => $city['slug'],
            'city_type' => $city['type'],
            'city_code' => $city['code'],
            'province' => $city['province'],
            'province_slug' => $city['province_slug'],
            'island' => $city['island'],
            'city' => $city,
            'sibling_districts' => array_values($siblings),
        ]);
    }

    public function getProvinceCities(string $provinceCode, ?string $excludeCode = null, int $limit = 12): array
    {
        self::initialize();
        $result = [];

        foreach (self::$cities as $city) {
            if ($city['province_code'] === $provinceCode && $city['code'] !== $excludeCode) {
                $result[] = $city;
                if (count($result) >= $limit) {
                    break;
                }
            }
        }

        return $result;
    }

    public function getAllProvinces(): array
    {
        self::initialize();
        $result = [];
        foreach (self::$provinces as $p) {
            $result[] = [
                'code' => $p['code'],
                'name' => $p['name'],
                'slug' => $p['slug'],
                'island' => $p['island'],
                'total_cities' => $p['total_cities'],
            ];
        }

        return $result;
    }

    public function getAllCities(): array
    {
        self::initialize();

        return array_values(self::$cities);
    }

    /**
     * Warm (or clear) the compiled cache. Call from an artisan command in production.
     */
    public function clearCache(): void
    {
        $file = self::cachePath();
        if (file_exists($file)) {
            unlink($file);
        }
        self::$cities = null;
        self::$provinces = null;
        self::$citySlugMap = null;
        self::$provinceSlugMap = null;
        self::$districtSlugMap = null;
    }
}
