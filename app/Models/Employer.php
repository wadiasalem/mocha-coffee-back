<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    function getUser(){
        return $this->hasOne(User::class,'id','user');
    }

    function getCategory(){
        return $this->hasOne(Category_Employer::class,'id','category');
    }

    function getCommands(){
        return $this->hasMany(Command::class,'employer','id');
    }
}
