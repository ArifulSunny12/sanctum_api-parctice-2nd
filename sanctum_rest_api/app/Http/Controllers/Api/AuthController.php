<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helper\ResponseHelper;
use App\http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    /**
     * function register new user in database storage.
     * @param use App\http\Requests\RegisterRequest;
     * @param json response
     */
    public function register(RegisterRequest $request)
    {
      // dd($request->all());
      try{
         $user= User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile ,
            'address' => $request->address ,
            'password' => Hash::make($request->password)
         ]);
         if($user){
            return ResponseHelper::success(message: 'User has been registerd successfully!', data: $user, statusCode:201);
         }
         return ResponseHelper::error(message: 'Unable to register User! try again.', statusCode:400);
      }
      catch(Exception $e){
        \log::error('unable to register user: '. $e->getMessage(). ' - line number '.$e->getLine() );
        return ResponseHelper::error(message: 'Unable to register User! try again.'.$e->getMessage(), statusCode:500);
      }
    }


    /**
     * function login user
     * @param use App\http\Requests\LoginRequest;
     */
    public function login(LoginRequest $request)
    {
        //dd($request->all());
        try{
            if(!Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
                return ResponseHelper::error(message: 'Unable to Login! Incurrect infomation', statusCode:400);
            };

            $user = Auth::user();
            $token = $user->createToken('My Api Token')->plainTextToken;
            $authUser = [
                'user'=> $user,
                'token' => $token

            ];
            return ResponseHelper::success(message: 'User loged in successfully!', data: $authUser, statusCode:200);

        }
        catch(Exception $e){
            \log::error('unable to Login: '. $e->getMessage(). ' - line number '.$e->getLine() );
            return ResponseHelper::error(message: 'Unable to Login! try again.'.$e->getMessage(), statusCode:500);

        }

    }


    /**
     * function auth user data, get user profile
     * @param NA;
     * @return JSON response
     */
    public function userProfile()
    {
        
        try{
           $user=auth::user();
           if($user){
            return ResponseHelper::success(message: 'User Data Fetch Successfully!', data: $user, statusCode:200);
         }
         return ResponseHelper::error(message: 'Fetch User Data Faild! try again.', statusCode:400);

        }
        catch(Exception $e){
            \log::error('unable to fetch user profile data: '. $e->getMessage(). ' - line number '.$e->getLine() );
            return ResponseHelper::error(message: 'unable to fetch user profile data! try again.'.$e->getMessage(), statusCode:500);

        }

    }


     /**
     * function logout
     * @param NA;
     * @return JSON response
     */
    public function logOut()
    {
        
        try{
           $user=auth::user();
           if($user){
            $user->currentAccessToken()->delete();
            return ResponseHelper::success(message: 'Logout Successfully!', data: $user, statusCode:200);
         }
         return ResponseHelper::error(message: 'logout Faild! due to wrong token.', statusCode:400);

        }
        catch(Exception $e){
            \log::error('unable to logout: '. $e->getMessage(). ' - line number '.$e->getLine() );
            return ResponseHelper::error(message: 'unable to logout! try again.'.$e->getMessage(), statusCode:500);

        }

    }
   
}
