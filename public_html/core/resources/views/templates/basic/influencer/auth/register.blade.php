@extends($activeTemplate . 'layouts.app')
@section('panel')
    @php
        $registerAsBrand = getContent('brand_register.content', true);
        $registerAsInfluencer = getContent('influencer_register.content', true);
    @endphp

    <section class="account-section py-60">
        <div class="bg-section">
            <img src="{{ getImage($activeTemplateTrue . 'images/section-bg.png') }}" alt="@lang('image')">
        </div>

        <div class="account-inner">
            <div class="container">
                <div class="row gy-4 align-items-center flex-wrap">
                    <div class="col-xl-6 col-lg-5">
                        <div class="account-info text-center">
                            <div class="account-info__thumb mb-4">
                                <a href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="image"></a>
                            </div>
                            <div class="account-info__content">
                                <h4 class="account-info__title">{{ __(@$registerAsBrand->data_values->title) }}</h4>
                                <p class="account-info__description">{{ __(@$registerAsBrand->data_values->short_description) }}</p>
                            </div>
                        </div>
                        @include('Template::partials.auth_top_influencer')
                    </div>
                    <div class="col-xl-6 col-lg-7">
                        <div class="account-form">
                            <div class="account-heading">
                                <div class="account-form__content">
                                    <h4 class="account-form__title mb-2">{{ __(@$registerAsBrand->data_values->heading) }}</h4>
                                    <p class="account-form__desc">{{ __(@$registerAsBrand->data_values->subheading) }}</p>
                                </div>
                                <div class="action-area">
                                    <button class="btn btn--base btn--sm actionBtn active outline" data-type="brand" type="button">@lang('Brand')</button>
                                    <button class="btn btn--base btn--sm actionBtn outline" data-type="influencer" type="button">@lang('Influencer')</button>
                                </div>
                            </div>
                            <form class="verify-gcaptcha" action="{{ route('user.register') }}" method="POST">
                                @csrf

                                <span class="form-disabled-text d-none">
                                    <svg style="enable-background:new 0 0 512 512" xmlns="http://www.w3.org/2000/svg" version="1.1" width="80" height="80" viewBox="0 0 512 512">
                                        <g>
                                            <path data-original="#f99f0b" d="M255.999 0c-79.044 0-143.352 64.308-143.352 143.353v70.193c0 4.78 3.879 8.656 8.659 8.656h48.057a8.657 8.657 0 0 0 8.656-8.656v-70.193c0-42.998 34.981-77.98 77.979-77.98s77.979 34.982 77.979 77.98v70.193c0 4.78 3.88 8.656 8.661 8.656h48.057a8.657 8.657 0 0 0 8.656-8.656v-70.193C399.352 64.308 335.044 0 255.999 0z" fill="#f99f0b"></path>
                                            <path data-original="#f99f0b" d="M410.63 204.89H101.371c-20.505 0-37.188 16.683-37.188 37.188v232.734c0 20.505 16.683 37.188 37.188 37.188H410.63c20.505 0 37.187-16.683 37.187-37.189V242.078c0-20.505-16.682-37.188-37.187-37.188z" fill="#f99f0b"></path>
                                            <path data-original="#f99f0b" d="M285.11 369.781c10.113-8.521 15.998-20.978 15.998-34.365 0-24.873-20.236-45.109-45.109-45.109-24.874 0-45.11 20.236-45.11 45.109 0 13.387 5.885 25.844 16 34.367l-9.731 46.362a8.66 8.66 0 0 0 8.472 10.436h60.738a8.654 8.654 0 0 0 8.47-10.434l-9.728-46.366z" fill="#f99f0b"></path>
                                        </g>
                                    </svg>
                                </span>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form--label">@lang('First Name')</label>
                                            <input type="text" class="form--control" name="firstname" value="{{ old('firstname') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Last Name')</label>
                                            <input type="text" class="form--control" name="lastname" value="{{ old('lastname') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Email Address')</label>
                                            <input class="form--control checkUser" name="email" type="email" value="{{ old('email') }}" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Password')</label>
                                            <input class="form--control @if (gs('secure_password')) secure-password @endif" name="password" type="password" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Confirm Password')</label>
                                            <input class="form--control" id="password_confirm" name="password_confirmation" type="password" required>
                                        </div>
                                    </div>

                                    <x-captcha />

                                    @if (gs('agree'))
                                        @php
                                            $policyPages = getContent('policy_pages.element', false, orderById: true);
                                        @endphp
                                        <div class="form-group form--check">
                                            <input class="form-check-input" id="agree" name="agree" type="checkbox" @checked(old('agree')) required>
                                            <label class="mx-2" for="agree">@lang('I agree with')</label> <span>
                                                @foreach ($policyPages as $policy)
                                                    <a class="text--base" href="{{ route('policy.pages', $policy->slug) }}" target="_blank">{{ __($policy->data_values->title) }}</a>@if (!$loop->last) , @endif
                                                @endforeach
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <button class="btn btn--base w-100" type="submit">@lang('Sign Up')</button>
                            </form>
                            <div class="have-account text-center mt-3">
                                <p class="have-account__text">@lang('Already Have An Account')? <a class="have-account__link text--base login-url" href="{{ route('user.login') }}">@lang('Login Now')</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- The Modal for Existing Users --}}
    <div class="modal fade" id="existModalCenter" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="mb-0 text-center">@lang('You already have an account please login')</h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark btn--sm" data-bs-dismiss="modal" type="button">@lang('Close')</button>
                    <a class="btn btn--base btn--sm login-url" href="{{ route('influencer.login') }}">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('style')
    <style>
        .hover-input-popup .input-popup {
            bottom: 80%;
        }
        .form-disabled {
            overflow: hidden;
            position: relative;
        }
        .form-disabled::after {
            content: "";
            position: absolute;
            height: 100%;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.2);
            top: 0;
            left: 0;
            backdrop-filter: blur(2px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            z-index: 99;
        }
        .form-disabled-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 991;
            font-size: 24px;
            height: auto;
            width: 100%;
            text-align: center;
            color: hsl(var(--dark-600));
            font-weight: 800;
            line-height: 1.2;
        }
    </style>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {
            
            // --- FIXED AJAX LOGIC ---
            $('.checkUser').on('focusout', function(e) {
                let userType = sessionStorage.getItem("register_user_type") ?? 'influencer';
                let url;
                let emailValue = $(this).val();

                if (!emailValue) return;

                if (userType == 'brand') {
                    url = `{{ route('user.checkUser') }}`;
                } else {
                    // Points to our hybrid route outside guest middleware
                    url = `{{ route('influencer.checkEmail') }}`;
                }

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        email: emailValue,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        /**
                         * Strict Check:
                         * Only trigger the popup if the server explicitly sends back true.
                         * This prevents redirects (HTML pages) from triggering the modal.
                         */
                        if (response && (response.exists === true || response.data === true)) {
                            $('#existModalCenter').modal('show');
                        }
                    },
                    error: function(xhr) {
                        console.error("AJAX Error: Route might be blocked or unreachable.");
                    }
                });
            });

            sessionStorage.removeItem("login_user_type");
            changeAttribute();

            $('.actionBtn').on('click', function() {
                sessionStorage.setItem("register_user_type", $(this).data('type'));
                changeAttribute();
            });

            function changeAttribute() {
                let userType = sessionStorage.getItem("register_user_type") ?? 'influencer';
                $('button[data-type]').removeClass('active');
                $('button[data-type="' + userType + '"]').addClass('active');

                let action, loginUrl, heading, subheading, pageTitle, shortDescription, register;

                if (userType == 'brand') {
                    action = `{{ route('user.register') }}`;
                    loginUrl = `{{ route('user.login') }}`;
                    heading = `{{ __(@$registerAsBrand->data_values->heading) }}`;
                    subheading = `{{ __(@$registerAsBrand->data_values->subheading) }}`;
                    pageTitle = `{{ __(@$registerAsBrand->data_values->title) }}`;
                    shortDescription = `{{ __(@$registerAsBrand->data_values->short_description) }}`;
                    register = `{{ gs('registration') }}`;
                } else {
                    action = `{{ route('influencer.register') }}`;
                    loginUrl = `{{ route('influencer.login') }}`;
                    heading = `{{ __(@$registerAsInfluencer->data_values->heading) }}`;
                    subheading = `{{ __(@$registerAsInfluencer->data_values->subheading) }}`;
                    pageTitle = `{{ __(@$registerAsInfluencer->data_values->title) }}`;
                    shortDescription = `{{ __(@$registerAsInfluencer->data_values->short_description) }}`;
                    register = `{{ gs('influencer_registration') }}`;
                }

                $('form')[0].action = action;
                $('.login-url').attr('href', loginUrl);
                $('.account-info__title').text(pageTitle);
                $('.account-info__description').text(shortDescription);
                $('.account-form__title').text(heading);
                $('.account-form__desc').text(subheading);

                if (Number(register)) {
                    $('.account-form form').removeClass('form-disabled');
                    $('.account-form .form-disabled-text').addClass('d-none');
                } else {
                    $('.account-form form').addClass('form-disabled');
                    $('.account-form .form-disabled-text').removeClass('d-none');
                }
            }

        })(jQuery);
    </script>
@endpush