<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'table_number'
    ];

    function getUser(){
        return $this->hasOne(User::class,'id','user');
    }

    function getReservations(){
        return $this->hasMany(Reservation::class,'table','id');
    }

    function getCommands(){
        return $this->hasMany(Command::class,'table','id');
    }
}
