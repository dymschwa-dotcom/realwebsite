@php
    $cta = getContent('cta.content', true);
@endphp
<div class="call-to-area py-120 bg-img"
     style="background-image: url({{ getImage($activeTemplateTrue . 'images/cta.png') }});">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="call-action text-center">
                    <h2 class="call-action__title">{{ __(@$cta->data_values->heading) }}</h2>
                    <p class="call-action__desc">{{ __(@$cta->data_values->subheading) }}</p>
                    <div class="call-action__btn">
                        <a href="{{ url(@$cta->data_values->button_url) }}" class="btn btn--base outline">{{ __(@$cta->data_values->button_name) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
