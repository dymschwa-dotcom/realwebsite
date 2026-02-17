@php
    $counters = getContent('counter.element', orderById: true);
@endphp
<div class="counter-area py-60" style="background-image: url({{ getImage($activeTemplateTrue . 'images/bg-counter.png') }});">
    <div class="container">
        <div class="row gy-4 align-items-center">
            @foreach ($counters as $counter)
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counterup-item text-center">
                        <div class="counterup-item__content">
                            <div class="counterup-item__number">
                                <h1 class="counterup-item__title mb-0">
                                    <span class="odometer" data-odometer-final="{{ @$counter->data_values->counter_digit }}"></span>{{ @$counter->data_values->counter_symbol }}
                                </h1>
                            </div>
                            <h6 class="counterup-item__text mb-0">{{ __(@$counter->data_values->title) }}</h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('style-lib')
    <link href="{{ asset($activeTemplateTrue . 'css/odometer.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/viewport.jquery.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/odometer.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $(".counterup-item").each(function() {
                $(this).isInViewport(function(status) {
                    if (status === "entered") {
                        for (
                            var i = 0; i < document.querySelectorAll(".odometer").length; i++
                        ) {
                            var el = document.querySelectorAll(".odometer")[i];
                            el.innerHTML = el.getAttribute("data-odometer-final");
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
