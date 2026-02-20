@extends($activeTemplate . 'layouts.master')
@php
    $fullWidth = true;
    $brandId = (auth()->guard('influencer')->check()) ? $participant->campaign->user_id : auth()->id();
    $influencerId = (auth()->guard('influencer')->check()) ? authInfluencerId() : $participant->influencer_id;
@endphp

@section('content')
<div class="inbox">
    <div class="row justify-content-center gy-4">
        
        {{-- 1. LEFT SIDEBAR: Active Contracts Context --}}
        <div class="col-xxl-3 col-lg-4 d-none d-lg-block">
            <div class="card custom--card h-100 shadow-sm">
                <div class="card-header bg--base text-white">
                    <h5 class="m-0 text-white">@lang('Brand Contracts')</h5>
                </div>
                <div class="list-group list-group-flush scrollable-list" style="max-height: 750px; overflow-y: auto;">
                    @forelse($relatedJobs as $job)
                        <a href="{{ auth()->guard('influencer')->check() ? route('influencer.campaign.conversation.inbox', $job->id) : route('user.participant.conversation.inbox', $job->id) }}" 
                           class="list-group-item list-group-item-action {{ $job->id == $participant->id ? 'bg-light border-start border-4 border--base' : '' }} p-3">
                            <div class="d-flex w-100 justify-content-between mb-1">
                                <h6 class="mb-0 text-truncate" style="max-width: 140px;">{{ __($job->campaign->title) }}</h6>
                                <small class="fw-bold text--base">{{ showAmount($job->budget) }}</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ showDateTime($job->created_at, 'M d') }}</small>
                                <div class="scale-75 origin-right">@php echo $job->statusBadge; @endphp</div>
                            </div>
                        </a>
                    @empty
                        <div class="p-3 text-center text-muted">@lang('No other active jobs.')</div>
                    @endforelse
                </div>
                <div class="card-footer p-3">
                    @if(auth()->guard('influencer')->check())
                        <a href="{{ route('influencer.campaign.log') }}" class="btn btn--base outline w-100 btn--sm">
                            <i class="las la-arrow-left"></i> @lang('Back to Campaigns')
                        </a>
                    @else
                        <a href="{{ route('user.campaign.index') }}" class="btn btn--base outline w-100 btn--sm">
                            <i class="las la-arrow-left"></i> @lang('Back to Dashboard')
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- 2. CENTER: Chat Interface --}}
        <div class="col-xxl-6 col-lg-8 col-12">
            <div class="card custom--card h-100 shadow-sm">
                <div class="card-body p-0">
                    <div class="chat__msg">
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white sticky-top">
                            <div class="d-flex align-items-center gap-3">
                                <div class="chat-user-info">
                                    <h5 class="mb-0">{{ __(@$user->brand_name ?? $user->username) }}</h5>
                                    <small class="{{ $user->isOnline() ? 'text--success' : 'text-muted' }}">
                                        <i class="las la-circle"></i> {{ $user->isOnline() ? __('Online') : __('Offline') }}
                                    </small>
                                </div>
                            </div>
                            <button class="btn btn--base outline btn--sm reloadBtn"><i class="las la-sync"></i></button>
                        </div>

                        <div class="chat__msg-body position-relative p-3" style="height: 550px;">
                            <div class="message-loader-wrapper">
                                <div class="message-loader mx-auto"></div>
                            </div>
                            <ul class="msg__wrapper" id="message">
                                @include($activeTemplate . 'conversation.messages')
                            </ul>
                        </div>

                        <div class="chat__msg-footer p-3 border-top bg-white">
                            <span class="file-count small text--base mb-1 d-block"></span>
                            <form class="send__msg" id="messageForm" method="POST" enctype="multipart/form-data">
                                <div class="input-group">
                                    <div class="input-group-text border-0 pe-0 bg-transparent">
                                        <label class="text--base cursor-pointer" for="upload-file"><i class="las la-paperclip fs-4"></i></label>
                                        <input class="form-control d-none" id="upload-file" name="attachments[]" type="file" multiple>
                                    </div>
                                    <textarea class="form-control form--control messageVal border-0" name="message" placeholder="@lang('Write Message')..." rows="1"></textarea>
                                    <div class="input-group-text border-0 pe-1 bg-transparent">
                                        <button class="send-btn bg--base text-white rounded-circle" type="submit" style="width: 40px; height: 40px;"><i class="las la-paper-plane"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. RIGHT SIDEBAR: Action Hub --}}
        <div class="col-xxl-3 col-12">
            <div class="sticky-sidebar">
                {{-- Main Job Status Card --}}
                <div class="card custom--card mb-3 shadow-sm border--base">
                    <div class="card-header bg--base text-white">
                        <h5 class="m-0 text-white">@lang('Job Management')</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <span class="tiny-label">@lang('FEE')</span>
                            <h3 class="text--base mb-1">{{ showAmount($participant->budget) }}</h3>
                            @php echo $participant->statusBadge; @endphp
                        </div>

                        <div class="d-grid gap-2">
                            @if(auth()->guard('influencer')->check())
                                {{-- Influencer Specific Actions --}}
                                @if ($participant->status == Status::PARTICIPATE_REQUEST_ACCEPTED)
                                    <button class="btn btn--success confirmationBtn w-100" 
                                            data-question="@lang('Ready to deliver the final work to the brand?')" 
                                            data-action="{{ route('influencer.campaign.deliver', $participant->id) }}">
                                        <i class="las la-check-circle"></i> @lang('Deliver Work Now')
                                    </button>
                                @endif


                                                                <button type="button" class="btn btn--base w-100" data-bs-toggle="modal" data-bs-target="#proposalModal">
                                    <i class="las la-file-invoice-dollar"></i> @lang('Upsell / New Offer')
                                </button>
                            @else
                                {{-- Brand Specific Actions --}}
                                @if($participant->status == Status::PARTICIPATE_INQUIRY)
                                    <form action="{{ route('user.participant.hire.inquiry', $participant->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group mb-2">
                                            <input type="number" step="any" name="budget" class="form-control form--control" placeholder="@lang('Agreed Budget')" required>
                                        </div>
                                        <button type="submit" class="btn btn--base w-100">@lang('Hire & Deposit')</button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Quick Summary Card --}}
                <div class="card custom--card shadow-sm">
                    <div class="card-body p-3">
                        <h6 class="small fw-bold mb-2">@lang('Campaign Summary')</h6>
                        <p class="small text-muted mb-3">{{ Str::limit(__($participant->campaign->description), 100) }}</p>
                        
                        <ul class="list-group list-group-flush small">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>@lang('Deadline')</span>
                                <span class="fw-bold">{{ showDateTime($participant->campaign->end_date, 'd M, Y') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <a href="{{ route('influencer.campaign.view', $participant->id) }}" class="text--base fw-bold">
                                    <i class="las la-external-link-alt"></i> @lang('Full Brief')
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Pending Proposals Detection (New Custom Offers) --}}
                @php
                    $pendingProposal = \App\Models\Participant::where('influencer_id', $influencerId)
                        ->where('status', Status::PARTICIPATE_PROPOSAL)
                        ->whereHas('campaign', function($q) use ($brandId) {
                            $q->where('user_id', $brandId);
                        })->latest()->first();
                @endphp

                @if ($pendingProposal)
                    <div class="card custom--card mt-3 border--warning shadow-sm">
                        <div class="card-header bg--warning py-2">
                            <h6 class="m-0 text-white small">@lang('Pending Custom Offer')</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small fw-bold">{{ Str::limit($pendingProposal->campaign->title, 20) }}</span>
                                <span class="text--base fw-bold small">{{ showAmount($pendingProposal->budget) }}</span>
                            </div>
                            @if (!auth()->guard('influencer')->check())
                                <form action="{{ route('user.participant.conversation.accept.proposal', $pendingProposal->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn--success btn--sm w-100">@lang('Accept Offer')</button>
                                </form>
                            @else
                                <div class="badge bg--light text--warning border w-100">@lang('Awaiting Brand')</div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('modal')
