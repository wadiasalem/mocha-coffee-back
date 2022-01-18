<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user',
        'category',
        'phone',
        'cin',
    ];
    
    function getUser(){
        return $this->belongsTo(User::class,'id','user');
    }

    function getCategory(){
        return $this->belongsTo(Category_Employer::class,'category','id');
    }

    function getCommands(){
        return $this->hasMany(Command::class,'employer','id');
    }
}
