<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DrivingController extends Controller
{
//     public function store(Request $request)
// {
//     $request->validate([
//         'make' => 'required',
//         'color' => 'required|string',
//         'model' => 'required|string',
//         'license_plate' => 'required|string',
//         'name' => 'required',
//         'year' => 'required|numeric|between:2010,2024',
//         'phone' => 'required|numeric|min:10'
//     ]);

//     //$user = $request->user(); // Retrieve the authenticated user
//     $user=User::where('phone', $request->phone)->first();
//     if ($user) {
//         // Update the user's name
//         $user->name = $request->name;
//         $user->save();

//         // Update or create the driver associated with the user
//         $user->driver()->updateOrCreate([], [
//             'make' => $request->make,
//             'color' => $request->color,
//             'model' => $request->model,
//             'license_plate' => $request->license_plate,
//             'phone' => $request->phone,
//             'year' => $request->year
//         ]);

//         $user->load('driver.user');

//         return response()->json([
//             'message' => 'Registration Successful',
//             'user' => $user
//         ], 201);
//     } else {
//         return response()->json([
//             'message' => 'User not found',
//         ], 404);
//     }
// }

public function store(Request $request)
{
    $request->validate([
        'make' => 'required',
        'color' => 'required|string',
        'model' => 'required|string',
        'license_plate' => 'required|string',
        'name' => 'required',
        'year' => 'required|numeric|between:2010,2024',
        'phone' => 'required|numeric|min:10'
    ]);

    $user = null;

    if ($request->header('Authorization')) {
        // Extract the token from the Authorization header
        $token = str_replace('Bearer ', '', $request->header('Authorization'));

        // Retrieve the user based on the token
        $user = User::where('api_token', $token)->first();
    }

    if ($user) {
        // Update the user's name
        $user->name = $request->name;
        $user->save();

        // Update or create the driver associated with the user
        $user->driver()->updateOrCreate([], [
            'make' => $request->make,
            'color' => $request->color,
            'model' => $request->model,
            'license_plate' => $request->license_plate,
            'phone' => $request->phone,
            'year' => $request->year
        ]);

        $user->load('driver');

        return response()->json([
            'message' => 'Registration Successful',
            'user' => $user
        ], 201);
    } else {
        return response()->json([
            'message' => 'Authentication failed',
        ], 401);
    }
}


}
