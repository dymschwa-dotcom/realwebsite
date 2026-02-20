@extends($activeTemplate . 'layouts.master')

@php
    $fullWidth = true;
@endphp

@section('content')
    <div class="inbox">
        <div class="row justify-content-center gy-4">
            
                                    {{-- LEFT SIDEBAR: Active Contracts Context --}}
            <div class="col-xxl-3 col-lg-4 d-none d-lg-block">
                <div class="card custom--card h-100">
                    <div class="card-header bg--base text-white">
                        <h5 class="m-0 text-white">@lang('Contracts')</h5>
                    </div>
                    <div class="list-group list-group-flush scrollable-list" style="max-height: 600px; overflow-y: auto;">
                        @foreach($relatedJobs as $job)
                            <a href="{{ route('user.participant.conversation.inbox', $job->id) }}" 
                               class="list-group-item list-group-item-action {{ $job->id == $participant->id ? 'active-job' : '' }} p-3">
                                <div class="d-flex w-100 justify-content-between mb-1">
                                    <h6 class="mb-0 text-truncate" style="max-width: 150px;">{{ __($job->campaign->title) }}</h6>
                                    <small class="fw-bold">{{ showAmount($job->budget) }}</small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ showDateTime($job->created_at, 'M d') }}</small>
                                    <div class="scale-75 origin-right">
                                        @php echo $job->statusBadge; @endphp
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="card-footer p-3">
                        <a href="{{ route('user.home') }}" class="btn btn--base outline w-100 btn--sm">
                            <i class="las la-arrow-left"></i> @lang('Back to Dashboard')
                        </a>
                    </div>
                </div>
            </div>

            {{-- CENTER: Chat Interface --}}
            <div class="col-xxl-6 col-lg-8 col-12">
                <div class="card custom--card h-100">
                    <div class="card-body">
                        <div class="chat__msg">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <div>
                                    <h5 class="mb-0">{{ __(@$influencer->fullname) }}</h5>
                                    @if ($influencer->status == Status::INFLUENCER_BAN)
                                        <span class="text--danger">@lang('Banned')</span>
                                    @else
                                        <small>
                                            @if ($influencer->isOnline())
                                                <span class="text--success">@lang('Online')</span>
                                            @else
                                                <span>@lang('Offline')</span>
                                            @endif
                                        </small>
                                    @endif
                                </div>
                                <button class="btn btn--base outline btn--sm reloadBtn"><i class="las la-sync"></i></button>
                            </div>
                            <div class="chat__msg-body position-relative">
                                <div class="message-loader-wrapper">
                                    <div class="message-loader mx-auto"></div>
                                </div>
                                <ul class="msg__wrapper mt-3" id="message">
                                    @if ($influencer)
                                        @include($activeTemplate . 'conversation.messages')
                                    @endif
                                </ul>
                            </div>
                                                        @if ($participant->status != Status::PARTICIPATE_REQUEST_REJECTED)
                                <div class="chat__msg-footer">
                                    <span class="file-count"></span>
                                    <form class="send__msg" id="messageForm" method="POST" enctype="multipart/form-data">
                                        <div class="input-group">
                                            <div class="input-group-text border-0 pe-0">
                                                <label class="text--base" for="upload-file"><i class="las la-paperclip"></i></label>
                                                <input class="form-control d-none" id="upload-file" name="attachments[]" type="file" accept=".png, .jpg, .jpeg, .pdf, .doc, .docx, .txt" multiple>
                                            </div>
                                            <textarea class="form-control form--control messageVal" name="message" placeholder="@lang('Write Message')..."></textarea>
                                            <div class="input-group-text border-0 pe-1">
                                                <button class="send-btn" type="submit"><i class="las la-paper-plane"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

                        {{-- Right Sidebar: Job Management Actions (Unified Workspace) --}}
            <div class="col-xxl-3 col-12">
                <div class="card custom--card sticky-top" style="z-index: 1;">
                    <div class="card-header bg--base">
                        <h5 class="m-0 text-white">@lang('Current Order')</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="mb-1">{{ __($participant->campaign->title) }}</h6>
                            <p class="small text-muted mb-0">{{ Str::limit(__($participant->campaign->description), 150) }}</p>
                        </div>
                        <div class="text-center mb-4">
                            <h3 class="text--base">{{ showAmount($participant->budget) }}</h3>
                            <span class="badge {{ $participant->status == Status::CAMPAIGN_JOB_COMPLETED ? 'badge--success' : 'badge--warning' }}">
                                @php echo $participant->statusBadge; @endphp
                            </span>
                        </div>

                                                {{-- Action Buttons --}}
                        <div class="d-grid gap-2">
                            @if ($participant->status == Status::CAMPAIGN_JOB_DELIVERED)
                                <button class="btn btn--success confirmationBtn" 
                                        data-question="@lang('Are you sure to complete this campaign job? You will be asked to leave a review.')" 
                                        data-action="{{ route('user.participant.completed', $participant->id) }}" 
                                        type="button">
                                    <i class="las la-check-circle"></i> @lang('Approve & Complete')
                                </button>
                                <button class="btn btn--black outline report-btn" type="button">
                                    <i class="las la-gavel"></i> @lang('Report Issue')
                                </button>
                            @elseif ($participant->status == Status::PARTICIPATE_PROPOSAL)
                                <form action="{{ route('user.participant.conversation.accept.proposal', $participant->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn--primary w-100">
                                        <i class="las la-check"></i> @lang('Accept Proposal')
                                    </button>
                                </form>
                            @endif

                            {{-- Pending Proposal Logic --}}
                            @php
                                $pendingProposal = \App\Models\Participant::where('influencer_id', $participant->influencer_id)
                                                    ->where('status', Status::PARTICIPATE_PROPOSAL)
                                                    ->whereHas('campaign', function($q) use ($participant) {
                                                        $q->where('user_id', $participant->campaign->user_id);
                                                    })->latest()->first();
                            @endphp

                            @if ($pendingProposal && $participant->status != Status::PARTICIPATE_PROPOSAL)
                                <div class="mt-3 p-3 bg-light rounded border">
                                    <h6 class="small fw-bold mb-1">@lang('New Proposal Received')</h6>
                                    <p class="small text-muted mb-2">{{ __($pendingProposal->campaign->title) }} - <strong>{{ showAmount($pendingProposal->budget) }}</strong></p>
                                    <form action="{{ route('user.participant.conversation.accept.proposal', $pendingProposal->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn--success btn--sm w-100">
                                            @lang('Accept & Hire')
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                                                    {{-- Campaign Summary & Full Brief Link --}}
                        <div class="mt-4 pt-4 border-top">
                            <h6 class="small fw-bold mb-2">@lang('Campaign Summary')</h6>
                            <p class="small text-muted mb-3">{{ Str::limit(__($participant->campaign->description), 120) }}</p>
                            
                            <ul class="list-group list-group-flush small">
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span>@lang('Deadline')</span>
                                    <span class="fw-bold">{{ showDateTime($participant->campaign->end_date, 'd M, Y') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <a href="{{ route('user.participant.detail', $participant->id) }}" class="text--base fw-bold">
                                        <i class="las la-external-link-alt"></i> @lang('View Full Brief')
                                    </a>
                                </li>
                            </ul>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('modal')
<div class="modal fade" id="proposalModal" tabindex="-1" aria-labelledby="proposalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Send Custom Offer')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user.participant.conversation.send.proposal', $participant->id) }}" method="POST">
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
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Report Campaign Job')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user.participant.reported', $participant->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Reason')</label>
                        <textarea class="form-control" name="report_reason" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--base">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            
            // Scroll to bottom
            function scrollHeight() {
                var chatBody = $('.chat__msg-body');
                chatBody.animate({
                    scrollTop: chatBody[0].scrollHeight
                });
            }
            scrollHeight();

            // File upload feedback
            $("#upload-file").on('change', function() {
                var fileCount = $(this)[0].files.length;
                $('.file-count').text(fileCount > 0 ? fileCount + ' file(s) selected' : '');
            });

            // Reload button
            $(".reloadBtn").on('click', function() {
                loadMore(10);
            });

            var messageCount = 10;
            
            // Load more on scroll
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
                    url: "{{ route('user.participant.conversation.view.message') }}",
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

            $("#messageForm").submit(function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: "{{ route('user.participant.conversation.send.message', $participant->id) }}",
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

            $('.report-btn').on('click', function() {
                var modal = $('#reportModal');
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            
            // Scroll to bottom
            function scrollHeight() {
                var chatBody = $('.chat__msg-body');
                chatBody.animate({
                    scrollTop: chatBody[0].scrollHeight
                });
            }
            scrollHeight();

            // File upload feedback
            $("#upload-file").on('change', function() {
                var fileCount = $(this)[0].files.length;
                $('.file-count').text(fileCount > 0 ? fileCount + ' file(s) selected' : '');
            });

            // Reload button
            $(".reloadBtn").on('click', function() {
                loadMore(10);
            });

            var messageCount = 10;
            
            // Load more on scroll
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
                    url: "{{ route('user.participant.conversation.view.message') }}",
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

            $("#messageForm").on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: "{{ route('user.participant.conversation.send.message', $participant->id) }}",
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

            $('.report-btn').on('click', function() {
                var modal = $('#reportModal');
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
        <x-confirmation-modal custom="true" />
@endsection





