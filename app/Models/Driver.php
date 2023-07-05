<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use HasFactory;
    // protected $fillable =[
    //                 'make',
    //                 'model',
    //                 'year',
    //                 'color',
    //                 'license_plate'

    // ];

    protected $guarded= [];

    

    public function user(){
        return $this->belongsTo(User::class);
    }
}
