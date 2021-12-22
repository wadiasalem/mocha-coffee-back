<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande',
        'product',
        'quantity'
    ];

    function getCommand(){
        return $this->belongsTo(Command::class,'id','Command');
    }

    function getProduct(){
        return $this->hasOne(Product::class,'id','Product');
    }
}
