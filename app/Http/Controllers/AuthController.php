<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Tymon\JWTAuth\Facades\JWTAuth;

use Validator;
use Auth;

class AuthController extends Controller
{
    //
    use ResponseTrait;
    

    public function login(Request $request)
    {
        try {

            //Validation
            $rules = [
                'email'=> 'required|',
                'password'=> 'required',
            ];

            //Validate request using the above rules
            $validate = Validator::make($request->all(), $rules);
            //if validation fails
            if($validate->fails())
            {
                return $this->returnErrorMessage($validate->errors()->first());
            }
            //get email and password
            $credentials = $request->only(['email', 'password']);
            //claom the token using guard auth.php
            $token = Auth::guard('admin-api')->attempt($credentials);
            //if there is no token then no admin exists
            if(!$token)
            {
                return $this->returnErrorMessage("Invalid Credentials");
            }
            //else return success token
            return $this->returnData(["accessToken"=> $token], "Login successful");
        } catch (\Throwable $th) {
            return $this->returnErrorMessage($th->getMessage());
        }
    }

    public function logout(Request $request)
    {


        $token = $request->header('auth-token');
        try {
            JWTAuth::setToken($token)->invalidate();
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $th) {
            return $this->returnErrorMessage('Something went wrong');
        } catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException){
            return $this->returnErrorMessage('Something went wrong');
        }

        if(!$token)
        {
            return $this->returnErrorMessage('Something went wrong'); //Important
        }

        return $this->returnSuccessMessage("Logged out Successfully");


    }

    public function userLogin(Request $request)
    {
        $rules = [
            'email'=>'required',
            'password'=>'required'
        ];

        try {
            $validator = Validator::make($request->all(), $rules);

            if(!$validator){
                $this->returnErrorMessage('Invalid Credentials');
            }
            $credentials = $request->only(['email','password']);
            $token = auth()->guard('user-api')->attempt($credentials);

            if(!$token)
            {
                return $this->returnErrorMessage("Invalid Credentials");
            }

            return $this->returnData(['accessToken'=>$token], "Login Successful");


        } catch (\Throwable $th) {
            return $this->returnErrorMessage($th->getMessage());
        }

    }

    public function userLogout(Request $request)
    {
        try {
            // $token = $request->header('auth-token');
            // $forever = true;
            // JWTAuth::setToken($token)->invalidate($forever);
            auth()->logout();
            


        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $th) {
            return $this->returnErrorMessage('Something went wrong');
        } catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException){
            return $this->returnErrorMessage('Something went wrong');
        }

        // if(!$token)
        // {
        //     return $this->returnErrorMessage('Something went wrong');
        // }

        return $this->returnSuccessMessage('Logout Successful');
    }
}
