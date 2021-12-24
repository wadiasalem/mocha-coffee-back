<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class command implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $command ;
    public $toDo ;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($command,$toDo)
    {
        $this->command = $command ;
        $this->toDo = $toDo ;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel($this->toDo);
    }

    public function broadcastAs()
    {
        return 'updated';
    }

    public function broadcastWith()
{
    return ['id' => $this->command->id];
}
}
