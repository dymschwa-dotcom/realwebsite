@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30 justify-content-center">
        <div class="col-xl-4 col-md-6 mb-30">
            <div class="card b-radius--10 box--shadow1 overflow-hidden">
                <div class="card-header">
                    <h6>@lang('Brand Information')</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Fullname')</span>
                            <span>{{ __(@$campaign->user->fullname) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Username')</span>
                            <span>
                                <a href="{{ route('admin.users.detail', $campaign->user_id) }}"><span>@</span>{{ __(@$campaign->user->username) }}</a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Email')</span>
                            <span>{{ @$campaign->user->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Mobile')</span>
                            <span>{{ @$campaign->user->mobile }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Country')</span>
                            <span>{{ __(@$campaign->user->country_name) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Total Campaign Created')</span>
                            <span>{{ getAmount(@$campaign->user->total_campaign_count) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-md-6 mb-30">
            <div class="card b-radius--10 box--shadow1 overflow-hidden">
                <div class="card-header">
                    <h6>@lang('Campaign Information')</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Type')</span>
                            <span>{{ __(ucfirst(@$campaign->campaign_type)) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Payment')</span>
                            <span>{{ __(ucfirst(@$campaign->payment_type)) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Title')</span>
                            <span>{{ __(@$campaign->title) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Category')</span>
                            <span>
                                @foreach ($campaign->categoryName as $category)
                                    <span class="badge badge--dark">{{ __($category) }}</span>
                                @endforeach
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Platform')</span>
                            <span>
                                @foreach ($campaign->platformName as $platform)
                                    <span class="badge badge--dark">{{ __($platform) }}</span>
                                @endforeach
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Brand')</span>
                            <span>{{ __(@$campaign->user->brand_name) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Budget')</span>
                            <span>{{ showAmount($campaign->budget) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="fw-bold">@lang('Status')</span>
                            <span>@php echo $campaign->statusBadge @endphp</span>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-30">
            <div class="card b-radius--10 box--shadow1 overflow-hidden">
                <div class="card-header">
                    @lang('More Information')
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                                    aria-selected="true">@lang('Basic')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#profile-tab-pane" type="button" role="tab"
                                    aria-controls="profile-tab-pane" aria-selected="false">@lang('Contents')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                    data-bs-target="#contact-tab-pane" type="button" role="tab"
                                    aria-controls="contact-tab-pane" aria-selected="false">@lang('Description')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="influencer-tab" data-bs-toggle="tab"
                                    data-bs-target="#influencer-tab-pane" type="button" role="tab"
                                    aria-controls="influencer-tab-pane" aria-selected="false">@lang('Requirements')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="image-tab" data-bs-toggle="tab" data-bs-target="#image-tab-pane"
                                    type="button" role="tab" aria-controls="image-tab-pane"
                                    aria-selected="false">@lang('Images')</button>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                             aria-labelledby="home-tab" tabindex="0">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">@lang('Campaign will be start')</span>
                                    <span>{{ $campaign->start_date }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">@lang('Campaign will be end')</span>
                                    <span>{{ $campaign->end_date }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">@lang('Campaign Created At')</span>
                                    <span>{{ showDateTime($campaign->created_at) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">@lang('Promoting Product')</span>
                                    <span>{{ __($campaign->promoting_type) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">@lang('Brand can send product')?</span>
                                    <span>{{ __($campaign->send_product) }}</span>
                                </li>
                                @if ($campaign->monetary_value)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">@lang('Sending Product Value')</span>
                                        <span>{{ showAmount($campaign->monetary_value) }}</span>
                                    </li>
                                @endif
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">@lang('Who will create content')?</span>
                                    <span>{{ __(@$campaign->content_creator) }}</span>
                                </li>
                                @if ($campaign->content)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">@lang('Content')</span>
                                        <a class="text--primary" download=""
                                           href="{{ getImage(getFilePath('content') . '/' . $campaign->content) }}">@lang('attachment')</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                             tabindex="0">
                            <ul class="list-group">
                                @if (in_array(1, $campaign->platformId))
                                    @php
                                        $type = implode(', ', @$campaign->content_requirements->facebook_type);
                                        $placement = implode(', ', @$campaign->content_requirements->facebook_placement);
                                    @endphp
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <span class="fw-bold">@lang('Facebook')</span>
                                        <span>@lang('Need')
                                            {{ @$campaign->content_requirements->facebook_post_count }}
                                            {{ __(@$type) }} @lang('as') {{ __(@$placement) }}</span>
                                    </li>
                                @endif
                                @if (in_array(2, $campaign->platformId))
                                    @php
                                        $type = implode(', ', @$campaign->content_requirements->instagram_type);
                                        $placement = implode(', ', @$campaign->content_requirements->instagram_placement);
                                    @endphp
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <span class="fw-bold">@lang('Instagram')</span>
                                        <span>@lang('Need')
                                            {{ @$campaign->content_requirements->instagram_post_count }}
                                            {{ __(@$type) }} @lang('as') {{ __(@$placement) }}</span>
                                    </li>
                                @endif
                                @if (in_array(3, $campaign->platformId))
                                    @php
                                        $placement = implode(', ', @$campaign->content_requirements->youtube_placement);
                                    @endphp
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <span class="fw-bold">@lang('Youtube')</span>
                                        <span>@lang('Need')
                                            {{ @$campaign->content_requirements->youtube_video_count }}
                                            {{ __(@$type) }} @lang('as') {{ __(@$placement) }}</span>
                                    </li>
                                @endif
                                @if ($campaign->content_requirements->video_length)
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <span class="fw-bold">@lang('Video Length')</span>
                                        <span>{{ $campaign->content_requirements->video_length }} @lang('minute')</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                             tabindex="0">
                            <div>
                                <span class="fw-bold mb-3">@lang('Description')</span>
                                <p>@php echo $campaign->description @endphp</p>
                            </div>
                            <div class="my-3">
                                <span class="fw-bold">@lang('Review Process')</span>
                                <p class="text--dark">{{ __($campaign->review_process) }}</p>
                            </div>
                            <div class="my-3">
                                <span class="fw-bold">@lang('Approval Process')</span>
                                <p class="text--dark">{{ __($campaign->approval_process) }}</p>
                            </div>
                            <div class="my-3">
                                <span class="fw-bold d-block">@lang('Tag')</span>
                                <span>
                                    @foreach (@$campaign->tagName as $tag)
                                        <span class="badge badge--dark">{{ __($tag) }}</span>
                                    @endforeach
                                </span>
                            </div>
                            @if (@$campaign->hash_tags)
                                <div>
                                    <span class="fw-bold d-block">@lang('Hash Tag')</span>
                                    <span>
                                        @foreach (@$campaign->hash_tags ?? [] as $tag)
                                            <span class="badge badge--dark">{{ __($tag) }}</span>
                                        @endforeach
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="influencer-tab-pane" role="tabpanel"
                             aria-labelledby="influencer-tab" tabindex="0">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">@lang('Required number of influencer')</span>
                                    <span>{{ __(@$campaign->influencer_requirements->required_influencer) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">@lang('Gender')</span>
                                    <span>
                                        @foreach ($campaign->influencer_requirements->gender as $gender)
                                            <span class="badge badge--dark">{{ __($gender) }}</span>
                                        @endforeach
                                    </span>
                                </li>
                                @if (in_array(1, $campaign->platformId))
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">@lang('Follower Range in Facebook')</span>
                                        <span>
                                            {{ getFollowerCount($campaign->influencer_requirements->follower_facebook_start) }}
                                            -
                                            {{ getFollowerCount($campaign->influencer_requirements->follower_facebook_end) }}
                                        </span>
                                    </li>
                                @endif
                                @if (in_array(2, $campaign->platformId))
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">@lang('Follower Range in Instagram')</span>
                                        <span>
                                            {{ getFollowerCount($campaign->influencer_requirements->follower_instagram_start) }}
                                            -
                                            {{ getFollowerCount($campaign->influencer_requirements->follower_instagram_end) }}
                                        </span>
                                    </li>
                                @endif
                                @if (in_array(3, $campaign->platformId))
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">@lang('Subscriber Range in Youtube')</span>
                                        <span>
                                            {{ getFollowerCount($campaign->influencer_requirements->follower_youtube_start) }}
                                            -
                                            {{ getFollowerCount($campaign->influencer_requirements->follower_youtube_end) }}
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="image-tab-pane" role="tabpanel" aria-labelledby="image-tab"
                             tabindex="0">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between flex-wrap align-items-center">
                                    <span class="fw-bold">@lang('Brand Logo')</span>
                                    <div class="user">
                                        <div class="thumb">
                                            <a href="{{ getImage(getFilePath('brand') . '/' . @$campaign->user->image) }}"
                                               class="image-popup">
                                                <img class="plugin_bg"
                                                     src="{{ getImage(getFilePath('brand') . '/' . @$campaign->user->image) }}"
                                                     alt="@lang('image')">
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between flex-wrap align-items-center">
                                    <span class="fw-bold">@lang('Campaign Image')</span>
                                    <div class="user">
                                        <div class="thumb">
                                            <a href="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}"
                                               class="image-popup">
                                                <img class="plugin_bg"
                                                     src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}"
                                                     alt="@lang('image')">
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejectModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Reject Campaign Confirmation')</h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="mt-2">@lang('Reason for Rejection')</label>
                            <textarea class="form-control" name="reason" maxlength="255" rows="5" required>{{ old('reason') }}</textarea>
                        </div>
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection
@push('style')
    <style>
        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            background: transparent;
            color: #4634ff !important;
            border-radius: 5px;
            border: 1px solid #4634ff;
            padding: 5px 15px;
            font-weight: 500;
        }

        .nav-tabs .nav-link {
            margin-bottom: 0;
            background: unset;
            border: unset;
            border-top-left-radius: unset;
            border-top-right-radius: unset;
        }

        .nav-tabs {
            border: unset;
        }

        .nav-link {
            color: #10163A;
        }

        .nav-link:focus,
        .nav-link:hover {
            color: #4634ff !important;
        }

        .plugin_bg {
            border: 1px solid #d5d5d5;
            border-radius: 50%;
            height: 80px;
            width: 80px;
            box-shadow: 0px 0px 3px 0px #757575;
        }
    </style>
@endpush
@push('breadcrumb-plugins')
    @if ($campaign->status == Status::CAMPAIGN_PENDING)
        <button class="btn btn-outline--success confirmationBtn btn-sm" data-question="@lang('Are you sure approve this campaign')?"
                data-action="{{ route('admin.campaign.approve', $campaign->id) }}" type="button"><i
               class="las la-check-circle"></i>@lang('Approve')</button>
        <button class="btn btn-outline--danger reject-btn btn-sm" type="button"><i
               class="las la-times-circle"></i>@lang('Reject')</button>
    @endif
    <x-back route="{{ route('admin.campaign.index') }}" />
@endpush


@push('style-lib')
    <link href="{{ asset($activeTemplateTrue . 'css/magnific-popup.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/magnific-popup.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.reject-btn').on('click', function() {
                var modal = $('#rejectModal');
                modal.find('form').attr('action', `{{ route('admin.campaign.reject', $campaign->id) }}`);
                modal.modal('show');
            });

            $(".image-popup").magnificPopup({
                type: "image",
            });
        })(jQuery);
    </script>
@endpush
