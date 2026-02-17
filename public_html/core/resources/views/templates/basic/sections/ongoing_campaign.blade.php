@php
    $campaignContent = getContent('ongoing_campaign.content', true);
    // Ensure we are getting the platforms and categories needed for the loop
    $campaigns = App\Models\Campaign::onGoing()->general()->with(['platforms', 'categories'])->withCount('participants')->orderBy('id', 'desc')->take(4)->get();
@endphp

@if (!blank($campaigns))
    <div class="influencer-campaign py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading style-three style-left">
                        <h2 class="section-heading__title">{{ __(@$campaignContent->data_values->heading) }}</h2>
                        <a href="{{ route('campaign.all') }}">@lang('View All') <i class="las la-angle-double-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row g-2 g-sm-3 g-md-4">
                @foreach ($campaigns as $campaign)
                    <div class="col-lg-6 col-md-12 col-xsm-6">
                        <div class="campaign">
                            <div class="campaign__thumb">
                                {{-- FIX: Changed route name and parameter --}}
                                <a href="{{ route('user.campaign.detail', $campaign->slug) }}">
                                    <img src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}" alt="@lang('image')">
                                </a>
                            </div>
                            <div class="campaign__content">
                                <div class="campaign__cate d-flex flex-wrap justify-content-between gap-3">
                                    <ul class="text-list style-category">
                                        @foreach ($campaign->categories->take(3) as $category)
                                            <li class="text-list__item">
                                                <a href="{{ route('campaign.all') }}?category={{ $category->slug }}" class="text-list__link">{{ __(@$category->name) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="campaign__user">
                                        <span data-bs-toggle="tooltip" data-bs-original-title="@lang('Applied')">
                                            <i class="lar la-user"></i> {{ getAmount(@$campaign->participants_count) }}
                                        </span>
                                    </div>
                                </div>
                                <h6 class="campaign__title">
                                    {{-- FIX: Changed route name and parameter --}}
                                    <a href="{{ route('user.campaign.detail', $campaign->slug) }}">
                                        {{ __(strLimit(@$campaign->title, 40)) }}
                                    </a>
                                </h6>
                                <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                                    <ul class="text-list style-tag">
                                        @foreach (@$campaign->influencer_requirements->gender ?? [] as $gender)
                                            <li class="text-list__item">
                                                <a href="{{ route('campaign.all') }}?gender[]={{ $gender }}" class="text-list__link">{{ __(ucfirst($gender)) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="campaign__user">
                                        <span class="fw-bold text--base">{{ showAmount(@$campaign->budget) }}</span>
                                    </div>
                                </div>
                                <div class="campaign__info d-flex align-items-center flex-wrap justify-content-between gap-1">
                                    <span class="fs-12"> <span class="date"><i class="lar la-clock"></i> {{ diffForHumans($campaign->end_date) }} </span></span>
                                    <ul class="social-links d-flex flex-wrap gap-2">
                                        @foreach ($campaign->platforms as $platform)
                                            <li>@php echo $platform->icon @endphp</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

@push('style')
    <style>
        .campaign__thumb a {
            border-radius: 12px;
            overflow: hidden;
            display: block;
        }
    </style>
@endpush