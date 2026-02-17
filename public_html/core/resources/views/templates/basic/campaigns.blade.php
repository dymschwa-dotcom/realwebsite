@extends($activeTemplate . 'layouts.frontend')
@section('content')

    <!-- ==================== Campaign Start Here ==================== -->
    <div class="campaign-area py-120">
        <div class="container">
            <div class="row">
                <div class="section-heading style-three single-style">
                    <h2 class="section-heading__title">@lang('All Campaign')</h2>
                    <div class="filter-with-search">
                        <div class="filter filterBtn">
                            <span>@lang('Advance Filter')</span>
                            <span><img src="{{ getImage($activeTemplateTrue . 'images/bars-filter.png') }}"
                                     alt=""></span>
                        </div>
                        <button class="search-icon section__search-btn" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                        <form class="section-search-form">
                            <input class="form--control" name="search" value="{{ request()->search }}" type="text"
                                   placeholder="Search here...">
                            <button class="section-search-form__btn text-white" type="submit"><i
                                   class="las la-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center g-2 g-md-4">
                @include($activeTemplate . 'partials.filtered_campaign')
                @if ($campaigns->hasPages())
                    <div class="mt-5">
                        {{ paginateLinks($campaigns) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- ==================== Campaign End Here ==================== -->
    <div class="modal custom--modal advance-filter fade" id="campaignModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="campaignModalLabel"> @lang('Filter By')</h1>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="campaignFilterForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Platform')</label>
                                    <select class="form--control select2" multiple name="platform_name[]">
                                        @foreach ($platforms as $platform)
                                            <option value="{{ $platform->name }}" @selected(in_array($platform->name, request()->platform_name ?? []))>
                                                {{ __($platform->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Category')</label>
                                    <select class="select form--control select2" multiple name="category[]">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->slug }}" @selected(in_array($category->slug, request()->category ?? []))>
                                                {{ __($category->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Country')</label>
                                    <select class="select form--control select2" multiple name="country[]">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country }}" @selected(in_array($country, request()->country ?? []))>
                                                {{ $country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Gender')</label>
                                    <select class="select form--control select2" multiple name="gender[]">
                                        <option value="male" @selected(in_array('male', request()->gender ?? []))>@lang('Male')</option>
                                        <option value="female" @selected(in_array('female', request()->gender ?? []))>@lang('Female')</option>
                                        <option value="other" @selected(in_array('other', request()->gender ?? []))>@lang('Other')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form--label">@lang('Follower Range')</label>
                                    <select class="select form--control select2" multiple name="follower_range[]">
                                        <option value="1_5" @selected(in_array('1_5', request()->follower_range ?? []))>@lang('1k - 5K')</option>
                                        <option value="5_20" @selected(in_array('5_20', request()->follower_range ?? []))>@lang('5k - 20K')</option>
                                        <option value="20_50" @selected(in_array('20_50', request()->follower_range ?? []))>@lang('20k - 50K')</option>
                                        <option value="50_100" @selected(in_array('50_100', request()->follower_range ?? []))>@lang('50k - 100K')</option>
                                        <option value="100_500" @selected(in_array('100_500', request()->follower_range ?? []))>@lang('100K - 500K')</option>
                                        <option value="500_1000" @selected(in_array('500_1000', request()->follower_range ?? []))>@lang('500K - 1M')</option>
                                        <option value="1000000" @selected(in_array('1000000', request()->follower_range ?? []))>@lang('1M+')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a href="javascript:void(0)" class="text--danger clear-btn clear-disabled"><i
                               class="las la-redo-alt"></i>
                            @lang('Clear')</a>
                        <button type="submit" class="btn btn--base btn--md">@lang('Apply')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection

@push('style')
    <style>
        .clear-disabled {
            color: hsl(var(--danger)/0.6) !important;
        }

        .select2-container {
            z-index: 9999 !important;
        }

        .select2-container:has(.select2-selection--multiple, .select2-selection--single) {
            width: 100% !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            let modal = $("#campaignModal");
            $('.filterBtn').on('click', function(e) {
                if (modal.find('input[type=text]').val() || modal.find('select').val()) {
                    clearForm(1);
                }
                modal.modal('show');
            });

            $('#campaignFilterForm input[type=text]').on('input', function(e) {
                clearForm($(this).val())
            });

            $('#campaignFilterForm select').on('change', function(e) {
                clearForm($(this).val())
            });

            $(document).on('click', '.resetBtn', function(e) {
                $('#campaignFilterForm input[type=text]').val('');
                $('#campaignFilterForm .select2').val([]).trigger("change");
                clearForm()
            });

            function clearForm(val = 0) {
                if (val) {
                    modal.find('.clear-btn').addClass('resetBtn');
                    modal.find('.clear-btn').removeClass('clear-disabled');
                } else {
                    modal.find('.clear-btn').removeClass('resetBtn');
                    modal.find('.clear-btn').addClass('clear-disabled');
                }
            }

        })(jQuery)
    </script>
@endpush
