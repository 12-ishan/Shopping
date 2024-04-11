<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin\Program;
use Illuminate\Http\Request;

class ProgramVerifyController extends Controller
{
    //
    public function programVerify(Request $request)
    {
       $checkProgram = Program::where('slug', $request->slug)->first();
    
        if (empty($checkProgram)) {

            $response = [
                'message' => 'program not exists',
                'status' => '0',
            ];
        } 
        else {
            $response = [
                'message' => 'program exists',
                'status' => '1',
                'programId' => $checkProgram->id
            ];
        }
    
        return response()->json($response, 201);
    }

    public function programTest(Request $request)
    {
       
       $checkProgram = Program::where('slug', $request->slug)->first();
    
        if (empty($checkProgram)) {

            $response = [
                'message' => 'program not exists',
                'status' => '0',
            ];
        } 
        else {
            $response = [
                'message' => 'program exists',
                'status' => '1'
            ];
        }
    
        return response()->json($response, 201);
    }
    
}


   
   

