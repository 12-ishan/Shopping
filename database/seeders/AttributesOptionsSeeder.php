<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributesOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('attributes_options')->insert([
            [
                'value' => 'Small',
                'attribute_id' => '1',
                'status' => 1,
                'sortOrder' => 1,
                'description' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'value' => 'Medium',
                'attribute_id' => '1',
                'status' => 1,
                'sortOrder' => 2,
                'description' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'value' => 'Magenta',
                'attribute_id' => '2',
                'status' => 1,
                'sortOrder' => 3,
                'description' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'value' => 'Peach',
                'attribute_id' => '2',
                'status' => 1,
                'sortOrder' => 4,
                'description' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'value' => '256GB',
                'attribute_id' => '3',
                'status' => 1,
                'sortOrder' => 4,
                'description' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'value' => '512GB',
                'attribute_id' => '3',
                'status' => 1,
                'sortOrder' => 4,
                'description' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'value' => 'Cotton',
                'attribute_id' => '4',
                'status' => 1,
                'sortOrder' => 5,
                'description' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'value' => 'Leather',
                'attribute_id' => '4',
                'status' => 1,
                'sortOrder' => 6,
                'description' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]); 
    }
}
