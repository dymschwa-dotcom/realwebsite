@php
    $testimonialContent = getContent('testimonial.content', true);
    $testimonials = [
        [
            'name' => 'Sarah Jenkins',
            'designation' => 'Marketing Director at GloWave',
            'quote' => 'Collabstar has completely transformed how we handle influencer campaigns. The workflow is seamless and the influencers we find are high-quality.',
            'image' => 'https://i.pravatar.cc/100?u=sarah'
        ],
        [
            'name' => 'Michael Chen',
            'designation' => 'Independent Content Creator',
            'quote' => 'As a creator, I love how easy it is to manage my collaborations. The automated payout system is a lifesaver and very transparent.',
            'image' => 'https://i.pravatar.cc/100?u=michael'
        ],
        [
            'name' => 'Elena Rodriguez',
            'designation' => 'Founder of Bloom Skincare',
            'quote' => 'Finding niche influencers was always a struggle until we started using this platform. Our ROI has increased by 40% since joining.',
            'image' => 'https://i.pravatar.cc/100?u=elena'
        ],
        [
            'name' => 'David Smith',
            'designation' => 'Social Media Manager',
            'quote' => 'The data and analytics provided for each campaign help us optimize our budget efficiently. It\'s an essential tool for any agency.',
            'image' => 'https://i.pravatar.cc/100?u=david'
        ]
    ];
@endphp
<section class="testimonials py-120 section-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading style-center">
                    <h2 class="section-heading__title">{{ __(@$testimonialContent->data_values->heading ?? 'What Our Clients Say') }}</h2>
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
                                    <img src="{{ $testimonial['image'] }}" alt="image">
                                </div>
                                <div class="testimonial-item__details">
                                    <h5 class="testimonial-item__name">{{ __($testimonial['name']) }}</h5>
                                    <span class="testimonial-item__designation">{{ __($testimonial['designation']) }}</span>
                                </div>
                            </div>
                        </div>
                        <p class="testimonial-item__desc">{{ __($testimonial['quote']) }}</p>
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

