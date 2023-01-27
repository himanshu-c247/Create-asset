<?php

use Illuminate\Database\Seeder;
use App\Category;
/**
 * Class CategorySeeder
 */
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

