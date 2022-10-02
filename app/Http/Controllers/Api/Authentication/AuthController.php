<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    /**
     * Generate Token
     * @group Authentication
     *
     * Check customer valid/invalid using mobile number and password. If everything is okay, you'll get a success TRUE response.
     *
     * Otherwise, the request will fail with an error, and a response listing the failed services wish success FALSE response
     * @bodyParam  mobile_number string required The mobile number for generate. Example: 01711111111
     * @bodyParam  password string required The password for token-generate. Example: 123456
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response {
    *      "status": 200,
    *      "success": true,
    *      "message": "Login successfully",
    *      "data": {
    *          "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTY0MDg1NTUxNywiZXhwIjoxNjQwODU5MTE3LCJuYmYiOjE2NDA4NTU1MTcsImp0aSI6InhqMzQ5eXMwSHF0OGZ0QWUiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.SSuVeFSEo4hh9p6arwrw7tJKc43F7n7vVMzyXmZudOA",
    *          "token_type": "bearer",
    *          "expires_in": 3600
    *       }
    *   }
    * @response {
    *        "status": 400,
    *        "success": false,
    *        "message": "Your mobile & password was incorrect"
    *    }
     * 
     */
    public function tokenGenerate(Request $request){
        $validator = Validator::make($request->all(), [ 
            'mobile_number' => 'required|regex:/(01)[0-9]{9}/',
            'password'      => 'required'
        ],[
            'mobile_number.required' => 'please enter your mobile number',
            'password.required'      => 'please enter your mobile number',
            'mobile_number.regex'    => 'please enter your valid-mobile number',
        ]);
       
         /**
         * Validation Failed
         */ 
        if($validator->fails()){
            $data = [
                "status"  => 400,
                "success" => false,
                "message" => $validator->errors()->first()
            ];
            return response()->json($data);
        }

        $credentials = $request->only(['mobile_number', 'password']);


        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }


        if (! $token = Auth::attempt($credentials)) {
            $data = [
                "status"  => 400,
                "success" => false,
                "message" => "Your mobile & password was incorrect"
            ];
            return response()->json($data);
        }

        // successfully login
        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $data = [
            "status" => 200,
            "success" => true,
            "message" => "Login successfully",
            "data" => [
                'token'      => $token,
                'token_type' => 'bearer',
                'name'       => $this->guard()->user()->name,
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ]
        ];
        return response()->json($data);
    }

     /**
     * Get the guard to be used during api-authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }

}
