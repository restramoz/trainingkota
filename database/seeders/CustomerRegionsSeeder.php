<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use Illuminate\Support\Facades\File;

class CustomerRegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(base_path('mapping_summary_v3.json'));
        $data = json_decode($json, true);

        if (!isset($data['details'])) {
            $this->command->error('No details found in mapping_summary_v3.json');
            return;
        }

        $this->command->info('Importing 212 customer regions...');

        foreach ($data['details'] as $item) {
            City::updateOrCreate(
                ['id' => $item['city_id']], // Using city_id from JSON as the primary ID
                [
                    'name'           => $item['city_name'],
                    'slug'           => $item['city_slug'],
                    'classification' => $item['classification'],
                    'status'         => 'published',
                ]
            );
        }

        $this->command->info('Successfully imported 212 customer regions.');
    }
}
