<div class="card custom--card mb-4 border--base">
    <div class="card-header bg--base text-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 text-white">@lang('Campaign Brief')</h5>
        <span class="badge bg-white text--base">{{ __(@$campaign->campaign_type) }}</span>
    </div>
    <div class="card-body">
        
        {{-- Section 1: Overview --}}
        <div class="mb-4">
            <h4 class="fw-bold mb-2">{{ __(@$campaign->title) }}</h4>
            <p class="text-muted">{{ __(@$campaign->description) }}</p>
        </div>

        <hr>

        {{-- Section 2: Key Details Grid --}}
        <div class="row gy-4 mb-4">
            <div class="col-md-3 col-6">
                <small class="text-muted d-block fw-bold uppercase">@lang('Start Date')</small>
                <span>{{ showDateTime(@$campaign->start_date, 'd M, Y') }}</span>
            </div>
            <div class="col-md-3 col-6">
                <small class="text-muted d-block fw-bold uppercase">@lang('End Date')</small>
                <span>{{ showDateTime(@$campaign->end_date, 'd M, Y') }}</span>
            </div>
            <div class="col-md-3 col-6">
                <small class="text-muted d-block fw-bold uppercase">@lang('Budget')</small>
                <span class="text--base fw-bold">{{ showAmount(@$campaign->budget) }}</span>
            </div>
            <div class="col-md-3 col-6">
                <small class="text-muted d-block fw-bold uppercase">@lang('Payment Type')</small>
                <span>{{ ucfirst(@$campaign->payment_type) }}</span>
            </div>
        </div>

        {{-- Section 3: Deliverables --}}
        <div class="p-3 bg-light rounded mb-4 border">
            <h6 class="fw-bold mb-3"><i class="las la-tasks"></i> @lang('Required Deliverables')</h6>
            <div class="row gy-3">
                @if (in_array(1, $campaign->platformId))
                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="lab la-facebook-f fs-3 text--base"></i>
                            <div>
                                <span class="fw-bold d-block">Facebook</span>
                                <small>{{ @$campaign->content_requirements->facebook_post_count }} Post(s)</small>
                            </div>
                        </div>
                    </div>
                @endif
                @if (in_array(2, $campaign->platformId))
                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="lab la-instagram fs-3 text--base"></i>
                            <div>
                                <span class="fw-bold d-block">Instagram</span>
                                <small>{{ @$campaign->content_requirements->instagram_post_count }} Post(s)</small>
                            </div>
                        </div>
                    </div>
                @endif
                @if (in_array(3, $campaign->platformId))
                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="lab la-youtube fs-3 text--base"></i>
                            <div>
                                <span class="fw-bold d-block">YouTube</span>
                                <small>{{ @$campaign->content_requirements->youtube_video_count }} Video(s)</small>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Section 4: Additional Info --}}
        <div class="row gy-4">
            <div class="col-md-6">
                <h6 class="fw-bold mb-2">@lang('Product Shipping')</h6>
                @if (@$campaign->send_product == 'yes')
                    <span class="badge badge--success">@lang('Yes, Product Provided')</span>
                    <p class="small mt-1">@lang('Value'): {{ showAmount(@$campaign->monetary_value) }}</p>
                @else
                    <span class="badge badge--dark">@lang('No Product Shipping')</span>
                @endif
            </div>
            <div class="col-md-6">
                <h6 class="fw-bold mb-2">@lang('Content Rights')</h6>
                <p class="small">{{ __(@$campaign->content_creator == 'influencer' ? 'Created by Influencer' : 'Provided by Brand') }}</p>
            </div>
        </div>

    </div>
</div>