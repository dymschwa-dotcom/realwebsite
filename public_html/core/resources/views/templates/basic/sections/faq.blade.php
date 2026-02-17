@php
    $faq = getContent('faq.content', true);
    $faqElement = getContent('faq.element', orderById: true);
    $faqs = $faqElement->chunk(4);
@endphp
<section class="faq-section py-120">
    <div class="container">
        <div class="row">
            <div class="section-heading style-three single-style">
                <h2 class="section-heading__title">{{ __(@$faq->data_values->heading) }}</h2>
            </div>
        </div>
        <div class="row gy-4">
            @foreach ($faqs as $faqElements)
                <div class="col-md-6">
                    <div class="accordion custom--accordion" id="accordionExample">
                        @foreach ($faqElements as $faq)
                            <div class="accordion-item">
                                <h5 class="accordion-header" id="heading{{ $faq->id }}">
                                    <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" type="button" aria-controls="collapse{{ $faq->id }}" aria-expanded="false">
                                        {{ __(@$faq->data_values->question) }}
                                    </button>
                                </h5>
                                <div class="accordion-collapse collapse" id="collapse{{ $faq->id }}" data-bs-parent="#accordionExample" aria-labelledby="heading{{ $faq->id }}">
                                    <div class="accordion-body">
                                        <p class="accordion-body__desc">{{ __(@$faq->data_values->answer) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@push('style')
    <style>
        .custom--accordion .accordion-button {
            font-size: 18px;
        }
    </style>
@endpush
