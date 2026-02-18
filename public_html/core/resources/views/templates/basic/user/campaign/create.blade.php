@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $isInfluencer = auth()->guard('influencer')->check();
        $campaignSteps = ['basic', 'content', 'description', 'requirement', 'budget'];

        // If influencer, we skip 'requirement'
        if ($isInfluencer) {
            $campaignSteps = ['basic', 'content', 'description', 'budget'];
        }

        $stepName = array_slice($campaignSteps, 0, $step + 1);

        // Adjust current step mapping for influencer because index might shift
        // If $step is 4 (budget in brand), it might need to be 3 in influencer array
        $currentStep = $campaignSteps[$step] ?? $campaignSteps[count($campaignSteps)-1];
    @endphp

    <div class="card custom--card">
        <div class="card-body">
            <div class="step-form position-relative">
                <div class="campaign-loader-wrapper d-none">
                    <div class="campaign-loader mx-auto"></div>
                </div>
                <div class="create-heading mb-4 text-center">
                    <h3 class="mb-2 text-center">{{ $isInfluencer ? __('Custom Proposal') : __($pageTitle) }}</h3>
                    <p>{{ $isInfluencer ? __('Outline your proposal in simple steps.') : __('Follow the simple 5 steps to create your campaign.') }}</p>
                </div>

                <div class="form-steps">
                    @foreach ($campaignSteps as $key => $campaignStep)
                        @php
                            // Mapping for influencer step indices to match controller response
                            $displayKey = $key;
                            if($isInfluencer && $key == 3) $displayKey = 4; // Force budget to show as index 4 for influencer
                        @endphp
                        <div class="form-steps__step {{ $campaignStep }} form-steps__step--{{ in_array($campaignStep, $stepName) ? 'active' : 'incomplete' }}">
                            <a class="form-steps__step-link" href="javascript:void(0)"></a>
                            <div class="form-steps__step-circle">
                                <span class="form-steps__step-number">{{ $key + 1 }} </span>
                            </div>
                            <span class="form-step__step-name text-capitalize">
                                @if($isInfluencer)
                                    @if($campaignStep == 'description') @lang('Creative Vision')
                                    @elseif($campaignStep == 'budget') @lang('Fee & Timeline')
                                    @else {{ __($campaignStep) }} @endif
                                @else
                                    {{ __($campaignStep) }}
                                @endif
                            </span>
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
    <style>
        .daterangepicker {
            z-index: 1051 !important;
        }
    </style>
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
            let isInfluencer = "{{ auth()->guard('influencer')->check() ? 1 : 0 }}" == "1";
            
            let baseUrl = isInfluencer ? 
                "{{ route('influencer.campaign.create.wizard') }}" : 
                "{{ route('user.campaign.create') }}";

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
                if (typeof productCount === "function") productCount();
                if (typeof initNicEditor === "function") initNicEditor();
                if (typeof datePicker === "function") datePicker();
            }

            function datePicker() {
                console.log("Initializing DatePicker...");
                if ($(".datepicker-here").length > 0) {
                    $('.datepicker-here').daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: true,
                        autoApply: true,
                        locale: {
                            format: 'YYYY-MM-DD'
                        }
                    }).on('show.daterangepicker', function(ev, picker) {
                        console.log("Picker shown");
                    });
                }
            }

            datePicker();

            // Step 0: Basic
            $(document).on('submit', '#basicForm', function(e) {
                e.preventDefault(); 
                $('.campaign-loader-wrapper').removeClass('d-none');
                
                let postUrl = slug ? 
                    "{{ route('user.campaign.basic', ':slug') }}".replace(':slug', slug) : 
                    "{{ route('user.campaign.basic') }}";

                if (isInfluencer) {
                    postUrl = slug ? 
                        "{{ route('influencer.campaign.create.basic', ':slug') }}".replace(':slug', slug) : 
                        "{{ route('influencer.campaign.create.basic') }}";
                }

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
                let actionUrl = isInfluencer ? 
                    "{{ route('influencer.campaign.create.content', ':slug') }}".replace(':slug', slug) :
                    "{{ route('user.campaign.content', ':slug') }}".replace(':slug', slug);
                
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
                let actionUrl = isInfluencer ? 
                    "{{ route('influencer.campaign.create.description', ':slug') }}".replace(':slug', slug) :
                    "{{ route('user.campaign.description', ':slug') }}".replace(':slug', slug);

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
                            let steps = isInfluencer ? ['basic', 'content', 'description', 'budget'] : ['basic', 'content', 'description', 'requirement'];
                            updateWizard(response, steps);
                        }
                    }
                });
            });

            // Step 3: Requirement (Brands Only)
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
                let route = isInfluencer ? 
                    "{{ route('influencer.campaign.create.budget', ':slug') }}".replace(':slug', slug) :
                    "{{ route('user.campaign.budget', ':slug') }}".replace(':slug', slug);

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
            $(document).on('click', '.preContentBtn, .preDescBtn, .preReqBtn, .preBudgetBtn', function() {
                let targetStepName = $(this).data('pre');
                let steps = isInfluencer ? ['basic', 'content', 'description', 'budget'] : ['basic', 'content', 'description', 'requirement', 'budget'];
                let targetStepIndex = steps.indexOf(targetStepName);

                if (targetStepIndex === -1) {
                    notify('error', 'Invalid step');
                    return;
                }
                
                $('.campaign-loader-wrapper').removeClass('d-none');
                
                let prevUrl = isInfluencer ? 
                    "{{ route('influencer.campaign.create.previous', ['step' => 'STEP_HOLDER', 'slug' => 'SLUG_HOLDER']) }}" :
                    "{{ route('user.campaign.previous', ['step' => 'STEP_HOLDER', 'slug' => 'SLUG_HOLDER']) }}";
                
                prevUrl = prevUrl.replace('STEP_HOLDER', targetStepIndex).replace('SLUG_HOLDER', slug);

                $.ajax({
                    url: prevUrl,
                    method: "GET",
                    headers: {"X-Requested-With": "XMLHttpRequest"},
                    success: function(response) {
                        $('.campaign-loader-wrapper').addClass('d-none');
                        updateWizard(response, getStepNamesUpTo(response.step));
                    },
                    error: function() {
                        $('.campaign-loader-wrapper').addClass('d-none');
                        notify('error', 'Could not load previous step.');
                    }
                });
            });

            function getStepNamesUpTo(stepIndex) {
                let steps = isInfluencer ? ['basic', 'content', 'description', 'budget'] : ['basic', 'content', 'description', 'requirement', 'budget'];
                return steps.slice(0, stepIndex + 1);
            }
        })(jQuery);
    </script>
@endpush
