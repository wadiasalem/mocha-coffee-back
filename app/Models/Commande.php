<?php

namespace App\Models;

use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use BroadcastsEvents,HasFactory;

    protected $fillable = [
        'category',
        'employer',
        'table_id',
        'client',
        'served_at',
        'amount'
    ];

    function getBuyer(){
        if($this->category == 'local')
            return $this->hasOne(Table::class,'id','table_id');
        elseif ($this->category == 'delivery')
            return $this->hasOne(Client::class,'id','client');
    }

    function getEmployer(){
        return $this->hasOne(Employer::class,'id','employer');
    }

    function getCommandDetails(){
        return $this->hasMany(Commande_detail::class,'commande','id');
    }

    public function broadcastOn($event)
    {
        if($this->category == 'local')
            return [new Channel('local')];
        if($this->category == 'delivery')
            return [new Channel('delivery')];
    }

    public function broadcastAs($event)
    {
        return $event ;
    }
    
    public function broadcastWith($event)
    {
        return [
            'command' => $this ,
            'buyer' => $this->getBuyer,
            'action' => $this->category
        ];
    }

}
