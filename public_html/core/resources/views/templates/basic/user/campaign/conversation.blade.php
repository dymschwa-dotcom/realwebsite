@extends($activeTemplate . 'layouts.master')

@php
    $fullWidth = true;
@endphp

@section('content')
@php
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

{{-- Main Container with side margins --}}
<div class="container px-md-5 py-4">
    <div class="inbox">
        <div class="row justify-content-center gy-4">
            
            {{-- LEFT COLUMN: Contract Tabs --}}
<div class="col-xxl-3 col-lg-4 col-12">
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
                                <a href="{{ route('user.participant.conversation.inbox', $job->id) }}" class="list-group-item list-group-item-action {{ $job->id == $participant->id ? 'bg-light border-start border-4 border--base' : '' }} p-3">
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
            <a href="{{ route('user.home') }}" class="btn btn--base outline w-100 btn--sm">
                <i class="las la-arrow-left"></i> @lang('Back to Dashboard')
            </a>
        </div>
    </div>
</div>

            {{-- CENTER COLUMN: Chat Interface --}}
            <div class="col-xxl-6 col-lg-8 col-12">
                <div class="card custom--card h-100 shadow-sm">
                    <div class="card-body p-0">
                        <div class="chat__msg">
                            <div class="alert alert-light border-bottom mb-0 p-2 text-center" style="font-size: 0.75rem; background-color: #f8f9fa; color: #6c757d;">
                                <i class="las la-shield-alt"></i> @lang('For your safety, never share sensitive information like passwords or credit card details. Do not open suspicious links.')
                            </div>
                            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white sticky-top">
                                <div>
                                    <h5 class="mb-0 text-dark">{{ __(@$influencer->fullname) }}</h5>
                                    <small class="{{ $influencer->isOnline() ? 'text--success' : 'text-muted' }}">
                                        <i class="las la-circle"></i> {{ $influencer->isOnline() ? __('Online') : __('Offline') }}
                                    </small>
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

                                                                                                                @if ($participant->status != Status::PARTICIPATE_REQUEST_REJECTED)
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Job Management --}}
            <div class="col-xxl-3 col-12">
                <div class="sticky-sidebar">
                    <div class="card custom--card mb-3 shadow-sm border--base">
                        <div class="card-header bg--base text-white d-flex justify-content-between align-items-center">
                            <h5 class="m-0 text-white">@lang('Order Management')</h5>
                            <div class="dropdown">
                            <button class="btn btn-sm btn-dark text--base dropdown-toggle py-1 px-2" type="button" data-bs-toggle="dropdown" style="font-size: 0.7rem;">
                                <i class="las la-images"></i> @lang('Files')
                            </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item filter-files active" data-filter="all" href="javascript:void(0)">@lang('All Files')</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item filter-files" data-filter="completed" href="javascript:void(0)">@lang('Completed Jobs Files')</a></li><li><a class="dropdown-item filter-files" data-filter="deliverables" href="javascript:void(0)">@lang('Deliverables Only')</a></li>
                        </ul>
                    </div>
                </div>

                    {{-- DELIVERABLES GALLERY --}}
                    <div class="collapse show" id="galleryCollapse">
                        <div class="card-body bg-light border-bottom p-2">
                            <h6 class="tiny-label mb-2">@lang('SHARED FILES')</h6>
                            <div class="d-flex flex-wrap gap-2" style="max-height: 250px; overflow-y: auto;">
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
                                        class="d-block border rounded bg-white text-center d-flex align-items-center justify-content-center text-decoration-none"
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

                                            {{-- Brand Controls --}}
                                            @if($file->approval_status == 0)
                                                <div class="mt-1 d-flex gap-1 justify-content-center">
                                                    <button class="btn btn--success btn--xxs approveBtn" data-id="{{ $file->message_id }}" title="@lang('Approve')"><i class="las la-check"></i></button>
                                                    <button class="btn btn--danger btn--xxs rejectBtn" data-id="{{ $file->message_id }}" title="@lang('Request Revision')"><i class="las la-times"></i></button>
                            </div>
                                @endif
                                @endif
                                    </div>
                                @empty
                                    <div class="w-100 text-center py-2 text-muted small">@lang('No files shared yet')</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        @if(!$isInquiry)
                        <div class="mb-3">
                    <h6 class="fw-bold mb-1">{{ __($participant->campaign->title) }}</h6>
                    <p class="small text-muted mb-0 lh-base">{{ Str::limit(__($participant->campaign->description), 100) }}</p>
                </div>
                @endif
                
                <div class="text-center bg-light rounded-3 p-3 mb-4">
                    <span class="tiny-label d-block mb-1 text-muted fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">@lang('TOTAL BUDGET')</span>
                    <h3 class="text--base fw-bold mb-1">{{ showAmount($participant->budget) }}</h3>
                    <div class="scale-90">
                        @php echo $participant->statusBadge; @endphp
                    </div>
                </div>

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
                                 @php
                                    $hasApprovedDeliverable = $galleryAttachments->where('is_deliverable', true)
                                        ->where('approval_status', 1)
                                        ->where('participant_id', $participant->id) // Add this filter
                                        ->first();
                                @endphp
                                
                                @if ($participant->status == Status::CAMPAIGN_JOB_DELIVERED)
                                    @if($hasApprovedDeliverable)
                                <div class="d-grid gap-2">
                                    <button class="btn btn--success confirmationBtn w-100 fw-bold"
                                            data-question="@lang('Approve this work and release funds to the influencer?')"
                                            data-action="{{ route('user.participant.completed', $participant->id) }}">
                                        <i class="las la-check-circle"></i> @lang('Approve & Pay')
                                    </button>
                                    @else
                                {{-- Instruction Alert --}}
                                <div class="alert alert-info border-0 py-3 px-3 small mb-0 shadow-sm text-start">
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="las la-info-circle fs-4 mt-1"></i>
                                        <div>
                                            <span class="fw-bold d-block mb-1">@lang('Review Required')</span>
                                            <span class="lh-base">
                                                @lang('Please review and approve a deliverable in the "Shared Files" gallery above to enable the final payment button.')
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                                {{-- Report Issue (Always available as a failsafe once work is delivered) --}}
                                    <button class="btn btn-danger report-btn w-100 border-0 fw-bold mt-3" type="button">
                                        <i class="las la-gavel"></i> @lang('Report Issue')
                                    </button>
                                </div>
                            
                                @elseif ($participant->status == Status::PARTICIPATE_PROPOSAL)
                                    <form action="{{ route('user.participant.conversation.accept.proposal', $participant->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn--base w-100 fw-bold">
                                            <i class="las la-check"></i> @lang('Accept & Hire')
                                        </button>
                                    </form>
                                @endif

                                {{-- CLOSE INQUIRY BUTTON FOR BRANDS --}}
                                @if($participant->status == Status::PARTICIPATE_INQUIRY)
                                    <button class="btn btn-dark w-100 mt-2 confirmationBtn" 
                                            data-question="@lang('Are you sure you want to close this inquiry? It will be moved to Closed/Archived.')" 
                                            data-action="{{ route('user.participant.close.inquiry', $participant->id) }}">
                                        <i class="las la-times-circle"></i> @lang('Close Inquiry')
                                    </button>
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
                                <a href="{{ route('user.participant.detail', $participant->id) }}" class="text--base fw-bold">
                                    <i class="las la-file-alt"></i> @lang('Full Brief')
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                @endif

                {{-- Pending Proposals Detection (New Custom Offers) --}}
                @php
                    $pendingProposal = \App\Models\Participant::where('influencer_id', $participant->influencer_id)
                        ->where('status', Status::PARTICIPATE_PROPOSAL)
                        ->whereHas('campaign', function($q) use ($participant) {
                            $q->where('user_id', $participant->campaign->user_id);
                        })->latest()->first();
                @endphp

                @if ($pendingProposal && $participant->status != Status::PARTICIPATE_PROPOSAL)
                    <div class="card custom--card mt-3 border--warning shadow-sm">
                        <div class="card-header bg--warning py-2">
                            <h6 class="m-0 text-white small">@lang('Pending Custom Offer')</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small fw-bold"><a href="{{ route('user.participant.detail', $pendingProposal->id) }}" class="text--base">{{ Str::limit($pendingProposal->campaign->title, 20) }} <i class="las la-external-link-alt"></i></a></span>
                                <span class="text--base fw-bold small">{{ showAmount($pendingProposal->budget) }}</span>
                            </div>
                            <div class="d-grid gap-2">
                                <form action="{{ route('user.participant.conversation.accept.proposal', $pendingProposal->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn--success btn--sm w-100">@lang('Accept Offer')</button>
                                </form>
                                <form action="{{ route('user.participant.conversation.reject.proposal', $pendingProposal->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn--sm w-100">@lang('Decline Offer')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


