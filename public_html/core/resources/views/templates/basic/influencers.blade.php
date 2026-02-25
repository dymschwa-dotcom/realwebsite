@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="infuencer-section pt-40 pb-120 position-relative">
        @php
            $isLoggedIn = auth()->check() || auth()->guard('influencer')->check();
        @endphp

        @if(!$isLoggedIn)
            <div class="gate-overlay">
                <div class="gate-card text-center">
                    <h3 class="fw-bold mb-3">@lang('Want to see more?')</h3>
                    <p class="mb-4 text-muted">@lang('Join thousands of brands and influencers on the platform.')</p>

                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mb-4">
                        <a href="{{ route('user.register') }}" class="btn btn--base px-4 py-3 rounded-pill fw-bold shadow">
                            <i class="las la-briefcase me-1"></i> @lang('Sign Up as Brand')
                        </a>
                        <a href="{{ route('influencer.register') }}" class="btn btn--base px-4 py-3 rounded-pill fw-bold shadow">
                            <i class="las la-user-circle me-1"></i> @lang('Sign Up as Influencer')
                        </a>
                    </div>

                    <p class="small text-muted">@lang('Already have an account?') <a href="{{ route('user.login') }}" class="text--base fw-bold">@lang('Log In')</a></p>
                </div>
            </div>
        @endif

        <div class="container @if(!$isLoggedIn) gated-content @endif">
                        <form id="influencerFilterForm" action="" method="GET">
                @php
                    $currentPlatforms = array_unique(array_filter(array_merge((array)request()->platform_name, request()->platform ? [request()->platform] : [])));
                    $currentCategories = (array)request()->category;
                    $currentFollowers = (array)request()->follower_range;
                    $currentGenders = (array)request()->gender;
                    $currentRegions = (array)request()->region;
                    $currentAges = (array)request()->age_range;
                @endphp
                
                {{-- 1. HERO SEARCH BAR SECTION --}}
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-11">
                        <div class="hero-filter-box p-2 d-flex align-items-center">
                            
                            {{-- PLATFORM PILL --}}
<div class="dropdown flex-grow-1 position-static">
    <button class="hero-pill dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
        <div class="pill-label">@lang('Platform')</div>
        <div class="pill-selected">@lang('All Platforms')</div>
    </button>
    <div class="dropdown-menu mega-menu-content p-5 shadow-lg border-0">
        <h5 class="mb-4 fw-bold">@lang('Social Platforms')</h5>
        <div class="row g-4">
            @foreach ($platforms as $platform)
                <div class="col-6 col-md-3">
                    <div class="form-check custom--check platform-item p-3 border rounded">
                        <input class="form-check-input" type="checkbox" name="platform_name[]" value="{{ $platform->name }}" id="plat_{{ $loop->index }}">
                        <label class="form-check-label fw-bold ms-2" for="plat_{{ $loop->index }}">
                            {{ __($platform->name) }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="hero-divider"></div>

{{-- CATEGORY PILL --}}
<div class="dropdown flex-grow-1 position-static">
    <button class="hero-pill dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
        <div class="pill-label">@lang('Category')</div>
        <div class="pill-selected">@lang('All Categories')</div>
    </button>
    <div class="dropdown-menu mega-menu-content p-5 shadow-lg border-0">
        <h5 class="mb-4 fw-bold">@lang('Filter by Niche')</h5>
        <div class="category-grid">
            @foreach ($categories as $category)
                <div class="form-check custom--check category-item p-2">
                    <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->slug }}" id="cat_{{ $loop->index }}">
                    <label class="form-check-label ms-2" for="cat_{{ $loop->index }}">{{ __($category->name) }}</label>
                </div>
            @endforeach
        </div>
    </div>
