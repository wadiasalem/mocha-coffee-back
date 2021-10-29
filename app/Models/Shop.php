<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    function getClient(){
        return $this->hasOne(Client::class,'id','client');
    }

    function getShopDetails(){
        return $this->hasMany(Shop_detail::class,'shop','id');
    }
}
