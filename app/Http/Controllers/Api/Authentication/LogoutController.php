<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class LogoutController extends Controller
{
    /**
     * Get the guard to be used during api-authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }
    
    /**
     * Logout
     * 
     * @group Authentication
     * 
     * @authenticated
     * @header Authorization bearer your-token
     * 
     * 
     * @response {
     *       "status": 200,
     *       "success": true,
     *       "message": "logout successfully"
     *   }
     */
    public function logout(Request $request)
    {  
        $this->guard()->logout();
        $data = [
            "status" => 200,
            "success" => true,
            "message" => "logout successfully",
        ];
        return response()->json($data);
    }

}
