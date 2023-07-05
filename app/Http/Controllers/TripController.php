<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Events\TripStarted;
use App\Events\TripAccepted;
use App\Events\TripCreated;
use App\Events\TripEnded;
use App\Events\TripLocation;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function registerTrip(Request $request, Trip $trip){

        $request->validate([
         
            'destination'=> 'required',
            'origin'=> 'required',
            'destination_name'=> 'required'


        ]);
       
       
        // $trip->update([
        //     'driver_id'=>$request->user()->id,
        //     'driver_location'=>$request->driver_location


        // ]);

        

        $trip =$request->user()->trip()->create($request->only([ 
            'destination',
            'origin', 
            'destination_name'

        ]));

        TripCreated::dispatch($trip, $request->user());
        if($trip){


            return response()->json([
                'message' =>'Trip Created Successfully'

            ], 201);

            
        } else{


            return response()->json([

                'message' =>'Sorry, Something Went Wrong!'
            ], 404);
        }

    }
    public function show(Request $request, Trip $trip){
        if($trip->user === $request->user()->id){

            return $trip;
        }
        //this means if a trip as a driver and requested user has a driver
        if ($trip->driver && $request->user()->driver->id){


            if($trip->user->id === $request->$trip->user()->driver->id){

                return $trip;
            }
        }

        else{
$message ="The Trip Cannot Be Found.";
            return response()->json([
                'message' =>$message

            ], 404);
        }



    }





    public function start(Request $request, Trip $trip){
        $trip ->update([
            'is_start' =>true

        ]);
        $trip->load('driver.user');

        return response()->json([

            'message' =>'You have Just Began The Journey, going to {$destination_name}'

        ], 200);

        TripStarted::dispatch($trip, $trip->user);

    }

    public function end(Request $request, Trip $trip){

        $trip ->update([
            'is_complete' =>true

        ]);
        $trip->load('driver.user');

        return response()->json([
            'message' =>'You have arrived your destination'

        ], 201);

        TripEnded::dispatch($trip, $trip->user);

    }
    public function accept(Request $request, Trip $trip){
            $request->validate([
                    'driver_location' =>'required'

            ]);

            $trip->update([
                'driver_id' =>$request->user()->id,

                'driver_location' => $request->driver_location
            ]);

            $trip->load('driver.user');
            TripAccepted::dispatch($trip, $trip->user);
            return $trip;

    }

    public function location(Request $request, Trip $trip){
        $request->validate([
            'driver_loaction' =>'required'
        ]);

       
        $trip->update([
            'driver_location'=>$request->driver_location

        ]);
        $trip->load('driver.user');//same as $trip->driver->load('user');
        TripLocation::dispatch($trip, $trip->user);

        return $trip;


    }
}
