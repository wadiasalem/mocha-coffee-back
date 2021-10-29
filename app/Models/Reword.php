<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reword extends Model
{
    use HasFactory;

    function getWins(){
        return $this->hasMany(Win::class,'reword','id');
    }
}
