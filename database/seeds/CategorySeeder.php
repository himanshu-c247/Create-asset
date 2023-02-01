<?php

use App\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Category::create([
            'name'           => 'Finish Product',
        ]);

        Category::create([
            'name'           => 'Raw Material',
        ]);
    }
}
