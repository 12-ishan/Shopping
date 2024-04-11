<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Admin\Application;
use App\Models\Frontend\LoginOtpVerification;
use App\Models\Frontend\ForgotPasswordOtpVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;


class StudentController extends Controller
{

public function studentRegister(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'first_name' => 'required',
        'last_name' => 'required',
        'register_email' => 'required|email',
        'phone_number' => 'required',
        'register_password' => 'required|min:8'
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        $errors = $validator->errors()->all();
        return response()->json(['message' => 'Validation failed', 'errors' => $errors], 422);
    }

    $checkStudent = Student::where('email', $request->register_email)->first();
    
    if (empty($checkStudent)) {
       
        $student = new Student();
        $student->first_name = $request->input('first_name');
        $student->last_name = $request->input('last_name');
        $student->email = $request->input('register_email');
        $student->phone_number = $request->input('phone_number');
        $student->password = Hash::make($request->input('register_password'));
        $student->receive_updates = $request->input('receive_updates');
        $student->is_otp_verified = 0;
        $student->otp = generateRandomOtp(6);
        $student->status = 1;
        $student->sort_order = 1;
        $student->increment('sort_order');
        $student->save();

        $studentId = $student->id;

        $response = [
            'message' => 'Registered successfully',
            'status' => 'success',
            'student' => $studentId,
        ];
    }
    else {
        $studentId = $checkStudent->id;

        $response = [
            'message' => 'Student already exists',
            'status' => 'error',
            'student' => $studentId,
        ];
    }

    $applicationExists = Application::where('student_id', $studentId)
        ->where('program_id', $request->program_id)
        ->exists();

    if ($applicationExists) {
        $response = [
            'message' => 'You have already enrolled',
            'status' => 'error',
        ];
    } else {
        $application = new Application();
        $application->student_id = $studentId;
        $application->program_id = $request->program_id;
        $application->status = 1;
        $application->sort_order = 1;
        $application->save();

        $response = [
            'message' => 'Application created successfully',
            'status' => 'success',
        ];
    }

    return response()->json($response, 201);
}

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        
        $student = Student::where('id', $request->id)->where('otp', $request->otp)->first();
     
        if (empty($student)) 
        {
            $response = [
                'message' => 'invalid OTP',
                'status' => '0'
            ];
        }
        else
        {
           $student->is_otp_verified = 1;
           $student->save();

           $response = [
            'message' => 'otp verified',
            'status' => '1'
          ];
        } 
        return response()->json($response, 201);
    }

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $student = Student::where('email', $request->email)->first();

        if(empty($student))
        {
          $response = [
            'message' => 'email not registered',
            'status' => '0'
          ];
        }
        else
        {
            $lovRecord = LoginOtpVerification::where('email', $request->email)->first();

            if (empty($lovRecord))
            {
                $loginOtpVerification = new LoginOtpVerification();
                $loginOtpVerification->email = $request->input('email');
            } 
            else 
            {
                $loginOtpVerification = LoginOtpVerification::find($lovRecord->id);
              
            }
    
            $loginOtpVerification->otp = generateRandomOtp(6);
            $loginOtpVerification->is_verified = 0;
            $loginOtpVerification->save();
    
            $response = [
                'message' => 'otp send successfully please check email',
                'status' => '1'
            ];
        }
        return response()->json($response, 201);

    }

    public function verifyStudentLoginOtp(Request $request)
    {
        $lovRecord = LoginOtpVerification::where('email', $request->email)->where('otp', $request->otp)->first();
       
        if($lovRecord)
        {
            $lovRecord->is_verified = 1;
            $lovRecord->save();

            $response = [
                'message' => 'otp verification successful',
                'status' => '1'
            ];
        }
        else
        {
            $response = [
                'message' => 'you entered wrong otp',
                'status' => '0'
            ];
        }
        return response()->json($response, 201);

    }

    public function studentLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
            "program_id" => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::guard('student')->attempt($credentials)) {
            
            $user = Auth::guard('student')->user();
          
            if ($user->status == 1) {

               $studentId = Auth::guard('student')->user()->id; 
               $programId = $request->program_id;
           
              $applicationDetails = Application::where('student_id', $studentId)->where('program_id', $programId)->first();

              if(empty($applicationDetails)){
                $response = [
                    'message' => 'invalid credentials',
                    'status' => '0'
                   ];  
              }

              else{ 
               $token = $user->createToken($request->email)->plainTextToken;

               $response = [
                'message' => 'login success',
                'status' => '1',
                'token' => $token,
                'applicationId' => $applicationDetails->id
               ];
             }
                
            }else{

               Auth::guard('student')->logout(); 
               
               $response = [
                'message' => 'invalid credentials',
                'status' => '0'
               ];       
            }            
        }else{
            $response = [
            'message' => 'Oppes! You have entered invalid credentials',
            'status' => '0'
            ];
        }
    
    return response()->json($response, 201);  
    }

    public function sendForgotPasswordOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'phone_number' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $student = Student::where('email', $request->email)->where('phone_number', $request->phone_number)->first();

        if(empty($student))
        {
          $response = [
            'message' => 'email and phone number not registered',
            'status' => '0'
          ];
        }
        else
        {
            $fpovRecord = ForgotPasswordOtpVerification::where('email', $request->email)->where('phone_number', $request->phone_number)->first();

            if (empty($fpovRecord))
            {
                $forgotOtpVerification = new ForgotPasswordOtpVerification();
                $forgotOtpVerification->email = $request->input('email');
                $forgotOtpVerification->phone_number = $request->input('phone_number');
            } 
            else 
            {
                $forgotOtpVerification = ForgotPasswordOtpVerification::find($fpovRecord->id);
            }
    
            $forgotOtpVerification->otp = generateRandomOtp(6);
            $forgotOtpVerification->is_verified = 0;
            $forgotOtpVerification->save();
    
            $response = [
                'message' => 'otp send successfully please check phone number and email',
                'status' => '1'
            ];
        }
        return response()->json($response, 201);
    }

    public function verifyForgotPasswordOtp(Request $request)
    {
        $fpovRecord = ForgotPasswordOtpVerification::where('email', $request->email)->where('otp', $request->otp)->first();
       
        if($fpovRecord)
        {
            $fpovRecord->is_verified = 1;
            $fpovRecord->save();

            $response = [
                'message' => 'otp verification successful',
                'status' => '1'
            ];
        }
        else
        {
            $response = [
                'message' => 'you entered wrong otp',
                'status' => '0'
            ];
        }
        return response()->json($response, 201);

    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $student = Student::where('email', $request->email)->first();

        if(empty($student))
        {
            $response = [
                'message' => 'email not exist',
                'status' => '0'
            ];
        }
        else
        {
            $existsOne = ForgotPasswordOtpVerification::where('is_verified', 1)->first();

            if(empty($existsOne)){
                $response = [
                    'message' => 'not verified',
                    'status' => '0'
                ];
            }
            else{
                $password = $request->input('password');
                $student->password = Hash::make($password);
                $student->save();

                $response = [
                    'message' => 'password reset successfully',
                    'status' => '1'
                ];
            }
        }
        return response()->json($response, 201);
    }
}





    



   
   

