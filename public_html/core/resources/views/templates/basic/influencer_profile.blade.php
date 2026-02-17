@extends($activeTemplate . 'layouts.frontend')

{{-- Remove Breadcrumb --}}
@section('breadcrumb')
@endsection

@section('content')
{{-- 1. IN-LINE GALLERY --}}
<div class="profile-cover-area pos-rel mt-4">
    <div class="container">
        <div class="position-relative gallery-container">
            <div class="row g-2">
                @php $mainPhotos = $influencer->galleries->take(3); @endphp
                @foreach($mainPhotos as $photo)
                    <div class="col-4">
                        <div class="cover-item">
                            <img src="{{ getImage(getFilePath('profileGallery') . '/' . $photo->image) }}" 
                                 class="w-100 rounded-3 shadow-sm" 
                                 style="height: 450px; object-fit: cover;">
                        </div>
                    </div>
                @endforeach
            </div>

            @if($influencer->galleries->count() > 3)
                <button class="btn btn-light shadow-sm btn-sm show-all-photos-inline" data-bs-toggle="modal" data-bs-target="#galleryModal">
                    <i class="las la-th text-dark"></i> @lang('Show all photos')
                </button>
            @endif
        </div>
    </div>
</div>

<div class="container mt-5 pb-80">
    <div class="row gy-5">
        {{-- LEFT COLUMN --}}
        <div class="col-lg-7">
            
            {{-- PROFILE HEADER --}}
            <div class="d-flex align-items-center gap-4 mb-5">
                <div class="avatar-wrapper">
                    <img src="{{ getImage(getFilePath('influencer') . '/' . $influencer->image, getFileSize('influencer')) }}" 
                         class="rounded-circle border" 
                         style="width: 140px; height: 140px; object-fit: cover; background: #fff;">
                </div>
                
                <div class="header-info">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h1 class="fw-bold m-0" style="font-size: 2.5rem; letter-spacing: -1px; color: #111;">
                            {{ __($influencer->fullname) }}
                        </h1>
                        @if($influencer->kv == 1)
                            <i class="fas fa-check-circle text-primary" style="font-size: 24px;" title="@lang('Verified')"></i>
                        @endif
                    </div>
                    
                    <div class="d-flex flex-wrap align-items-center gap-3 text-muted" style="font-size: 1.1rem;">
                        <span class="text-dark fw-bold"><i class="las la-star text-warning"></i> {{ $influencer->rating ?? '0.0' }}</span>
                        <span>&bull;</span>
                        <span class="fw-bold text-dark">{{ $reviews->count() }} @lang('Reviews')</span>
                        <span>&bull;</span>
                        <span>{{ __($influencer->country_name) }}</span>
                    </div>
                </div>
            </div>

            {{-- SOCIAL CHANNELS --}}
            <div class="social-channels d-flex flex-wrap gap-2 mb-4">
                @foreach($influencer->socialLinks as $social)
                    <div class="social-badge d-flex align-items-center gap-2 px-3 py-2 border rounded bg-white shadow-sm">
                        <span class="text--danger">@php echo $social->platform->icon @endphp</span>
                        <span class="fw-bold text-dark">{{ getFollowerCount($social->followers) }}</span>
                        <small class="text-muted">@lang('Followers')</small>
                    </div>
                @endforeach
            </div>

            {{-- ABOUT --}}
            <div class="about-section mb-5">
                <h4 class="fw-bold mb-3 border-start border-dark border-4 ps-3">@lang('About')</h4>
                <p style="font-size: 1.1rem; line-height: 1.7; color: #444;">{{ __($influencer->bio) }}</p>
            </div>

            {{-- TABS NAVIGATION --}}
            <ul class="nav nav-pills custom--pills mb-4 border-bottom" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-packages">@lang('Packages')</button>
                </li>
                @if($influencer->engagement_rate || $influencer->avg_reach || $influencer->primary_gender)
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-audience">@lang('Audience')</button>
                </li>
                @endif
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-reviews">@lang('Reviews')</button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                {{-- 1. PACKAGES --}}
                <div class="tab-pane fade show active" id="pills-packages">
                    <div class="package-menu-list">
                        @forelse($influencer->services as $service)
                            <div class="package-menu-item p-4 mb-3 border rounded-3 bg-white shadow-sm d-flex align-items-center justify-content-between pointer select-package" 
                                 data-id="{{ $service->id }}"
                                 data-title="{{ __($service->title) }}"
                                 data-price="{{ $service->price }}">
                                <div class="package-info">
                                    <h5 class="fw-bold mb-1 text--danger">{{ __($service->title) }}</h5>
                                    <p class="text-muted small mb-0">{{ Str::limit(__($service->description), 120) }}</p>
                                </div>
                                <div class="package-price text-end ps-4 d-flex align-items-center gap-3">
                                    <h4 class="fw-bold text-dark m-0">{{ gs('cur_sym') }}{{ showAmount($service->price) }}</h4>
                                    <div class="selection-indicator">
                                        <i class="las la-circle fs-4 text-muted"></i>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>@lang('No packages available.')</p>
                        @endforelse
                    </div>
                </div>

                {{-- 2. AUDIENCE (Updated Spacing) --}}
                @if($influencer->engagement_rate || $influencer->avg_reach || $influencer->primary_gender)
                <div class="tab-pane fade" id="pills-audience">
                    {{-- FIXED: Added mb-5 for more bottom margin --}}
                    <div class="audience-section mb-5 mt-2">
                        <h4 class="fw-bold mb-4">@lang('Audience Insights')</h4>
                        <div class="row g-4"> {{-- Changed g-3 to g-4 for more internal gutter spacing --}}
                            @if($influencer->engagement_rate)
                            <div class="col-sm-4">
                                <div class="metric-card p-3 border-top border--danger border-3 rounded shadow-sm text-center bg-white">
                                    <h5 class="text-muted small text-uppercase fw-bold">@lang('Engagement Rate')</h5>
                                    <h3 class="fw-bold mb-0">{{ $influencer->engagement_rate }}</h3>
                                </div>
                            </div>
                            @endif
                            @if($influencer->avg_reach)
                            <div class="col-sm-4">
                                <div class="metric-card p-3 border rounded shadow-sm text-center bg-white">
                                    <h5 class="text-muted small text-uppercase fw-bold">@lang('Avg. Reach')</h5>
                                    <h3 class="fw-bold mb-0">{{ $influencer->avg_reach }}</h3>
                                </div>
                            </div>
                            @endif
                            @if($influencer->primary_gender)
                            <div class="col-sm-4">
                                <div class="metric-card p-3 border rounded shadow-sm text-center bg-white">
                                    <h5 class="text-muted small text-uppercase fw-bold">@lang('Primary Gender')</h5>
                                    <h3 class="fw-bold mb-0">{{ __($influencer->primary_gender) }}</h3>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                {{-- 3. REVIEWS --}}
                <div class="tab-pane fade" id="pills-reviews">
                    <div class="reviews-wrapper mt-4">
                        @include($activeTemplate . 'partials.reviews')
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-5 ps-lg-5">
            <div class="sticky-sidebar">
                <div class="card border-0 shadow-lg p-4 rounded-4 bg-white text-center border-top border--danger border-5">
                    
                    <div id="selection-placeholder">
                        <h4 class="fw-bold mb-3">@lang('Build Your Campaign')</h4>
                        <p class="text-muted mb-4">@lang('Select one or more packages from the list to start your order.')</p>
                    </div>

                    <div id="selected-packages-container" style="display: none;" class="mb-4">
                        <div id="package-list" class="text-start mb-3"></div>
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <h5 class="fw-bold">@lang('Total')</h5>
                            <h4 class="fw-bold text--danger" id="total-price-display"></h4>
                        </div>
                    </div>

                    <form action="{{ route('user.campaign.create') }}" method="GET">
                        <input type="hidden" name="influencer" value="{{ $influencer->username }}">
                        <input type="hidden" name="packages" id="selected-package-ids" value="">
                        
                        <button type="submit" id="order-btn" class="btn btn--danger w-100 btn-lg rounded-pill py-3 fw-bold mb-0" disabled>
                            @lang('Order Now')
                        </button>
                    </form>

                    <div class="or-separator my-3 d-flex align-items-center justify-content-center">
                        <span class="px-2 text-muted small text-uppercase">@lang('or')</span>
                    </div>

                    <div class="custom-negotiation">
                        @auth
                            <a href="{{ route('user.conversation.start', $influencer->id) }}" class="text-dark fw-bold text-decoration-underline small">
                                @lang('Negotiate a custom package')
                            </a>
                        @else
                            <a href="{{ route('user.login') }}" class="text-dark fw-bold text-decoration-underline small">
                                @lang('Negotiate a custom package')
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- GALLERY MODAL --}}
<div class="modal fade" id="galleryModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 px-4 pt-4">
                <h4 class="fw-bold m-0">@lang('Portfolio Gallery')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 overflow-auto" style="max-height: 85vh;">
                <div class="masonry-grid">
                    @foreach($influencer->galleries as $gallery)
                        <div class="masonry-item">
                            <img src="{{ getImage(getFilePath('profileGallery') . '/' . $gallery->image) }}" class="w-100 rounded-3 shadow-sm">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .breadcrumb-section, .inner-hero { display: none !important; }

    .gallery-container { position: relative; }
    .show-all-photos-inline {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background: #ffffff !important;
        color: #000000 !important;
        border: 1px solid #ddd !important;
        font-weight: 600;
        z-index: 10;
        padding: 8px 16px;
        border-radius: 8px;
    }

    .custom--pills .nav-link {
        color: #666;
        font-weight: 600;
        background: transparent;
        border-radius: 0;
        padding: 10px 20px;
        border-bottom: 2px solid transparent;
    }
    .custom--pills .nav-link.active {
        color: #000 !important;
        background: transparent !important;
        border-bottom: 2px solid #000 !important;
    }

    .package-menu-item { transition: all 0.3s ease; border: 1px solid #eee !important; }
    .package-menu-item:hover { border-color: #ff3366 !important; }
    .package-menu-item.active-selection { 
        border: 2px solid #ff3366 !important; 
        background-color: #fffafa !important;
    }

    .border--danger { border-color: #ff3366 !important; }
    .text--danger { color: #ff3366 !important; }
    .btn--danger { background-color: #ff3366 !important; color: white !important; border: none; }
    .btn--danger:disabled { background-color: #ccc !important; cursor: not-allowed; }

    .masonry-grid { column-count: 3; column-gap: 15px; }
    .masonry-item { display: inline-block; width: 100%; margin-bottom: 15px; }

    .or-separator::before, .or-separator::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid #eee;
    }

    @media (max-width: 991px) { .masonry-grid { column-count: 2; } }
    @media (max-width: 575px) { .masonry-grid { column-count: 1; } }
</style>
@endpush

@push('script')
<script>
    (function($) {
        "use strict";
        let selectedPackages = [];
        const curSym = "{{ gs('cur_sym') }}";

        $('.select-package').on('click', function() {
            const id = $(this).data('id');
            const title = $(this).data('title');
            const price = parseFloat($(this).data('price'));

            const index = selectedPackages.findIndex(p => p.id === id);
            if (index > -1) {
                selectedPackages.splice(index, 1);
                $(this).removeClass('active-selection');
                $(this).find('.selection-indicator i').removeClass('la-check-circle text--danger').addClass('la-circle text-muted');
            } else {
                selectedPackages.push({ id, title, price });
                $(this).addClass('active-selection');
                $(this).find('.selection-indicator i').removeClass('la-circle text-muted').addClass('la-check-circle text--danger');
            }
            updateSidebar();
        });

        function updateSidebar() {
            if (selectedPackages.length > 0) {
                $('#selection-placeholder').hide();
                $('#selected-packages-container').fadeIn();
                
                let listHtml = '';
                let total = 0;
                let ids = [];

                selectedPackages.forEach(p => {
                    listHtml += `
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small fw-bold text-dark"><i class="las la-check text--danger me-1"></i> ${p.title}</span>
                            <span class="small text-muted">${curSym}${p.price.toFixed(2)}</span>
                        </div>`;
                    total += p.price;
                    ids.push(p.id);
                });

                $('#package-list').html(listHtml);
                $('#total-price-display').text(curSym + total.toFixed(2));
                $('#selected-package-ids').val(ids.join(','));
                $('#order-btn').prop('disabled', false);
            } else {
                $('#selected-packages-container').hide();
                $('#selection-placeholder').fadeIn();
                $('#order-btn').prop('disabled', true);
                $('#selected-package-ids').val('');
            }
        }
    })(jQuery);
</script>
@endpush