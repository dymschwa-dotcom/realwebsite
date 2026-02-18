@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="py-60">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="campaign-title__area">
                        <h4>{{ __($campaign->title) }}</h4>
                    </div>
                </div>
                <div class="col-md-6">
                    @if ($eligible)
                        <div class="text-md-end">
                            @if ($campaign->payment_type == 'paid')
                                <button class="btn btn--base paidCampaignBtn"
                                        data-action="{{ route('influencer.campaign.participate', encrypt($campaign->id)) }}"
                                        type="button">@lang('Participate Now')</button>
                            @else
                                <button class="btn btn--base givewayCampaignBtn"
                                        data-action="{{ route('influencer.campaign.participate', encrypt($campaign->id)) }}"
                                        type="button">@lang('Participate Now')</button>
                            @endif
                        </div>
                    @else
                        @auth('influencer')
                            <div class="text-md-end">
                                <button class="btn btn--danger disabled" type="button">@lang('Participate Now')</button>
                                <p class="text--danger fw-bold mt-2">@lang('You aren\'t eligible for this campaign')</p>
                            </div>
                        @endauth
                    @endif
                </div>
            </div>

            <div class="row gy-4">
                @if (in_array(1, $campaign->platformId))
                    @php
                        $type = implode(', ', @$campaign->content_requirements->facebook_type);
                        $placement = implode(', ', @$campaign->content_requirements->facebook_placement);
                    @endphp
                    <div class="custom-col">
                        <div class="card custom--card">
                            <div class="card-body">
                                <div class="platform__title">
                                    <span class="social-links"><i class="fab fa-facebook"></i></span>
                                    <span class="title">@lang('Facebook')</span>
                                </div>
                                <div class="campaign__task">
                                    <h6>@lang('You will have to make')</h6>
                                    <ul class="campaign__task-list">
                                        <li>
                                            <span>@lang('Need')
                                                {{ @$campaign->content_requirements->facebook_post_count }}
                                                {{ __(@$type) }} @lang('as') {{ __(@$placement) }}</span>
                                        </li>
                                        <li>
                                            <span>@lang('Follower Required')
                                                {{ getFollowerCount($campaign->influencer_requirements->follower_facebook_start) }}
                                                -
                                                {{ getFollowerCount($campaign->influencer_requirements->follower_facebook_end) }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (in_array(2, $campaign->platformId))
                    @php
                        $type = implode(', ', @$campaign->content_requirements->facebook_type);
                        $placement = implode(', ', @$campaign->content_requirements->facebook_placement);
                    @endphp
                    <div class="custom-col">
                        <div class="card custom--card">
                            <div class="card-body">
                                <div class="platform__title">
                                    <span class="social-links"><i class="fab fa-instagram"></i></span>
                                    <span class="title">@lang('Instagram')</span>
                                </div>
                                <div class="campaign__task">
                                    <h6>@lang('You will have to make')</h6>
                                    <ul class="campaign__task-list">
                                        <li>
                                            <span>@lang('Need')
                                                {{ @$campaign->content_requirements->instagram_post_count }}
                                                {{ __(@$type) }} @lang('as') {{ __(@$placement) }}</span>
                                        </li>
                                        <li>
                                            <span>@lang('Follower Required')
                                                {{ getFollowerCount($campaign->influencer_requirements->follower_instagram_start) }}
                                                -
                                                {{ getFollowerCount($campaign->influencer_requirements->follower_instagram_end) }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (in_array(3, $campaign->platformId))
                    @php
                        $placement = implode(', ', @$campaign->content_requirements->youtube_placement);
                    @endphp
                    <div class="custom-col">
                        <div class="card custom--card">
                            <div class="card-body">
                                <div class="platform__title">
                                    <span class="social-links"><i class="fab fa-youtube"></i></span>
                                    <span class="title">@lang('Youtube')</span>
                                </div>
                                <div class="campaign__task">
                                    <h6>@lang('You will have to make')</h6>
                                    <ul class="campaign__task-list">
                                        <li>
                                            <span>@lang('Need')
                                                {{ @$campaign->content_requirements->youtube_video_count }}
                                                {{ __(@$type) }} @lang('as') {{ __(@$placement) }}</span>
                                        </li>
                                        <li>
                                            <span>@lang('Follower Required')
                                                {{ getFollowerCount($campaign->influencer_requirements->follower_youtube_start) }}
                                                -
                                                {{ getFollowerCount($campaign->influencer_requirements->follower_youtube_end) }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row gy-4 mt-3">
                <div class="col-lg-8">
                    <div class="card custom--card mb-4">
                        <div class="card-body">
                            <div class="campaign__task-details">
                                <h5 class="title">@lang('Campaign Description')</h5>
                                <p class="desc">@php echo $campaign->description @endphp</p>
                            </div>
                        </div>
                    </div>
                    <div class="card custom--card mb-4">
                        <div class="card-body">
                            <div class="campaign__task-details">
                                <h5 class="title">@lang('Approval Process')</h5>
                                <p class="desc">{{ __($campaign->approval_process) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card custom--card">
                        <div class="card-body">
                            <div class="campaign__task-details">
                                <h5 class="title">@lang('Review Process')</h5>
                                <p class="desc">{{ __($campaign->review_process) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card custom--card">
                        <div class="card-body">
                            <div class="campaign__task-sidebar">
                                <h5 class="title">@lang('Tags')</h5>
                                @foreach ($campaign->tagName as $tag)
                                    <a href="{{ route('campaign.all') }}?tag={{ $tag }}">{{ __($tag) }}</a>
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @if (!blank(@$campaign->hash_tags))
                        <div class="card custom--card mt-4">
                            <div class="card-body">
                                <div class="campaign__task-sidebar">
                                    <h5 class="title">@lang('Hash Tags')</h5>
                                    @foreach (@$campaign->hash_tags as $hashTag)
                                        <span>{{ __($hashTag) }}</span>
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card custom--card mt-4">
                        <div class="card-body">
                            <div class="campaign__task-sidebar">
                                <h5 class="title">@lang('Campaign Budget')</h5>
                                <p><span>{{ showAmount($campaign->budget) }} {{ __($general->cur_text) }}</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="card custom--card mt-4">
                        <div class="card-body">
                            <div class="campaign__task-sidebar">
                                <h5 class="title">@lang('Campaign Category') </h5>
                                <ul class="text-list style-tag campaign-information-tag">
                                    @foreach ($campaign->categories ?? [] as $category)
                                        <li class="text-list__item">
                                            <a href="{{ route('campaign.all') }}?category={{ $category->slug }}"
                                               class="text-list__link">{{ __(@$category->name) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card custom--card mt-4">
                        <div class="card-body">
                            <div class="campaign__task-sidebar">
                                <h5 class="title">@lang('Requred Influencer') </h5>
                                <span>{{ @$campaign->influencer_requirements->required_influencer }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card custom--card mt-4">
                        <div class="card-body">
                            <div class="campaign__task-sidebar">
                                <h5 class="title">@lang('Gender') </h5>
                                <ul class="text-list style-tag campaign-information-tag">
                                    @foreach ($campaign->influencer_requirements->gender as $gender)
                                        <li class="text-list__item">
                                            <a href="{{ route('campaign.all') }}?gender={{ $gender }}"
                                               class="text-list__link">{{ __(@$gender) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                                        <div class="card custom--card mt-4">
                        <div class="card-body">
                            <div class="campaign__task-sidebar">
                                <h5 class="title">@lang('Campaign Schedule')</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small text-muted">@lang('Start Date'):</span>
                                    <span class="small fw-bold">{{ showDateTime($campaign->start_date, 'd M, Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="small text-muted">@lang('Deadline'):</span>
                                    <span class="small fw-bold">{{ showDateTime($campaign->end_date, 'd M, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-confirmation-modal btn="btn--base" btnType="btn--md" />

    <div class="modal fade" id="paidCampaignModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="loginModalLabel"> @lang('Participate Campaign!')</h1>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>@lang('Remuneration amount must be less than or equal') {{ showAmount($campaign->budget) }} {{ __($general->cur_text) }}</p>
                        <div class="form-group">
                            <label class="form--label">@lang('Remuneration')</label>
                            <input class="form--control" name="budget" type="text" value="{{ old('budget') }}"
                                   required>
                        </div>
                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="givewayCampaignModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="loginModalLabel"> @lang('Participate Campaign!')</h1>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>@lang('Are you sure to participate this campaign?')</p>
                        <p>@lang('You will be rewarded with a gift for joining this campaign')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark btn--md"
                                data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--base btn--md">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.paidCampaignBtn').on('click', function(e) {
                var modal = $('#paidCampaignModal');
                modal.find('form').attr('action', $(this).data('action'));
                modal.modal('show')
            });
            $('.givewayCampaignBtn').on('click', function(e) {
                var modal = $('#givewayCampaignModal');
                modal.find('form').attr('action', $(this).data('action'));
                modal.modal('show')
            });

        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        .custom--modal .modal-body {
            padding: 35px;
        }
    </style>
@endpush
