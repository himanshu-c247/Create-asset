<?php

use App\Asset;
use Illuminate\Database\Seeder;

/**
 * Class AssetsTableSeeder
 */
class AssetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $assets = [
            'shirts',
            'jackets',
            'bottoms'
        ];

        foreach ($assets as $asset) {
            Asset::factory()->create([
                'name'        => $asset,
                'unit'        => 'quantity',
                'description' => $asset
            ]);
        }
     
    }
}
