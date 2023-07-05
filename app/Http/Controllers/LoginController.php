<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\LoginNeedVerification;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function submit(Request $request){
        $request->validate([
            'phone' => 'required|numeric|min:10'

        ]);

        $user =User::firstOrCreate([
            'phone' =>$request->phone


        ]);
        $user->notify(new LoginNeedVerification());

        if($user){

            return response()->json([
                'message' =>'Registration Code Sent Successfully'


            ], 200);
        } else{


            return response->json([

                'message' =>'Something Went Wrong'
            ], 200);
        }

    }



    public function verify(Request $request){
        $request->validate([
            'phone' =>'required|numeric|min:10',
            'login_code' =>'required|numeric|between:111111,999999'


        ]);

        $user=User::where('phone', $request->phone)->where('login_code', $request->login_code)->first();

        if($user){
            $user->update([
                'login_code' =>null

            ]);


            return response()->json([

                'message' =>'Registration Successfull',
                'token' =>$user->createToken($request->login_code)->plainTextToken
            ], 201);
        } else{



            return response()->json([


                'message' =>'Incorrect Login Code'
            ], 422);
        }



    }
}
