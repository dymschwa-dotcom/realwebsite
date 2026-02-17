@php
    $partners = getContent('partner.element', orderById: true);
@endphp

<div class="client py-60">
    <div class="container">
        <div class="client-logos client-slider">
            @foreach ($partners as $partner)
                <img src="{{ frontendImage('partner', @$partner->data_values->image, '120x30') }}" alt="image">
            @endforeach
        </div>
    </div>
</div>

@push('script')
    <script>
        (function($) {
            "use strict";

            $(".client-slider").slick({
                slidesToShow: 6,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 1000,
                pauseOnHover: true,
                speed: 2000,
                dots: false,
                arrows: false,
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
                responsive: [{
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 6,
                        },
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 4,
                        },
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 3,
                        },
                    },
                    {
                        breakpoint: 400,
                        settings: {
                            slidesToShow: 2,
                        },
                    },
                ],
            });
        })(jQuery);
    </script>
@endpush
