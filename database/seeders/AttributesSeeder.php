<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('attributes')->insert([
            [
                'name' => 'Size',
                'status' => 1,
                'sortorder' => 1,
                'description' => 'find your best size',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Colour',
                'status' => 1,
                'sortorder' => 2,
                'description' => 'find your best colour',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Storage',
                'status' => 1,
                'sortorder' => 3,
                'description' => 'find your best storage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cloth Type',
                'status' => 1,
                'sortorder' => 4,
                'description' => 'find your best cloth type',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
