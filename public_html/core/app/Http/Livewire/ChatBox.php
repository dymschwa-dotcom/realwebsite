<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\Conversation;

class ChatBox extends Component
{
    public $messageText;
    public $conversationId;

    public function sendMessage()
    {
        if (!$this->messageText) return;

        Message::create([
            'conversation_id' => $this->conversationId,
            'message' => $this->messageText,
            'sender_id' => auth()->id() ?? auth()->guard('influencer')->id(),
            'sender_type' => auth()->check() ? 'User' : 'Influencer',
            'type' => 'text'
        ]);

        $this->reset('messageText');
    }

    public function render()
    {
        $messages = Message::where('conversation_id', $this->conversationId)->get();
        return view('livewire.chat-box', compact('messages'));
    }
}