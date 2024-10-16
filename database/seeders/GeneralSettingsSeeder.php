<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\GeneralSettings;

class GeneralSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $generalSettings = new GeneralSettings();
       $generalSettings->meta_title = "Finding Your Perfect Shoes";
       $generalSettings->meta_description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.";
       $generalSettings->button_url = "#";
       $generalSettings->save();
    }
}
