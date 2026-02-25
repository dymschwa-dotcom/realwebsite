@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="campaign-section pt-40 pb-120">
        <div class="container">
                        <form id="campaignFilterForm" action="" method="GET">
                
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
                        <button class="btn sub-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            @lang('Followers Required')
                        </button>
                        <div class="dropdown-menu giant-pill-menu p-4">
                            <h6 class="mb-4 fw-bold border-bottom pb-2">@lang('Follower Requirement')</h6>
                            <div class="row g-3">
                                @php
                                    $ranges = ['1_5' => '1k - 5K', '5_20' => '5k - 20K', '20_50' => '20k - 50K', '50_100' => '50k - 100K', '100_500' => '100K - 500K', '500_1000' => '500K - 1M', '1000000' => '1M+'];
                                @endphp
                                @foreach ($ranges as $key => $label)
                                    <div class="col-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="follower_range[]" value="{{ $key }}" id="fol_{{ $loop->index }}">
                                            <label class="form-check-label text-nowrap ms-2" for="fol_{{ $loop->index }}">{{ $label }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Gender Pill --}}
                    <div class="dropdown">
                        <button class="btn sub-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            @lang('Gender')
                        </button>
                        <div class="dropdown-menu giant-pill-menu p-4">
                            <h6 class="mb-4 fw-bold border-bottom pb-2">@lang('Target Gender')</h6>
                            <div class="row g-2">
                                @foreach(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $val => $label)
                                    <div class="col-6">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="gender[]" value="{{ $val }}" id="gen_{{ $val }}">
                                            <label class="form-check-label fw-medium ms-2 text-nowrap" for="gen_{{ $val }}">@lang($label)</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                
                @if (authInfluencer())
                        <div class="form-check custom--check mb-0 ms-3">
                            <input class="form-check-input" type="checkbox" name="eligible_only" value="1" id="eligible_only" @checked(request()->eligible_only) onchange="this.form.submit()">
                            <label class="form-check-label fw-bold ms-2" for="eligible_only">
                                @lang('Show Eligible Only')
                            </label>
                        </div>
                    @endif

                    

                    <a href="{{ route('campaign.all') }}" class="clear-all-link ms-4 text-nowrap">@lang('Clear all filters')</a>
                </div>
            </form>

           {{-- 3. RESULTS --}}
@if ($campaigns->count() > 0)
    <div class="row justify-content-center g-3 g-md-4 mt-4">
        @include($activeTemplate . 'partials.filtered_campaign')
    </div>
    @if ($campaigns->hasPages())
        <div class="mt-5">
            {{ paginateLinks($campaigns) }}
        </div>
    @endif
@else
    <div class="mt-4">
        @include($activeTemplate . 'partials.empty_animation', ['resetRoute' => route('campaign.all')])
    </div>
@endif


    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection

@push('script')
<script>
    (function ($) {
        "use strict";

        // 1. Remove all internal "Apply" buttons
        $('.dropdown-menu').find('.btn--base, .btn--sm, .d-flex.justify-content-end, button[type="submit"]').not('.hero-search-btn').remove();

        // 2. Update labels immediately while the user is clicking
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
                $pillSelected.text(count > 0 ? vals.join(', ') : "@lang('All Platforms')");
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
    })(jQuery);
</script>
@endpush

@push('style')
<style>
    /* Reuse Influencer Search Styles */
    .hero-filter-box { background: #fff; border: 1px solid #e2e8f0; border-radius: 100px; box-shadow: 0 4px 30px rgba(0,0,0,0.06); }
    .hero-pill { background: transparent; border: none; text-align: left; padding: 12px 35px; transition: 0.2s; }
    .hero-pill:hover { background: #f8fafc; border-radius: 100px; }
    .hero-pill::after { display: none; }
    .pill-label { font-size: 11px; font-weight: 800; text-transform: uppercase; color: #1a202c; letter-spacing: 0.8px; }
    .pill-selected { font-size: 15px; font-weight: 500; color: #718096; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .hero-divider { width: 1px; height: 50px; background: #e2e8f0; flex-shrink: 0; }
    .hero-search-btn { background: #ff385c; color: white; border: none; width: 58px; height: 58px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; transition: 0.2s; flex-shrink: 0; }
    .hero-search-btn:hover { background: #e31c5f; transform: scale(1.08); }

    .mega-menu-content {
        width: 100vw !important;
        max-width: 950px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
        margin-top: 25px !important;
        border-radius: 32px !important;
        z-index: 2000;
        padding: 4rem !important;
    }
    
    .giant-pill-menu {
        min-width: 450px !important;
        border-radius: 28px !important;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.18) !important;
        border: none !important;
        margin-top: 15px !important;
        padding: 3.5rem !important;
    }
    .category-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; max-height: 450px; overflow-y: auto; }
    
    .sub-pill { background: #fff; border: 1px solid #cbd5e0 !important; border-radius: 50px !important; padding: 12px 30px !important; font-size: 14px; font-weight: 700; color: #2d3748 !important; white-space: nowrap; }
    .sub-pill:hover { border-color: #ff385c !important; }
    
    .clear-all-link { font-size: 15px; font-weight: 700; color: #1a202c; text-decoration: underline; text-underline-offset: 4px; }
    .clear-all-link:hover { color: #ff385c; }

    .custom--check .form-check-input { width: 1.4em; height: 1.4em; cursor: pointer; border: 2px solid #cbd5e0; }
    .custom--check .form-check-input:checked { background-color: #ff385c; border-color: #ff385c; }
</style>
@endpush

