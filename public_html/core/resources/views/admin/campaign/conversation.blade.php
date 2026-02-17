@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30 justify-content-center">
        <div class="col-xl-4 col-md-6 mb-30">
            @if ($participant->status == Status::CAMPAIGN_JOB_REPORTED)
                <div class="card b-radius--10 box--shadow1 mb-4 overflow-hidden">
                    <div class="card-header">
                        <h4 class="card-title mb-0 text-center"> <i class="la la-exclamation-triangle text--warning"></i> @lang('Reason of Report')</h4>
                    </div>
                    <div class="card-body">
                        <p class="text--danger">{{ $participant->report_reason }}</p>
                    </div>

                    <div class="card-footer">
                        <p>@lang('Reported by')
                            <a href="{{ route('admin.users.detail', $participant->campaign->user_id) }}" target="blank">
                                <span>@</span>{{ $participant->campaign->user->username }}</a>
                            (@lang('Brand'))
                        </p>
                    </div>
                </div>
                <div class="card b-radius--10 box--shadow1 mb-4 overflow-hidden">
                    <div class="card-header">
                        <h4 class="card-title mb-0 text-center">@lang('Take Action')</h4>
                    </div>
                    <div class="card-body">
                        @if ($participant->status == Status::CAMPAIGN_JOB_REPORTED)
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-outline--danger confirmationBtn" data-action="{{ route('admin.campaign.job.refund', $participant->id) }}" data-question="@lang("If you click on the 'yes' button, the brand will get the balance and the campaign job will be rejected")" data-btn_class="btn btn--primary" type="button">
                                    <i class="la la-user-astronaut"></i>
                                    @lang('In Favour of Brand')
                                </button>

                                <button class="btn btn-outline--success confirmationBtn" data-action="{{ route('admin.campaign.job.complete', $participant->id) }}" data-question="@lang("If you click on the 'yes' button, the balance will be added to the influencer account and the campaign job will be completed.")" data-btn_class="btn btn--primary" type="button">
                                    <i class="la la-user"></i>
                                    @lang('In Favour of Influencer')
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="card b-radius--10 box--shadow1 overflow-hidden">
                <div class="card-header">
                    <h4 class="card-title mb-0 text-center">@lang('Campaign Information')</h4>
                </div>
                <div class="card-body p-0">

                    <ul class="list-group list-group-flush">

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold"> @lang('Title')</span>
                            <div class="">
                                <span>{{ __(strLimit(@$participant->campaign->title, 25)) }} </span>
                                <a class="text--primary" href="{{ route('admin.campaign.detail', $participant->campaign_id) }}">@lang('Read More')</a>
                            </div>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Influencer')</span>
                            <span>
                                <a class="fw-bold" href="{{ route('admin.influencer.detail', $participant->influencer_id) }}">
                                    <span>@</span>{{ @$participant->influencer->username }}
                                </a>
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Brand')</span>
                            <span>
                                <a class="text--cyan fw-bold" href="{{ route('admin.users.detail', @$participant->campaign->user_id) }}">
                                    <span>@</span>{{ @$participant->campaign->user->username }}
                                </a>
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Budget')</span>
                            <span>{{ showAmount($participant->campaign->budget) }} </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Status')</span>
                            @php
                                echo $participant->statusBadge;
                            @endphp
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-xl-8 col-md-6 mb-30">
            <div class="card b-radius--10 box--shadow1 overflow-hidden">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">@lang('Conversations')</h5>
                    <button class="btn btn-sm btn-outline--primary reloadBtn" type="button"><i class="las la-redo-alt"></i></button>
                </div>
                <div class="card-body">
                    <div class="chat-box" id="message">
                        @include('admin.conversation.messages')
                    </div>
                    @if ($participant->status == Status::CAMPAIGN_JOB_REPORTED)
                        <div class="message-admin mt-5">
                            <form id="messageForm" action="" method="POST">
                                @csrf
                                <div class="input-group mb-3">
                                    <textarea class="form-control" name="message" placeholder="@lang('Write here.....')"></textarea>
                                </div>
                                <div class="input-group">
                                    <button class="btn btn--primary w-100" type="submit">@lang('Send Message')</button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection
@push('style')
    <style>
        .gap-1 {
            gap: 5px;
        }

        .chat-box {
            max-height: 500px;
            overflow-y: scroll;
            scrollbar-width: thin;
            scrollbar-color: #ddd #fff;
        }

        .chat-box::-webkit-scrollbar {
            width: 12px;
        }

        .chat-box::-webkit-scrollbar-track {
            background: #fff;
        }

        .chat-box::-webkit-scrollbar-thumb {
            background-color: #ddd;
            border-radius: 20px;
            border: 3px solid #fff;
        }

        .single-message {
            width: 80%;
            padding: 20px;
            background-color: #f5f4fb;
            border-radius: 5px;
        }

        @media (max-width: 575px) {
            .single-message {
                width: 100%;
            }
        }

        .single-message+.single-message {
            margin-top: 15px;
        }

        .single-message.admin-message {
            margin-left: auto;
            background-color: #f7f7f7;
        }

        .badge--secondary {
            border-radius: 999px;
            padding: 2px 15px;
            position: relative;
            border-radius: 999px;
            -webkit-border-radius: 999px;
            -moz-border-radius: 999px;
            -ms-border-radius: 999px;
            -o-border-radius: 999px;
        }

        .badge--secondary {
            background-color: rgb(134, 142, 150, 0.1);
            border: 1px solid #868e96;
            color: #868e96;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $(".reloadBtn").on('click', function() {
                loadMore(10);
            });

            var messageCount = 10
            $(".chat-box").on('scroll', function() {
                if ($(this).scrollTop() == 0) {
                    messageCount += 10;
                    loadMore(messageCount);
                }
            });

            function loadMore(messageCount) {
                $.ajax({
                    method: "GET",
                    data: {
                        participant_id: `{{ @$participant->id }}`,
                        messageCount: messageCount
                    },
                    url: "{{ route('admin.campaign.view.message') }}",
                    success: function(response) {
                        $("#message").html(response);
                    }
                });
            }

            function scrollHeight() {
                $('.chat-box').animate({
                    scrollTop: $('.chat-box')[0].scrollHeight
                });
            }

            scrollHeight();


            $("#messageForm").submit(function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: "{{ route('admin.campaign.send.message', $participant->id) }}",
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
                            $("#message").append(response);
                            scrollHeight();
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
