<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DriverController extends Controller
{
//     public function store(Request $request){
//         $request->validate([
//             'make' =>'required',
//             'color' =>'required|string',
//             'model' =>'required|string',
//             'license_plate' =>'required|string',
//             'name' =>'required',
//             'year' =>'required|numeric|between:2010,2024',
//             'phone' =>'required|numeric|min:10'

//         ]);

//          $user =$request->user();
       
//         $user->user()->update($request->only('name'));

    
    

//     // $user->driver()->updateOrCreate($request->only([

//     //         'make',
//     //         'color',
//     //         'model',
//     //         'license_plate',
//     //         'phone'
//     // ]));

   
//     $user->driver()->updateOrCreate($request->only([
//         'year',
//         'make',
//         'model',
//         'color',
//         'license_plate'
//     ]));

//    // if($user){
//         // return response()->json([

//         //     'message' =>'Registration Successfull',
//         //     'User' =>$user
//         // ], 201);      

//                  $user->load('driver');


//             return $user;
//     //}
// }


      public function show(Request $request)
    {
        // return back the user and associated driver model
        $user = $request->user();
        $user->load('driver');

        return $user;
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|numeric|between:2010,2024',
            'make' => 'required',
            'model' => 'required',
            
            'license_plate' => 'required',
            'color' => 'required|alpha',
            'name' => 'required'
        ]);

        $user = $request->user();

        $user->update($request->only('name'));

        // create or update a driver associated with this user
        $user->driver()->updateOrCreate($request->only([
            'year',
            'make',
            'model',
            'color',
            'license_plate'
        ]));

        $user->load('driver');

        return $user;
    }

    
    
    
    
    
    
    
}




    

