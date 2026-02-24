@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="brand-dashboard-header d-flex align-items-center justify-content-between gap-3 mb-4  flex-wrap">
        <div class="brand-dashboard-header__left">
            <h5>@lang('Secure Checkout')</h5>
            <p class="fs-14 mb-0">@lang('Select your preferred payment method to complete the transaction.')</p>
        </div>
        <div class="brand-dashboard-header__right">
            <a href="{{ route('user.transactions') }}" class="btn btn--base outline btn--sm" type="button">@lang('Billing History') <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
    <form class="deposit-form" action="{{ route('user.deposit.insert') }}" method="post">
        @csrf
        <input name="currency" type="hidden">
        <input name="success_action" type="hidden" value="{{ request()->success_action }}">
        <input name="success_action_data" type="hidden" value="{{ request()->success_action_data }}">
        <input name="amount" type="hidden" value="{{ request()->amount }}">
        <div class="gateway-card">
            <div class="row justify-content-center gy-sm-4 gy-3">
                <div class="col-lg-6 @if(request()->direct_checkout) d-none @endif">
                    <div class="payment-system-list is-scrollable gateway-option-list">
                        @foreach ($gatewayCurrency as $data)
                            <label class="payment-item @if ($loop->index > 4) d-none @endif gateway-option" for="{{ titleToKey($data->name) }}">
                                <div class="payment-item__info">
                                    <span class="payment-item__check"></span>
                                    <span class="payment-item__name">{{ __($data->name) }}</span>
                                </div>
                                <div class="payment-item__thumb">
                                    <img class="payment-item__thumb-img" src="{{ getImage(getFilePath('gateway') . '/' . $data->method->image) }}" alt="@lang('payment-thumb')">
                                </div>
                                <input class="payment-item__radio gateway-input" id="{{ titleToKey($data->name) }}" name="gateway" data-gateway='@json($data)' data-min-amount="{{ showAmount($data->min_amount) }}" data-max-amount="{{ showAmount($data->max_amount) }}" type="radio" value="{{ $data->method_code }}" hidden @checked(old('gateway', $loop->first) == $data->method_code)>
                            </label>
                        @endforeach
                        @if ($gatewayCurrency->count() > 4)
                            <button class="payment-item__btn more-gateway-option" type="button">
                                <p class="payment-item__btn-text mb-0">@lang('Show All Payment Options')</p>
                                <span class="payment-item__btn__icon"><i class="fas fa-chevron-down"></i></span>
                            </button>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="payment-system-list p-3">
    <h6 class="mb-3 px-2">@lang('Order Summary')</h6>

    @if(request()->price)
    <div class="deposit-info">
        <div class="deposit-info__title"><p class="text mb-0">@lang('Item Price')</p></div>
        <div class="deposit-info__input"><p class="text mb-0"><span>{{ showAmount(request()->price, 2) }}</p></div>
    </div>
    @endif

    @if(request()->service_fee)
    <div class="deposit-info">
        <div class="deposit-info__title"><p class="text mb-0">@lang('Marketplace Fee')</p></div>
        <div class="deposit-info__input"><p class="text mb-0"><span>{{ showAmount(request()->service_fee, 2) }}</p></div>
    </div>
    @endif
    
    @if(request()->gst_amount)
    <div class="deposit-info">
        <div class="deposit-info__title"><p class="text mb-0">@lang('GST (15%)')</p></div>
        <div class="deposit-info__input"><p class="text mb-0"><span>{{ showAmount(request()->gst_amount, 2) }}</p></div>
    </div>
    @endif

    <input type="hidden" id="amount_val" value="{{ request()->amount }}">

<div class="deposit-info pt-2">
    <div class="deposit-info__title"><p class="text fw-bold mb-0">@lang('Subtotal')</p></div>
    <div class="deposit-info__input"><p class="text fw-bold mb-0">{{ showAmount(request()->amount, 2) }}</p></div>
</div>

<hr>

<div class="deposit-info">
    <div class="deposit-info__title"><p class="text mb-0">@lang('Gateway Fee')</p></div>
    {{-- Removed manual $ here to stop double symbol --}}
    <div class="deposit-info__input"><p class="text mb-0"><span class="processing-fee">0.00</span></p></div>
</div>

<div class="deposit-info total-amount pt-3 border-top-0">
    <div class="deposit-info__title"><p class="text fw-bold mb-0">@lang('Total')</p></div>
    {{-- Removed manual $ here to stop double symbol --}}
    <div class="deposit-info__input"><p class="text fw-bold mb-0" style="color: #28c76f;"><span class="final-amount">0.00</span></p></div>
</div>

<button class="btn btn--base w-100 mt-3" type="submit" id="btn-pay" disabled>
    @lang('Pay Now')
</button>
</div>
                        <div class="info-text mt-3">
                            <span class="icon"><i class="las la-shield-alt"></i></span>
                            <p class="text">@lang('Your payment is processed through a secure, encrypted gateway for your protection.')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('script')
<script>
    (function ($) {
        "use strict";

        function calculateFinalTotal() {
            // 1. Get the amount
            var rawAmount = $('#amount_val').val() || "0";
            var cleanAmount = parseFloat(rawAmount.replace(/[^0-9.]/g, ''));
            
            if (isNaN(cleanAmount) || cleanAmount <= 0) return;

            // 2. Find the selected gateway
            var selectedGateway = $('.gateway-input:checked');
            var gatewayData = selectedGateway.data('gateway');

            // 3. Fallback Logic: If no gateway is found, fee is 0 and total is just the subtotal
            var percent = 0;
            var fixed = 0;

            if (gatewayData) {
                percent = parseFloat(gatewayData.percent_charge || 0);
                fixed = parseFloat(gatewayData.fixed_charge || 0);
                
                // Finalize Form for Laravel if gateway exists
                $('#btn-pay').prop('disabled', false);
                $('input[name=currency]').val(gatewayData.currency);

                // Update Button Text if Direct Checkout
                @if(request()->direct_checkout)
                    $('#btn-pay').text("@lang('Complete Purchase')");
                @endif
            } else {
                // Keep button disabled if no payment method is available
                $('#btn-pay').prop('disabled', true);
            }

            // 4. Perform Calculation
            var gatewayFee = (cleanAmount * percent / 100) + fixed;
            var grandTotal = cleanAmount + gatewayFee;

            // 5. Update the Screen
            $('.processing-fee').text(gatewayFee.toFixed(2));
            $('.final-amount').text(grandTotal.toFixed(2));
        }

        $(document).on('change', '.gateway-input', calculateFinalTotal);

        $(document).ready(function() {
            // If gateways exist, click the first one automatically
            @if(request()->direct_checkout && request()->gateway)
                var gatewayInput = $('.gateway-input[value="{{ request()->gateway }}"]');
                if(gatewayInput.length > 0) {
                    gatewayInput.prop('checked', true);
                } else {
                    $('.gateway-input').first().prop('checked', true);
                }
            @else
                if ($('.gateway-input').length > 0) {
                    $('.gateway-input').first().prop('checked', true);
                }
            @endif
            calculateFinalTotal();
        });

        $(window).on('load', function() {
            calculateFinalTotal();
        });

    })(jQuery);
</script>
@endpush
