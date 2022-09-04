<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\ResponseTrait;

class CheckAdminToken
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = null;
       try {
        
        $user = JWTAuth::parseToken()->authenticate();
       } catch (\Throwable $th) {
        if($th instanceof Tymon\JWTAuth\Exceptions\TokenInvalidException)
        {
            return $this->returnErrorMessage("INVALID_TOKEN");
        }  elseif ($th instanceof Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            
            return $this->returnErrorMessage("TOKEN_EXPIRED");
        } else {
           

            return $this->returnErrorMessage("TOKEN_NOTFOUND");
        }
       }

       if(!$user){
        return $this->returnErrorMessage("Admin not found");
       }
        return $next($request);
    }
}