</div>

                            <div class="ps-2 pe-1">
                                <button type="submit" class="hero-search-btn">
                                    <i class="las la-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. SECONDARY PILLS ROW --}}
                <div class="d-flex justify-content-center align-items-center flex-wrap gap-3 mb-5">
                    
                    {{-- Followers Pill --}}
                    <div class="dropdown">
                        <button class="btn sub-pill dropdown-toggle @if(count($currentFollowers)) border--base text--base @endif" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            @lang('Followers') {{ count($currentFollowers) ? '('.count($currentFollowers).')' : '' }}
                        </button>
                        <div class="dropdown-menu giant-pill-menu p-4">
                            <h6 class="mb-4 fw-bold border-bottom pb-2">@lang('Follower Count')</h6>
                            <div class="row g-3">
                                @php
                                    $ranges = ['1_5' => '1k - 5K', '5_20' => '5k - 20K', '20_50' => '20k - 50K', '50_100' => '50k - 100K', '100_500' => '100K - 500K', '500_1000' => '500K - 1M', '1000000' => '1M+'];
                                @endphp
                                @foreach ($ranges as $key => $label)
                                    <div class="col-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="follower_range[]" value="{{ $key }}" id="fol_{{ $loop->index }}" @checked(in_array($key, $currentFollowers))>
                                            <label class="form-check-label text-nowrap ms-2" for="fol_{{ $loop->index }}">{{ $label }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>                            
                        </div>
                    </div>

                    {{-- Price Pill --}}
                    <div class="dropdown">
                        <button class="btn sub-pill dropdown-toggle @if(request()->min_price || request()->max_price) border--base text--base @endif" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            @lang('Price Range')
                        </button>
                        <div class="dropdown-menu giant-pill-menu p-4">
                            <h6 class="mb-4 fw-bold border-bottom pb-2">@lang('Budget')</h6>
                            <div class="row g-4">
                                <div class="col-6">
                                    <label class="tiny-label">@lang('Min ($)')</label>
                                    <input type="number" name="min_price" class="form--control py-3 rounded-pill px-4" value="{{ request()->min_price }}" placeholder="0">
                                </div>
                                <div class="col-6">
                                    <label class="tiny-label">@lang('Max ($)')</label>
                                    <input type="number" name="max_price" class="form--control py-3 rounded-pill px-4" value="{{ request()->max_price }}" placeholder="5000">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Gender Pill --}}
                    <div class="dropdown">
                        <button class="btn sub-pill dropdown-toggle @if(count($currentGenders)) border--base text--base @endif" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            @lang('Gender') {{ count($currentGenders) ? '('.count($currentGenders).')' : '' }}
                        </button>
                        <div class="dropdown-menu giant-pill-menu p-4">
                            <h6 class="mb-4 fw-bold border-bottom pb-2">@lang('Gender')</h6>
                            <div class="row g-2">
                                @foreach(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $val => $label)
                                    <div class="col-6">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="gender[]" value="{{ $val }}" id="gen_{{ $val }}" @checked(in_array($val, $currentGenders))>
                                            <label class="form-check-label fw-medium ms-2 text-nowrap" for="gen_{{ $val }}">@lang($label)</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Region (Location) Pill --}}
                    <div class="dropdown">
                        <button class="btn sub-pill dropdown-toggle @if(count($currentRegions)) border--base text--base @endif" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            @lang('Location') {{ count($currentRegions) ? '('.count($currentRegions).')' : '' }}
                        </button>
                        <div class="dropdown-menu giant-pill-menu p-4">
                            <h6 class="mb-4 fw-bold border-bottom pb-2">@lang('Filter by Region')</h6>
                            <div class="category-grid" style="max-height: 350px;">
                                @php
                                    $regions = json_decode(file_get_contents(resource_path('views/partials/regions.json')), true);
                                    $allRegions = array_merge($regions['New Zealand'], $regions['Australia']);
                                    sort($allRegions);
                                @endphp
                                @foreach ($allRegions as $region)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="region[]" value="{{ $region }}" id="reg_{{ $loop->index }}" @checked(in_array($region, $currentRegions))>
                                        <label class="form-check-label small ms-2" for="reg_{{ $loop->index }}">{{ __($region) }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Age Pill --}}
                    <div class="dropdown">
                        <button class="btn sub-pill dropdown-toggle @if(count($currentAges)) border--base text--base @endif" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            @lang('Age') {{ count($currentAges) ? '('.count($currentAges).')' : '' }}
                        </button>
                        <div class="dropdown-menu giant-pill-menu p-4">
                            <h6 class="mb-4 fw-bold border-bottom pb-2">@lang('Age Bracket')</h6>
                            <div class="row g-2">
                                @foreach(['18_24' => '18 - 24', '25_34' => '25 - 34', '35_44' => '35 - 44', '45_100' => '45+'] as $key => $label)
                                    <div class="col-6">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="age_range[]" value="{{ $key }}" id="age_{{ $key }}" @checked(in_array($key, $currentAges))>
                                            <label class="form-check-label fw-medium ms-2 text-nowrap" for="age_{{ $key }}">{{ $label }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('influencer.all') }}" class="clear-all-link ms-4 text-nowrap">@lang('Clear all filters')</a>
                </div>
            </form>

            {{-- 3. RESULTS --}}
            @if (!blank($influencers))
                <div class="row justify-content-center g-3 g-md-4 mt-4">
                    @include($activeTemplate . 'partials.filtered_influencer')
                </div>
                <div class="mt-5">
                    {{ paginateLinks($influencers) }}
                </div>
            @else
                {{-- FUN ANIMATION PLACEHOLDER --}}
                @include($activeTemplate . 'partials.empty_animation', ['resetRoute' => route('influencer.all')])
            @endif
        </div>
    </div>
