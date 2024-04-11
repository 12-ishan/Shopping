<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin\Application;
use App\Models\Frontend\ApplicantDetails;
use App\Models\Frontend\Scholarship;
use App\Models\Frontend\Documents;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


use Illuminate\Http\Request;
use Validator;

class MediaController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware(function ($request, $next) {
           // $this->userId = Auth::user()->id;
           // $this->organisationId = Auth::user()->organisationId;
            $this->organisationId = 1;
        
            return $next($request);
        });
    }

    public function mediaUpload(Request $request)
    {

        if ($request->hasFile('image')) {
           
            $validator = Validator::make($request->all(), [
                'key' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        } elseif ($request->hasFile('file')) {
           
            $validator = Validator::make($request->all(), [
                'key' => 'required',
                'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
            ]);
        } 
       
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => 'Validation failed', 'errors' => $errors], 422);
        }

        $imageId = $this->checkImageAlreadyUploaded($request->key, $request->application_id);

        if ($request->hasFile('image')) {
            $mediaId = imageUploadApi($request->image, $imageId, "uploads/applications/");
        } elseif ($request->hasFile('file')) {
            $mediaId = imageUploadApi($request->file, $imageId, "uploads/applications/");
        }

        $imageInfo =  $this->setNewMedia($request->key, $request->application_id,  $mediaId);
     
            $response = [
                'message' => 'image uplaoded successfully',
                'status' => 'success',
                'data' => $imageInfo
            ];
       
     
        return response()->json($response, 201);
    }

    private function setNewMedia($key, $applicationId, $mediaId)
    {
        switch($key) {
            case 'personal_profile':

               $ad = ApplicantDetails::where('application_id', $applicationId)->first();
                $ad->pd_profile_id = $mediaId;
                $ad->save();
                
                return url('/') . "/uploads/applications/" . $ad->pdProfile->name;
                
            case 'explanation_document':
                $ed = Scholarship::where('application_id', $applicationId)->first();
                $ed->explanation_document_id = $mediaId;
                $ed->save();
                return  url('/') . "/uploads/applications/" . $ed->explanationDocument->name;

            case 'highschool_markssheet':
                $hm = Documents::where('application_id', $applicationId)->first();
                $hm->highschool_markssheet_id = $mediaId;
                $hm->save();
                return  url('/') . "/uploads/applications/" . $hm->highschoolMarksheet->name;

            case 'inter_markssheet':
                $im = Documents::where('application_id', $applicationId)->first();
                $im->inter_markssheet_id = $mediaId;
                $im->save();
                return  url('/') . "/uploads/applications/" . $im->interMarksheet->name;

            case 'consolidated_marksheet':
                $cm = Documents::where('application_id', $applicationId)->first();
                $cm->consolidated_marksheet_id = $mediaId;
                $cm->save();
                return  url('/') . "/uploads/applications/" . $cm->consolidatedMarksheet->name;

            case 'consolidated_certificate':
                $cc = Documents::where('application_id', $applicationId)->first();
                $cc->consolidated_certificate_id = $mediaId;
                $cc->save();
                return  url('/') . "/uploads/applications/" . $cc->consolidatedCertificate->name;

            case 'aadhar_card':
                $ar = Documents::where('application_id', $applicationId)->first();
                $ar->aadhar_card_id = $mediaId;
                $ar->save();
                return  url('/') . "/uploads/applications/" . $ar->aadharCard->name;

            case 'signature':
                $s = Documents::where('application_id', $applicationId)->first();
                $s->signature_id = $mediaId;
                $s->save();
                return  url('/') . "/uploads/applications/" . $s->signature->name;
                            
            // Add cases for other stages if needed

            default:
                return 0; // Default to false if the stage is not found
        }

    }

    private function checkImageAlreadyUploaded($key, $applicationId)
    {
        switch($key) {
            case 'personal_profile':

                $ad = ApplicantDetails::where('application_id', $applicationId)->first();
                
                if (empty($ad)) {
                   
                    $ad = new ApplicantDetails();
                    $ad->application_id = $applicationId;
                } 
                $ad->status = 1;
                $ad->sort_order = 1;
                $ad->save();
                return  $ad->pd_profile_id;

            case 'explanation_document':

                $ed = Scholarship::where('application_id', $applicationId)->first();
                
                if (empty($ed)) {
                   
                    $ed = new Scholarship();
                    $ed->application_id = $applicationId;
                } 
                $ed->status = 1;
                $ed->sort_order = 1;
                $ed->save();
                return  $ed->explanation_document_id;

            case 'highschool_markssheet':

                $hm = Documents::where('application_id', $applicationId)->first();
                
                if (empty($hm)) {
                   
                    $hm = new Documents();
                    $hm->application_id = $applicationId;
                } 
                $hm->status = 1;
                $hm->sort_order = 1;
                $hm->save();
                return  $hm->highschool_markssheet_id;

            case 'inter_markssheet':

                $im = Documents::where('application_id', $applicationId)->first();
                
                if (empty($im)) {
                   
                    $im = new Documents();
                    $im->application_id = $applicationId;
                } 
                $im->status = 1;
                $im->sort_order = 1;
                $im->save();
                return  $im->inter_markssheet_id;

            case 'consolidated_marksheet':

                $cm = Documents::where('application_id', $applicationId)->first();
                
                if (empty($cm)) {
                   
                    $cm = new Documents();
                    $cm->application_id = $applicationId;
                } 
                $cm->status = 1;
                $cm->sort_order = 1;
                $cm->save();
                return  $cm->consolidated_marksheet_id;

            case 'consolidated_certificate':
                $cc = Documents::where('application_id', $applicationId)->first();
                
                if (empty($cc)) {
                   
                    $cc = new Documents();
                    $cc->application_id = $applicationId;
                } 
                $cc->status = 1;
                $cc->sort_order = 1;
                $cc->save();
                return  $cc->consolidated_certificate_id;

            case 'aadhar_card':
                $ar = Documents::where('application_id', $applicationId)->first();
                
                if (empty($ar)) {
                   
                    $ar = new Documents();
                    $ar->application_id = $applicationId;
                } 
                $ar->status = 1;
                $ar->sort_order = 1;
                $ar->save();
                return  $ar->aadhar_card_id;

            case 'signature':
                $s = Documents::where('application_id', $applicationId)->first();
                
                if (empty($s)) {
                   
                    $s = new Documents();
                    $s->application_id = $applicationId;
                } 
                $s->status = 1;
                $s->sort_order = 1;
                $hsm->save();
                return  $s->signature_id;
                        
            // Add cases for other stages if needed

            default:
                return 0; // Default to false if the stage is not found
        }
    }

}
