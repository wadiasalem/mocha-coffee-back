<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Win extends Model
{
    use HasFactory;

    function getClient(){
        return $this->hasOne(Client::class,'id','client');
    }

    function getReword(){
        return $this->hasOne(Reword::class,'id','reword');
    }
}
