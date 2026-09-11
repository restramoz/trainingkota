<?php
// Audit EMSIFA regency code duplicates among verified city mappings
$path = __DIR__ . '/../mapping_summary_v4.json';
if (!file_exists($path)) {
    fwrite(STDERR, "Mapping file not found: $path\n");
    exit(1);
}
$data = json_decode(file_get_contents($path), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    fwrite(STDERR, "Failed to parse JSON: " . json_last_error_msg() . "\n");
    exit(1);
}
$verified = $data['verified_mappings'] ?? [];
$totalVerified = count($verified);
$codeMap = [];
foreach ($verified as $city) {
    $cityId = $city['city_id'];
    $cityName = $city['city_name'];
    $classification = $city['classification'];
    foreach ($city['matches'] as $match) {
        $code = $match['code'];
        $codeMap[$code][] = [
            'city_id' => $cityId,
            'city_name' => $cityName,
            'classification' => $classification,
        ];
    }
}
$uniqueCodes = count($codeMap);
$duplicates = [];
foreach ($codeMap as $code => $cities) {
    if (count($cities) > 1) {
        $duplicates[$code] = $cities;
    }
}
// Output report
echo "=== EMSIFA Mapping Audit Report ===\n";
echo "Total verified city records: $totalVerified\n";
echo "Total unique EMSIFA regency codes: $uniqueCodes\n";
if (empty($duplicates)) {
    echo "No duplicate regency codes found.\n";
} else {
    echo "Duplicate regency codes (appearing in multiple cities):\n";
    foreach ($duplicates as $code => $cities) {
        echo "- Code $code appears in " . count($cities) . " cities:\n";
        foreach ($cities as $c) {
            echo "    * City ID {$c['city_id']}: {$c['city_name']} ({$c['classification']})\n";
        }
    }
}
?>