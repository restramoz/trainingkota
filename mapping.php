<?php
// Mapping script for TrainingKota cities to Wilayah.id regencies

function fetchJson($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $data = curl_exec($ch);
    if (curl_errno($ch)) {
        fwrite(STDERR, "cURL error: " . curl_error($ch) . "\n");
        exit(1);
    }
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($code !== 200) {
        fwrite(STDERR, "HTTP $code fetching $url\n");
        exit(1);
    }
    return json_decode($data, true);
}

// Load provinces
$provData = fetchJson('https://wilayah.id/api/provinces.json');
$provinces = [];
foreach ($provData['data'] as $p) {
    $provinces[$p['code']] = $p['name'];
}

// Load all regencies per province
$regencies = [];
foreach ($provinces as $provCode => $provName) {
    $url = "https://wilayah.id/api/regencies/{$provCode}.json";
    $regData = fetchJson($url);
    foreach ($regData['data'] as $r) {
        // store mapping code => name and province code
        $regencies[$r['code']] = ['name' => $r['name'], 'province_code' => $provCode];
    }
}

// Load cities from DB via Laravel's Eloquent (boot the app)
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\City;
$cities = City::all();

// Alias mappings for known naming differences (Level 4)
// Format: 'TrainingKota name' => ['code' => 'wilayah_code', 'name' => 'Wilayah.id name']
$aliases = [
    // Example: 'Jakarta' => ['code' => '31.71', 'name' => 'Kota Administrasi Jakarta Pusat'],
    // Add explicit aliases as needed
];

// List of city names that are not regency entities (Level 1 detection)
// These will be classified as NON_REGENCY_ENTITY
$nonRegencyNames = [
    'Jakarta',
    'Bali',
    'Bangka Belitung',
    'Cikarang',
    'Batulicin',
    'Cepu',
    'Luwuk',
    // Add more as identified
];

$verifiedExact = $verifiedNormalized = $verifiedAlias = $ambiguous = $notFound = $nonRegency = 0;
$results = [];

foreach ($cities as $city) {
    $cityName = $city->name;
    $citySlug = $city->slug;
    $cityProvince = $city->province ?? null;
    $matches = [];

    // Detect non-regency entities
    $isNonRegency = false;
    foreach ($nonRegencyNames as $nrName) {
        if (strcasecmp($cityName, $nrName) === 0) {
            $isNonRegency = true;
            break;
        }
    }

    if ($isNonRegency) {
        $classification = 'NON_REGENCY_ENTITY';
        $reason = 'City name corresponds to a province or region, not a regency';
    } else {
        // Level 1: Exact semantic match (including province constraint)
        foreach ($regencies as $code => $info) {
            $regName = $info['name'];
            $regProvinceCode = $info['province_code'];
            $regProvinceName = $provinces[$regProvinceCode] ?? null;

            // Province constraint: skip if city province known and does not match regency province
            if ($cityProvince && $cityProvince !== $regProvinceName) {
                continue;
            }

            // Exact name match (case-insensitive)
            if (strcasecmp($cityName, $regName) === 0) {
                $matches[] = ['type' => 'exact', 'code' => $code, 'name' => $regName];
                continue;
            }

            // Level 2: Safe normalization (preserve administrative type, including "Administrasi" variants)
            // Extract prefixes
            $cityPrefix = '';
            $cityBase = $cityName;
            if (preg_match('/\b(kota|kabupaten)(?:\s+administrasi)?\b/i', $cityName, $m)) {
                $cityPrefix = strtolower($m[1]);
                $cityBase = preg_replace('/\b(kota|kabupaten)(?:\s+administrasi)?\b/i', '', $cityName);
            }
            $regPrefix = '';
            $regBase = $regName;
            if (preg_match('/\b(kota|kabupaten)(?:\s+administrasi)?\b/i', $regName, $m2)) {
                $regPrefix = strtolower($m2[1]);
                $regBase = preg_replace('/\b(kota|kabupaten)(?:\s+administrasi)?\b/i', '', $regName);
            }

            // Consider normalized match if prefixes are the same, or if city name lacks a prefix (allow any regency prefix)
            if ($cityPrefix === $regPrefix || $cityPrefix === '') {
                $normCity = strtolower(preg_replace('/[^a-z0-9]/', '', $cityBase));
                $normReg = strtolower(preg_replace('/[^a-z0-9]/', '', $regBase));
                if ($normCity === $normReg) {
                    $matches[] = ['type' => 'normalized', 'code' => $code, 'name' => $regName];
                }
            }
        }

        // Level 4: Explicit alias mapping
        if (empty($matches) && isset($aliases[$cityName])) {
            $alias = $aliases[$cityName];
            $matches[] = ['type' => 'alias', 'code' => $alias['code'], 'name' => $alias['name']];
        }

        // Determine classification
        if (count($matches) === 1) {
            $type = $matches[0]['type'];
            if ($type === 'exact') {
                $classification = 'VERIFIED_EXACT';
            } elseif ($type === 'normalized') {
                $classification = 'VERIFIED_NORMALIZED';
            } elseif ($type === 'alias') {
                $classification = 'VERIFIED_ALIAS';
            } else {
                $classification = 'NOT_FOUND';
            }
        } elseif (count($matches) > 1) {
            $classification = 'AMBIGUOUS';
        } else {
            $classification = 'NOT_FOUND';
        }
    }

    // Update counters based on classification
    switch ($classification) {
        case 'VERIFIED_EXACT': $verifiedExact++; break;
        case 'VERIFIED_NORMALIZED': $verifiedNormalized++; break;
        case 'VERIFIED_ALIAS': $verifiedAlias++; break;
        case 'AMBIGUOUS': $ambiguous++; break;
        case 'NOT_FOUND': $notFound++; break;
        case 'NON_REGENCY_ENTITY': $nonRegency++; break;
    }

    // Prepare result entry
    $resultEntry = [
        'city_id' => $city->id,
        'city_name' => $cityName,
        'city_slug' => $citySlug,
        'province' => $cityProvince,
        'classification' => $classification,
        'matches' => $matches,
    ];

    // Add reason for NON_REGENCY_ENTITY or NOT_FOUND
    if ($classification === 'NON_REGENCY_ENTITY') {
        $resultEntry['reason'] = $reason;
    } elseif ($classification === 'NOT_FOUND') {
        // Compute nearest candidates (simple Levenshtein distance)
        $normCity = strtolower(preg_replace('/[^a-z0-9]/', '', $cityName));
        $distances = [];
        foreach ($regencies as $code => $info) {
            $normReg = strtolower(preg_replace('/[^a-z0-9]/', '', $info['name']));
            $distances[$code] = levenshtein($normCity, $normReg);
        }
        asort($distances);
        $nearest = array_slice($distances, 0, 3, true);
        $nearestCandidates = [];
        foreach ($nearest as $code => $dist) {
            $nearestCandidates[] = [
                'code' => $code,
                'name' => $regencies[$code]['name'],
                'distance' => $dist,
            ];
        }
        $resultEntry['nearest_candidates'] = $nearestCandidates;
    }

    $results[] = $resultEntry;
}

