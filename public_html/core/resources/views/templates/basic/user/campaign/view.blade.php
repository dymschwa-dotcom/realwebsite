@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-body">
            <div class="step-form">
                <ul class="nav progressbar nav-pills project-setup-menu mb-4" id="pills-tab" role="tablist">
                    <li class="nav-item active" role="presentation">
                        <button class="nav-btn active" id="pills-basic-tab" data-bs-toggle="tab" data-bs-target="#pills-basic" type="button" role="tab" aria-controls="basic">@lang('Basic')</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-btn" id="pills-content-tab" data-bs-toggle="tab" data-bs-target="#pills-content" type="button" role="tab" aria-controls="content">@lang('Content')</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-btn" id="pills-description-tab" data-bs-toggle="tab" data-bs-target="#pills-description" type="button" role="tab" aria-controls="description">@lang('Description')</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-btn" id="pills-influencer-tab" data-bs-toggle="tab" data-bs-target="#pills-influencer" type="button" role="tab" aria-controls="influencer">@lang('Requirement')</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-btn" id="pills-budget-tab" data-bs-toggle="tab" data-bs-target="#pills-budget" type="button" role="tab" aria-controls="budget">@lang('Budget')</button>
                    </li>
                </ul>
            </div>

            <div class="tab-content mt-3" id="myTabContent">
                {{-- Basic Tab --}}
                <div class="tab-pane fade show active" id="pills-basic" role="tabpanel" aria-labelledby="pills-basic-tab">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Type')</span>
                            <span>{{ __(ucfirst($campaign->campaign_type)) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Payment')</span>
                            <span>{{ __(ucfirst($campaign->payment_type)) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Title')</span>
                            <span>{{ __(@$campaign->title) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Platform')</span>
                            <span>
                                @foreach (@$campaign->platformName ?? [] as $platform)
                                    <span class="badge badge--base">{{ __($platform) }}</span>
                                @endforeach
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Sending product to Influecner')</span>
                            <span>{{ __($campaign->send_product) }}</span>
                        </li>
                        @if ($campaign->send_product == 'yes')
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                                <span class="fw-bold">@lang('Sending Product Value')</span>
                                <span>{{ showAmount($campaign->monetary_value) }}</span>
                            </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Content Creator')</span>
                            <span>{{ __($campaign->content_creator) }}</span>
                        </li>
                        @if ($campaign->content_creator == 'yourself')
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                                <span class="fw-bold">@lang('Content')</span>
                                <a class="text--base" href="{{ getImage(getFilePath('content') . '/' . $campaign->content) }}" download="">@lang('attachment')</a>
                            </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Image')</span>
                            <a class="image-popup" href="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}">
                                <img class="campaign-img" src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}" alt="@lang('image')" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Content Requirements Tab --}}
                <div class="tab-pane fade" id="pills-content" role="tabpanel" aria-labelledby="pills-content-tab">
                    <div class="my-3">
                        <ul class="list-group list-group-flush">
                            @if (@$campaign->content_requirements)
                                @if (in_array(1, $campaign->platformId))
                                    @php
                                        $fbType = implode(', ', @$campaign->content_requirements->facebook_type ?? []);
                                        $fbPlacement = implode(', ', @$campaign->content_requirements->facebook_placement ?? []);
                                    @endphp
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                                        <span class="fw-bold">@lang('Facebook')</span>
                                        <span class="text-end text-muted small">@lang('Need') {{ @$campaign->content_requirements->facebook_post_count }} {{ __($fbType) }} @lang('as') {{ __($fbPlacement) }}</span>
                                    </li>
                                @endif
                                @if (in_array(2, $campaign->platformId))
                                    @php
                                        $igType = implode(', ', @$campaign->content_requirements->instagram_type ?? []);
                                        $igPlacement = implode(', ', @$campaign->content_requirements->instagram_placement ?? []);
                                    @endphp
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                                        <span class="fw-bold">@lang('Instagram')</span>
                                        <span class="text-end text-muted small">@lang('Need') {{ @$campaign->content_requirements->instagram_post_count }} {{ __($igType) }} @lang('as') {{ __($igPlacement) }}</span>
                                    </li>
                                @endif
                                @if (in_array(3, $campaign->platformId))
                                    @php
                                        $ytPlacement = implode(', ', @$campaign->content_requirements->youtube_placement ?? []);
                                    @endphp
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                                        <span class="fw-bold">@lang('Youtube')</span>
                                        <span class="text-end text-muted small">@lang('Need') {{ @$campaign->content_requirements->youtube_video_count }} @lang('Video as') {{ __($ytPlacement) }}</span>
                                    </li>
                                @endif
                                @if (@$campaign->content_requirements->video_length)
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                                        <span class="fw-bold">@lang('Video Length')</span>
                                        <span>{{ $campaign->content_requirements->video_length }} @lang('minute')</span>
                                    </li>
                                @endif
                            @else
                                <li class="list-group-item text-center text-muted">@lang('No specific content requirements defined.')</li>
                            @endif
                        </ul>
                    </div>
                </div>

                {{-- Description Tab --}}
                <div class="tab-pane fade" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">
                    <div class="my-3">
                        <h6 class="fw-bold mb-2">@lang('Description')</h6>
                        <div class="text-muted">@php echo $campaign->description @endphp</div>
                    </div>
                    <div class="my-4">
                        <h6 class="fw-bold mb-2">@lang('Review Process')</h6>
                        <p class="text-muted">{{ __($campaign->review_process) }}</p>
                    </div>
                    <div class="my-4">
                        <h6 class="fw-bold mb-2">@lang('Approval Process')</h6>
                        <p class="text-muted">{{ __($campaign->approval_process) }}</p>
                    </div>
                    <div class="my-4">
                        <h6 class="fw-bold mb-2">@lang('Tags')</h6>
                        <span>
                            @foreach (@$campaign->tagName ?? [] as $tag)
                                <span class="badge badge--base">{{ __($tag) }}</span>
                            @endforeach
                        </span>
                    </div>
                    <div class="my-4">
                        <h6 class="fw-bold mb-2">@lang('Hash Tags')</h6>
                        <span>
                            @foreach (@$campaign->hash_tags ?? [] as $tag)
                                <span class="badge badge--base">{{ __($tag) }}</span>
                            @endforeach
                        </span>
                    </div>
                </div>

                {{-- Requirement Tab --}}
                <div class="tab-pane fade" id="pills-influencer" role="tabpanel" aria-labelledby="pills-influencer-tab">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Required Influencer')</span>
                            <span>{{ @$campaign->influencer_requirements->required_influencer }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Gender')</span>
                            <span>
                                @foreach ($campaign->influencer_requirements->gender ?? [] as $gender)
                                    <span class="badge badge--base">{{ __($gender) }}</span>
                                @endforeach
                            </span>
                        </li>
                        @if (@$campaign->influencer_requirements)
                        @if (in_array(1, $campaign->platformId))
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="fw-bold">@lang('Facebook Followers')</span>
                                    <span>{{ getFollowerCount(@$campaign->influencer_requirements->follower_facebook_start) }} - {{ getFollowerCount(@$campaign->influencer_requirements->follower_facebook_end) }}</span>
                            </li>
                        @endif
                        @if (in_array(2, $campaign->platformId))
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="fw-bold">@lang('Instagram Followers')</span>
                                    <span>{{ getFollowerCount(@$campaign->influencer_requirements->follower_instagram_start) }} - {{ getFollowerCount(@$campaign->influencer_requirements->follower_instagram_end) }}</span>
                            </li>
                        @endif
                        @if (in_array(3, $campaign->platformId))
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="fw-bold">@lang('Youtube Subscribers')</span>
                                    <span>{{ getFollowerCount(@$campaign->influencer_requirements->follower_youtube_start) }} - {{ getFollowerCount(@$campaign->influencer_requirements->follower_youtube_end) }}</span>
                            </li>
                        @endif
                        @else
                            <li class="list-group-item d-flex justify-content-center px-0">
                                <span class="text-muted">@lang('Custom Proposal Campaign')</span>
                            </li>
                        @endif
                    </ul>
                </div>
                {{-- Budget Tab --}}
                <div class="tab-pane fade" id="pills-budget" role="tabpanel" aria-labelledby="pills-budget-tab">
                    <ul class="list-group list-group-flush">
                        @if ($campaign->payment_type == 'paid')
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                                <span class="fw-bold">@lang('Budget')</span>
                                <span>{{ showAmount(@$campaign->budget) }}</span>
                            </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Campaign Start')</span>
                            <span>{{ @$campaign->start_date }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Campaign End')</span>
                            <span>{{ @$campaign->end_date }}</span>
                        </li>
                    </ul>
        </div>
            </div> {{-- End Tab Content --}}
    </div>
    </div>
@endsection

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
            $(".image-popup").magnificPopup({
                type: "image",
            });

            $('.nav-btn').on('click', function(e) {
                $('.project-setup-menu .nav-item').removeClass('active');
                $(this).parent('.nav-item').addClass('active');
            });
        })(jQuery);
    </script>
@endpush