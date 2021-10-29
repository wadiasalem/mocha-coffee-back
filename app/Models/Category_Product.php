<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_Product extends Model
{
    use HasFactory;

    function getProducts(){
        return $this->hasMany(Product::class,'category','id');
    }
}