@endsection

@push('script')
<script>
    (function ($) {
        "use strict";

        // 1. Remove internal apply buttons so user uses the main search icon
        $('.dropdown-menu').find('.btn--base, .btn--sm, .d-flex.justify-content-end').remove();

        // 2. Update labels ONLY while the user is interacting
        $('.form-check-input').on('change', function() {
            let $dropdown = $(this).closest('.dropdown');
            let $pillSelected = $dropdown.find('.pill-selected');
            let $subPill = $dropdown.find('.sub-pill');
            let name = $(this).attr('name');
            let checkedInputs = $dropdown.find('input:checked');
            let count = checkedInputs.length;

            if (name === 'platform_name[]') {
                let vals = [];
                checkedInputs.each(function() { vals.push($(this).val()); });
                $pillSelected.text(count > 0 ? vals.join(', ') : "@lang('Select Platforms')");
            } 
            else if (name === 'category[]') {
                $pillSelected.text(count > 0 ? count + ' ' + "@lang('selected')" : "@lang('All Categories')");
            } 
            else if ($subPill.length > 0) {
                let baseText = $subPill.data('base-text') || $subPill.text().split(' (')[0].trim();
                if (!$subPill.data('base-text')) $subPill.data('base-text', baseText);
                
                $subPill.text(count > 0 ? baseText + " (" + count + ")" : baseText);
                count > 0 ? $subPill.addClass('border--base text--base') : $subPill.removeClass('border--base text--base');
            }
        });

        // We do NOT initialize labels on page load, so they always reset to default.
    })(jQuery);
</script>
@endpush

