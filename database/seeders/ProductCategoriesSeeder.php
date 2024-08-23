<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_category')->insert([
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'status' => 1,
                'sortorder' => 1,
                'description' => 'Devices and gadgets',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'status' => 1,
                'sortorder' => 2,
                'description' => 'Clothing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mobiles',
                'slug' => 'mobiles',
                'status' => 1,
                'sortorder' => 3,
                'description' => 'Apparel and accessories',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
