<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model


{protected $fillable = [
    'conversation_id', 
    'sender_id', 
    'sender_type', 
    'message', 
    'type',           // Add this
    'participant_id', // Add this
    'is_read'
];
    protected $guarded = ['id'];

    /**
     * Get the conversation this message belongs to.
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Get the campaign proposal/contract associated with this message.
     * This allows the "Contract Card" to display campaign details in the chat.
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
    public function participant()
{
    return $this->belongsTo(Participant::class, 'participant_id');
}
}