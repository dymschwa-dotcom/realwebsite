@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $showInsights = (auth()->check() && auth()->user()->plan_id>1) || auth()->guard('influencer')->check();
    @endphp
    <section class="influencer-profile-section pt-5 pb-120 bg-white">
        <div class="container">
            {{-- Photo Gallery Grid with Action Icons --}}
            <div class="profile-gallery-wrapper mb-5 position-relative">
                <div class="action-icons-top">
                    <button class="icon-btn favorite-btn @if(in_array($influencer->id, $favoriteInfluencer)) active @endif" data-id="{{ $influencer->id }}">
                        <i class="las la-heart"></i>
                    </button>
                    <button class="icon-btn share-btn" onclick="copyProfileUrl()">
                        <i class="las la-share-alt"></i>
                    </button>
                </div>

                <div class="row g-2">
                    @php
                        $galleryImages = $influencer->galleries->where('video_url', null)->take(3);
                    @endphp
                    @foreach($galleryImages as $gallery)
                        <div class="col-md-4">
                            <div class="gallery-item h-100 overflow-hidden rounded-4 shadow-sm position-relative">
                                <img src="{{ getImage(getFilePath('profileGallery') . '/' . $gallery->image) }}" alt="gallery" class="w-100 h-100 object-fit-cover">
                                @if($gallery->video_url)
                                    <div class="video-indicator position-absolute top-50 start-50 translate-middle text-white fs-1" style="pointer-events: none; text-shadow: 0 0 20px rgba(0,0,0,0.5);">
                                        <i class="las la-play-circle"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($influencer->galleries->count() > 3)
                <button class="btn btn-white btn-sm position-absolute bottom-0 end-0 m-4 shadow-sm rounded-pill px-4 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#galleryModal">
                    <i class="las la-images me-1"></i> @lang('Show Portfolio')
                </button>
                @endif
            </div>

            <div class="row gy-5">
                <div class="col-lg-7">
                    <div class="influencer-header mb-5">
                        <div class="d-flex align-items-center gap-4 mb-4">
                            <div class="position-relative">
                                <img src="{{ getImage(getFilePath('influencer') . '/' . $influencer->image, getFileSize('influencer')) }}" alt="image" class="rounded-circle border" style="width: 100px; height: 100px; object-fit: cover;">
                                 @if($influencer->kv == Status::KYC_VERIFIED && $influencer->tax_number && $influencer->address)
                                    <span class="position-absolute bottom-0 end-0 bg-white rounded-circle d-flex align-items-center justify-content-center border" style="width: 25px; height: 25px; transform: translate(5%, 5%);">
                                        <i class="las la-check-circle text-primary fs-5"></i>
                                    </span>
                                @endif
                            </div>
                            <div>
                                <h1 class="fw-bold h2 mb-1 text-dark">{{ $influencer->firstname }}</h1>
                                <div class="d-flex flex-wrap align-items-center gap-3 text-secondary">
                                    <div class="rating-display d-flex align-items-center bg-light px-2 py-1 rounded">
                                            <i class="las la-star text--warning"></i>
                                        <span class="ms-1 fw-bold text-dark small">{{ getAmount($influencer->rating) }} ({{ getAmount($influencer->total_review) ?? 0 }})</span>
                                    </div>
                                    <div class="location small fw-medium">
                                        <i class="las la-map-marker fs-5"></i> {{ __(@$influencer->city) }}, {{ __(@$influencer->country_name) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="social-pills d-flex flex-wrap gap-2 mb-4">
                            @foreach ($influencer->socialLink as $social)
                                @php
                                    $platformName = strtolower($social->platform->name);
                                    $iconColor = '#666'; // Default
                                    if(str_contains($platformName, 'instagram')) $iconColor = '#E4405F';
                                    elseif(str_contains($platformName, 'facebook')) $iconColor = '#1877F2';
                                    elseif(str_contains($platformName, 'youtube')) $iconColor = '#FF0000';
                                    elseif(str_contains($platformName, 'tiktok')) $iconColor = '#000000';
                                    elseif(str_contains($platformName, 'twitter') || str_contains($platformName, 'x')) $iconColor = '#000000';
                                    elseif(str_contains($platformName, 'linkedin')) $iconColor = '#0077B5';
                                @endphp
                                <div class="social-pill d-flex align-items-center gap-2 border rounded-pill px-3 py-1 bg-white shadow-sm">
                                    <span class="fs-18" style="color: {{ $iconColor }};">@php echo $social->platform->icon @endphp</span>
                                    <span class="fw-bold small {{ !$showInsights ? 'blur-text' : '' }}">{{ getFollowerCount($social->followers) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="about-block">
                            <h4 class="fw-bold mb-3">@lang('About')</h4>
                            <p class="text-muted lh-base" style="font-size: 1.1rem;">{{ __($influencer->bio) }}</p>
                            
                            @if (!blank($influencer->skills))
                            <div class="mt-3">
                                @foreach ($influencer->skills as $skill)
                                    <span class="badge bg-light text-secondary border-0 me-1 mb-2 px-3 py-2 rounded-pill fw-normal">#{{ __($skill) }}</span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Tabs Navigation --}}
                    <ul class="nav nav-tabs border-0 gap-4 mb-4" id="profileTabs" role="tablist">
                        @if($influencer->engagement && $influencer->avg_views && $influencer->primary_gender)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold border-0 px-0 pb-2 bg-transparent text-dark" id="audience-tab" data-bs-toggle="tab" data-bs-target="#audience" type="button" role="tab" aria-selected="true">@lang('Audience')</button>
                        </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold border-0 px-0 pb-2 bg-transparent text-muted {{ !($influencer->engagement && $influencer->avg_views && $influencer->primary_gender) ? 'active text-dark' : '' }}" id="packages-tab" data-bs-toggle="tab" data-bs-target="#packages" type="button" role="tab" aria-selected="false">@lang('Packages')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold border-0 px-0 pb-2 bg-transparent text-muted" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-selected="false">@lang('Reviews')</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-2" id="profileTabsContent">
                        {{-- Audience Tab --}}
                        @if($influencer->engagement && $influencer->avg_views && $influencer->primary_gender)
                        <div class="tab-pane fade show active" id="audience" role="tabpanel">
                            <div class="position-relative">
                                @if(!$showInsights)
                                    <div class="insight-lock-overlay">
                                        <div class="text-center">
                                            <i class="las la-lock fs-2 mb-2 text-dark"></i>
                                            <h6 class="fw-bold mb-1">@lang('Subscribers Only')</h6>
                                            <p class="small text-muted mb-2">@lang('Unlock detailed audience metrics')</p>
                                            <a href="{{ route('pricing') }}" class="btn btn-dark btn-sm rounded-pill px-3">@lang('Upgrade Plan')</a>
                                        </div>
                                    </div>
                                @endif
                                <div class="row g-4 {{ !$showInsights ? 'blur-content' : '' }}">
                                    <div class="col-sm-4">
                                        <div class="card border rounded-4 p-4 text-center bg-light shadow-none h-100">
                                            <h6 class="text-muted mb-2 small text-uppercase fw-bold">@lang('Engagement')</h6>
                                            <h3 class="fw-bold mb-0">{{ $influencer->engagement }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card border rounded-4 p-4 text-center bg-light shadow-none h-100">
                                            <h6 class="text-muted mb-2 small text-uppercase fw-bold">@lang('Avg Views')</h6>
                                            <h3 class="fw-bold mb-0">{{ $influencer->avg_views }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card border rounded-4 p-4 text-center bg-light shadow-none h-100">
                                            <h6 class="text-muted mb-2 small text-uppercase fw-bold">@lang('Primary Gender')</h6>
                                            <h3 class="fw-bold mb-0">{{ $influencer->primary_gender }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Packages Tab --}}
                        <div class="tab-pane fade {{ !($influencer->engagement && $influencer->avg_views && $influencer->primary_gender) ? 'show active' : '' }}" id="packages" role="tabpanel">
                            {{-- Dynamic Platform Filter Tabs --}}
                            <ul class="nav nav-pills mb-3 gap-2" id="platform-filters" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active rounded-pill btn-sm px-3 fw-bold" data-filter="all">@lang('All')</button>
                                </li>
                                @php
                                    $uniquePlatformIds = $influencer->packages->pluck('platform_id')->unique();
                                    $availablePlatforms = \App\Models\Platform::whereIn('id', $uniquePlatformIds)->get();
                                @endphp
                                @foreach($availablePlatforms as $platform)
                                    @php
                                        $pName = strtolower($platform->name);
                                        $pColor = '#666';
                                        if(str_contains($pName, 'instagram')) $pColor = '#E4405F';
                                        elseif(str_contains($pName, 'facebook')) $pColor = '#1877F2';
                                        elseif(str_contains($pName, 'youtube')) $pColor = '#FF0000';
                                    @endphp
                                    <li class="nav-item">
                                        <button class="nav-link rounded-pill btn-sm px-3 fw-bold d-flex align-items-center gap-2" data-filter="platform-{{ $platform->id }}">
                                            <span style="color: {{ $pColor }};">@php echo $platform->icon @endphp</span> {{ $platform->name }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="d-flex flex-column gap-3">
                                @foreach ($influencer->packages ?? [] as $package)
                                <div class="package-wrapper filter-item platform-{{ $package->platform_id }}">
                                    <div class="package-item border rounded-4 p-4 shadow-sm bg-white hover-shadow transition cursor-pointer"
                                         onclick="selectPackage(this)"
                                         data-id="{{ $package->id }}"
                                         data-name="{{ __($package->name) }}"
                                         data-price="{{ showAmount($package->price) }}">
                                        
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-3">
                                                @if($package->platform)
                                                    <div class="social-icon fs-2 text-muted">
                                                        @php echo $package->platform->icon @endphp
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1">
                                                    <h5 class="fw-bold mb-1">{{ __($package->name) }}</h5>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <div class="text-muted small text-truncate" style="max-width: 250px;">
                                                            {{ __($package->description) }}
                                                        </div>
                                                        <span class="cursor-pointer text-muted" onclick="event.stopPropagation(); toggleDetails('details-{{ $package->id }}', this)">
                                                            <i class="las la-plus fs-6"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="h4 fw-bold mb-0 text-nowrap">{{ showAmount($package->price) }} <span class="fs-6 text-muted">+ GST</span></span>
                                                <div class="form-check m-0">
                                                    <input type="radio" name="package_select" class="form-check-input" style="transform: scale(1.3); cursor: pointer;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Expanded Details --}}
                                    <div id="details-{{ $package->id }}" class="collapse">
                                        <div class="p-4 bg-light border-start border-end border-bottom rounded-bottom-4 mx-2 mt-n2 position-relative" style="top: -5px; z-index: 0;">
                                            <h6 class="fw-bold small text-uppercase text-muted mb-2">@lang('Description')</h6>
                                            <p class="text-muted mb-3 small lh-base">{{ __($package->description) }}</p>
                                            
                                            <div class="d-flex flex-wrap gap-2">
                                                @if($package->delivery_time)
                                                    <span class="badge bg-white text-secondary border fw-normal">
                                                        <i class="las la-clock"></i> {{ $package->delivery_time }} @lang('Days')
                                                    </span>
                                                @endif
                                                @if($package->post_count)
                                                    <span class="badge bg-white text-secondary border fw-normal">
                                                        <i class="las la-copy"></i> {{ $package->post_count }} @lang('Post')
                                                    </span>
                                                @endif
                                                @if($package->video_length)
                                                    <span class="badge bg-white text-secondary border fw-normal">
                                                        <i class="las la-video"></i> {{ $package->video_length }}@lang('s')
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                {{-- Custom Package Card --}}
                                <div class="custom-package-card border-dashed p-4 rounded-4 text-center mt-2 cursor-pointer hover-shadow transition" onclick="window.location.href='{{ route('user.participant.create.inquiry', $influencer->id) }}'">
                                    <div class="mb-2 text-muted">
                                        <i class="las la-magic fs-2"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1">@lang('Create Custom Package')</h6>
                                    <p class="text-muted small mb-0">@lang('Need something specific? Start a chat to discuss.')</p>
                                </div>
                            </div>
                        </div>
                                {{-- Reviews Tab --}}
        <div class="tab-pane fade" id="reviews" role="tabpanel">
            <div class="d-flex flex-column gap-3">
                @forelse ($reviews as $review)
                    <div class="review-item border rounded-4 p-4 shadow-sm bg-white">
                        <div class="d-flex gap-3 align-items-center">
                            {{-- Brand Profile Picture --}}
                            <img src="{{ getImage(getFilePath('brand') . '/' . $review->user->image) }}" 
                                alt="{{ $review->user->username }}" 
                                class="rounded-circle border" 
                                style="width: 52px; height: 52px; object-fit: cover;">
                    
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">{{ $review->user->fullname }}</h6>
                                        <span class="text-muted tiny-label" style="font-size: 0.7rem;">{{ showDateTime($review->created_at, 'M d, Y') }}</span>
                                    </div>
                            
                                    {{-- Star Icon + Number --}}
                                    <div class="bg-light px-3 py-1 rounded-pill border d-flex align-items-center gap-1">
                                        <i class="las la-star text--warning fs-5"></i>
                                        <span class="fw-bold text-dark small">{{ getAmount($review->star) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                        <div class="mt-3">
                            <p class="text-muted mb-0 small lh-base" style="font-size: 0.95rem;">
                                {{ __($review->review) }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 border rounded-4 bg-light">
                        <div class="mb-2 text-muted">
                            <i class="las la-comment-slash fs-1 opacity-25"></i>
                        </div>
                        <p class="text-muted fw-bold mb-0">@lang('No reviews yet')</p>
                        <small class="text-muted">@lang('Be the first brand to leave feedback!')</small>
                    </div>
                @endforelse
            </div>
        </div>
    </div> </div>    
                {{-- STICKY WIDGET AREA --}}
                <div class="col-lg-5 col-xl-4 offset-xl-1">
                    <div class="sticky-sidebar">
                        <div class="card border-0 rounded-4 shadow-lg p-4 mb-4 bg-white">
                            <h4 class="fw-bold mb-4">@lang('Hire') {{ $influencer->firstname }}</h4>

                            <div id="selection-summary" class="mb-4 d-none border-bottom pb-4">
                                <div class="p-3 bg-light rounded-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="small text-muted">@lang('Package'):</span>
                                        <span class="fw-bold small text-truncate ms-2" id="selected-name"></span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small text-muted">@lang('Total'):</span>
                                        <span class="h5 fw-bold mb-0 text-dark" id="selected-price"></span>
                                    </div>
                                </div>
                                @auth
                                    <form id="buy-form" action="" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-dark w-100 rounded-pill py-3 fw-bold fs-6">@lang('Buy Now')</button>
                                    </form>
                                @else
                                    <a href="{{ route('user.login') }}" class="btn btn-dark w-100 rounded-pill py-3 fw-bold fs-6">@lang('Login to Order')</a>
                                @endauth
                            </div>

                            <div class="d-grid gap-3">
                                @auth
                                <a href="{{ route('user.participant.create.inquiry', $influencer->id) }}" class="btn btn--base rounded-pill py-3 fw-bold fs-6 text-white">
                                 @lang('Message Now')
                                </a>
                                @else
                                 <a href="{{ route('user.login') }}" class="btn btn--base rounded-pill py-3 fw-bold fs-6 text-white">
                                @lang('Message Now')
                                </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Fullscreen Gallery Modal --}}
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold ms-3 mt-2">@lang('Portfolio')</h5>
                    <button type="button" class="btn-close m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        @foreach($influencer->galleries as $gallery)
                            <div class="col-md-4 col-sm-6">
                                <div class="gallery-modal-item rounded-3 overflow-hidden shadow-sm h-100 position-relative">
                                    @if($gallery->video_url)
                                        <div class="ratio ratio-16x9 h-100">
                                            @if($gallery->video_type == 'youtube')
                                                @php
                                                    $videoId = '';
                                                    if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $gallery->video_url, $matches)) {
                                                        $videoId = $matches[1];
                                                    } elseif (preg_match('/youtube\.com.*v=([a-zA-Z0-9_-]+)/', $gallery->video_url, $matches)) {
                                                        $videoId = $matches[1];
                                                    }
                                                @endphp
                                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" allowfullscreen></iframe>
                                            @else
                                                <video controls class="w-100 h-100 object-fit-cover">
                                                    <source src="{{ $gallery->video_url }}" type="video/mp4">
                                                </video>
                                            @endif
                                        </div>
                                    @else
                                        <img src="{{ getImage(getFilePath('profileGallery') . '/' . $gallery->image) }}" alt="gallery" class="w-100 h-100 object-fit-cover" style="min-height: 250px;">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    // Platform Filtering Logic
    $('#platform-filters .nav-link').on('click', function() {
        $('#platform-filters .nav-link').removeClass('active bg-dark text-white').addClass('text-muted');
        $(this).addClass('active bg-dark text-white').removeClass('text-muted');
        
        const filter = $(this).data('filter');
        if(filter === 'all') {
            $('.filter-item').fadeIn();
        } else {
            $('.filter-item').hide();
            $('.' + filter).fadeIn();
        }
    });

    function toggleDetails(id, btn) {
        $('#' + id).collapse('toggle');
        // Toggle Icon
        let icon = $(btn).find('i');
        if(icon.hasClass('la-plus')) {
            icon.removeClass('la-plus').addClass('la-minus');
        } else {
            icon.removeClass('la-minus').addClass('la-plus');
        }
    }

    function selectPackage(el) {
        // Toggle Deselect Logic
        if ($(el).hasClass('selected-package')) {
            $(el).removeClass('selected-package border-dark shadow-sm').addClass('border-light');
            $(el).find('input[type="radio"]').prop('checked', false);
            
            $('#selection-summary').addClass('d-none');
            $('#selected-name').text('');
            $('#selected-price').text('');
            $('#buy-form').attr('action', '');
            return;
        }

        // Reset others
        $('.package-item').removeClass('selected-package border-dark shadow-sm').addClass('border-light');
        $('.package-item input[type="radio"]').prop('checked', false);

        // Select clicked
        $(el).addClass('selected-package border-dark shadow-sm').removeClass('border-light');
        $(el).find('input[type="radio"]').prop('checked', true);

        const name = $(el).data('name');
        const price = $(el).data('price');
        const id = $(el).data('id');

        $('#selected-name').text(name);
        $('#selected-price').text(price);
        $('#buy-form').attr('action', `{{ route('user.participant.buy.service', '') }}/${id}`);
        $('#selection-summary').removeClass('d-none');
    }

    function copyProfileUrl() {
        navigator.clipboard.writeText(window.location.href);
        // You can replace this alert with a toast notification
        alert('Profile URL copied to clipboard!');
    }

    $('.favorite-btn').on('click', function() {
        @auth
            const btn = $(this);
            const id = btn.data('id');
            $.post("{{ route('user.favorite.add') }}", {
                influencerId: id,
                _token: "{{ csrf_token() }}"
            }, function(response) {
                if(response.success) {
                    btn.toggleClass('active');
                } else if (response.error) {
                    alert(response.error);
                }
            });
        @else
            window.location.href = "{{ route('user.login') }}";
        @endauth
    });
</script>
@endpush

@push('style')
<style>
    :root {
        --base-color: hsl(var(--base-h), var(--base-s), var(--base-l));
        --base-color-rgba: hsla(var(--base-h), var(--base-s), var(--base-l), 0.1);
        --base-color-rgba-2: hsla(var(--base-h), var(--base-s), var(--base-l), 0.2);
    }
    body {
        background-color: #fff !important;
    }
    .rounded-4 { border-radius: 1.25rem !important; }
    .gallery-item img {
        height: 400px !important;
        transition: transform 0.3s ease;
    }
    .gallery-item:hover img {
        transform: scale(1.05);
    }
    .btn-white {
        background-color: #fff;
        color: #000 !important;
        border: 1px solid #eee;
    }
    .btn-white:hover {
        background-color: #f8f9fa;
    }
    .social-pill {
        transition: all 0.2s ease;
    }
    .social-pill:hover {
        transform: translateY(-2px);
        background-color: #f8f9fa !important;
    }
    .hover-shadow:hover {
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.08)!important;
    }
    .transition {
        transition: all 0.2s ease;
    }
    .last-child-no-border:last-child {
        border-bottom: none !important;
    }
    
    /* Sticky Sidebar Logic */
    .sticky-sidebar {
        position: sticky;
        top: 40px;
        z-index: 5;
    }
    
    /* Action Icons Style */
    .action-icons-top {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 10;
        display: flex;
        gap: 10px;
    }
    .icon-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: none;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #444;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .icon-btn:hover {
        transform: translateY(-3px);
        background: #fff;
    }
    .favorite-btn.active {
        color: #ff385c;
    }
    .favorite-btn.active i {
        font-weight: 900;
    }

    .cursor-pointer { cursor: pointer; }
    .btn-dark {
        background-color: #000;
        border: none;
    }
    .btn-dark:hover {
        background-color: #222;
    }
    .lh-base { line-height: 1.6 !important; }

    .nav-tabs .nav-link {
        border-bottom: 3px solid transparent !important;
        transition: all 0.3s ease;
    }
    .nav-tabs .nav-link.active {
        border-bottom-color: var(--base-color) !important;
        color: var(--base-color) !important;
    }
    .nav-tabs .nav-link:hover {
        color: var(--base-color) !important;
    }

    /* Filter Tabs Styles */
    .nav-pills .nav-link {
        color: #666;
        background: #f8f9fa;
        border: 1px solid #eee;
        transition: all 0.2s;
    }
    .nav-pills .nav-link:hover {
        background-color: #eee;
    }
    .nav-pills .nav-link.active {
        background-color: var(--base-color) !important;
        color: #fff !important;
        border-color: var(--base-color);
        box-shadow: 0 4px 10px var(--base-color-rgba-2);
    }
    
    /* Selected Package State */
    .selected-package {
        border-color: var(--base-color) !important;
        background-color: var(--base-color-rgba) !important;
        transform: translateY(-3px);
    }

    .rating-display i {
        color: var(--base-color) !important;
    }

    .text--warning {
        color: var(--base-color) !important;
    }
    
    /* Custom Styling for Platform icons in packages */
    .social-icon {
        transition: color 0.3s;
    }
    .package-item:hover .social-icon {
        color: var(--base-color) !important;
    }
    
    /* Expand Button */
    .expand-btn {
        width: 30px; 
        height: 30px; 
        display: flex; 
        align-items: center; 
        justify-content: center;
    }
    
    .border-dashed {
        border-style: dashed !important;
    }

    /* INSIGHT BLURRING */
    .blur-text {
        filter: blur(4px);
        user-select: none;
    }
    .blur-content {
        filter: blur(12px);
        pointer-events: none;
        user-select: none;
        opacity: 0.6;
    }
    .insight-lock-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.1);
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 1.25rem;
    }
</style>
@endpush



