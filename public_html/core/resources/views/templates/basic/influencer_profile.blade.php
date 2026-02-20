@extends($activeTemplate . 'layouts.frontend')
@section('content')
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
                        $galleryImages = $influencer->galleries->take(3);
                    @endphp
                    @foreach($galleryImages as $gallery)
                        <div class="col-md-4">
                            <div class="gallery-item h-100 overflow-hidden rounded-4 shadow-sm">
                                <img src="{{ getImage(getFilePath('profileGallery') . '/' . $gallery->image) }}" alt="gallery" class="w-100 h-100 object-fit-cover">
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($influencer->galleries->count() > 3)
                <button class="btn btn-white btn-sm position-absolute bottom-0 end-0 m-4 shadow-sm rounded-pill px-4 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#galleryModal">
                    <i class="las la-images me-1"></i> @lang('Show all photos')
                </button>
                @endif
            </div>

            <div class="row gy-5">
                <div class="col-lg-7">
                    <div class="influencer-header mb-5">
                        <div class="d-flex align-items-center gap-4 mb-4">
                            <img src="{{ getImage(getFilePath('influencer') . '/' . $influencer->image, getFileSize('influencer')) }}" alt="image" class="rounded-circle border" style="width: 100px; height: 100px; object-fit: cover;">
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
                                <div class="social-pill d-flex align-items-center gap-2 border rounded-pill px-3 py-1 bg-white shadow-sm">
                                    <span class="fs-18">@php echo $social->platform->icon @endphp</span>
                                    <span class="fw-bold small">{{ getFollowerCount($social->followers) }}</span>
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
                            <button class="nav-link active fw-bold border-0 px-0 pb-2 bg-transparent text-dark border-bottom-2" id="audience-tab" data-bs-toggle="tab" data-bs-target="#audience" type="button" role="tab" aria-selected="true">@lang('Audience')</button>
                        </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold border-0 px-0 pb-2 bg-transparent text-muted {{ !($influencer->engagement && $influencer->avg_views && $influencer->primary_gender) ? 'active text-dark border-bottom-2' : '' }}" id="packages-tab" data-bs-toggle="tab" data-bs-target="#packages" type="button" role="tab" aria-selected="false">@lang('Packages')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold border-0 px-0 pb-2 bg-transparent text-muted" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-selected="false">@lang('Reviews')</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-2" id="profileTabsContent">
                        {{-- Audience Tab --}}
                        @if($influencer->engagement && $influencer->avg_views && $influencer->primary_gender)
                        <div class="tab-pane fade show active" id="audience" role="tabpanel">
                            <div class="row g-4">
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
                        @endif

                        {{-- Packages Tab --}}
                        <div class="tab-pane fade {{ !($influencer->engagement && $influencer->avg_views && $influencer->primary_gender) ? 'show active' : '' }}" id="packages" role="tabpanel">
                            <div class="d-flex flex-column gap-3">
                                @foreach ($influencer->packages ?? [] as $package)
                                <div class="package-item border rounded-4 p-4 shadow-sm bg-white hover-shadow transition cursor-pointer"
                                     onclick="selectPackage(this)"
                                     data-id="{{ $package->id }}"
                                     data-name="{{ __($package->name) }}"
                                     data-price="{{ showAmount($package->price) }}">
                                    <div class="row align-items-center">
                                        <div class="col-1">
                                            <input type="radio" name="package_select" class="form-check-input" style="transform: scale(1.2);">
                                        </div>
                                        <div class="col-sm-7">
                                            <h5 class="fw-bold mb-2">{{ __($package->name) }}</h5>
                                            <p class="text-muted small mb-0">{{ __($package->description) }}</p>
                                        </div>
                                        <div class="col-sm-4 text-sm-end mt-3 mt-sm-0">
                                            <span class="h4 fw-bold mb-2">{{ showAmount($package->price) }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- Reviews Tab --}}
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            @forelse ($reviews as $review)
                                <div class="review-card border-bottom pb-4 mb-4 last-child-no-border">
                                    <div class="d-flex gap-3 align-items-start">
                                        <img src="{{ getImage(getFilePath('userProfile') . '/' . $review->user->image, getFileSize('userProfile')) }}" alt="user" class="rounded-circle border" style="width: 48px; height: 48px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="fw-bold mb-0 text-dark">{{ $review->user->fullname }}</h6>
                                                <span class="text-muted small">@php echo showRatings($review->rating) @endphp</span>
                                            </div>
                                            <p class="text-muted mb-0 small">{{ __($review->review) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted small">@lang('No reviews yet')</p>
                            @endforelse
                        </div>
                    </div>
                </div>

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
                                <a href="{{ route('user.participant.create.inquiry', $influencer->id) }}" class="btn btn-dark rounded-pill py-3 fw-bold fs-6 text-white">
                                 @lang('Message Now')
                                </a>
                                @else
                                 <a href="{{ route('user.login') }}" class="btn btn-dark rounded-pill py-3 fw-bold fs-6 text-white">
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
                                <div class="gallery-modal-item rounded-3 overflow-hidden shadow-sm h-100">
                                    <img src="{{ getImage(getFilePath('profileGallery') . '/' . $gallery->image) }}" alt="gallery" class="w-100 h-100 object-fit-cover" style="min-height: 250px;">
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
    function selectPackage(el) {
        $('.package-item').removeClass('border-dark shadow-sm').addClass('border-light');
        $(el).addClass('border-dark shadow-sm').removeClass('border-light');
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
                influencer_id: id,
                _token: "{{ csrf_token() }}"
            }, function(response) {
                if(response.success) {
                    btn.toggleClass('active');
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
        color: #000;
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
        border-bottom: 2px solid transparent !important;
    }
    .nav-tabs .nav-link.active {
        border-bottom-color: #000 !important;
    }
</style>
@endpush