@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="inbox">
        <div class="row justify-content-center gy-4">
            <div class="col-md-6">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="mb-0">@lang('Campaign Detail')</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between flex-wrap px-0">
                                <span class="fw-bold">@lang('Brand')</span>
                                <span>{{ $campaign->user->fullname }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-wrap px-0">
                                <span class="fw-bold">@lang('Title')</span>
                                <span>{{ __($campaign->title) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-wrap px-0">
                                <span class="fw-bold">@lang('Budget')</span>
                                <span>{{ showAmount($participant->budget) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-wrap px-0">
                                <span class="fw-bold">@lang('More Information')</span>
                                <a href="{{ route('influencer.campaign.view', $participant->id) }}" class="btn btn--base outline btn--sm"><i class="las la-eye"></i> @lang('View')</a>
                            </li>
                        </ul>
                    </div>
                </div>
                @if ($participant->status == Status::PARTICIPATE_REQUEST_ACCEPTED)
                    <div class="card custom--card mt-4">
                        <div class="card-header">
                            <h5 class="m-0">@lang('Take Action')</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center gap-3">
                                <button class="btn btn--danger outline btn--md confirmationBtn" data-question="@lang('Are you sure to cancel this campaign job')?" data-action="{{ route('influencer.campaign.cancel', $participant->id) }}" type="button">
                                    <i class="las la-times-circle"></i> @lang('Cancel')
                                </button>
                                <button class="btn btn--info outline btn--md confirmationBtn" data-question="@lang('If you complete campaign work, you need to ensure delivery of this work, which means you need to keep proof and documents of the work. The brand can report this work without proper proof. So check everything before clicking the yes button.')" data-action="{{ route('influencer.campaign.deliver', $participant->id) }}" type="button"><i class="las la-check-circle"></i> @lang('Deliver')</button>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($participant->status == Status::CAMPAIGN_JOB_REPORTED)
                    <div class="card custom--card mt-4">
                        <div class="card-header">
                            <h5 class="m-0">@lang('Take Action')</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <span class="text--danger fw-bold">@lang('This job was reported. Admin will handle this. ')</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <div class="card custom--card">
                    <div class="card-body">
                        <div class="chat__msg">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <div>
                                    <h5 class="mb-0">{{ __(@$user->fullname) }}</h5>
                                    @if ($user->status == Status::USER_BAN)
                                        <span class="text--danger">@lang('Banned')</span>
                                    @else
                                        <small>
                                            @if ($user)
                                                @if ($user->isUserOnline())
                                                    <span class="text--success">@lang('Online')</span>
                                                @else
                                                    <span>@lang('Offline')</span>
                                                @endif
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
                                    @if ($user)
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
                                            <textarea class="form-control form--control messageVal" name="message" type="text" contenteditable="true" placeholder="@lang('Write Message')..."></textarea>
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
        </div>
    </div>

    <x-confirmation-modal custom="true" />
@endsection

@push('style')
    <style>
        .messageVal {
            resize: none;
            overflow: hidden;
        }

        .input-group-text.border-0 {
            border: 0 !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.message-loader-wrapper').fadeOut(300);

            $('#upload-file').on('change', function() {
                var fileCount = $(this)[0].files.length;
                $('.file-count').text(`${fileCount} files upload`)
            });

            let scrollAvailable = true;

            $(".reloadBtn").on('click', function() {
                loadMore(10);
                scrollHeight();
            });

            function scrollHeight() {
                if ($('.chat__msg-body').length) {
                    $('.chat__msg-body').animate({
                        scrollTop: $('.chat__msg-body')[0].scrollHeight
                    });
                }
            }
            scrollHeight();


            var messageCount = 10
            $(".chat__msg-body").on('scroll', function() {
                if ($(this).scrollTop() == 0) {
                    messageCount += 10;
                    if (scrollAvailable) {
                        loadMore(messageCount);
                    }
                }
            });

            function loadMore(messageCount) {
                $('.message-loader-wrapper').fadeIn(300)
                $.ajax({
                    method: "GET",
                    data: {
                        participant_id: `{{ @$participant->id }}`,
                        messageCount: messageCount,
                    },
                    url: "{{ route('influencer.campaign.conversation.view.message') }}",
                    success: function(response) {
                        if (response.scrollAvailable) {
                            $("#message").html(response.html);
                        }
                        scrollAvailable = response.scrollAvailable;
                    }
                }).done(function() {
                    $('.message-loader-wrapper').fadeOut(500)
                });
            }

            $("#messageForm").on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: "{{ route('influencer.campaign.conversation.send.message', $participant->id) }}",
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
                            $('.file-count').text('')
                            $("#message").append(response.html);
                            scrollHeight();
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
