@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group ">
                                    <label> @lang('Site Title')</label>
                                    <input class="form-control" type="text" name="site_name" required value="{{ gs('site_name') }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group ">
                                    <label>@lang('Currency')</label>
                                    <input class="form-control" type="text" name="cur_text" required value="{{ gs('cur_text') }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group ">
                                    <label>@lang('Currency Symbol')</label>
                                    <input class="form-control" type="text" name="cur_sym" required value="{{ gs('cur_sym') }}">
                                </div>
                            </div>
                            <div class="form-group col-xl-3 col-sm-6">
                                <label class="required"> @lang('Timezone')</label>
                                <select class="select2 form-control" name="timezone">
                                    @foreach ($timezones as $key => $timezone)
                                        <option value="{{ @$key }}" @selected(@$key == $currentTimezone)>{{ __($timezone) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-xl-3 col-sm-6">
                                <label class="required"> @lang('Site Base Color')</label>
                                <div class="input-group">
                                    <span class="input-group-text p-0 border-0">
                                        <input type='text' class="form-control colorPicker" value="{{ gs('base_color') }}">
                                    </span>
                                    <input type="text" class="form-control colorCode" name="base_color" value="{{ gs('base_color') }}">
                                </div>
                            </div>
                            <div class="form-group col-xl-3 col-sm-6">
                                <label> @lang('Record to Display Per page')</label>
                                <select class="select2 form-control" name="paginate_number" data-minimum-results-for-search="-1">
                                    <option value="20" @selected(gs('paginate_number') == 20)>@lang('20 items per page')</option>
                                    <option value="50" @selected(gs('paginate_number') == 50)>@lang('50 items per page')</option>
                                    <option value="100" @selected(gs('paginate_number') == 100)>@lang('100 items per page')</option>
                                </select>
                            </div>

                            <div class="form-group col-xl-3 col-sm-6 ">
                                <label class="required"> @lang('Currency Showing Format')</label>
                                <select class="select2 form-control" name="currency_format" data-minimum-results-for-search="-1">
                                    <option value="1" @selected(gs('currency_format') == Status::CUR_BOTH)>@lang('Show Currency Text and Symbol Both')</option>
                                    <option value="2" @selected(gs('currency_format') == Status::CUR_TEXT)>@lang('Show Currency Text Only')</option>
                                    <option value="3" @selected(gs('currency_format') == Status::CUR_SYM)>@lang('Show Currency Symbol Only')</option>
                                </select>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Influencer Register Bonus')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="influencer_register_bonus_amount"
                                               value="{{ getAmount(gs('influencer_register_bonus_amount')) }}" required>
                                        <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Brand Register Bonus')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="brand_register_bonus_amount"
                                               value="{{ getAmount(gs('brand_register_bonus_amount')) }}" required>
                                        <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Campaign Approval Charge')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="campaign_approval_charge"
                                               value="{{ getAmount(gs('campaign_approval_charge')) }}" required>
                                        <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Maximum Image can be Uploaded')</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="max_image_upload"
                                               value="{{ getAmount(gs('max_image_upload')) }}" required>
                                        <span class="input-group-text">@lang('Qty')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Brand Campaign Commission')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="brand_campaign_commission"
                                               value="{{ getAmount(gs('brand_campaign_commission')) }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Influencer Campaign Commission')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="influencer_campaign_commission"
                                               value="{{ getAmount(gs('influencer_campaign_commission')) }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('GST Rate (Total Amount)')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="gst_rate"
                                               value="{{ getAmount(gs('gst_rate')) }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('GST on Commission Rate')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="marketplace_commission_gst_rate"
                                               value="{{ getAmount(gs('marketplace_commission_gst_rate')) }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('GST on Influencer Service Rate')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="influencer_gst_rate"
                                               value="{{ getAmount(gs('influencer_gst_rate')) }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Marketplace GST Return Rate')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="marketplace_gst_return_rate"
                                               value="{{ getAmount(gs('marketplace_gst_return_rate')) }}" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Marketplace GST Return To')</label>
                                    <select class="form-control" name="marketplace_gst_return_to">
                                        <option value="1" @selected(gs('marketplace_gst_return_to') == 1)>@lang('Influencer')</option>
                                        <option value="2" @selected(gs('marketplace_gst_return_to') == 2)>@lang('Marketplace')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script-lib')
    <script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/spectrum.css') }}">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";


            $('.colorPicker').spectrum({
                color: $(this).data('color'),
                change: function(color) {
                    $(this).parent().siblings('.colorCode').val(color.toHexString().replace(/^#?/, ''));
                }
            });

            $('.colorCode').on('input', function() {
                var clr = $(this).val();
                $(this).parents('.input-group').find('.colorPicker').spectrum({
                    color: clr,
                });
            });
        })(jQuery);
    </script>
@endpush

