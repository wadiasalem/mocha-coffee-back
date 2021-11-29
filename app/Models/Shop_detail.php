<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop',
        'gift',
        'quantity'
    ];

    public $timestamps = false;

    function getShop(){
        return $this->hasOne(Shop::class,'id','shop');
    }

    function getGift(){
        return $this->hasOne(Gift::class,'id','gift');
    }
}
