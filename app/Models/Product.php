<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'stock',
        'price',
        'category',
    ];

    function getCategory(){
        return $this->hasOne(Category_Product::class,'id','category');
    }

    function getCommandDetails(){
        return $this->hasMany(Commande_detail::class,'product','id');
    }
}
