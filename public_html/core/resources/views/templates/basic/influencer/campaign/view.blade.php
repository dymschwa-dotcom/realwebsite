@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">

        <div class="card-body">

            <div class="step-form">
                <ul class="nav progressbar nav-pills project-setup-menu mb-4" id="pills-tab" role="tablist">
                    <li class="nav-item active" role="presentation">
                        <button class="nav-btn active" id="pills-basic-tab" data-bs-toggle="tab" data-bs-target="#pills-basic"
                                type="button" role="tab" aria-controls="basic">@lang('Basic')</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-btn" id="pills-content-tab" data-bs-toggle="tab" data-bs-target="#pills-content"
                                type="button" role="tab" aria-controls="content">@lang('Content')</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-btn" id="pills-about-tab" data-bs-toggle="tab" data-bs-target="#pills-about"
                                type="button" role="tab" aria-controls="about">@lang('About')</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-btn" id="pills-influencer-tab" data-bs-toggle="tab"
                                data-bs-target="#pills-influencer" type="button" role="tab"
                                aria-controls="influencer">@lang('Influencer Requirement')</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-btn" id="pills-budget-tab" data-bs-toggle="tab" data-bs-target="#pills-budget"
                                type="button" role="tab" aria-controls="budget">@lang('Budget')</button>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="pills-basic" role="tabpanel" aria-labelledby="pills-basic-tab">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Type')</span>
                            <span>{{ __(ucfirst(@$campaign->campaign_type)) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Payment Type')</span>
                            <span>{{ __(ucfirst(@$campaign->payment_type)) }}</span>
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
                            <span>{{ __(@$campaign->send_product) }}</span>
                        </li>
                        @if (@$campaign->send_product == 'yes')
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                                <span class="fw-bold">@lang('Sending Product Value')</span>
                                <span>{{ showAmount($campaign->monetary_value) }}</span>
                            </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Content Creator')</span>
                            <span>{{ __(@$campaign->content_creator) }}</span>
                        </li>
                        @if (@$campaign->content_creator == 'yourself')
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                                <span class="fw-bold">@lang('Content')</span>
                                <a class="text--base"
                                   href="{{ getImage(getFilePath('content') . '/' . $campaign->content) }}"
                                   download="">@lang('attachment')</a>
                            </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Brand')</span>
                            <span>{{ @$campaign->user->brand_name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Brand Logo')</span>
                            <a href="{{ getImage(getFilePath('brand') . '/' . @$campaign->user->image) }}"
                               class="image-popup"> <img class="campaign-img" src="{{ getImage(getFilePath('brand') . '/' . @$campaign->user->image) }}" alt="@lang('image')">
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Image')</span>
                            <a href="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}"
                               class="image-popup"> <img class="campaign-img" src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}" alt="@lang('image')">
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="pills-content" role="tabpanel" aria-labelledby="pills-content-tab">
                    <div class="my-3">
                        <ul class="list-group list-group-flush">
                            @if (in_array(1, $campaign->platformId))
                                @php
                                    $facebookType = (array) (@$campaign->content_requirements->facebook_type ?? []);
                                    $facebookPlacement = (array) (@$campaign->content_requirements->facebook_placement ?? []);
                                    $type = implode(', ', $facebookType);
                                    $placement = implode(', ', $facebookPlacement);
                                @endphp
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                                    <span class="fw-bold">@lang('Facebook')</span>
                                    <span>@lang('Need') {{ @$campaign->content_requirements->facebook_post_count }}
                                        {{ __(@$type) }} @lang('as') {{ __(@$placement) }}</span>
                                </li>
                            @endif
                            @if (in_array(2, $campaign->platformId))
                                @php
                                    $instagramType = (array) (@$campaign->content_requirements->instagram_type ?? []);
                                    $instagramPlacement = (array) (@$campaign->content_requirements->instagram_placement ?? []);
                                    $type = implode(', ', $instagramType);
                                    $placement = implode(', ', $instagramPlacement);
                                @endphp
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                                    <span class="fw-bold">@lang('Instagram')</span>
                                    <span>@lang('Need') {{ @$campaign->content_requirements->instagram_post_count }}
                                        {{ __(@$type) }} @lang('as') {{ __(@$placement) }}</span>
                                </li>
                            @endif
                        
                            @if (in_array(3, $campaign->platformId))
                                 @php
                                    $youtubePlacement = (array) (@$campaign->content_requirements->youtube_placement ?? []);
                                    $placement = implode(', ', $youtubePlacement);
                                    // Youtube only has video_count
                                    $count = @$campaign->content_requirements->youtube_video_count;
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                                    <span class="fw-bold">@lang('Youtube')</span>
                                    <span>@lang('Need') {{ $count }}
                                        @lang('Video') @lang('as') {{ __(@$placement) }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-about" role="tabpanel" aria-labelledby="pills-about-tab">
                    <div>
                        <h6 class="fw-bold">@lang('Description')</h6>
                        <p>@php echo $campaign->description @endphp</p>
                    </div>
                    <div class="my-4">
                        <h6 class="fw-bold">@lang('Review Process')</h6>
                        <p>{{ __($campaign->review_process) }}</p>
                    </div>
                    <div class="my-4">
                        <h6 class="fw-bold">@lang('Approval Process')</h6>
                        <p>{{ __($campaign->approval_process) }}</p>
                    </div>
                    <div>
                        <h6 class="fw-bold d-block">@lang('Tag')</h6>
                        <span>
                            @foreach (@$campaign->tagName ?? [] as $tag)
                                <span class="badge badge--base">{{ __($tag) }}</span>
                            @endforeach
                        </span>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-influencer" role="tabpanel" aria-labelledby="pills-influencer-tab">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Category')</span>
                            <span>
                                @foreach ($campaign->categoryName as $category)
                                    <span class="badge badge--base">{{ __($category) }}</span>
                                @endforeach
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Required Number of Influencer')</span>
                            <span>{{ @$campaign->influencer_requirements->required_influencer }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Gender')</span>
                            <span>
                                @foreach (@$campaign->influencer_requirements->gender ?? [] as $gender)
                                    <span class="badge badge--base">{{ __($gender) }}</span>
                                @endforeach
                            </span>
                        </li>
                        @if (in_array(1, $campaign->platformId))
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="fw-bold">@lang('Follower Range in Facebook')</span>
                                <span>
                                    {{ getFollowerCount(@$campaign->influencer_requirements->follower_facebook_start) }} -
                                    {{ getFollowerCount(@$campaign->influencer_requirements->follower_facebook_end) }}
                                </span>
                            </li>
                        @endif
                        @if (in_array(2, $campaign->platformId))
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="fw-bold">@lang('Follower Range in Instagram')</span>
                                <span>
                                    {{ getFollowerCount(@$campaign->influencer_requirements->follower_instagram_start) }} -
                                    {{ getFollowerCount(@$campaign->influencer_requirements->follower_instagram_end) }}
                                </span>
                            </li>
                        @endif
                        @if (in_array(3, $campaign->platformId))
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="fw-bold">@lang('Subscriber Range in Youtube')</span>
                                <span>
                                    {{ getFollowerCount(@$campaign->influencer_requirements->follower_youtube_start) }} -
                                    {{ getFollowerCount(@$campaign->influencer_requirements->follower_youtube_end) }}
                                </span>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="tab-pane fade" id="pills-budget" role="tabpanel" aria-labelledby="pills-budget-tab">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Budget')</span>
                            <span>{{ showAmount(@$campaign->budget) }}</span>
                        </li>
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
            </div>
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
                $(document).find('.nav-item').removeClass('active')
                $(this).parent('.nav-item').addClass('active')
            });
        })(jQuery);
    </script>
@endpush

@push('tab-nav')
    <div class="tab-wrapper">
        <ul class="custom--tab nav template-tabs">
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link active">@lang('About Campaign')</button>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('influencer.campaign.detail', @$participate->id) }}"
                   class="nav-link">@lang('Campaign Detail')</a>
            </li>
            <li class="outline-background"></li>
        </ul>
    </div>
@endpush
