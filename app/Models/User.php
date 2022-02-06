<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
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
        return $this->belongsTo(Role::class,'role','id');
    }

    function getMoreDetails(){
        if(Role::find($this->role)->name == 'client'){
            return $this->hasOne(Client::class,'user','id');
        }elseif(Role::find($this->role)->name == 'table'){
            return $this->hasOne(Table::class,'user','id');
        }elseif(Role::find($this->role)->name == 'employer'){
            return $this->hasOne(Employer::class,'user','id');
        }
        
    }

    function sendMail(Mailable $mail){
        Mail::to($this->email)->send($mail);
    }
}
