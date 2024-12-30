<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class TaskReminderEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('tasks.' . $this->data['user_id']);
    }

    public function broadcastWith()
    {
        return $this->data;
    }
}
