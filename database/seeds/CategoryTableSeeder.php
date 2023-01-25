<?php

namespace Database\Seeders;

use App\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name'           => 'Finish Product',
            ],
            [
                'name'           => 'Raw Material',
            ],
        ];

        Category::create($categories);
    }
}
