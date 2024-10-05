<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;

class CreateMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    private $message = null;
    private $chatId = null;
    private $user = null;
    public function __construct($message, $chatId, $user)
    {
        $this->message = $message;
        $this->chatId = $chatId;
        $this->user = $user;
    }

    public function broadcastWith(): array
    {
       $data =  [$this->message];

       $data['message']['user'] = $this->user;
       $data['message']['message'] = $this->message['message'];
       return $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('chat.' . $this->chatId),
        ];
    }

    public function broadcastAs(): string {
        return 'CreateMessage';
    }
}
