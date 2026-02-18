@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="card b-radius--10 overflow-hidden shadow-sm">
    <div class="card-body p-0">
        <div class="row g-0" style="min-height: 700px;">
            {{-- Left Side: Conversation List --}}
            <div class="col-xl-4 col-lg-5 border-end">
                <div class="chat-sidebar">
                    <div class="p-3 border-bottom bg-light">
                        <h5 class="m-0 fw-bold">@lang('Messages')</h5>
                    </div>
                    
                    <div class="conversation-list overflow-auto" style="max-height: 650px;">
                        @forelse($conversations as $conversation)
                            <a href="{{ route('influencer.conversation.view', $conversation->id) }}" 
                               class="d-flex align-items-center p-3 border-bottom decoration-none chat-item {{ Request::route('id') == $conversation->id ? 'bg-selected' : '' }}">
                                
                                <div class="avatar-wrapper position-relative">
                                    {{-- Brand's Profile Image --}}
                                    <img src="{{ getImage(getFilePath('brand') . '/' . $conversation->user->image, getFileSize('brand')) }}" 
                                         class="rounded-circle border" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                </div>

                                <div class="ms-3 overflow-hidden flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="text-dark fw-bold mb-0 text-truncate">{{ __($conversation->user->fullname) }}</h6>
                                        <small class="text-muted fs-12">{{ diffForHumans($conversation->updated_at) }}</small>
                                    </div>
                                    <p class="text-muted small mb-0 text-truncate">
                                        @if($conversation->lastMessage)
                                            {{ $conversation->lastMessage->sender_type == 'influencer' ? 'You: ' : '' }}{{ Str::limit($conversation->lastMessage->message, 45) }}
                                        @else
                                            @lang('Start a conversation')
                                        @endif
                                    </p>
                                </div>
                            </a>
                        @empty
                            <div class="text-center p-5">
                                <i class="las la-envelope-open text-muted" style="font-size: 3rem;"></i>
                                <p class="mt-2 text-muted">@lang('No messages yet')</p>
                            </div>
                        @endforelse
                    </div>

                    @if($conversations->hasPages())
                        <div class="p-3 border-top">
                            {{ paginateLinks($conversations) }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Side: Empty State Placeholder --}}
            <div class="col-xl-8 col-lg-7 d-none d-lg-flex align-items-center justify-content-center bg-light">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="las la-comments text-muted" style="font-size: 5rem;"></i>
                    </div>
                    <h4 class="fw-bold">@lang('Your Inbox')</h4>
                    <p class="text-muted">@lang('Select a brand from the left to view your messages and negotiate deals.')</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .chat-item {
        transition: all 0.2s ease;
        text-decoration: none !important;
        display: flex;
    }
    .chat-item:hover {
        background-color: #f8f9fa;
    }
    .chat-item.bg-selected {
        background-color: #f0f4ff;
        border-left: 4px solid #4634ff;
    }
    .decoration-none {
        text-decoration: none;
    }
    .fs-12 {
        font-size: 12px;
    }
    .avatar-wrapper img {
        background: #eee;
    }
    .conversation-list::-webkit-scrollbar {
        width: 5px;
    }
    .conversation-list::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 10px;
    }
</style>
@endpush