{{-- Modals --}}
@push('modal')
<div class="modal fade" id="reportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white">@lang('Report Order')</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('user.participant.reported', $participant->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="fw-bold mb-2">@lang('Why are you reporting this work?')</label>
                        <textarea class="form-control" name="report_reason" rows="4" placeholder="@lang('Describe the issue in detail...')" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn--dark px-4" data-bs-dismiss="modal">@lang('Cancel')</button>
                    <button type="submit" class="btn btn--danger px-4">@lang('Submit Report')</button>
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

        let isSending = false;
        let lastMessageId = "{{ $lastId }}"; 

        function scrollHeight() {
            var chatBody = $('.chat__msg-body');
            if(chatBody.length > 0) {
                chatBody.scrollTop(chatBody[0].scrollHeight);
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

        function loadMore(count) {
            $('.message-loader-wrapper').fadeIn();
            $.ajax({
                method: "GET",
                data: { participant_id: "{{ $participant->id }}", messageCount: count },
                url: "{{ route('user.participant.conversation.view.message') }}",
                success: function(response) {
                    if(response.html) { $("#message").html(response.html); }
                    $('.message-loader-wrapper').fadeOut();
                }
            });
        }
        
        $(".messageVal").on('keypress', function(e) {
            if (e.which == 13 && !e.shiftKey) {
                e.preventDefault();
                $("#messageForm").submit();
            }
        });

        $("#messageForm").on('submit', function(e) {
            e.preventDefault();
            if(isSending) return;
            isSending = true;
            var formData = new FormData($(this)[0]);
            $.ajax({
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                url: "{{ route('user.participant.conversation.send.message', $participant->id) }}",
                method: "POST",
                data: formData,
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
                        $('.file-count').text('');
                        scrollHeight();
                    }
                    isSending = false; 
                },
                error: function() { isSending = false; }
            });
        });

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

        $('.confirmationBtn').on('click', function() {
            var modal = $('#confirmationModal');
            let data = $(this).data();
            modal.find('.question').text(`${data.question}`);
            modal.find('form').attr('action', `${data.action}`);
            modal.modal('show');
        });

        $('.report-btn').on('click', function() {
            $('#reportModal').modal('show');
        });

        window.locateMessage = function(id) {
            $('.message-loader-wrapper').fadeIn();
            $.ajax({
                method: "GET",
                data: { participant_id: "{{ $participant->id }}", locate_id: id },
                url: "{{ route('user.participant.conversation.view.message') }}",
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

    function fetchNewMessages() {
        if(isSending) return;

        $.ajax({
            method: "GET",
            data: { 
                participant_id: "{{ $participant->id }}", 
                last_id: lastMessageId 
            },
            url: "{{ route('user.participant.conversation.view.message') }}",
            success: function(response) {
                if(response.html && response.html.trim() !== '') {
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

    // Poll every 5 seconds
    setInterval(fetchNewMessages, 5000);

        // Deliverable Approval
        $('.approveBtn').on('click', function() {
            let id = $(this).data('id');
            if(confirm("@lang('Are you sure you want to approve this deliverable?')")) {
                $.post("{{ route('user.participant.conversation.deliverable.approve') }}", {
                    _token: "{{ csrf_token() }}",
                    message_id: id
                }, function(res) {
                    if(res.success) {
                        notify('success', res.message);
                        location.reload();
                    } else {
                        notify('error', res.error);
                    }
                });
            }
        });

        $('.rejectBtn').on('click', function() {
            let id = $(this).data('id');
            let reason = prompt("@lang('Please enter the reason for revision request:')");
            if(reason) {
                $.post("{{ route('user.participant.conversation.deliverable.reject') }}", {
                    _token: "{{ csrf_token() }}",
                    message_id: id,
                    reason: reason
                }, function(res) {
                    if(res.success) {
                        notify('success', res.message);
                        location.reload();
                    } else {
                        notify('error', res.error);
                    }
                });
            }
        });
    })(jQuery);
</script>
@endpush
@endsection

