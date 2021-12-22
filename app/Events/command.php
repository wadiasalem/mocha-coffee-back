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
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($command)
    {
        $this->command = $command ;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('command');
    }

    public function broadcastAs()
    {
        return 'my-command';
    }

    public function broadcastWith()
{
    return ['id' => $this->command];
}
}
