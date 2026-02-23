@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="pricing-section py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-heading style-center">
                        <h2 class="section-heading__title">@lang('Simple, Transparent Pricing')</h2>
                        <p>@lang('Choose the plan that fits your business needs.')</p>
                    </div>

                    {{-- Billing Toggle --}}
                    <div class="billing-toggle-wrapper mb-5 text-center">
                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <span class="fw-bold monthly-label text-primary">@lang('Monthly')</span>
                            <div class="form-check form-switch custom-switch">
                                <input class="form-check-input" type="checkbox" id="billingToggle">
                            </div>
                            <span class="fw-bold yearly-label text-muted">@lang('Yearly') <span class="badge bg-success rounded-pill ms-1">@lang('Save 20%')</span></span>
                        </div>
                    </div>
                </div>
            </div>
            
                        <div class="row gy-4 justify-content-center">
                                @foreach ($plans as $plan)
                    <div class="col-xl-4 col-md-6">
                        <div class="card custom--card h-100 border-0 shadow-sm rounded-4 {{ $plan->id == 2 ? 'shadow-lg border-top border-primary border-4 position-relative' : '' }}">
                            @if ($plan->id == 2)
                                <div class="position-absolute top-0 start-50 translate-middle">
                                    <span class="badge bg-primary rounded-pill px-3 py-2">@lang('Most Popular')</span>
                                </div>
                            @endif
                            <div class="card-body p-4 p-xl-5">
                                <div class="text-center mb-4">
                                    <h3 class="fw-bold mb-2">{{ __($plan->name) }}</h3>
                                    <div class="price-tag mb-3">
                                        <span class="fs-1 fw-bold">{{ gs('cur_sym') }}<span class="plan-price"
                                                  data-monthly="{{ getAmount($plan->price) }}"
                                                  data-yearly="{{ getAmount($plan->price * 0.8) }}">{{ getAmount($plan->price) }}</span></span>
                                        <span class="text-muted monthly-subtext">/@lang('mo') <span class="fs-12">+ GST</span></span>
                                        <span class="text-muted yearly-subtext d-none">/@lang('mo') <span class="fs-12">+ GST</span> <small class="d-block fs-14">@lang('billed annually')</small></span>
                                    </div>
                                    <p class="text-muted">
                                        @if ($plan->id == 1)
                                            @lang('Explore the platform and find the perfect talent for your brand.')
                                        @elseif($plan->id == 2)
                                            @lang('Perfect for small businesses starting with influencer marketing.')
                                        @else
                                            @lang('For growing brands needing more scale and advanced features.')
                                        @endif
                                    </p>
                                </div>
                                <ul class="list-unstyled mb-5">
                                    <li class="mb-3 d-flex align-items-center {{ $plan->campaign_limit == 0 ? 'text-muted' : '' }}">
                                        <i class="las {{ $plan->campaign_limit == 0 ? 'la-times-circle' : 'la-check-circle text-success' }} me-2 fs-4"></i>
                                        <span class="{{ $plan->campaign_limit == 0 ? 'text-decoration-line-through' : '' }}">
                                            @if ($plan->campaign_limit == -1)
                                                @lang('Unlimited Campaigns')
                                            @elseif($plan->campaign_limit == 0)
                                                @lang('No Campaigns')
                                            @else
                                                {{ $plan->campaign_limit }} @lang('Active Campaign'){{ $plan->campaign_limit > 1 ? 's' : '' }}
                                            @endif
                                        </span>
                                    </li>

                                    @if ($plan->id == 1)
                                        <li class="mb-3 d-flex align-items-center text-muted">
                                            <i class="las la-times-circle me-2 fs-4"></i>
                                            <span class="text-decoration-line-through">@lang('Direct Messaging')</span>
                                        </li>
                                        <li class="mb-3 d-flex align-items-center text-muted">
                                            <i class="las la-times-circle me-2 fs-4"></i>
                                            <span class="text-decoration-line-through">@lang('Full Influencer Details')</span>
                                        </li>
                                    @else
                                        <li class="mb-3 d-flex align-items-center">
                                            <i class="las la-check-circle text-success me-2 fs-4"></i>
                                            <span>@lang('Direct Messaging')</span>
                                        </li>
                                        <li class="mb-3 d-flex align-items-center">
                                            <i class="las la-check-circle text-success me-2 fs-4"></i>
                                            <span>@lang('Full Influencer Details')</span>
                                        </li>
                                        <li class="mb-3 d-flex align-items-center">
                                            <i class="las la-check-circle text-success me-2 fs-4"></i>
                                            <span>@lang('Secure Payments')</span>
                                        </li>
                                    @endif
                                </ul>

                                @if (auth()->guard('influencer')->check())
                                    <button class="btn btn--base w-100 py-3 rounded-pill fw-bold" disabled>@lang('Brand Plan Only')</button>
                                @elseif(auth()->check())
                                    @if (auth()->user()->plan_id == $plan->id)
                                        <button class="btn btn--base w-100 py-3 rounded-pill fw-bold" disabled>@lang('Current Status')</button>
                                    @else
                                        <form action="{{ route('user.subscribe.plan', $plan->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="type" class="billing-type" value="monthly">
                                            <button type="submit" class="btn btn--base w-100 py-3 rounded-pill fw-bold">
                                                {{ $plan->price > 0 ? __('Subscribe Now') : __('Get Started') }}
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('user.register') }}" class="btn btn--base w-100 py-3 rounded-pill fw-bold">
                                        {{ $plan->price > 0 ? __('Get Started') : __('Sign Up Free') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- FAQ / Extra Info Section --}}
            <div class="row justify-content-center mt-5">
                <div class="col-lg-8 text-center">
                    <div class="p-4 bg-light rounded-4">
                        <h5 class="fw-bold mb-3">@lang('How do we make money?')</h5>
                        <p class="mb-0 text-muted">@lang('We charge a small service fee on transactions to keep the platform running and provide secure escrow services for both parties.')</p>
                    </div>
                </div>
            </div>

            @if($faqElements->count())
                <div class="row justify-content-center mt-120">
                    <div class="col-lg-12">
                        <div class="section-heading style-center">
                            <h2 class="section-heading__title">{{ __(@$faq->data_values->heading) }}</h2>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="row gy-4">
                            @foreach ($faqElements->chunk(ceil($faqElements->count() / 2)) as $faqChunk)
                                <div class="col-md-6">
                                    <div class="accordion custom--accordion">
                                        @foreach ($faqChunk as $item)
                                            <div class="accordion-item">
                                                <h5 class="accordion-header" id="heading{{ $item->id }}">
                                                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse{{ $item->id }}" type="button" aria-controls="collapse{{ $item->id }}" aria-expanded="false">
                                                        {{ __(@$item->data_values->question) }}
                                                    </button>
                                                </h5>
                                                <div class="accordion-collapse collapse" id="collapse{{ $item->id }}" data-bs-parent="#accordionExample{{ $loop->parent->index }}" aria-labelledby="heading{{ $item->id }}">
                                                    <div class="accordion-body">
                                                        <p class="accordion-body__desc">{{ __(@$item->data_values->answer) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('style')
<style>
    .pricing-section {
        background-color: #f8f9fa;
    }
    .custom--card {
        transition: transform 0.3s ease;
    }
    .custom--card:hover {
        transform: translateY(-10px);
    }
    .custom-switch .form-check-input {
        width: 3.5rem;
        height: 1.75rem;
        cursor: pointer;
    }
    .custom-switch .form-check-input:checked {
        background-color: var(--base-color);
        border-color: var(--base-color);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
    }
    .custom-switch .form-check-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(var(--base-r), var(--base-g), var(--base-b), 0.25);
        border-color: var(--base-color);
    }
    .text-primary {
        color: var(--base-color) !important;
    }
    /* ... existing code ... */
    .custom--accordion .accordion-button {
        font-size: 18px;
    }
    .mt-120 {
        margin-top: 120px;
    }
</style>
@endpush

@push('script')
<script>
    (function($) {
        "use strict";
        $('#billingToggle').on('change', function() {
            const isYearly = $(this).is(':checked');
            $('.billing-type').val(isYearly ? 'yearly' : 'monthly');

            if (isYearly) {
                $('.yearly-label').removeClass('text-muted').addClass('text-primary');
                $('.monthly-label').removeClass('text-primary').addClass('text-muted');

                $('.plan-price').each(function() {
                    $(this).text($(this).data('yearly'));
                });
            } else {
                $('.monthly-label').removeClass('text-muted').addClass('text-primary');
                $('.yearly-label').removeClass('text-primary').addClass('text-muted');

                $('.plan-price').each(function() {
                    $(this).text($(this).data('monthly'));
                });
            }
        });
    })(jQuery);
</script>
@endpush

