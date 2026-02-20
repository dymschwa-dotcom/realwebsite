@extends($activeTemplate . 'layouts.master')
@section('content')
    @if (!blank($inviteCampaigns))
        <div class="row gy-4">
            @foreach ($inviteCampaigns as $invite)
                <div class="col-xl-6 col-lg-6 col-xsm-6">
                    <div class="campaign">
                        <div class="campaign__thumb">
                            <a
                                href="{{ route('campaign.detail', [slug(@$invite->campaign->title), @$invite->campaign->id]) }}">
                                <img src="{{ getImage(getFilePath('campaign') . '/' . $invite->campaign->image, getFileSize('campaign')) }}"
                                    alt="@lang('image')">
                            </a>
                        </div>
                        <div class="campaign__content">
                            <div class="campaign__cate d-flex flex-wrap justify-content-between gap-3">
                                <ul class="text-list style-category">
                                    @foreach (@$invite->campaign->categories->take(3) as $category)
                                        <li class="text-list__item">
                                            <a href="{{ route('campaign.all') }}?category={{ $category->slug }}"
                                                class="text-list__link">{{ __(@$category->name) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="campaign__user">
                                    <span data-bs-toggle="tooltip" data-bs-original-title="@lang('Applied')"><i
                                            class="lar la-user"></i>
                                        {{ getAmount(@$invite->campaign->participants_count) }}</span>
                                </div>
                            </div>
                            <h6 class="campaign__title">
                                <a
                                    href="{{ route('campaign.detail', [slug(@$invite->campaign->title), @$invite->campaign->id]) }}">{{ __(strLimit(@$invite->campaign->title, 60)) }}</a>
                            </h6>
                            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                                <ul class="text-list style-tag">
                                    @foreach (@$invite->campaign->influencer_requirements->gender ?? [] as $gender)
                                        <li class="text-list__item"><a
                                                href="{{ route('campaign.all') }}?gender={{ $gender }}"
                                                class="text-list__link">{{ __(ucfirst($gender)) }}</a></li>
                                    @endforeach
                                </ul>
                                <div class="campaign__user">
                                    <span
                                        class="fw-bold text--base">{{ showAmount(@$invite->campaign->budget) }}</span>
                                </div>
                            </div>
                            <div class="campaign__info d-flex align-items-center flex-wrap justify-content-between  gap-1">
                                <span class="fs-12"> <span class="date"><i class="lar la-clock"></i>
                                        {{ diffForHumans(@$invite->campaign->end_date) }} </span></span>
                                <ul class="social-links d-flex flex-wrap gap-2">
                                    @foreach (@$invite->campaign->platforms as $platform)
                                        <li>@php echo $platform->icon @endphp</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ paginateLinks($inviteCampaigns) }}
    @else
        @php
            $emptyData = getContent('empty_data.content', true);
        @endphp
        <div class="d-flex justify-content-center">
            <div class="empty-data text-center">
                <img src="{{ getImage('assets/images/frontend/empty_data/' . @$emptyData->data_values->image, '256x256') }}"
                    alt="@lang('image')">
            </div>
        </div>
        <h6 class="text-center mt-3 fs-20">@lang('No Campaign Yet!')</h6>
    @endif
@endsection


@push('tab-nav')
    <div class="tab-wrapper">
        <ul class="custom--tab nav template-tabs">
            <li class="nav-item" role="presentation">
                <a href="{{ route('influencer.campaign.log') }}" class="nav-link">@lang('Campaigns')</a>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link active">@lang('Invite Campaigns')</button>
            </li>
            <li class="outline-background"></li>
        </ul>
    </div>
@endpush
