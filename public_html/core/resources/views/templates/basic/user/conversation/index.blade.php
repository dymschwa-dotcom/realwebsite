@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="card b-radius--10 overflow-hidden shadow-sm">
    <div class="card-body p-0">
        <div class="row g-0" style="min-height: 700px;">
            {{-- Left Side: Sidebar --}}
            <div class="col-xl-4 col-lg-5 border-end">
                <div class="chat-sidebar">
                    <div class="p-3 border-bottom bg-light">
                        <h5 class="m-0 fw-bold">@lang('Influencer Messages')</h5>
                    </div>
                    
                    <div class="conversation-list overflow-auto" style="max-height: 650px;">
                        @forelse($conversations as $conversation)
                            <a href="{{ route('user.conversation.view', $conversation->id) }}" 
                               class="d-flex align-items-center p-3 border-bottom decoration-none chat-item">
                                
                                <div class="avatar-wrapper position-relative">
                                    <img src="{{ getImage(getFilePath('influencer') . '/' . $conversation->influencer->image, getFileSize('influencer')) }}" 
                                         class="rounded-circle border" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                </div>

                                <div class="ms-3 overflow-hidden flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="text-dark fw-bold mb-0 text-truncate">{{ __($conversation->influencer->fullname) }}</h6>
                                        <small class="text-muted fs-12">{{ diffForHumans($conversation->updated_at) }}</small>
                                    </div>
                                    <p class="text-muted small mb-0 text-truncate">
                                        @if($conversation->lastMessage)
                                            {{ $conversation->lastMessage->sender_type == 'user' ? 'You: ' : '' }}{{ Str::limit($conversation->lastMessage->message, 45) }}
                                        @else
                                            @lang('No messages yet')
                                        @endif
                                    </p>
                                </div>
                            </a>
                        @empty
                            <div class="text-center p-5">
                                <i class="las la-envelope-open text-muted" style="font-size: 3rem;"></i>
                                <p class="mt-2 text-muted">@lang('You haven\'t started any conversations yet.')</p>
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

            {{-- Right Side: Placeholder --}}
            <div class="col-xl-8 col-lg-7 d-none d-lg-flex align-items-center justify-content-center bg-light">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="las la-comment-dots text-muted" style="font-size: 5rem;"></i>
                    </div>
                    <h4 class="fw-bold">@lang('Select a Conversation')</h4>
                    <p class="text-muted">@lang('Choose an influencer to start negotiating your next campaign.')</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .chat-item { transition: all 0.2s ease; text-decoration: none !important; }
    .chat-item:hover { background-color: #f8f9fa; }
    .decoration-none { text-decoration: none; }
    .fs-12 { font-size: 12px; }
</style>
@endpush