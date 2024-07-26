  $checkStudent = Student::where('password', $request->password)->where('email', $request->email)->first();

        $checkVerification = LoginOtpVerification::where('is_verified', $request->is_verified)->first();

        if ($checkVerification) {
           
            if (Hash::check($request->password, $checkStudent->password))
            {
                $token = $checkStudent->createToken($request->email)->plainTextToken;
    
                $response = [
                    'message' => 'logged in',
                    'status' => '1',
                    'token' => $token
                ];
            }
            else 
            {
                $response = [
                    'message' => 'Incorrect password',
                    'status' => '1'
                ];
            }
        } 
        else 
        { 
            $response = [
                'message' => 'not registerded',
                'status' => '0'
            ];
        }
        return response()->json($response, 201);