<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use App\Models\CaseMessage;
use App\Models\User;
use App\Models\Customer;
use App\Models\Lawyer;
use App\Models\CaseMessageAttachMent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $caseMessage;
    public $attachment;
    public function __construct($caseMessage, $attachment = null)
    {
        $this->caseMessage = $caseMessage;

        $this->attachment = $attachment;


    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('case-message-channel')
        ];
    }

    public function broadcastWith()
    {
        if ($this->caseMessage->guard == 'user') {
            $messengerName = User::find($this->caseMessage->messenger_id)->name;
            $role = 'Render_law_firm_consultant';
        }

        if ($this->caseMessage->guard == 'lawyer') {
            $messengerName = Lawyer::find($this->caseMessage->messenger_id)->name;
            $role = 'lawyer';
        }

        if ($this->caseMessage->guard == 'customer') {
            $messengerName = Customer::find($this->caseMessage->messenger_id)->name;
            $role = 'customer';
        }


        $data = [
            'cases_id' => $this->caseMessage->cases_id,

            'messenger_guard' => $this->caseMessage->guard,
            'message' => $this->caseMessage->message,
            'messenger_id' => $this->caseMessage->messenger_id,
            'messenger_name' => $messengerName,
            'role' => $role,

            'created_at' => date('d M Y h:i A', strtotime($this->caseMessage->created_at)),
        ];

        if ($this->attachment) {
            $data['attachment'] = $this->attachment->attachment_file;
        }

        return $data;
    }
}