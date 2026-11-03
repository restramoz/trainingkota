<?php

namespace App\Services;

/**
 * Output-level geographic reference detection for generated article content.
 *
 * The region vocabulary is taken from the existing BPS dataset
 * (RegionalService); nothing is duplicated or hand-maintained. The scanned
 * content is never modified — callers use the returned labels only to request
 * human review.
 *
 * shortcut: detects province, city and regency names only (not all 7,288
 * kecamatan), and bare city names must be written Title Case to limit
 * false positives; upgrade if review noise becomes a problem.
 */
class GeographicContentService
{
    private ?array $regionIndex = null;

    public function __construct(protected RegionalService $regional) {}

    /**
     * Distinct geographic references found in the visible text of HTML content.
     *
     * @param  string  $html  Article HTML body
     * @return list<array{kind: string, name: string}>
     */
    public function findReferences(string $html): array
    {
        $index = $this->regionIndex();

        // Visible text only: strip tags to a single space so words from
        // adjacent elements do not fuse ("...Jawa Timur</h2><ul><li>bagida..."
        // would otherwise read "timurbagida"), decode entities, collapse
        // whitespace.
        $text = preg_replace('#<[^>]+>#u', ' ', $html) ?? '';
        $text = html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/u', ' ', trim($text)) ?? '';

        if ($text === '' || $index['rawCount'] === 0) {
            return [];
        }

        $folded = mb_strtolower($text);
        $found = [];
        $seenRaw = [];

        // Provinces first (so province references are reported before
        // cities); longest name first, common prose drops the official
        // prefix ("Jakarta" instead of "DKI Jakarta").
        if ($index['provinceMap'] !== []) {
            $pattern = '/\b('.implode('|', $index['provinceRaws']).')\b/u';
            if (preg_match_all($pattern, $folded, $matches)) {
                foreach ($matches[1] as $key) {
                    $found[$index['provinceMap'][$key]] = ['kind' => 'province', 'name' => $index['provinceMap'][$key]];
                }
            }
        }

        // "Kota Bandung" / "Kabupaten Bekasi" / "kab. Tegal": the type prefix
        // must pair with the BPS type, so the generic words "kota",
        // "kabupaten" or "provinsi" in ordinary prose never match alone.
        if ($index['cityMap'] !== []) {
            $pattern = '/\bkota\s+('.implode('|', $index['cityRaws']).')\b/u';
            if (preg_match_all($pattern, $folded, $matches)) {
                foreach ($matches[1] as $key) {
                    $seenRaw[$key] = true;
                    $found[$index['cityMap'][$key]] = ['kind' => 'city', 'name' => $index['cityMap'][$key]];
                }
            }
        }
        if ($index['regencyMap'] !== []) {
            $pattern = '/\b(?:kabupaten|kab\.?)\s+('.implode('|', $index['regencyRaws']).')\b/u';
            if (preg_match_all($pattern, $folded, $matches)) {
                foreach ($matches[1] as $key) {
                    $seenRaw[$key] = true;
                    $found[$index['regencyMap'][$key]] = ['kind' => 'regency', 'name' => $index['regencyMap'][$key]];
                }
            }
        }

        // Bare city/regency names are only flagged when capitalized as a
        // proper noun, so ordinary lowercase words ("batu bata", "medan
        // magnet") are not flagged.
        if ($index['barePatterns'] !== []) {
            $pattern = '/\b('.implode('|', $index['barePatterns']).')\b/u';
            if (preg_match_all($pattern, $text, $matches)) {
                foreach ($matches[1] as $match) {
                    $key = mb_strtolower($match);
                    if (isset($seenRaw[$key])) {
                        continue;
                    }
                    $seenRaw[$key] = true;
                    $found[$index['bareMap'][$key]] = ['kind' => 'city_or_regency', 'name' => $index['bareMap'][$key]];
                }
            }
        }

        return array_values($found);
    }

