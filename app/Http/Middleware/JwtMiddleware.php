<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = \JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                $data = [
                    "status"  => 403,
                    "success" => false,
                    "message" => "Un-authenticated User"
                ];
                return response()->json($data);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                $data = [
                    "status"  => 403,
                    "success" => false,
                    "message" => "Token is Expired"
                ];
                return response()->json($data);
            }else{
                $data = [
                    "status"  => 403,
                    "success" => false,
                    "message" => "Authorization Token not found"
                ];
                return response()->json($data);
            }
        }
        return $next($request);
    }
}