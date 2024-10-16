<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin\LandingPage;
use Illuminate\Http\Request;



class LandingPagesController extends Controller
{
    //
    public function landingPages($slug)
    {
        $landingPage = LandingPage::where('slug', $slug)->first();
    
        if (empty($landingPage)) {

            $response = [
                'data' => [],
                'message' => 'page not found',
                'status' => '0',
            ];
        } 
        else {
            $response = [
                'data' => [
                  'image' =>  url('/') . "/uploads/landingPages/" . getMediaName($landingPage->imageId),
                  'title' =>   $landingPage->title,
                  'slug' =>  $landingPage->slug,
                  'description' => $landingPage->description,
                ],
                'status' => '1'
            ];
        }
    
        return response()->json($response, 201);
    }    


  
}


   
   

