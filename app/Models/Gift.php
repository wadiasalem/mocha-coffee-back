<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'discription',
        'quantity',
        'price'
    ];

    function getShopDetails(){
        return $this->hasMany(Shop_detail::class,'gift','id');
    }
}
