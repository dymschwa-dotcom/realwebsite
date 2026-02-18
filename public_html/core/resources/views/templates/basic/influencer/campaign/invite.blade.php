@extends($activeTemplate . 'layouts.master')
@section('content')
    @if (!blank($inviteCampaigns))
        <div class="row gy-4">
            @foreach ($inviteCampaigns as $invite)
                <div class="col-xl-6 col-lg-6 col-xsm-6">
                    <div class="campaign h-100 d-flex flex-column">
                        <div class="campaign__thumb">
                            {{-- Pointing to internal dashboard view --}}
                            <a href="{{ route('influencer.campaign.view', @$invite->campaign->id) }}">
                                <img src="{{ getImage(getFilePath('campaign') . '/' . $invite->campaign->image, getFileSize('campaign')) }}"
                                    alt="@lang('image')">
                            </a>
                        </div>
                        <div class="campaign__content d-flex flex-column flex-grow-1">
                            <div class="campaign__cate d-flex flex-wrap justify-content-between gap-3">
                                <ul class="text-list style-category">
                                    @foreach (@$invite->campaign->categories->take(2) as $category)
                                        <li class="text-list__item">
                                            <a href="{{ route('campaign.all') }}?category={{ $category->slug }}"
                                                class="text-list__link">{{ __(@$category->name) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="campaign__user">
                                    <span data-bs-toggle="tooltip" title="@lang('Total Applied')">
                                        <i class="lar la-user"></i> {{ getAmount(@$invite->campaign->participants_count) }}
                                    </span>
                                </div>
                            </div>
                            <h6 class="campaign__title">
                                <a href="{{ route('influencer.campaign.view', @$invite->campaign->id) }}">
                                    {{ __(strLimit(@$invite->campaign->title, 50)) }}
                                </a>
                            </h6>
                            
                            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                                <ul class="text-list style-tag">
                                    @foreach (@$invite->campaign->influencer_requirements->gender ?? [] as $gender)
                                        <li class="text-list__item">
                                            <span class="text-list__link small">{{ __(ucfirst($gender)) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="campaign__user">
                                    <span class="fw-bold text--success">{{ showAmount(@$invite->campaign->budget) }}</span>
                                </div>
                            </div>

                            <div class="campaign__info d-flex align-items-center flex-wrap justify-content-between gap-1 mb-3 border-top pt-2">
                                <span class="fs-12 text-muted">
                                    <i class="lar la-clock"></i> {{ diffForHumans(@$invite->campaign->end_date) }}
                                </span>
                                <ul class="social-links d-flex flex-wrap gap-2">
                                    @foreach (@$invite->campaign->platforms as $platform)
                                        <li title="{{ $platform->name }}">@php echo $platform->icon @endphp</li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- THE SOURCE OF TRUTH FIX --}}
                            <div class="accept-action mt-auto border-top pt-3">
                                {{-- We target the specific POST route defined in web.php --}}
                                <form action="{{ route('influencer.campaign.proposal.final.submit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="campaign_id" value="{{ $invite->campaign->id }}">
                                    {{-- Providing a default message to satisfy controller validation --}}
                                    <input type="hidden" name="message" value="I have accepted your invitation. Looking forward to working together!">
                                    
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('influencer.campaign.view', @$invite->campaign->id) }}" class="btn btn--outline-custom btn--sm w-50">
                                            <i class="las la-info-circle"></i> @lang('Details')
                                        </a>
                                        <button type="submit" class="btn btn--base btn--sm w-50">
                                            <i class="las la-check-circle"></i> @lang('Accept')
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ paginateLinks($inviteCampaigns) }}
        </div>
    @else
        @php $emptyData = getContent('empty_data.content', true); @endphp
        <div class="empty-template text-center py-5">
            <img src="{{ getImage('assets/images/frontend/empty_data/' . @$emptyData->data_values->image, '128x128') }}" alt="No Data">
            <h6 class="mt-3">@lang('You have no active campaign invitations.')</h6>
            <a href="{{ route('campaign.all') }}" class="btn btn--base btn--sm mt-3">@lang('Browse Marketplace')</a>
        </div>
    @endif
@endsection

@push('tab-nav')
    <div class="tab-wrapper">
        <ul class="custom--tab nav template-tabs">
            <li class="nav-item">
                <a href="{{ route('influencer.campaign.log') }}" class="nav-link">@lang('My Campaigns')</a>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link active">@lang('Invited Campaigns')</button>
            </li>
            <li class="outline-background"></li>
        </ul>
    </div>
@endpush