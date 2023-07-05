<?php

namespace App\Models;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trip extends Model
{
    use HasFactory;

    protected $fillable =[

       
        'driver_location',
        'origin',
        'destination_name'
    ];

    public function driver(){

        $this->belongsTo(Driver::class);
    }

    public function user(){

        $this->belongsTo(User::class);
    }
}
