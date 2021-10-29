<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_Employer extends Model
{
    use HasFactory;

    function getEmployers(){
        return $this->hasMany(Employer::class,'category','id');
    }
}
