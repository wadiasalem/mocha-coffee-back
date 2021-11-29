<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user',
        'points',
        'phone',
        'address'
    ];

    function getUser(){
        return $this->belongsTo(User::class,'id','user');
    }

    function getReservations(){
        return $this->hasMany(Reservation::class,'client','id');
    }

    function getShops(){
        return $this->hasMany(Shop::class,'client','id');
    }

    function getWins(){
        return $this->hasMany(Win::class,'client','id');
    }

    function getCommands(){
        return $this->hasMany(Command::class,'client','id');
    }
}
