<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_name',
        'role',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function getRole(){
        return $this->hasOne(Role::class,'id','role');
    }

    function getMoreDetails(){
        if(Role::find($this->role)->code == 1){
            return $this->hasOne(Client::class,'user','id');
        }elseif(Role::find($this->role)->code == 2){
            return $this->hasOne(Table::class,'user','id');
        }elseif(Role::find($this->role)->code == 3){
            return $this->hasOne(Employer::class,'user','id');
        }
        
    }
}