<div class="modal fade" id="proposalModal" tabindex="-1" aria-labelledby="proposalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Send Custom Offer')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('influencer.campaign.conversation.send.proposal', $participant->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group mb-3">
                            <label>@lang('Offer Title')</label>
                            <input type="text" name="title" class="form-control form--control" placeholder="@lang('e.g. 2 Instagram Stories')" required>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label>@lang('Budget')</label>
                            <div class="input-group">
                                <input type="number" step="any" name="price" class="form-control form--control" required>
                                <span class="input-group-text bg--base text-white border-0">{{ gs('cur_text') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label>@lang('Delivery Time (Days)')</label>
                            <input type="number" name="delivery_time" class="form-control form--control" value="7" required>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label>@lang('Platform')</label>
                            <select name="platform_id" class="form-control form--control" required>
                                <option value="">@lang('Select One')</option>
                                @foreach(\App\Models\Platform::active()->get() as $platform)
                                    <option value="{{ $platform->id }}">{{ __($platform->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label>@lang('Post/Video Count')</label>
                            <input type="number" name="post_count" class="form-control form--control" value="1" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>@lang('Describe Deliverables')</label>
                            <textarea name="description" class="form-control form--control" rows="4" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--base w-100">@lang('Send Proposal')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<x-confirmation-modal custom="true" />
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            function scrollHeight() {
                var chatBody = $('.chat__msg-body');
                if(chatBody.length > 0) {
                    chatBody.animate({
                        scrollTop: chatBody[0].scrollHeight
                    });
                }
            }
            scrollHeight();

            $("#upload-file").on('change', function() {
                var fileCount = $(this)[0].files.length;
                $('.file-count').text(fileCount > 0 ? fileCount + ' file(s) selected' : '');
            });

            $(".reloadBtn").on('click', function() {
                loadMore(10);
            });

            var messageCount = 10;

            $(".chat__msg-body").on('scroll', function() {
                if ($(this).scrollTop() == 0) {
                    messageCount += 10;
                    loadMore(messageCount);
                }
            });

            function loadMore(count) {
                $('.message-loader-wrapper').fadeIn();
                $.ajax({
                    method: "GET",
                    data: {
                        participant_id: "{{ $participant->id }}",
                        messageCount: count
                    },
                    url: "{{ auth()->guard('influencer')->check() ? route('influencer.campaign.conversation.view.message') : route('user.participant.conversation.view.message') }}",
                    success: function(response) {
                        if(response.html) {
                            $("#message").html(response.html);
                        }
                        $('.message-loader-wrapper').fadeOut();
                    },
                    error: function() {
                         $('.message-loader-wrapper').fadeOut();
                    }
                });
                e.preventDefault();
                var formData = new FormData($(this)[0);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: "{{ auth()->guard('influencer')->check() ? route('influencer.campaign.conversation.send.message', $participant->id) : route('user.participant.conversation.send.message', $participant->id) }}",
                    method: "POST",
                    data: formData,
                    async: false,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.error) {
                            notify('error', response.error);
                        } else {
                            $('#messageForm')[0].reset();
                            $("#message").append(response.html);
                            $('.file-count').text('');
                            scrollHeight();
                        }
                    }
                });
            });

            $('.confirmationBtn').on('click', function() {
                var modal = $('#confirmationModal');
                let data = $(this).data();
                modal.find('.question').text(`${data.question}`);
                modal.find('form').attr('action', `${data.action}`);
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
