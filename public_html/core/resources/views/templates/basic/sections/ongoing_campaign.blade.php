@php
    $campaignContent = getContent('ongoing_campaign.content', true);
    $campaigns = App\Models\Campaign::onGoing()->general()->withCount('participants')->orderBy('id', 'desc')->take(4)->get();
@endphp

@if (!blank($campaigns) && !auth()->check())
    @php
        $campaignRoute = auth()->guard('influencer')->check() ? route('campaign.all') : route('influencer.login');
    @endphp
    <div class="influencer-campaign py-120 bg-white">
        <div class="container">
            {{-- Header with Clean Alignment --}}
            <div class="d-flex justify-content-between align-items-end mb-40">
                <div>
                    <h2 class="fw-bold text-dark mb-0">{{ __(@$campaignContent->data_values->heading) }}</h2>
                    <div class="border-bottom border-dark border-3 mt-2" style="width: 60px;"></div>
                </div>
                <a href="{{ $campaignRoute }}" class="text-dark fw-bold small text-decoration-underline text-underline-offset-4">
                    @lang('View All') <i class="las la-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="row g-4">
                @foreach ($campaigns as $campaign)
                    @php
                        $detailRoute = auth()->guard('influencer')->check() ? route('campaign.detail', [slug($campaign->title), $campaign->id]) : route('influencer.login');
                    @endphp
                    <div class="col-lg-6">
                        <div class="campaign-card-minimal d-flex gap-4 p-3 rounded-4 border hover-shadow transition">
                            {{-- Thumbnail with Unsplash Fallback --}}
                            <div class="campaign-card-img">
                                <a href="{{ $detailRoute }}" class="d-block h-100">
                                    @if($campaign->image)
                                        <img src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}" alt="campaign" class="rounded-3">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?q=80&w=500&auto=format&fit=crop" alt="placeholder" class="rounded-3">
                                    @endif
                                </a>
                            </div>

                            <div class="campaign-card-body flex-grow-1 d-flex flex-column justify-content-between py-1">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="tiny-label text-muted">{{ $campaign->categories->first()?->name ?? __('General') }}</span>
                                        <div class="platform-icons d-flex gap-2">
                                            @foreach ($campaign->platforms as $platform)
                                                <span class="small text-dark">@php echo $platform->icon @endphp</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <h5 class="fw-bold mb-2">
                                        <a href="{{ $detailRoute }}" class="text-dark text-decoration-none">
                                            {{ __(strLimit(@$campaign->title, 45)) }}
                                        </a>
                                    </h5>

                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="small fw-bold text-dark">
                                            <i class="las la-users me-1"></i> {{ getAmount(@$campaign->participants_count) }} @lang('Applied')
                                        </div>
                                        <div class="small text-muted">
                                            <i class="lar la-clock me-1"></i> {{ diffForHumans($campaign->end_date) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                    <span class="h6 fw-bold mb-0 text-dark">{{ showAmount(@$campaign->budget) }}</span>
                                    <a href="{{ $detailRoute }}" class="btn btn-dark btn-sm rounded-pill px-3 py-1 fw-bold">
                                        @lang('Details')
                                    </a>
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
        .rounded-4 { border-radius: 1.25rem !important; }
        .campaign-card-minimal {
            background: #fff;
            transition: all 0.3s ease;
            min-height: 200px;
        }
        .campaign-card-minimal:hover {
            border-color: #000 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important;
        }
        .campaign-card-img {
            width: 160px;
            height: 160px;
            flex-shrink: 0;
        }
        .campaign-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .tiny-label {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn-dark {
            background: #000;
            border: none;
            font-size: 12px;
        }
        .btn-dark:hover {
            background: #222;
        }
        .text-underline-offset-4 {
            text-underline-offset: 4px;
        }
        .transition {
            transition: all 0.2s ease-in-out;
        }
        @media (max-width: 575px) {
            .campaign-card-minimal {
                flex-direction: column;
            }
            .campaign-card-img {
                width: 100%;
                height: 200px;
            }
        }
    </style>
@endpush

