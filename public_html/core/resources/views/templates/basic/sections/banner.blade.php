@php
    $banner = getContent('banner.content', true);
@endphp
<section class="banner-section section-bg">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-5 col-lg-6 col-md-10">
                <div class="banner-content">
                    <h1 class="banner-content__title highlight" data-length="2">{{ __(@$banner->data_values->heading) }}</h1>
                    <p class="banner-content__desc">{{ __(@$banner->data_values->subheading) }}</p>
                    <div class="banner-content__button d-flex gap-2 flex-wrap">
                        <a href="{{ url(@$banner->data_values->button_url) }}" class="btn btn--base btn--md">{{ __(@$banner->data_values->button_name) }}</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-6 d-none d-lg-block">
                <div class="banner-content__thumbs text-end">
                    <img src="{{ frontendImage('banner', @$banner->data_values->image, '625x495') }}" class="main-banner" alt="@lang('image')">
                </div>
            </div>
        </div>
    </div>
</section>

@push('script')
    <script>
        (function($) {
            "use strict";
            $(window).on('load', function(e) {
                let hightlightContent = $('.highlight');
                let content = hightlightContent.text();
                let splitContent = content.split(' ');
                let length = hightlightContent.data('length');
                let htmlContent = ``;
                for (let i = 0; i < splitContent.length; i++) {
                    if (i === (length - 1)) {
                        htmlContent += ' ' + `<span class="text--base px-1">${splitContent[i]}</span>`
                    } else {
                        htmlContent += ' ' + splitContent[i];
                    }
                }
                hightlightContent.html(htmlContent);
            });
        })(jQuery)
    </script>
@endpush