    /**
     * Compile the BPS dataset into detection patterns (cached per instance).
     *
     * @return array{
     *     rawCount: int,
     *     cityMap: array<string, string>,
     *     cityRaws: list<string>,
     *     regencyMap: array<string, string>,
     *     regencyRaws: list<string>,
     *     provinceMap: array<string, string>,
     *     provinceRaws: list<string>,
     *     bareMap: array<string, string>,
     *     barePatterns: list<string>,
     * }
     */
    protected function regionIndex(): array
    {
        if ($this->regionIndex !== null) {
            return $this->regionIndex;
        }

        $cityMap = [];
        $regencyMap = [];
        $bareMap = [];

        foreach ($this->regional->getAllCities() as $city) {
            $raw = trim((string) ($city['raw_name'] ?? ''));
            $folded = mb_strtolower($raw);
            if ($folded === '') {
                continue;
            }

            if (($city['type'] ?? '') === 'Kota') {
                $cityMap[$folded] = 'Kota '.$raw;
            } else {
                $regencyMap[$folded] = 'Kabupaten '.$raw;
            }

            // A bare name (without "Kota"/"Kabupaten") cannot tell the type
            // apart, so it carries its own neutral label.
            if (! isset($bareMap[$folded])) {
                $bareMap[$folded] = mb_convert_case($folded, MB_CASE_TITLE, 'UTF-8');
            }
        }

        $provinceMap = [];
        foreach ($this->regional->getAllProvinces() as $province) {
            $folded = mb_strtolower(trim((string) ($province['name'] ?? '')));
            if ($folded === '') {
                continue;
            }
            $provinceMap[$folded] = $province['name'];
        }

        // Common prose drops the official "DKI" prefix of Jakarta.
        if (isset($provinceMap['dki jakarta']) && ! isset($provinceMap['jakarta'])) {
            $provinceMap['jakarta'] = 'Jakarta';
        }

        $cityRaws = array_keys($cityMap);
        $regencyRaws = array_keys($regencyMap);
        $provinceRaws = array_keys($provinceMap);
        $bareKeys = array_keys($bareMap);

        // Longest alternation first so "Papua Barat" wins over "Papua" and
        // "Bandung Barat" over "Bandung"; ties stay alphabetical.
        usort($cityRaws, fn (string $a, string $b): int => mb_strlen($b) <=> mb_strlen($a) ?: strcmp($a, $b));
        usort($regencyRaws, fn (string $a, string $b): int => mb_strlen($b) <=> mb_strlen($a) ?: strcmp($a, $b));
        usort($provinceRaws, fn (string $a, string $b): int => mb_strlen($b) <=> mb_strlen($a) ?: strcmp($a, $b));
        usort($bareKeys, fn (string $a, string $b): int => mb_strlen($b) <=> mb_strlen($a) ?: strcmp($a, $b));

        $barePatterns = [];
        foreach ($bareKeys as $folded) {
            $barePatterns[] = $this->titlePattern($folded);
        }

        $this->regionIndex = [
            'rawCount' => count($cityMap) + count($regencyMap) + count($provinceMap),
            'cityMap' => $cityMap,
            'cityRaws' => $cityRaws,
            'regencyMap' => $regencyMap,
            'regencyRaws' => $regencyRaws,
            'provinceMap' => $provinceMap,
            'provinceRaws' => $provinceRaws,
            'bareMap' => $bareMap,
            'barePatterns' => $barePatterns,
        ];

        return $this->regionIndex;
    }

    /**
     * Escape and case-shape a folded name into a Title-Case regex:
     * "bandung" -> "B(?i:andung)" so only the capitalized form matches.
     */
    protected function titlePattern(string $folded): string
    {
        $words = preg_split('/\s+/u', $folded) ?: [];

        $pieces = [];
        foreach ($words as $word) {
            $word = trim($word);
            if ($word === '') {
                continue;
            }
            $first = mb_strtoupper(mb_substr($word, 0, 1), 'UTF-8');
            $rest = mb_substr($word, 1);
            $pieces[] = $this->escape($first).'(?i:'.$this->escape($rest).')';
        }

        return implode(' ', $pieces);
    }

    protected function escape(string $text): string
    {
        return preg_quote($text, '/');
    }
}
