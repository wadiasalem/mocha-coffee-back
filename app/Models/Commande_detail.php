<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande',
        'product'
    ];

    function getCommand(){
        return $this->hasOne(Command::class,'id','Command');
    }

    function getProduct(){
        return $this->hasOne(Product::class,'id','Product');
    }
}
