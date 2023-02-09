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
            [
                'id'            => 1,
                'name'          => 'Smartees Men Color Blocked',
                'category_id'   => 1,
                'type'          => 't-shirt',
                'unit'          => 'Qty',
                'status'        => '1',
                'description'   => 'This cool t-shirt for men is made from Cotton which is pre-shrunk and bio-washed for longevity is a perfect treat for Men & Boys who like to move out in style. This tshirt is available in 3 sizes - M L XL.',
                'danger_level'  => '10',      
            ],
            [
                'id'            => 2,
                'name'          => 'TORTUGA Men Washed Casual Grey Denim Shirt',
                'category_id'   => 1,
                'type'          => 'shirt',
                'unit'          => 'Qty',
                'status'        => '1',
                'description'   => 'This shirt is made from premium quality material. Durable quality with a stylish look makes it a must have on your shelves.',
                'danger_level'  => '10',      
            ],
            [
                'id'            => 3,
                'name'          => 'Unstitched Crepe Salwar Suit Material Printed',
                'category_id'   => 1,
                'type'          => 'suit',
                'unit'          => 'Qty',
                'status'        => '1',
                'description'   => 'This product doesnt require installation',
                'danger_level'  => '10',      
            ],
            [
                'id'            => 4,
                'name'          => 'Unstitched Viscose Rayon Shirt & Trouser Fabric Solid',
                'category_id'   => 2,
                'type'          => 'fabric',
                'unit'          => 'meter',
                'status'        => '1',
                'description'   => 'This cool t-shirt for men is made from Cotton which is pre-shrunk and bio-washed for longevity is a perfect treat for Men & Boys who like to move out in style. This tshirt is available in 3 sizes - M L XL.',
                'danger_level'  => '200',      
            ],
            
        ];
        // $url =[
        //     public_path('/images/s-479634-bewakoof-original-imaghauygbdsg3dm.webp'),

        // ];
        foreach ($assets as $asset) {
            $asset = Asset::create($asset)->each(function($avtar,$key){
                // $imageUrl = 'https://source.unsplash.com/random';
                $url = [
                     public_path('/images/s-479634-bewakoof-original-imaghauygbdsg3dm.webp'),
                     public_path('/images/tortuga-men-washed-casual-grey-denim-shirt-product-images-rvkaooxqv0-0-202205092228.jpg'),
                     public_path('/images/2-m-unstitched-inithi-1458-beige-2-35-m-salwar-suit-material-original-imag975dkmcmw7dt.webp'),
                     public_path('/images/material.jpeg'),
                  ] ;
                $avtar->addMedia($url[$key])->preservingOriginal()->toMediaCollection('avatar');
            });
            // $asset->addMedia($url1)->preservingOriginal()->toMediaCollection('avatar');
            // $asset->addMedia($url2)->preservingOriginal()->toMediaCollection('avatar');
            // $asset->addMedia($url3)->preservingOriginal()->toMediaCollection('avatar');
            // $asset->addMedia($url1)->preservingOriginal()->toMediaCollection('asset');
            // $asset->addMedia($url2)->preservingOriginal()->toMediaCollection('asset');
            // $asset->addMedia($url3)->preservingOriginal()->toMediaCollection('asset');
        }
    }
}