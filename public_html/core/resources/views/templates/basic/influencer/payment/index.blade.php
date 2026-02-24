@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-xl-8">
            <div class="card custom--card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom py-4 px-4 d-flex align-items-center gap-3">
                    <div class="icon-wrap bg-dark text-white rounded-3 p-2">
                        <i class="las la-wallet fs-4"></i>
                    </div>
                    <h5 class="card-title mb-0 fw-bold">@lang('Payment Settings')</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    <div class="payment-method-card p-4 rounded-4 border bg-light mb-4">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
                            <div class="d-flex align-items-center gap-4">
                                <div class="stripe-logo">
                                    <svg width="60" height="25" viewBox="0 0 60 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M59.64 14.272c0-5.224-2.733-8.273-7.551-8.273-4.832 0-7.854 3.197-7.854 8.273 0 5.617 3.328 8.441 8.204 8.441 2.227 0 4.093-.418 5.604-1.127l-.462-2.709c-1.398.594-3.05.908-5.025.908-2.607 0-4.708-1.259-4.819-4.22h11.838c.03-.43.065-.828.065-1.294zm-11.876-2.09c.121-2.43 1.954-3.692 4.251-3.692 2.112 0 4.06.945 4.168 3.692h-8.419zm-16.712-4.102c-1.353 0-2.317.581-3.007 1.341l-.161-1.076h-3.235v14.418h3.518V13.88c0-2.756 2.053-3.328 3.483-3.328.324 0 .684.037 1.05.109l.343-3.183c-.562-.124-1.21-.194-1.99-.194zm-8.875 1.076l-.161-1.076H18.78v14.418h3.518v-8.416c0-2.342 1.583-3.328 3.178-3.328.312 0 .612.025.903.078l.41-3.266c-.45-.078-.962-.122-1.611-.122-1.365 0-2.342.594-2.992 1.712zm-9.155-1.076h-3.518v14.418h3.518V8.08zm-1.76-5.858c-1.218 0-2.19.983-2.19 2.203 0 1.219.972 2.202 2.19 2.202 1.219 0 2.202-.983 2.202-2.202 0-1.22-.983-2.203-2.202-2.203zM3.518 12.043c0-1.42.753-2.19 2.148-2.19 1.149 0 2.074.77 2.074 2.19V14.418H3.518v-2.375zm0 10.455c1.171.325 2.502.502 3.824.502 5.094 0 7.868-2.527 7.868-7.868v-7.042c0-4.832-2.618-8.273-7.551-8.273-2.27 0-4.34.502-5.656 1.144L2.464 3.736C3.766 3.138 5.4 2.8 7.218 2.8c3.228 0 4.225 1.763 4.225 4.887v.647c-1.275-.544-2.812-.862-4.481-.862-4.102 0-7.391 2.227-7.391 6.556 0 4.103 3.328 6.544 8.216 6.544 1.487 0 2.68-.194 3.656-.475v2.85c-.976.281-2.169.475-3.656.475-5.32 0-8.875-2.541-8.875-8.441l.004-.002c.004 0 .016-.01.016-.01l3.518.895v2.215z" fill="#635BFF"/>
                                    </svg>
                                </div>
                                <div class="status-info">
                                    <h6 class="fw-bold mb-1">Stripe Connect</h6>
                                    @if ($influencer->stripe_onboarded)
                                        <div class="d-flex align-items-center gap-2 text-success small fw-bold">
                                            <i class="las la-check-circle fs-6"></i> @lang('Active & Connected')
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center gap-2 text-warning small fw-bold">
                                            <i class="las la-info-circle fs-6"></i> @lang('Connection Pending')
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="action-wrap">
                                @if ($influencer->stripe_onboarded)
                                    <a href="{{ route('influencer.payment.stripe.connect') }}" class="btn btn-dark rounded-pill px-4">
                                        <i class="las la-external-link-alt"></i> @lang('View Dashboard')
                                    </a>
                                @else
                                    <a href="{{ route('influencer.payment.stripe.connect') }}" class="btn btn-dark rounded-pill px-5 py-3 fw-bold">
                                        @lang('Connect Stripe Now')
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="info-box p-4 rounded-4 bg-white border">
                        <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                            <i class="las la-lightbulb text-warning"></i> @lang('Why connect Stripe?')
                        </h6>
                        <ul class="list-unstyled mb-0 small text-muted">
                            <li class="mb-3 d-flex gap-3">
                                <div class="dot mt-2"></div>
                                <div>
                                    <strong class="text-dark">@lang('Instant Payments:')</strong> 
                                    @lang('Receive funds directly into your bank account as soon as a brand approves your job.')
                                </div>
                            </li>
                            <li class="mb-3 d-flex gap-3">
                                <div class="dot mt-2"></div>
                                <div>
                                    <strong class="text-dark">@lang('Automated Transfers:')</strong> 
                                    @lang('No more manual withdrawal requests or waiting 3-5 business days for approval.')
                                </div>
                            </li>
                            <li class="mb-3 d-flex gap-3">
                                <div class="dot mt-2"></div>
                                <div>
                                    <strong class="text-dark">@lang('Stripe Business URL:')</strong>
                                    @lang('During setup, Stripe will ask for your website or business URL. Use your profile link below:')
                                    <div class="mt-2 p-2 bg-light border rounded d-flex align-items-center justify-content-between">
                                        <code id="profileUrl" class="text-primary">{{ route('influencer.profile', $influencer->username) }}</code>
                                        <button class="btn btn-sm btn-link p-0 copyBtn" type="button">
                                            <i class="las la-copy fs-5"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex gap-3">
                                <div class="dot mt-2"></div>
                                <div>
                                    <strong class="text-dark">@lang('Professionalism:')</strong> 
                                    @lang('Stripe Connect is the industry standard for marketplace payments, ensuring your data is secure.')
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    (function($){
        "use strict";
        $('.copyBtn').on('click', function(){
            var text = $('#profileUrl').text();
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(text).select();
            document.execCommand("copy");
            $temp.remove();
            
            $(this).html('<i class="las la-check text-success fs-5"></i>');
            setTimeout(() => {
                $(this).html('<i class="las la-copy fs-5"></i>');
            }, 2000);
        });
    })(jQuery);
</script>
@endpush

@push('style')
<style>
    .rounded-4 { border-radius: 1.25rem !important; }
    .icon-wrap { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
    .payment-method-card { transition: all 0.3s ease; }
    .dot { width: 6px; height: 6px; background: #000; border-radius: 50%; flex-shrink: 0; }
    .btn-dark { background: #000; border-color: #000; }
    .btn-dark:hover { background: #222; border-color: #222; }
    .btn-outline-dark { color: #000; border-color: #000; font-weight: 700; }
    .btn-outline-dark:hover { background: #000; color: #fff; }
</style>
@endpush