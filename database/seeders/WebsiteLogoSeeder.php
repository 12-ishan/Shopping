<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\WebsiteLogo;

class WebsiteLogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $websiteLogo = new WebsiteLogo();
       $websiteLogo->save();
    }
}
