@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $campaignSteps = ['basic', 'content', 'description', 'requirement', 'budget'];
        $stepName = array_slice($campaignSteps, 0, $step + 1);
        $currentStep = $campaignSteps[$step];
        $campaignStepDb = request()->step ?? 0;
    @endphp

    <div class="card custom--card">
        <div class="card-body">
            <div class="step-form position-relative">
                <div class="campaign-loader-wrapper d-none">
                    <div class="campaign-loader mx-auto"></div>
                </div>
                <div class="create-heading mb-4 text-center">
                    <h3 class="mb-sm-5 mb-4 text-center">
                        <h3 class="mb-2 text-center">{{ __($pageTitle) }}</h3>
                        <p>@lang('Follow the simple 5 steps to create your campaign.')</p>
                    </h3>
                </div>

                <div class="form-steps">
                    @foreach ($campaignSteps as $key => $campaignStep)
                        <div class="form-steps__step {{ $campaignStep }} form-steps__step--{{ in_array($campaignStep, $stepName) ? 'active' : 'incomplete' }}">
                            <a class="form-steps__step-link" href="javascript:void(0)"></a>
                            <div class="form-steps__step-circle">
                                <span class="form-steps__step-number">{{ $key + 1 }} </span>
                            </div>
                            <span class="form-step__step-name text-capitalize">{{ $campaignStep }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-content mt-5" id="myTabContent">
                @foreach ($campaignSteps as $campaignStep)
                    <div class="tab-pane fade @if (!in_array($campaignStep, $stepName)) disabled @endif @if ($currentStep == $campaignStep) show active @endif" id="pills-{{ $campaignStep }}" role="tabpanel" aria-labelledby="pills-{{ $campaignStep }}-tab">
                        @if (in_array($campaignStep, $stepName))
                            @include($activeTemplate . 'partials.campaign.' . $campaignStep)
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('style-lib')
    <link type="text/css" href="{{ asset('assets/admin/css/daterangepicker.css') }}" rel="stylesheet" />
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/nicEdit.js') }}"></script>
    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/daterangepicker.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            bkLib.onDomLoaded(function() {
                $(".nicEdit").each(function(index) {
                    $(this).attr("id", "nicEditor" + index);
                    new nicEditor({
                        fullPanel: true
                    }).panelInstance('nicEditor' + index, {
                        hasPanel: true
                    });
                });
            });


            $(document).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain', function() {
                $('.nicEdit-main').focus();
            });

            let url;
            let step;
            let stepName;
            let route;
            let slug = "{{ @$campaign->slug }}";

            $(document).on('submit', '#basicForm', function(e) {
                e.preventDefault();
                $(document).find('.campaign-loader-wrapper').removeClass('d-none');
                var formData = new FormData($(this)[0]);
                if (slug) {
                    route = `{{ route('user.campaign.basic', '') }}/${slug}`
                } else {
                    route = `{{ route('user.campaign.basic') }}`;
                }
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: route,
                    method: "POST",
                    data: formData,
                    async: false,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $(document).find('.campaign-loader-wrapper').addClass('d-none');
                        if (response.error) {
                            notify('error', response.error)
                            return;
                        } else {
                            $(document).find('.form-steps__step').removeClass('form-steps__step--active');
                            stepName = $(document).find('.form-steps__step.content,.form-steps__step.basic');
                            stepName.addClass('form-steps__step--active')

                            step = response.step;
                            slug = response.campaign_slug;
                            $('#myTabContent').html(response.html);
                            url = `{{ route('user.campaign.create') }}/${step}/${slug}`;
                            window.history.pushState("object or string", "Title", `${url}`);

                            productCount()
                        }
                    }
                });
            });

            $(document).on('submit', '#contentForm', function(e) {
                e.preventDefault();
                $(document).find('.campaign-loader-wrapper').removeClass('d-none');
                route = `{{ route('user.campaign.content', '') }}/${slug}`;
                var formData = new FormData($(this)[0]);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: route,
                    method: "POST",
                    data: formData,
                    async: false,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $(document).find('.campaign-loader-wrapper').addClass('d-none');
                        if (response.error) {
                            notify('error', response.error)
                            return;
                        } else {
                            $(document).find('.form-steps__step').removeClass('form-steps__step--active');
                            stepName = $(document).find('.form-steps__step.content,.form-steps__step.basic,.form-steps__step.description');
                            stepName.addClass('form-steps__step--active')

                            step = response.step;
                            slug = response.campaign_slug;
                            stepName.addClass('active')
                            $(document).find('#myTabContent').html(response.html);

                            $(".select2-auto-tokenize").select2({
                                tags: true,
                                tokenSeparators: [","],
                                dropdownParent: $(".card-body"),
                                width: "100%",
                                closeOnSelect: true
                            });

                            $(".nicEdit").each(function(index) {
                                $(this).attr("id", "nicEditor" + index);
                                new nicEditor({
                                    fullPanel: true
                                }).panelInstance('nicEditor' + index, {
                                    hasPanel: true
                                });
                            });

                            $('.nicEdit-panelContain').parent().width('100%');
                            $('.nicEdit-panelContain').parent().next().width('100%');
                            $('.nicEdit-main').width('100%');
                            $('.nicEdit-main').addClass('nicEdit-selected');

                            url = `{{ route('user.campaign.create') }}/${step}/${slug}`
                            window.history.pushState("object or string", "Title", `${url}`);
                        }
                    }
                });
            });

            $(document).on('submit', '#descriptionForm', function(e) {
                e.preventDefault();
                $(document).find('.campaign-loader-wrapper').removeClass('d-none');
                route = `{{ route('user.campaign.description', '') }}/${slug}`;
                var formData = new FormData($(this)[0]);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: route,
                    method: "POST",
                    data: formData,
                    async: false,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $(document).find('.campaign-loader-wrapper').addClass('d-none');
                        if (response.error) {
                            notify('error', response.error)
                            return;
                        } else {
                            $(document).find('.form-steps__step').removeClass('form-steps__step--active');
                            stepName = $(document).find('.form-steps__step.content,.form-steps__step.basic,.form-steps__step.description,.form-steps__step.requirement');
                            stepName.addClass('form-steps__step--active')

                            step = response.step;
                            slug = response.campaign_slug;
                            $(document).find('#myTabContent').html(response.html);

                            $(".select2-basic").select2({
                                width: "100%",
                                closeOnSelect: false
                            });

                            url = `{{ route('user.campaign.create') }}/${step}/${slug}`
                            window.history.pushState("object or string", "Title", `${url}`);

                            $('.select2').each(function(index, element) {
                                $(element).select2();
                            });

                            productCount()
                        }
                    }
                });
            });
            $(document).on('submit', '#requirementForm', function(e) {
                e.preventDefault();
                $(document).find('.campaign-loader-wrapper').removeClass('d-none');
                route = `{{ route('user.campaign.requirement', '') }}/${slug}`;
                var formData = new FormData($(this)[0]);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: route,
                    method: "POST",
                    data: formData,
                    async: false,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $(document).find('.campaign-loader-wrapper').addClass('d-none');
                        if (response.error) {
                            notify('error', response.error)
                            return;
                        } else {
                            $(document).find('.form-steps__step').removeClass('form-steps__step--active');
                            stepName = $(document).find('.form-steps__step.content,.form-steps__step.basic,.form-steps__step.description,.form-steps__step.requirement,.form-steps__step.budget');
                            stepName.addClass('form-steps__step--active')

                            step = response.step;
                            slug = response.campaign_slug;
                            $(document).find('#myTabContent').html(response.html);

                            url = `{{ route('user.campaign.create') }}/${step}/${slug}`
                            window.history.pushState("object or string", "Title", `${url}`);

                            dateRange();

                            $.each($('input, select, textarea'), function(i, element) {
                                if (element.hasAttribute('required')) {
                                    $(element).closest('.form-group').find('label').first().addClass('required');
                                }
                            });
                        }
                    }
                });
            });
            $(document).on('submit', '#budgetForm', function(e) {
                e.preventDefault();
                $(document).find('.campaign-loader-wrapper').removeClass('d-none');
                $(document).find('.submit-btn').addClass('disabled');
                route = `{{ route('user.campaign.budget', '') }}/${slug}`;
                var formData = new FormData($(this)[0]);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: route,
                    method: "POST",
                    data: formData,
                    async: false,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $(document).find('.campaign-loader-wrapper').addClass('d-none');
                        if (response.error) {
                            notify('error', response.error)
                            return;
                        } else {
                            $(document).find('.submit-btn').removeClass('disabled');
                            window.location.href = response.redirect_url;
                        }
                    }
                });
            });


            $(document).on('click', '.preContentBtn', function(e) {
                $(document).find('.campaign-loader-wrapper').removeClass('d-none');

                $.ajax({
                    type: "GET",
                    url: `{{ route('user.campaign.previous', ['', '']) }}/basic/${slug}`,
                    success: function(response) {
                        $(document).find('.campaign-loader-wrapper').addClass('d-none');
                        if (response.error) {
                            notify('error', response.error)
                            return;
                        } else {
                            $(document).find('.form-steps__step').removeClass('form-steps__step--active');
                            stepName = $(document).find('.form-steps__step.basic');
                            stepName.addClass('form-steps__step--active');

                            step = response.step;
                            slug = response.campaign_slug;
                            $(document).find('#myTabContent').html(response.html);
                            sendProduct(response.send_product)
                            contentCreator(response.content_creator)
                            url = `{{ route('user.campaign.create') }}`
                            window.history.pushState("object or string", "Title", `${url}`);
                            reinitializeComponents();
                        }
                    }
                });
            });

            function reinitializeComponents() {
                $(document).on('change', '.image-upload-input', function() {
                    proPicURL(this);
                });

                function proPicURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var preview = $(input).closest('.image-upload-wrapper').find('.image-upload-preview');
                            $(preview).css('background-image', 'url(' + e.target.result + ')');
                            $(preview).addClass('has-image');
                            $(preview).hide();
                            $(preview).fadeIn(650);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            }

            $(document).on('click', '.preDescBtn', function(e) {
                $(document).find('.campaign-loader-wrapper').removeClass('d-none');
                $.ajax({
                    type: "GET",
                    url: `{{ route('user.campaign.previous', ['', '']) }}/content/${slug}`,
                    success: function(response) {
                        $(document).find('.campaign-loader-wrapper').addClass('d-none');
                        if (response.error) {
                            notify('error', response.error)
                            return;
                        } else {
                            $(document).find('.form-steps__step').removeClass('form-steps__step--active');
                            stepName = $(document).find('.form-steps__step.basic,.form-steps__step.content');
                            stepName.addClass('form-steps__step--active')

                            step = response.step;
                            slug = response.campaign_slug;
                            $(document).find('#myTabContent').html(response.html);
                            url = `{{ route('user.campaign.create') }}/${step}/${slug}`
                            window.history.pushState("object or string", "Title", `${url}`);

                            productCount()
                        }
                    }
                });
            });
            $(document).on('click', '.preReqBtn', function(e) {
                $(document).find('.campaign-loader-wrapper').removeClass('d-none');
                $.ajax({
                    type: "GET",
                    url: `{{ route('user.campaign.previous', ['', '']) }}/description/${slug}`,
                    success: function(response) {
                        $(document).find('.campaign-loader-wrapper').addClass('d-none');
                        if (response.error) {
                            notify('error', response.error)
                            return;
                        } else {
                            $(document).find('.form-steps__step').removeClass('form-steps__step--active');
                            stepName = $(document).find('.form-steps__step.basic,.form-steps__step.content,.form-steps__step.description');
                            stepName.addClass('form-steps__step--active')


                            step = response.step;
                            slug = response.campaign_slug;
                            $(document).find('#myTabContent').html(response.html);

                            $(".select2-auto-tokenize").select2({
                                tags: true,
                                tokenSeparators: [","],
                                dropdownParent: $(".card-body"),
                                width: "100%",
                                closeOnSelect: true
                            });

                            $(".nicEdit").each(function(index) {
                                $(this).attr("id", "nicEditor" + index);
                                new nicEditor({
                                    fullPanel: true
                                }).panelInstance('nicEditor' + index, {
                                    hasPanel: true
                                });
                            });

                            $('.nicEdit-panelContain').parent().width('100%');
                            $('.nicEdit-panelContain').parent().next().width('100%');
                            $('.nicEdit-main').width('100%');
                            $('.nicEdit-main').addClass('nicEdit-selected');

                            url = `{{ route('user.campaign.create') }}/${step}/${slug}`
                            window.history.pushState("object or string", "Title", `${url}`);
                        }
                    }
                });
            });

            $(document).on('click', '.preBudgetBtn', function(e) {
                $(document).find('.campaign-loader-wrapper').removeClass('d-none');
                $.ajax({
                    type: "GET",
                    url: `{{ route('user.campaign.previous', ['', '']) }}/requirement/${slug}`,
                    success: function(response) {
                        $(document).find('.campaign-loader-wrapper').addClass('d-none');
                        if (response.error) {
                            notify('error', response.error)
                            return;
                        } else {
                            $(document).find('.form-steps__step').removeClass('form-steps__step--active');
                            stepName = $(document).find('.form-steps__step.basic,.form-steps__step.content,.form-steps__step.description,.form-steps__step.requirement');
                            stepName.addClass('form-steps__step--active')

                            step = response.step;
                            slug = response.campaign_slug;
                            $(document).find('#myTabContent').html(response.html);

                            $(".select2-basic").select2({
                                width: "100%",
                                closeOnSelect: false
                            });

                            url = `{{ route('user.campaign.create') }}/${step}/${slug}`
                            window.history.pushState("object or string", "Title", `${url}`);

                            $('.select2').each(function(index, element) {
                                $(element).select2();
                                productCount()
                            });
                        }
                    }
                });
            });

            function productCount() {
                const productQty = $(document).find(".product-qty");
                productQty.each(function() {
                    const qtyIncrement = $(this).find(".product-qty__increment");
                    const qtyDecrement = $(this).find(".product-qty__decrement");
                    let qtyValue = $(this).find(".product-qty__value");
                    qtyIncrement.on("click", function() {
                        var oldValue = parseFloat(qtyValue.val());
                        var newVal = oldValue + 1;
                        qtyValue.val(newVal).trigger("change");
                    });

                    qtyDecrement.on("click", function() {
                        var oldValue = parseFloat(qtyValue.val());
                        if (oldValue <= 1) {
                            var newVal = oldValue;
                        } else {
                            var newVal = oldValue - 1;
                        }
                        qtyValue.val(newVal).trigger("change");
                    });
                });
            }

            function dateRange() {
                let minDate = `{{ now()->format('Y-m-d') }}`;
                $('input[name="start_date"]').daterangepicker({
                    "singleDatePicker": true,
                    "opens": "right",
                    "minDate": minDate,
                    "locale": {
                        "format": "YYYY-MM-DD",
                    }
                });
                $('input[name="end_date"]').daterangepicker({
                    "singleDatePicker": true,
                    "minDate": minDate,
                    "opens": "right",
                    "locale": {
                        "format": "YYYY-MM-DD",
                    }
                });
            }

            dateRange();

            function sendProduct(value) {
                if (value == 'yes') {
                    $('.monetary-value').removeClass('d-none');
                } else {
                    $('.monetary-value').addClass('d-none');
                }
            }

            function contentCreator(value) {
                if (value == 'influencer') {
                    $('.yourself-content').addClass('d-none');
                } else {
                    $('.yourself-content').removeClass('d-none');
                }
            }
        })(jQuery);
    </script>
@endpush