// Output summary as JSON for easy parsing
$summary = [
    'total_cities' => count($cities),
    'verified_exact' => $verifiedExact,
    'verified_normalized' => $verifiedNormalized,
    'verified_alias' => $verifiedAlias,
    'ambiguous' => $ambiguous,
    'not_found' => $notFound,
    'non_regency_entity' => $nonRegency,
];

file_put_contents('mapping_summary_v3.json', json_encode(['summary' => $summary, 'details' => $results], JSON_PRETTY_PRINT));

// Generate mapping_summary_v4.json with full city results and separate verified mappings
$verifiedMappings = array_filter($results, function ($cityInfo) {
    return in_array($cityInfo['classification'], ['VERIFIED_EXACT', 'VERIFIED_NORMALIZED', 'VERIFIED_ALIAS']);
});
$verifiedCount = count($verifiedMappings);
$ambiguousCount = count(array_filter($results, fn($c) => $c['classification'] === 'AMBIGUOUS'));
$notFoundCount = count(array_filter($results, fn($c) => $c['classification'] === 'NOT_FOUND'));
$nonRegencyCount = count(array_filter($results, fn($c) => $c['classification'] === 'NON_REGENCY_ENTITY'));

$summaryV4 = [
    'total_cities' => count($cities),
    'verified_exact' => $verifiedExact,
    'verified_normalized' => $verifiedNormalized,
    'verified_alias' => $verifiedAlias,
    'verified_total' => $verifiedCount,
    'ambiguous' => $ambiguousCount,
    'not_found' => $notFoundCount,
    'non_regency_entity' => $nonRegencyCount,
];

$v4Data = [
    'summary' => $summaryV4,
    'verified_mappings' => array_values($verifiedMappings), // reindex
    'all_city_results' => $results,
];

file_put_contents('mapping_summary_v4.json', json_encode($v4Data, JSON_PRETTY_PRINT));

echo "Mapping completed. Summary written to mapping_summary_v3.json and mapping_summary_v4.json\n";

// Generate mapping_summary_v4.json with full city results and separate verified mappings
$verifiedMappings = array_filter($results, function ($cityInfo) {
    return in_array($cityInfo['classification'], ['VERIFIED_EXACT', 'VERIFIED_NORMALIZED', 'VERIFIED_ALIAS']);
});
$verifiedCount = count($verifiedMappings);
$ambiguousCount = count(array_filter($results, fn($c) => $c['classification'] === 'AMBIGUOUS'));
$notFoundCount = count(array_filter($results, fn($c) => $c['classification'] === 'NOT_FOUND'));
$nonRegencyCount = count(array_filter($results, fn($c) => $c['classification'] === 'NON_REGENCY_ENTITY'));

$summaryV4 = [
    'total_cities' => count($cities),
    'verified' => $verifiedCount,
    'ambiguous' => $ambiguousCount,
    'not_found' => $notFoundCount,
    'non_regency_entity' => $nonRegencyCount,
];

$v4Data = [
    'summary' => $summaryV4,
    'verified_mappings' => array_values($verifiedMappings), // reindex
    'all_city_results' => $results,
];

file_put_contents('mapping_summary_v4.json', json_encode($v4Data, JSON_PRETTY_PRINT));

echo "Mapping completed. Summary written to mapping_summary_v3.json and mapping_summary_v4.json\n";

echo "Mapping completed. Summary written to mapping_summary_v3.json\n";
?>