@push('style')
<style>
    /* HERO BOX & SEARCH ICON FIX */
    .hero-filter-box { background: #fff; border: 1px solid #e2e8f0; border-radius: 100px; box-shadow: 0 4px 30px rgba(0,0,0,0.06); }
    .hero-pill { background: transparent; border: none; text-align: left; padding: 12px 35px; transition: 0.2s; }
    .hero-pill:hover { background: #f8fafc; border-radius: 100px; }
    .hero-pill::after { display: none; }
    .pill-label { font-size: 11px; font-weight: 800; text-transform: uppercase; color: #1a202c; letter-spacing: 0.8px; }
    .pill-selected { font-size: 15px; font-weight: 500; color: #718096; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .hero-divider { width: 1px; height: 50px; background: #e2e8f0; flex-shrink: 0; }
    .hero-search-btn { background: #ff385c; color: white; border: none; width: 58px; height: 58px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; transition: 0.2s; flex-shrink: 0; }
    .hero-search-btn:hover { background: #e31c5f; transform: scale(1.08); }

    /* MEGA & GIANT DROPDOWNS */
    .mega-menu-content {
        width: 100vw !important;
        max-width: 950px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
        margin-top: 25px !important;
        border-radius: 32px !important;
        z-index: 2000;
        padding: 4rem !important; /* Increased padding */
    }
    
    .giant-pill-menu {
        min-width: 450px !important;
        border-radius: 28px !important;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.18) !important;
        border: none !important;
        margin-top: 15px !important;
        padding: 3.5rem !important; /* Increased padding */
    }
    .category-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; max-height: 450px; overflow-y: auto; } /* Increased gap */
    
    .text-nowrap { white-space: nowrap !important; }

    /* SECONDARY PILLS */
    .sub-pill { background: #fff; border: 1px solid #cbd5e0 !important; border-radius: 50px !important; padding: 12px 30px !important; font-size: 14px; font-weight: 700; color: #2d3748 !important; white-space: nowrap; }
    .sub-pill:hover { border-color: #ff385c !important; }
    
    .tiny-label { font-size: 11px; font-weight: 800; color: #718096; text-transform: uppercase; margin-bottom: 8px; display: block; }
    .clear-all-link { font-size: 15px; font-weight: 700; color: #1a202c; text-decoration: underline; text-underline-offset: 4px; }
    .clear-all-link:hover { color: #ff385c; }

    /* CHECKBOX THEME */
    .custom--check .form-check-input { width: 1.4em; height: 1.4em; cursor: pointer; border: 2px solid #cbd5e0; }
    .custom--check .form-check-input:checked { background-color: #ff385c; border-color: #ff385c; }

    /* COLLABSTR STYLE INFLUENCER CARDS */
    .influencer-card {
        border: none;
        background: transparent;
        transition: transform 0.2s ease-in-out;
    }
    .influencer-card:hover {
        transform: translateY(-5px);
    }
    .influencer-card__img-wrapper {
        position: relative;
        aspect-ratio: 4 / 5;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .influencer-card__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center 20%;
        transition: scale 0.4s ease;
    }
    .influencer-card:hover .influencer-card__img {
        scale: 1.05;
    }
    .influencer-card__overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 20px;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);
        pointer-events: none;
    }
    .influencer-card__info-wrap {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .influencer-card__name {
        font-size: 18px;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    .influencer-card__rating {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 14px;
    }
    .star-icon {
        color: #ffb400;
    }
    .influencer-card__location {
        font-size: 14px;
        font-weight: 500;
    }
    .influencer-card__location i {
        font-size: 16px;
    }

    .favoriteBtn {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 10;
        width: 35px;
        height: 35px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 18px;
        color: #ff385c;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .favoriteBtn:hover {
        background: #fff;
        transform: scale(1.1);
    }
    .favoriteBtn.active i {
        font-weight: 900;
    }

    /* GATED CONTENT STYLES */
    @if(!$isLoggedIn)
    .gated-content {
        filter: blur(5px);
        pointer-events: none;
        user-select: none;
        opacity: 0.9;
    }
    .gate-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding-top: 300px;
        background: rgba(0, 0, 0, 0.5);
    }
    .gate-card {
        background: #fff;
        padding: 4.5rem 3.5rem;
        border-radius: 40px;
        box-shadow: 0 40px 80px -15px rgba(0,0,0,0.35);
        max-width: 750px;
        width: 90%;
        border: 1px solid rgba(0,0,0,0.05);
        animation: fadeInUp 0.6s ease-out;
    }
    .gate-card h3 {
        font-size: 2.5rem;
    }
    .gate-card p.mb-4 {
        font-size: 1.2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @endif
</style>
@endpush

