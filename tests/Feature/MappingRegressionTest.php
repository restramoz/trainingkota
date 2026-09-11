<?php

namespace Tests\Feature;

use Tests\TestCase;

class MappingRegressionTest extends TestCase
{
    /**
     * Path to the mapping summary JSON file.
     *
     * @var string
     */
    private $summaryPath = __DIR__ . '/../../mapping_summary_v4.json';

    /** @test */
    public function mapping_summary_file_exists_and_is_valid_json()
    {
        $this->assertFileExists($this->summaryPath, 'mapping_summary_v4.json does not exist');

        $content = file_get_contents($this->summaryPath);
        $this->assertNotFalse($content, 'Failed to read mapping_summary_v4.json');

        $data = json_decode($content, true);
        $this->assertNotNull($data, 'mapping_summary_v4.json is not valid JSON');
        $this->assertIsArray($data, 'Decoded JSON is not an array');
    }

    /** @test */
    public function all_city_results_contains_expected_number_of_cities_and_unique_ids()
    {
        $data = $this->getSummaryData();

        $this->assertArrayHasKey('all_city_results', $data, 'Missing all_city_results key');

        $allCities = $data['all_city_results'];
        $this->assertCount(212, $allCities, 'Expected 212 city records');

        $ids = array_column($allCities, 'city_id');
        $uniqueIds = array_unique($ids);
        $this->assertCount(count($ids), $uniqueIds, 'city_id values are not unique');
    }

    /** @test */
    public function summary_totals_match_actual_counts()
    {
        $data = $this->getSummaryData();
        $summary = $data['summary'];

        $this->assertEquals(212, $summary['total_cities'], 'total_cities mismatch');

        $verifiedTotal = $summary['verified'];
        $this->assertEquals(151, $verifiedTotal, 'Verified total mismatch');

        $this->assertEquals(25, $summary['ambiguous'], 'Ambiguous count mismatch');
        $this->assertEquals(30, $summary['not_found'], 'Not found count mismatch');
        $this->assertEquals(6, $summary['non_regency_entity'], 'Non regency entity count mismatch');

        $this->assertCount($summary['total_cities'], $data['all_city_results'], 'total_cities does not match number of city results');
    }

    /** @test */
    public function classifications_are_valid_and_verified_mappings_are_correct()
    {
        $data = $this->getSummaryData();
        $allowed = [
            'VERIFIED_EXACT',
            'VERIFIED_NORMALIZED',
            'VERIFIED_ALIAS',
            'AMBIGUOUS',
            'NOT_FOUND',
            'NON_REGENCY_ENTITY',
        ];

        foreach ($data['all_city_results'] as $city) {
            $this->assertContains($city['classification'], $allowed, "Invalid classification for city_id {$city['city_id']}");
        }

        foreach ($data['verified_mappings'] as $city) {
            $this->assertStringStartsWith('VERIFIED', $city['classification'], "Verified mapping contains non-verified classification for city_id {$city['city_id']}");
            $this->assertArrayHasKey('city_id', $city);
            $this->assertArrayHasKey('city_name', $city);
            $this->assertNotEmpty($city['matches'], "Verified mapping for city_id {$city['city_id']} has no matches");
            foreach ($city['matches'] as $match) {
                $this->assertArrayHasKey('code', $match);
                $this->assertArrayHasKey('name', $match);
                $this->assertNotEmpty($match['code']);
                $this->assertNotEmpty($match['name']);
            }
        }

        // Ensure no ambiguous, not_found, non_regency_entity in verified_mappings
        foreach ($data['verified_mappings'] as $city) {
            $this->assertNotEquals('AMBIGUOUS', $city['classification']);
            $this->assertNotEquals('NOT_FOUND', $city['classification']);
            $this->assertNotEquals('NON_REGENCY_ENTITY', $city['classification']);
        }
    }

    /** @test */
    public function ambiguous_mappings_have_all_candidate_matches()
    {
        $data = $this->getSummaryData();
        $ambiguous = array_filter($data['all_city_results'], fn($c) => $c['classification'] === 'AMBIGUOUS');
        foreach ($ambiguous as $city) {
            $this->assertNotEmpty($city['matches'], "Ambiguous city_id {$city['city_id']} has no candidate matches");
            $this->assertGreaterThan(1, count($city['matches']), "Ambiguous city_id {$city['city_id']} should have multiple candidate matches");
        }
    }

    /** @test */
    public function malang_is_ambiguous_with_expected_candidates()
    {
        $data = $this->getSummaryData();
        $malang = null;
        foreach ($data['all_city_results'] as $city) {
            if (isset($city['city_name']) && $city['city_name'] === 'Malang') {
                $malang = $city;
                break;
            }
        }
        $this->assertNotNull($malang, 'Malang entry not found in all_city_results');
        $this->assertEquals(51, $malang['city_id'], 'Malang city_id mismatch');
        $this->assertEquals('AMBIGUOUS', $malang['classification'], 'Malang classification mismatch');
        $candidateCodes = array_column($malang['matches'], 'code');
        $this->assertContains('35.07', $candidateCodes, 'Malang missing candidate 35.07 Kabupaten Malang');
        $this->assertContains('35.73', $candidateCodes, 'Malang missing candidate 35.73 Kota Malang');
    }

    /** @test */
    public function duplicate_regency_codes_are_not_allowed()
    {
        $data = $this->getSummaryData();
        $codeMap = [];
        foreach ($data['verified_mappings'] as $city) {
            foreach ($city['matches'] as $match) {
                $code = $match['code'];
                $codeMap[$code][] = $city['city_name'];
            }
        }
        foreach ($codeMap as $code => $cityNames) {
            $uniqueNames = array_unique($cityNames);
            if (count($cityNames) > 1 && count($uniqueNames) > 1) {
                $this->fail("Regency code {$code} is assigned to multiple distinct city names: " . implode(', ', $uniqueNames));
            }
        }
        $this->assertTrue(true);
    }

    /**
     * Helper to load and decode the summary JSON.
     *
     * @return array
     */
    private function getSummaryData(): array
    {
        $content = file_get_contents($this->summaryPath);
        $data = json_decode($content, true);
        $this->assertNotNull($data, 'Failed to decode mapping_summary_v4.json');
        return $data;
    }
}
