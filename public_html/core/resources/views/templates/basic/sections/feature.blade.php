@php
    $featureContent = getContent('feature.content', true);
    $featureElement = getContent('feature.element', false, null, true)->chunk(3);
    $featuresLeft = $featureElement[0];
    $featuresRight = $featureElement[1];
@endphp
<section class="global-infuencer py-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading style-center">
                    <h2 class="section-heading__title">{{ __(@$featureContent->data_values->heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row align-items-center gy-4">
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="platform-left">
                    @foreach ($featuresLeft as $feature)
                        <div class="platform">
                            <div class="platform__icon">
                                <img src="{{ frontendImage('feature/', @$feature->data_values->image, '30x30') }}" alt="image">
                            </div>
                            <div class="platform__content">
                                <h5 class="platform__title">{{ __(@$feature->data_values->title) }}</h5>
                                <p class="platform__subtitle">
                                    {{ __(@$feature->data_values->description) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 d-none d-lg-block">
                <div class="platform__thumb">
                    <img src="{{ frontendImage('feature' , @$featureContent->data_values->image, '430x345') }}" alt="image">
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="platform-right">
                    @foreach ($featuresRight as $feature)
                        <div class="platform">
                            <div class="platform__icon">
                                <img src="{{ frontendImage('feature', @$feature->data_values->image, '30x30') }}" alt="@lang('image')">
                            </div>
                            <div class="platform__content">
                                <h5 class="platform__title">{{ __(@$feature->data_values->title) }}</h5>
                                <p class="platform__subtitle">
                                    {{ __(@$feature->data_values->description) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
