@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $campaignSteps = ['basic', 'content', 'description', 'requirement', 'budget'];
        $stepName = array_slice($campaignSteps, 0, $step + 1);
        $currentStep = $campaignSteps[$step];
    @endphp

    <div class="card custom--card">
        <div class="card-body">
            <div class="step-form position-relative">
                <div class="campaign-loader-wrapper d-none">
                    <div class="campaign-loader mx-auto"></div>
                </div>
                <div class="create-heading mb-4 text-center">
                    <h3 class="mb-2 text-center">{{ __($pageTitle) }}</h3>
                    <p>@lang('Follow the simple 5 steps to create your campaign.')</p>
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

            // Initialize global slug
            let slug = "{{ @$campaign->slug }}";
            let baseUrl = "{{ route('user.campaign.create') }}";

            function initNicEditor() {
                $(".nicEdit").each(function(index) {
                    if (!$(this).prev().hasClass('nicEdit-panelContain')) {
                        $(this).attr("id", "nicEditor" + index);
                        new nicEditor({fullPanel: true}).panelInstance('nicEditor' + index);
                    }
                });
                $('.nicEdit-panelContain').parent().width('100%');
                $('.nicEdit-main').width('100%');
            }

            bkLib.onDomLoaded(initNicEditor);

            $(document).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain', function() {
                $('.nicEdit-main').focus();
            });

            // --- REWRITTEN UPDATEWIZARD ---
            function updateWizard(response, stepsArray) {
                // Debugging: This will show you exactly what the server sent back
                    console.log("Server Response:", response);

                // Capture the slug (Check for both possible names)
                    slug = response.campaign_slug || response.slug; 

                    if (!slug) {
                            console.error("CRITICAL: No slug returned from server!");
                }
                // 1. Capture the new slug immediately
                if (response.campaign_slug) {
                    slug = response.campaign_slug;
                }
                
                let step = response.step;

                // 2. Update Progress Circles
                $('.form-steps__step').removeClass('form-steps__step--active');
                stepsArray.forEach(s => {
                    $('.form-steps__step.' + s).addClass('form-steps__step--active');
                });

                // 3. Inject HTML
                $('#myTabContent').html(response.html);

                // 4. Force Visibility of the Next Tab
                $('.tab-pane').removeClass('show active').addClass('fade');
                let nextStepName = stepsArray[stepsArray.length - 1]; 
                $('#pills-' + nextStepName).addClass('show active').removeClass('disabled');

                // 5. Update Browser URL
                let newUrl = baseUrl + "/" + step + "/" + slug;
                window.history.pushState({}, "", newUrl);

                // 6. Re-init UI elements
                productCount();
                if (typeof initNicEditor === "function") initNicEditor();
            }

            // Step 0: Basic
            $(document).on('submit', '#basicForm', function(e) {
                e.preventDefault(); 
                $('.campaign-loader-wrapper').removeClass('d-none');
                
                let postUrl = slug ? 
                    "{{ route('user.campaign.basic', ':slug') }}".replace(':slug', slug) : 
                    "{{ route('user.campaign.basic') }}";

                $.ajax({
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    url: postUrl,
                    method: "POST",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.campaign-loader-wrapper').addClass('d-none');
                        if (response.error) {
                            notify('error', response.error);
                        } else {
                            updateWizard(response, ['basic', 'content']);
                        }
                    },
                    error: function(xhr) {
                        $('.campaign-loader-wrapper').addClass('d-none');
                        notify('error', "Server Error. Check console.");
                    }
                });
            });

            // Step 1: Content
            $(document).on('submit', '#contentForm', function(e) {
                e.preventDefault();
                
                if (!slug || slug === 'null' || slug === '') {
                    notify('error', 'Campaign ID not found. Please try re-saving the first step.');
                    return false;
                }

                $('.campaign-loader-wrapper').removeClass('d-none');
                let actionUrl = "{{ route('user.campaign.content', ':slug') }}".replace(':slug', slug);
                
                $.ajax({
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    url: actionUrl,
                    method: "POST",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.campaign-loader-wrapper').addClass('d-none');
                        if (response.error) {
                            notify('error', response.error);
                        } else {
                            updateWizard(response, ['basic', 'content', 'description']);
                        }
                    }
                });
            });

            // Step 2: Description
            $(document).on('submit', '#descriptionForm', function(e) {
                e.preventDefault();
                
                if (!slug || slug === 'null') {
                    notify('error', 'Campaign session lost. Please refresh.');
                    return false;
                }

                $('.campaign-loader-wrapper').removeClass('d-none');
                let actionUrl = "{{ route('user.campaign.description', ':slug') }}".replace(':slug', slug);

                $.ajax({
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    url: actionUrl,
                    method: "POST",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.campaign-loader-wrapper').addClass('d-none');
                        if (response.status == 'success') {
                            notify('success', 'Description and image saved!');
                            updateWizard(response, ['basic', 'content', 'description', 'requirement']);
                        }
                    }
                });
            });

            // Step 3: Requirement
            $(document).on('submit', '#requirementForm', function(e) {
                e.preventDefault();
                $('.campaign-loader-wrapper').removeClass('d-none');
                let route = "{{ route('user.campaign.requirement', ':slug') }}".replace(':slug', slug);

                $.ajax({
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    url: route,
                    method: "POST",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.campaign-loader-wrapper').addClass('d-none');
                        if (response.error) {
                            notify('error', response.error);
                        } else {
                            updateWizard(response, ['basic', 'content', 'description', 'requirement', 'budget']);
                            dateRange();
                        }
                    }
                });
            });

            // Step 4: Budget
            $(document).on('submit', '#budgetForm', function(e) {
                e.preventDefault();
                $('.campaign-loader-wrapper').removeClass('d-none');
                let route = "{{ route('user.campaign.budget', ':slug') }}".replace(':slug', slug);

                $.ajax({
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    url: route,
                    method: "POST",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.campaign-loader-wrapper').addClass('d-none');
                        if (response.error) {
                            notify('error', response.error);
                        } else {
                            window.location.href = response.redirect_url;
                        }
                    }
                });
            });

            // Previous Button Logic
            $(document).on('click', '[class^="pre"]', function() {
                let targetStep = $(this).data('pre');
                $('.campaign-loader-wrapper').removeClass('d-none');

                let preUrl = "{{ route('user.campaign.previous', ['', '']) }}/" + targetStep + "/" + slug;

                $.ajax({
                    type: "GET",
                    url: preUrl,
                    success: function(response) {
                        $('.campaign-loader-wrapper').addClass('d-none');
                        updateWizard(response, ['basic', 'content', 'description', 'requirement', 'budget'].slice(0, response.step + 1));
                    }
                });
            });

            function productCount() {
                $(".product-qty").each(function() {
                    let qtyValue = $(this).find(".product-qty__value");
                    $(this).find(".product-qty__increment").off('click').on("click", function() {
                        qtyValue.val(parseFloat(qtyValue.val()) + 1).trigger("change");
                    });
                    $(this).find(".product-qty__decrement").off('click').on("click", function() {
                        let val = parseFloat(qtyValue.val());
                        if (val > 1) qtyValue.val(val - 1).trigger("change");
                    });
                });
            }

            function dateRange() {
                let minDate = `{{ now()->format('Y-m-d') }}`;
                if($.fn.daterangepicker) {
                    $('input[name="start_date"], input[name="end_date"]').daterangepicker({
                        "singleDatePicker": true,
                        "minDate": minDate,
                        "locale": {"format": "YYYY-MM-DD"}
                    });
                }
            }

            productCount();
            dateRange();

        })(jQuery);
    </script>
@endpush