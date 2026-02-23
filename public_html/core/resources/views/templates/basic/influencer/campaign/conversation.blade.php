@extends($activeTemplate . 'layouts.master')
@php
    $fullWidth = true;
    $brandId = (auth()->guard('influencer')->check()) ? $participant->campaign->user_id : auth()->id();
    $influencerId = (auth()->guard('influencer')->check()) ? authInfluencerId() : $participant->influencer_id;

    // Logic for filtering related jobs into tabs
    $inquiryJobs = $relatedJobs->filter(function($job) {
        return in_array($job->status, [
            Status::PARTICIPATE_REQUEST_PENDING, 
            Status::PARTICIPATE_INQUIRY, 
            Status::PARTICIPATE_PROPOSAL
        ]);
    });
    $activeJobs = $relatedJobs->filter(function($job) {
        return in_array($job->status, [
            Status::PARTICIPATE_REQUEST_ACCEPTED, 
            Status::CAMPAIGN_JOB_DELIVERED, 
            Status::CAMPAIGN_JOB_REPORTED
        ]);
    });
    $completedJobs = $relatedJobs->filter(function($job) {
        return in_array($job->status, [
            Status::CAMPAIGN_JOB_COMPLETED, 
            Status::PARTICIPATE_REQUEST_REJECTED, 
            Status::CAMPAIGN_JOB_REFUNDED, 
            Status::CAMPAIGN_JOB_CANCELED
        ]);
    });

    // Default tab logic
    $activeTab = 'active';
    if ($inquiryJobs->where('id', $participant->id)->first()) {
        $activeTab = 'inquiry';
    } elseif ($completedJobs->where('id', $participant->id)->first()) {
        $activeTab = 'completed';
    }
    $isInquiry = ($activeTab == 'inquiry');
@endphp

@section('content')

