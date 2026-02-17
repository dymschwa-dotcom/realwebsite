<div wire:poll.3s> {{-- Auto-refreshes every 3 seconds to check for new messages --}}
    <div class="chat-history p-3" style="height: 400px; overflow-y: auto; background: #f9f9f9;">
        @foreach($messages as $msg)
            <div class="mb-2 {{ $msg->sender_type == (auth()->check() ? 'User' : 'Influencer') ? 'text-end' : 'text-start' }}">
                <div class="d-inline-block p-2 rounded {{ $msg->sender_type == (auth()->check() ? 'User' : 'Influencer') ? 'bg-primary text-white' : 'bg-light text-dark' }}">
                    {{ $msg->message }}
                </div>
            </div>
        @endforeach
    </div>

    <div class="chat-input p-3 border-top">
        <div class="input-group">
            <input type="text" wire:model.defer="messageText" class="form-control" placeholder="Type a message...">
            <button class="btn btn-primary" wire:click="sendMessage">Send</button>
        </div>
    </div>
</div>