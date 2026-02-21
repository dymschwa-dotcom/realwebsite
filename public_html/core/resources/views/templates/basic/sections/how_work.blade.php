@php
    $howWorkContent = getContent('how_work.content', true);
    $howWorkElement = getContent('how_work.element');
@endphp
<div class="how-work-section bg-img py-120 section-bg" style="background-image: url({{ getImage($activeTemplateTrue . 'images/how_work.png') }})">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading style-center">
                    <h2 class="section-heading__title">{{ __(@$howWorkContent->data_values->heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @foreach ($howWorkElement as $howWork)
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="work-item text-center">
                        @if (!$loop->last)
                            <span class="work-item__arrow"></span>
                        @endif
                        <div class="work-item__icon">
                            <img src="{{ frontendImage('how_work', @$howWork->data_values->image, '30x30') }}" alt="image">
                        </div>
                        <h5 class="work-item__title">{{ __(@$howWork->data_values->heading) }}</h5>
                        <p class="work-item__subtitle">{{ __(@$howWork->data_values->subheading) }}</p>
                    </div>
                </div>
            @endforeach
            <div class="more-btn text-center">
                <a href="{{ url(@$howWorkContent->data_values->button_url) }}" class="btn btn--base outline btn--md">{{ __(@$howWorkContent->data_values->button_name) }}</a>
            </div>
        </div>
    </div>
</div>
