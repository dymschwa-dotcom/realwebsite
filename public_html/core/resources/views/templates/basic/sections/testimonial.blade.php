@php
    $testimonialContent = getContent('testimonial.content', true);
    $testimonials = getContent('testimonial.element', orderById: true);
@endphp
<section class="testimonials py-120 section-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading style-center">
                    <h2 class="section-heading__title">{{ __(@$testimonialContent->data_values->heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="testimonial-slider">
            @foreach ($testimonials as $testimonial)
                <div class="testimonails-card">
                    <div class="testimonial-item">
                        <div class="testimonial-item__quate"><i class="las la-quote-right"></i></div>
                        <div class="testimonial-item__content">
                            <div class="testimonial-item__info">
                                <div class="testimonial-item__thumb">
                                    <img src="{{ frontendImage('testimonial', @$testimonial->data_values->image, '100x100') }}" alt="image">
                                </div>
                                <div class="testimonial-item__details">
                                    <h5 class="testimonial-item__name">{{ __(@$testimonial->data_values->name) }}</h5>
                                    <span class="testimonial-item__designation">{{ __(@$testimonial->data_values->designation) }}</span>
                                </div>
                            </div>
                        </div>
                        <p class="testimonial-item__desc">{{ __(@$testimonial->data_values->quote) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@push('script')
    <script>
        (function($) {
            "use strict";

            $(".testimonial-slider").slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                speed: 1500,
                dots: true,
                pauseOnHover: true,
                arrows: false,
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
                responsive: [{
                        breakpoint: 1199,
                        settings: {
                            arrows: false,
                            slidesToShow: 2,
                            dots: true,
                        },
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            arrows: false,
                            slidesToShow: 1,
                        },
                    },
                ],
            });
        })(jQuery);
    </script>
@endpush
