<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\GeneralSettings;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\WebsiteLogo;


class GeneralSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->organisation_id = Auth::user()->organisation_id;    
            return $next($request);
        });
    }

    public function index()
    {
        $generalSettings = GeneralSettings::where('id', 1)->first();
       
        $data = [
            'generalSettings' => $generalSettings,
            
        ];
        $data["pageTitle"] = 'Home Page Settings';
        $data["activeMenu"] = 'generalSettings';
        return view('admin.generalSettings.home')->with($data);
    }
      

public function update(Request $request)
{
   
    $GeneralSettings = GeneralSettings::where('id', 1)->first();
    
   if ($request->hasFile('image')) { 
        $mediaId = imageUpload($request->image, $GeneralSettings->imageId ?? null, $this->userId, "uploads/home/");
        
        $GeneralSettings->imageId = $mediaId;
    }

    $GeneralSettings->meta_title = $request->input('metaTitle');
    $GeneralSettings->meta_description = $request->input('metaDescription');
    $GeneralSettings->button_url = $request->input('buttonUrl');
    $GeneralSettings->description = $request->input('description');
    $GeneralSettings->save();
    $request->session()->flash('message', 'Contact Updated Successfully');
    return redirect()->route('home');
}

public function websiteLogo()
{
    $websiteLogo = WebsiteLogo::where('id', 1)->first();
   
    $data = [
        'websiteLogo' => $websiteLogo,
        
    ];
    $data["pageTitle"] = 'website logo Setting';
    $data["activeMenu"] = 'generalSettings';
    return view('admin.generalSettings.websiteLogo')->with($data);
}
  
public function updateLogo(Request $request)
{
   
    $websiteLogo = WebsiteLogo::where('id', 1)->first();
    
   if ($request->hasFile('image')) { 
        $mediaId = imageUpload($request->image, $websiteLogo->imageId ?? null, $this->userId, "uploads/home/");
        
        $websiteLogo->imageId = $mediaId;
    }

    $websiteLogo->save();
    $request->session()->flash('message', 'Contact Updated Successfully');
    return redirect()->route('websiteLogo');
}

}