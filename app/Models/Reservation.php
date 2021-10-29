<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    function getClient(){
        return $this->hasOne(Client::class,'id','client');
    }

    function getTable(){
        return $this->hasOne(Table::class,'id','table');
    }
}
