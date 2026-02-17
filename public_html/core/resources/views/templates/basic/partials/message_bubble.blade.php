@php
    // Explicitly determine the current viewer's identity
    $currInfluencer = auth()->guard('influencer')->user();
    $currBrand = auth()->user();

    $isSender = false;

    if ($currInfluencer && $message->sender_type == 'influencer' && $message->sender_id == $currInfluencer->id) {
        $isSender = true;
    } elseif ($currBrand && $message->sender_type == 'user' && $message->sender_id == $currBrand->id) {
        $isSender = true;
    }
@endphp

<div class="mb-3 d-flex {{ $isSender ? 'justify-content-end' : 'justify-content-start' }}">
    <div class="message-bubble p-3 rounded-3 shadow-sm {{ $isSender ? 'bg--primary text-white' : 'bg-white text-dark' }}" 
         style="max-width: 80%; min-width: 280px; border: 1px solid #e9ecef; position: relative;">
        
        @if($message->type == 'contract_proposal')
            {{-- NEW: Influencer's Custom Package / Contract Card --}}
            <div class="contract-proposal-wrapper">
                <div class="d-flex align-items-center mb-2 pb-2 border-bottom {{ $isSender ? 'border-white-50' : 'border-secondary' }}">
                    <i class="las la-file-contract fs-4 me-2 text-warning"></i>
                    <h6 class="m-0 {{ $isSender ? 'text-white' : 'text-dark' }}">@lang('Project Proposal')</h6>
                </div>
                
                <div class="p-2 mb-3 rounded {{ $isSender ? 'bg-white text-dark' : 'bg-light' }} border text-center">
                    <p class="small mb-1 fw-bold text-muted text-uppercase">@lang('Proposal Title')</p>
                    <h6 class="mb-2 text--base">{{ __($message->title ?? $message->message) }}</h6>
                    
                    <p class="small mb-1 fw-bold text-muted text-uppercase">@lang('Budget')</p>
                    <h5 class="m-0 text-success">
                        {{ gs('cur_sym') }}{{ showAmount($message->participant?->budget ?? 0) }}
                    </h5>
                </div>

                <div class="d-flex flex-column gap-2">
                    {{-- IF VIEWER IS BRAND: Show Action Buttons --}}
                    @if($currBrand && $message->sender_type == 'influencer')
                        @if($message->participant?->status == 0) {{-- Status: Pending --}}
                            <div class="d-flex gap-2">
                                <button onclick="updateProposalStatus({{ $message->participant->id }}, 'accept')" class="btn btn-sm btn-success flex-grow-1 fw-bold">
                                    <i class="las la-check"></i> @lang('Accept')
                                </button>
                                <button onclick="updateProposalStatus({{ $message->participant->id }}, 'reject')" class="btn btn-sm btn-outline-danger flex-grow-1">
                                    @lang('Reject')
                                </button>
                            </div>
                        @elseif($message->participant?->status == 1)
                            <div class="badge bg-success w-100 p-2 py-2"><i class="las la-check-circle"></i> @lang('Contract Active')</div>
                        @elseif($message->participant?->status == 3)
                            <div class="badge bg-danger w-100 p-2 py-2"><i class="las la-times-circle"></i> @lang('Proposal Rejected')</div>
                        @endif

                    {{-- IF VIEWER IS INFLUENCER: Show Status Only --}}
                    @else
                        <div class="text-center">
                            @if($message->participant?->status == 0)
                                <span class="badge bg-warning text-dark w-100 p-2 py-2">
                                    <i class="las la-clock"></i> @lang('Pending Brand Approval')
                                </span>
                            @elseif($message->participant?->status == 1)
                                <span class="badge bg-success w-100 p-2 py-2">
                                    <i class="las la-check-double"></i> @lang('Proposal Accepted')
                                </span>
                            @elseif($message->participant?->status == 3)
                                <span class="badge bg-danger w-100 p-2 py-2">
                                    <i class="las la-times"></i> @lang('Proposal Declined')
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

        @elseif($message->type == 'campaign_invite' && $message->campaign)
            {{-- Existing Campaign Invite Card --}}
            <div class="campaign-invite-wrapper">
                <div class="d-flex align-items-center mb-2 pb-2 border-bottom {{ $isSender ? 'border-white-50' : 'border-secondary' }}">
                    <i class="las la-handshake fs-4 me-2 text-warning"></i>
                    <h6 class="m-0 {{ $isSender ? 'text-white' : 'text-dark' }}">@lang('Campaign Invitation')</h6>
                </div>
                
                <div class="p-2 mb-3 rounded {{ $isSender ? 'bg-white text-dark' : 'bg-light' }} border text-center">
                    <h6 class="mb-1 text--base">{{ __($message->campaign->title) }}</h6>
                    <h5 class="m-0 text-success">{{ gs('cur_sym') }}{{ showAmount($message->campaign->budget) }}</h5>
                </div>

                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('user.campaign.detail', $message->campaign->slug) }}" 
                       class="btn btn-sm {{ $isSender ? 'btn--dark' : 'btn--base' }} w-100 fw-bold">
                        <i class="las la-info-circle"></i> @lang('View Details')
                    </a>

                    @if($message->campaign->status == 0 && auth()->guard('influencer')->check() && $message->sender_type == 'user')
                        <div class="d-flex gap-2">
                            <button onclick="updateProposalStatus({{ $message->campaign->id }}, 'accept')" class="btn btn-sm btn-success flex-grow-1">@lang('Accept')</button>
                            <button onclick="updateProposalStatus({{ $message->campaign->id }}, 'reject')" class="btn btn-sm btn-danger flex-grow-1">@lang('Reject')</button>
                        </div>
                    @endif
                </div>
            </div>

        @else
            {{-- Standard Text Message & Attachments --}}
            <div class="message-content">
                <p class="mb-2" style="white-space: pre-wrap;">{{ __($message->message) }}</p>

                @if($message->attachment)
                    <div class="p-2 rounded bg-light text-dark d-flex align-items-center justify-content-between border mt-2">
                        <div class="overflow-hidden d-flex align-items-center">
                            <i class="las la-paperclip text-primary fs-5 me-2"></i>
                            <span class="small text-truncate" style="max-width: 150px;">
                                {{ $message->original_filename ?? 'Attachment' }}
                            </span>
                        </div>
                        <a href="{{ route(auth()->guard('influencer')->check() ? 'influencer.conversation.download' : 'user.conversation.download', $message->attachment) }}" 
                           class="btn btn-sm btn--primary py-1 px-2 ms-2">
                            <i class="las la-download"></i>
                        </a>
                    </div>
                @endif
            </div>
        @endif

        {{-- Footer: Time & Status --}}
        <div class="d-flex justify-content-between align-items-center mt-2 border-top {{ $isSender ? 'border-white-50' : 'border-light' }} pt-1">
            <small class="opacity-75" style="font-size: 10px;">{{ showDateTime($message->created_at, 'h:i A') }}</small>
            @if($isSender)
                <i class="las {{ $message->is_read ? 'la-check-double text-info' : 'la-check text-white-50' }}" style="font-size: 12px;"></i>
            @endif
        </div>
    </div>
</div>