<div class="container px-md-5 py-4">
    <div class="inbox">
        <div class="row justify-content-center gy-4">
        
                {{-- 1. LEFT SIDEBAR: Active Contracts Context --}}
        <div class="col-xxl-3 col-lg-4 d-none d-lg-block">
            <div class="card custom--card h-100 shadow-sm">
                <div class="card-header bg--base text-white">
                    <h5 class="m-0 text-white"><i class="las la-file-contract"></i> @lang('Contracts')</h5>
                </div>
                <div class="card-body p-0">
                    {{-- Tab Navigation --}}
                    <ul class="nav nav-tabs nav-tabs--custom border-bottom bg-light" id="inboxTab" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 py-3 small fw-bold {{ $activeTab == 'inquiry' ? 'active' : '' }}" id="inquiry-tab" data-bs-toggle="tab" data-bs-target="#inquiry" type="button" role="tab">@lang('Inquiry')</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 py-3 small fw-bold {{ $activeTab == 'active' ? 'active' : '' }}" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab">@lang('Active')</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 py-3 small fw-bold {{ $activeTab == 'completed' ? 'active' : '' }}" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">@lang('Closed')</button>
                        </li>
                    </ul>

                    {{-- Tab Content --}}
                    <div class="tab-content" id="inboxTabContent">
                        @foreach(['inquiry' => $inquiryJobs, 'active' => $activeJobs, 'completed' => $completedJobs] as $key => $jobs)
                            <div class="tab-pane fade {{ $activeTab == $key ? 'show active' : '' }}" id="{{ $key }}" role="tabpanel">
                                <div class="list-group list-group-flush scrollable-list" style="max-height: 650px; overflow-y: auto;">
                                    @forelse($jobs as $job)
                                        <a href="{{ auth()->guard('influencer')->check() ? route('influencer.campaign.conversation.inbox', $job->id) : route('user.participant.conversation.inbox', $job->id) }}" 
                                           class="list-group-item list-group-item-action {{ $job->id == $participant->id ? 'bg-light border-start border-4 border--base' : '' }} p-3">
                                            <div class="d-flex w-100 justify-content-between mb-1">
                                                <h6 class="mb-0 text-truncate" style="max-width: 150px;">{{ __($job->campaign->title) }}</h6>
                                                <small class="fw-bold text--base">{{ showAmount($job->budget) }}</small>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">{{ showDateTime($job->created_at, 'M d') }}</small>
                                                <div class="scale-75 origin-right">@php echo $job->statusBadge; @endphp</div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="p-4 text-center text-muted small">@lang('No items found in this category')</div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
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
                        <div class="alert alert-light border-bottom mb-0 p-2 text-center" style="font-size: 0.75rem; background-color: #f8f9fa; color: #6c757d;">
                            <i class="las la-shield-alt"></i> @lang('For your safety, never share sensitive information like passwords or credit card details. Do not open suspicious links.')
                        </div>
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
                            <form class="send__msg" id="messageForm" method="POST" enctype="multipart/form-data">
                                <div class="d-flex flex-wrap gap-3 mb-2 align-items-center">
                                    <div class="form-check form-switch m-0">
                                        <input class="form-check-input" type="checkbox" name="is_deliverable" id="isDeliverable" value="1">
                                        <label class="form-check-label small fw-bold text-primary" for="isDeliverable">
                                            <i class="las la-certificate"></i> @lang('Mark as Deliverable')
                                        </label>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <label class="small text-muted mb-0">@lang('Assign to'):</label>
                                        <span class="badge bg-light text-dark border py-1 px-2" style="font-size: 0.75rem; font-weight: 600;">
                                            {{ __($participant->campaign->title) }}
                                            </span>
                                            <input type="hidden" name="target_participant_id" value="{{ $participant->id }}">
                                        </div>
                                    </div>
                                <span class="file-count small text--base mb-1 d-block"></span>
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
                <div class="card custom--card mb-3 shadow-sm border--base">
                    <div class="card-header bg--base text-white d-flex justify-content-between align-items-center">
                        <h5 class="m-0 text-white">@lang('Job Management')</h5>
                        <div class="dropdown">
                        <button class="btn btn-sm btn-dark text--base dropdown-toggle py-1 px-2" type="button" data-bs-toggle="dropdown" style="font-size: 0.7rem;">
                            <i class="las la-filter"></i> @lang('View')
                        </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><a class="dropdown-item filter-files active" data-filter="all" href="javascript:void(0)">@lang('All Files')</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item filter-files" data-filter="deliverables" href="javascript:void(0)">@lang('Deliverables Only')</a></li>
                        <li><a class="dropdown-item filter-files" data-filter="completed" href="javascript:void(0)">@lang('Completed Jobs Files')</a></li>
                    </ul>
                </div>
            </div>
                        <div class="collapse show" id="galleryCollapse">
                            <div class="card-body bg-light border-bottom p-2">
                                <h6 class="tiny-label mb-2">@lang('SHARED FILES')</h6>
                                <div class="d-flex flex-wrap gap-2 file-gallery-container" style="max-height: 250px; overflow-y: auto;">
                                    @forelse($galleryAttachments as $file)
                                        @php
                                            $isCompleted = in_array($file->job_status, [
                                                Status::CAMPAIGN_JOB_COMPLETED,
                                                Status::PARTICIPATE_REQUEST_REJECTED,
                                                Status::CAMPAIGN_JOB_REFUNDED,
                                                Status::CAMPAIGN_JOB_CANCELED
                                            ]);
                                        @endphp
                                        <div class="position-relative file-item {{ $file->is_deliverable ? 'is-deliverable' : 'is-general' }} {{ $isCompleted ? 'is-completed-job' : 'is-active-job' }}">
                                            <a href="javascript:void(0)" onclick="locateMessage({{ $file->message_id }})"
                                               class="d-block border rounded bg-white text-center d-flex align-items-center justify-content-center"
                                               style="width: 65px; height: 65px; overflow: hidden;"
                                               title="{{ $file->original_name }}">
                                                @if($file->extension == 'link')
                                                    <span class="fs-4 text-primary"><i class="las la-link"></i></span>
                                                @elseif(in_array(strtolower($file->extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                    <img src="{{ getImage(getFilePath('conversation') . '/' . $file->filename) }}" class="w-100 h-100 object-fit-cover">
                                                @else
                                                    <span class="fs-4 text-muted">{{ strtoupper($file->extension) }}</span>
                                                @endif
                                            </a>

                            {{-- Badge logic remains same --}}
                                        @if($file->is_deliverable)
                                            <div class="position-absolute top-0 start-0 m-1">
                                                @if($file->approval_status == 0)
                                                    <span class="badge bg-warning p-1" style="font-size: 8px;" title="@lang('Pending Approval')"><i class="las la-clock"></i></span>
                                                @elseif($file->approval_status == 1)
                                                    <span class="badge bg-success p-1" style="font-size: 8px;" title="@lang('Approved')"><i class="las la-check"></i></span>
                                                @elseif($file->approval_status == 2)
                                                    <span class="badge bg-danger p-1" style="font-size: 8px;" title="@lang('Revision Requested')"><i class="las la-exclamation-circle"></i></span>
                                                @endif
                                            </div> 
                                        @endif
                                    </div>    
                                @empty
                                    <div class="w-100 text-center py-2 text-muted small">@lang('No files shared yet')</div>
                                @endforelse
                            </div>
                        </div>
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
                                    <div class="alert alert-primary border-0 py-3 px-3 small mb-3 shadow-sm text-start">
                                        <div class="d-flex align-items-start gap-2">
                                        <i class="las la-info-circle fs-4 mt-1"></i>
                                        <div>
                                        <span class="fw-bold d-block mb-1 text-primary"><i class="las la-info-circle"></i> @lang('Contract Active')</span>
                                        <span class="lh-base">
                                        @lang('Send your work in the chat below. Remember to check the "Mark as Deliverable" box to submit for approval.')
                                    </span>
                                </div>
                            </div>
                        </div>
                                @elseif ($participant->status == Status::CAMPAIGN_JOB_DELIVERED)
                                    <div class="alert alert-warning border-0 py-3 px-3 small mb-3 shadow-sm text-start">
                                        <i class="las la-info-circle fs-4 mt-1"></i>
                                        <div>
                                        <span class="fw-bold d-block mb-1 text-warning">@lang('Work Delivered')</span>
                                        <span class="lh-base">
                                        @lang('Waiting for the brand to review and approve your deliverables. You can still send messages or updates below.')
                                        </span>
                                    </div>
                                </div>
                            </div>

                                @endif
                                <button type="button" class="btn btn--base w-100" data-bs-toggle="modal" data-bs-target="#proposalModal">
                                    <i class="las la-file-invoice-dollar"></i> @lang('Upsell / New Offer')
                                </button>
                                {{-- CLOSE INQUIRY BUTTON --}}
                                @if($participant->status == Status::PARTICIPATE_INQUIRY)
                                    <button class="btn btn-dark w-100 mt-2 confirmationBtn" 
                                            data-question="@lang('Are you sure you want to close this inquiry? It will be moved to Closed/Archived.')" 
                                            data-action="{{ route('influencer.campaign.close.inquiry', $participant->id) }}">
                                        <i class="las la-times-circle"></i> @lang('Close Inquiry')
                                    </button>
                                @endif
                            @else
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
                @if(!$isInquiry && $participant->status != Status::PARTICIPATE_INQUIRY)
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
                                <a href="{{ route('influencer.campaign.detail', $participant->id) }}" class="text--base fw-bold">
                                    <i class="las la-external-link-alt"></i> @lang('Full Brief')
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                @endif
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

@push('style')
<style>
    .px-md-5 { padding-left: 3rem !important; padding-right: 3rem !important; }
    .tiny-label { font-size: 10px; font-weight: 800; color: #999; letter-spacing: 1px; }
    .sticky-sidebar { position: sticky; top: 20px; }
    .bg--dark { background-color: #111 !important; }
    .scrollable-list::-webkit-scrollbar { width: 4px; }
    .scrollable-list::-webkit-scrollbar-thumb { background: #eee; border-radius: 10px; }
    .chat__msg-body::-webkit-scrollbar { width: 4px; }
    .chat__msg-body::-webkit-scrollbar-thumb { background: #eee; }
    .nav-tabs--custom .nav-link { color: #666; border-radius: 0; border: none; border-bottom: 2px solid transparent; }
    .nav-tabs--custom .nav-link.active { color: #000; border-bottom: 2px solid #37f; background: transparent; }
    .chat__msg-body { background: #f8f9fa; }
    .msg__wrapper { list-style: none; padding: 10px; display: flex; flex-direction: column; gap: 10px; }
    .outgoing__msg { align-self: flex-end; width: 90%; justify-content: flex-end; }
    .incoming__msg { align-self: flex-start; width: 90%; justify-content: flex-start; }
    .msg__item { max-width: 80%; }
    .comment-date { font-size: 0.65rem; opacity: 0.7; }
</style>
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

             $(".messageVal").on('keypress', function(e) {
                if (e.which == 13 && !e.shiftKey) {
                    e.preventDefault();
                    $("#messageForm").submit();
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
            }

            $('.filter-files').on('click', function() {
                $('.filter-files').removeClass('active text--base fw-bold');
                $(this).addClass('active text--base fw-bold');
    
                let filter = $(this).data('filter');
                $('.file-item').hide();

                if(filter == 'deliverables') {
                    $('.file-item.is-deliverable.is-active-job').fadeIn(200);
                } else if(filter == 'completed') {
                    $('.file-item.is-completed-job').fadeIn(200);
                } else {
                    $('.file-item.is-active-job').fadeIn(200);
                }
            });

            let isSending = false;
            $("#messageForm").on('submit', function(e) {
                e.preventDefault();
                if(isSending) return;
                isSending = true;
                var formData = new FormData($(this)[0]);
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
                            isSending = false;
                        } else {
                            $('#messageForm')[0].reset();
                            
                            // Parse HTML safely to find the list item and its ID
                            let tempDiv = $('<div>').html(response.html);
                            let newMsg = tempDiv.find('li');
                            
                            if (newMsg.length > 0) {
                                let msgId = newMsg.attr('id');
                                if (msgId && $("#" + msgId).length === 0) {
                                    $("#message").append(newMsg);
                                }
                            }
                            
                            lastMessageId = response.lastId; 
                            isSending = false;
                            $('.file-count').text('');
                            scrollHeight();
                        }
                    },
                    error: function() { isSending = false; }
                });
            });

            window.locateMessage = function(id) {
                $('.message-loader-wrapper').fadeIn();
                $.ajax({
                    method: "GET",
                    data: { 
                        participant_id: "{{ $participant->id }}", 
                        locate_id: id 
                    },
                    url: "{{ auth()->guard('influencer')->check() ? route('influencer.campaign.conversation.view.message') : route('user.participant.conversation.view.message') }}",
                    success: function(response) {
                        if(response.html) { 
                            $("#message").html(response.html);
                            setTimeout(() => {
                                let target = $("#msg-" + id);
                                if(target.length) {
                                    target[0].scrollIntoView({behavior: "smooth", block: "center"});
                                    target.addClass("bg-warning bg-opacity-25");
                                    setTimeout(() => target.removeClass("bg-warning bg-opacity-25"), 2000);
                                }
                            }, 500);
                        }
                        $('.message-loader-wrapper').fadeOut();
                    }
                });
            };

                let lastMessageId = "{{ $lastId }}";

    function fetchNewMessages() {
        if(isSending) return;
        $.ajax({
            method: "GET",
            data: { 
                participant_id: "{{ $participant->id }}", 
                last_id: lastMessageId 
            },
            url: "{{ auth()->guard('influencer')->check() ? route('influencer.campaign.conversation.view.message') : route('user.participant.conversation.view.message') }}",
            success: function(response) {
                if(response.html && response.html.trim() !== '') {
                    // Create a temporary element to parse the HTML
                    let newMessages = $('<div>').append(response.html).find('li');
                    
                    newMessages.each(function() {
                        let msgId = $(this).attr('id');
                        // ONLY append if the message ID doesn't already exist on the page
                        if (msgId && $("#" + msgId).length === 0) {
                            $("#message").append(this);
                        }
                    });

                    lastMessageId = response.last_id;
                    scrollHeight();
                }
            }
        });
    }

    setInterval(fetchNewMessages, 5000);

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

