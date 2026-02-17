@php
    $breacrumbContent = getContent('breadcrumb.content', true);
@endphp
<section class="breadcrumb">
    <div class="breadcrumb__top bg-img" data-background-image="{{ frontendImage('breadcrumb', @$breacrumbContent->data_values->image, '1920x140') }}" style="background: url({{ frontendImage('breadcrumb', @$breacrumbContent->data_values->image, '1920x140') }});">
        <div class=" container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h5 class="breadcrumb-content__title mb-0">{{ __($pageTitle) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
