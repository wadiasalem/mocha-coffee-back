<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'employer',
        'table_id',
        'client',
    ];

    function getBuyer(){
        if($this->category == 'locally')
            return $this->hasOne(Table::class,'id','table_id');
        else
            return $this->hasOne(Client::class,'id','client');
    }

    function getEmployer(){
        return $this->hasOne(Employer::class,'id','employer');
    }

    function getCommandDetails(){
        return $this->hasMany(Commande_detail::class,'command','id');
    }
}
