@php
    $partners = getContent('partner.element', orderById: true);
@endphp

<div class="client py-60">
    <div class="container">
        <div class="client-logos client-slider">
            @if($partners->count() > 0)
                @foreach ($partners as $partner)
                <img src="{{ frontendImage('partner', @$partner->data_values->image, '120x30') }}" alt="image">
            @endforeach
            @else
                 {{-- Fallback Styled Text "Logos" --}}
                <div class="partner-text-logo">Lumina</div>
                <div class="partner-text-logo" style="font-family: 'Times New Roman', serif; font-weight: 700; letter-spacing: 2px;">VANTAGE</div>
                <div class="partner-text-logo" style="font-style: italic; font-weight: 300; text-transform: capitalize;">Aura</div>
                <div class="partner-text-logo" style="font-weight: 900; letter-spacing: -1px;">CORE</div>
                <div class="partner-text-logo" style="text-transform: lowercase; font-weight: 600; font-family: sans-serif;">elevate</div>
                <div class="partner-text-logo" style="letter-spacing: 5px; font-size: 0.8rem; font-weight: 800;">SPHERE</div>
                <div class="partner-text-logo" style="font-family: monospace; font-weight: bold; 1px solid #ddd; padding: 2px 10px; font-size: 0.9rem;">NODE_JS</div>
            @endif
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



