@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="campaign-details pt-5 pb-120 bg-white">
        <div class="container">
            <div class="row gy-5">
                {{-- LEFT SIDE: Image and Technical Details --}}
<div class="col-lg-7">
    <div class="campaign-header mb-5">
        <h1 class="fw-bold h2 mb-4 text-dark">{{ __($campaign->title) }}</h1>
        
        <div class="campaign-details-image rounded-4 overflow-hidden mb-4 shadow-sm bg-light">
            @if($campaign->image)
                <img src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}"
                     alt="Campaign image" class="w-100 object-fit-cover" style="height: 500px;">
            @else
                {{-- FALLBACK TO UNSPLASH --}}
                <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?q=80&w=1000&auto=format&fit=crop" 
                     alt="Campaign placeholder" class="w-100 object-fit-cover" style="height: 500px;">
            @endif
        </div>

        <div class="about-block">
            <h4 class="fw-bold mb-3 border-start border-dark border-4 ps-3">@lang('Campaign Description')</h4>
            <div class="text-muted lh-base" style="font-size: 1.1rem;">
                @php echo $campaign->description @endphp
            </div>
        </div>
    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <div class="card border-0 rounded-4 shadow-sm p-4 bg-light h-100">
                                <h6 class="fw-bold mb-3">@lang('Approval Process')</h6>
                                <p class="small text-muted mb-0">@php echo nl2br($campaign->approval_process) @endphp</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 rounded-4 shadow-sm p-4 bg-light h-100">
                                <h6 class="fw-bold mb-3">@lang('Review Process')</h6>
                                <p class="small text-muted mb-0">@php echo nl2br($campaign->review_process) @endphp</p>
                            </div>
                        </div>
                    </div>

                    <div class="campaign-cate">
                        <h6 class="fw-bold mb-3">@lang('Campaign Category')</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach (@$campaign->categories ?? [] as $category)
                                <a href="{{ route('campaign.all') }}?category[]={{ $category->slug }}"
                                   class="badge bg-white text-dark border px-3 py-2 rounded-pill fw-normal shadow-sm">
                                   {{ __(@$category->name) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- RIGHT SIDE: Hiring Widget / Sticky Sidebar --}}
                <div class="col-lg-5 col-xl-4 offset-xl-1">
                    <div class="sticky-sidebar">
                        <div class="card border-0 rounded-4 shadow-lg p-4 mb-4 bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold mb-0">@lang('Requirements')</h4>
                                <div class="bg-dark text-white px-3 py-1 rounded-pill small fw-bold">
                                    {{ showAmount($campaign->budget) }}
                                </div>
                            </div>

                            <div class="requirements-list d-flex flex-column gap-3 mb-4">
                                {{-- Platform Specific Requirements --}}
                                @php
                                    $platforms = [
                                        1 => ['name' => 'Facebook', 'icon' => 'facebook-f', 'prefix' => 'facebook'],
                                        2 => ['name' => 'Instagram', 'icon' => 'instagram', 'prefix' => 'instagram'],
                                        3 => ['name' => 'Youtube', 'icon' => 'youtube', 'prefix' => 'youtube']
                                    ];
                                @endphp

                                @foreach($platforms as $id => $info)
                                    @if(in_array($id, $campaign->platformId))
                                        <div class="platform-req p-3 rounded-4 border">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <i class="fab fa-{{ $info['icon'] }} fs-5"></i>
                                                <span class="fw-bold">{{ $info['name'] }}</span>
                                            </div>
                                            <ul class="list-unstyled mb-0 small text-muted">
                                                @php
                                                    $countKey = $info['prefix'].'_post_count';
                                                    if($id == 3) $countKey = 'youtube_video_count';
                                                    $typeKey = $info['prefix'].'_type';
                                                    $placeKey = $info['prefix'].'_placement';
                                                    
                                                    $types = (array)@$campaign->content_requirements->$typeKey;
                                                    $placement = implode(', ', (array)@$campaign->content_requirements->$placeKey);
                                                    $followerStart = 'follower_'.$info['prefix'].'_start';
                                                    $followerEnd = 'follower_'.$info['prefix'].'_end';
                                                @endphp
                                                
                                                <li class="mb-1"><i class="las la-check-circle text-success me-1"></i> 
                                                    {{ @$campaign->content_requirements->$countKey }} Posts ({{ $placement }})
                                                </li>
                                                <li><i class="las la-users me-1"></i> 
                                                    {{ getFollowerCount($campaign->influencer_requirements->$followerStart) }} - {{ getFollowerCount($campaign->influencer_requirements->$followerEnd) }} @lang('Followers')
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="row g-2 mb-4">
                                <div class="col-6">
                                    <div class="border rounded-4 p-3 text-center">
                                        <span class="tiny-label">@lang('Gender')</span>
                                        <div class="fw-bold small mt-1">
                                            {{ implode(', ', array_map('ucfirst', $campaign->influencer_requirements->gender)) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded-4 p-3 text-center">
                                        <span class="tiny-label">@lang('Open Slots')</span>
                                        <div class="fw-bold small mt-1">{{ @$campaign->influencer_requirements->required_influencer }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="apply-section">
                                @if ($eligible)
                                    @if ($campaign->payment_type == 'paid')
                                        <button class="btn btn-dark w-100 rounded-pill py-3 fw-bold fs-6 paidCampaignBtn"
                                                data-action="{{ route('influencer.campaign.participate', encrypt($campaign->id)) }}"
                                                type="button">@lang('Participate Now')</button>
                                    @else
                                        <button class="btn btn-dark w-100 rounded-pill py-3 fw-bold fs-6 givewayCampaignBtn"
                                                data-action="{{ route('influencer.campaign.participate', encrypt($campaign->id)) }}"
                                                type="button">@lang('Participate Now')</button>
                                    @endif
                                @else
                                    @auth('influencer')
                                        <button class="btn btn-danger w-100 rounded-pill py-3 fw-bold fs-6 disabled" type="button">@lang('Not Eligible')</button>
                                        <p class="text-danger text-center small fw-bold mt-2 mb-0">@lang('You don\'t meet the criteria')</p>
                                    @endauth
                                @endif
                            </div>
                        </div>

                        <div class="card border-0 rounded-4 shadow-sm p-4 bg-light">
                            <h6 class="fw-bold mb-2">@lang('Deadline')</h6>
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <i class="las la-calendar-check fs-4"></i>
                                <span class="fw-medium">{{ showDateTime($campaign->end_date, 'M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modals remain same but with class btn-dark and rounded-pill --}}
@endsection

@push('style')
<style>
    .rounded-4 { border-radius: 1.25rem !important; }
    .sticky-sidebar { position: sticky; top: 40px; }
    .tiny-label { font-size: 10px; font-weight: 800; text-transform: uppercase; color: #999; letter-spacing: 0.5px; }
    .btn-dark { background-color: #000; border: none; }
    .btn-dark:hover { background-color: #222; }
    .platform-req { background: #fcfcfc; transition: all 0.2s; }
    .platform-req:hover { border-color: #000 !important; }
    .lh-base { line-height: 1.7 !important; }
    .object-fit-cover { object-fit: cover; }
</style>
@endpush