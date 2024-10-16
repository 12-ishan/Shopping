<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin\GeneralSettings;
use App\Models\Admin\WebsiteLogo;
use Illuminate\Http\Request;



class GeneralSettingsController extends Controller
{
    //
    public function homePage(Request $request)
    {
        $generalSettings = GeneralSettings::where('id', 1)->first();
    
        if (empty($generalSettings)) {

            $response = [
                'message' => 'not found',
                'status' => '0',
            ];
        } 
        else {
            $response = [
                'data' => [
                  'image' =>  url('/') . "/uploads/home/" . getMediaName($generalSettings->imageId),
                 'title' =>   $generalSettings->meta_title,
                  'meta_description' =>  $generalSettings->meta_description,
                   'button_url' => $generalSettings->button_url,
                    'description' => $generalSettings->description,
                ],
                'status' => '1'
            ];
        }
    
        return response()->json($response, 201);
    }    


    public function websiteLogo(Request $request)
    {
        $websiteLogo = WebsiteLogo::where('id', 1)->first();
    
        if (empty($websiteLogo)) {

            $response = [
                'message' => 'not found',
                'status' => '0',
            ];
        } 
        else {
            $response = [
                'data' => [
                  'image' =>  url('/') . "/uploads/home/" . getMediaName($websiteLogo->imageId),
                ],
                'status' => '1'
            ];
        }
    
        return response()->json($response, 201);
    } 
}


   
   

