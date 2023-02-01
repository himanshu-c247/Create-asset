<?php

use App\Segment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SegmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run(): void
    {
        Segment::create([
            'name'           => 'Finish Product',
        ]);

        Segment::create([
            'name'           => 'Raw Material',
        ]);
    }
}
