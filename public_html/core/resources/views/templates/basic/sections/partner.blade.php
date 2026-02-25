@php
    $partners = getContent('partner.element', orderById: true);
@endphp

<div class="client py-60">
    <div class="container">
        <div class="client-logos client-slider">
            @php
                $hardcodedPartners = [
                    ['name' => 'Lumina'],
                    ['name' => 'VANTAGE'],
                    ['name' => 'Aura'],
                    ['name' => 'CORE'],
                    ['name' => 'elevate'],
                    ['name' => 'SPHERE'],
                    ['name' => 'NODE_JS'],
                    ['name' => 'PRISM'],
                    ['name' => 'VELOCITY'],
                    ['name' => 'ZENITH']
                ];
            @endphp

            @if($partners->count() > 0)
                @foreach ($partners as $partner)
                <img src="{{ frontendImage('partner', @$partner->data_values->image, '120x30') }}" alt="image">
            @endforeach
            @else
                @foreach($hardcodedPartners as $index => $partner)
                    <div class="partner-text-logo-wrapper">
                        <div class="partner-text-logo"
                            @if($index == 0) style="font-family: sans-serif; font-weight: 700; color: #333;" @endif
                            @if($index == 1) style="font-family: 'Times New Roman', serif; font-weight: 700; letter-spacing: 2px; color: #555;" @endif
                            @if($index == 2) style="font-style: italic; font-weight: 300; text-transform: capitalize; color: #777;" @endif
                            @if($index == 3) style="font-weight: 900; letter-spacing: -1px; color: #222;" @endif
                            @if($index == 4) style="text-transform: lowercase; font-weight: 600; font-family: sans-serif; color: #444;" @endif
                            @if($index == 5) style="letter-spacing: 5px; font-size: 0.8rem; font-weight: 800; color: #666;" @endif
                            @if($index == 6) style="font-family: monospace; font-weight: bold; border: 1px solid #ddd; padding: 2px 10px; font-size: 0.9rem; color: #888;" @endif
                            @if($index == 7) style="font-family: serif; font-variant: small-caps; font-weight: 600; color: #333;" @endif
                            @if($index == 8) style="font-family: sans-serif; font-weight: 200; letter-spacing: 3px; color: #444;" @endif
                            @if($index == 9) style="font-family: 'Georgia', serif; font-weight: 800; font-style: italic; color: #222;" @endif
                        >
                            {{ $partner['name'] }}
                        </div>
                    </div>
                @endforeach
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

