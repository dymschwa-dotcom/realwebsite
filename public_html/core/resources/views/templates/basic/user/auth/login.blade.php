@extends($activeTemplate . 'layouts.app')
@section('panel')
    @php
        $loginAsBrand = getContent('brand_login.content', true);
        $loginAsInfluencer = getContent('influencer_login.content', true);
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
                                <a href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="@lang('image')"></a>
                            </div>
                            <div class="account-info__content">
                                <h4 class="account-info__title">{{ __(@$loginAsBrand->data_values->title) }}</h4>
                                <p class="account-info__description">{{ __(@$loginAsBrand->data_values->short_description) }}</p>
                            </div>
                        </div>
                        @include('Template::partials.auth_top_influencer')
                    </div>
                    <div class="col-xl-6 col-lg-7">
                        <div class="account-form">
                            <div class="account-heading">
                                <div class="account-form__content">
                                    <h4 class="account-form__title mb-2">{{ __(@$loginAsBrand->data_values->heading) }}</h4>
                                    <p class="account-form__desc">{{ __(@$loginAsBrand->data_values->subheading) }}</p>
                                </div>
                                <div class="action-area">
                                    <button class="btn btn--base outline btn--sm actionBtn active" data-type="brand" type="button">@lang('Brand')</button>
                                    <button class="btn btn--base outline btn--sm actionBtn" data-type="influencer" type="button">@lang('Influencer')</button>
                                </div>
                            </div>
                            <form class="verify-gcaptcha" method="POST" action="{{ route('user.login') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="form--label">@lang('Username or Email')</label>
                                    <input type="text" class="form--control" name="username" value="{{ old('username') }}" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label class="form--label">@lang('Password')</label>
                                    <input type="password" class="form--control" name="password" required autocomplete="off">
                                </div>

                                <x-captcha />

                                <div class="form-group">
                                    <div class="d-flex flex-wrap justify-content-between gap-1">
                                        <div class="form--check">
                                            <input class="form-check-input" type="checkbox" id="remember"
                                                   name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">@lang('Remember me')</label>
                                        </div>
                                        <a href="{{ route('user.password.request') }}" class="forgot-password text--base">@lang('Forgot Your Password')?</a>
                                    </div>
                                </div>
                                <button type="submit" id="recaptcha" class="btn btn--base w-100 mb-4">@lang('Submit')</button>
                                <div class="have-account text-center">
                                    <p class="have-account__text">@lang('Don\'t Have An Account')?
                                        <a href="{{ route('user.register') }}" class="have-account__link text--base register-url">@lang('Create New Account')</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            let action;
            let forgotUrl;
            let registerUrl;
            let pageTitle;
            let shortDescription;
            let heading;
            let subheading;

            sessionStorage.removeItem("register_user_type");

            changeAttribute();

            $('.actionBtn').on('click', function() {
                sessionStorage.setItem("login_user_type", $(this).data('type'));
                changeAttribute()
            });

            function changeAttribute() {
                let userType = sessionStorage.getItem("login_user_type") ?? 'brand';
                $('button[data-type]').removeClass('active');
                $('button[data-type="' + userType + '"]').addClass('active');

                if (userType == 'brand') {
                    action = `{{ route('user.login') }}`;
                    forgotUrl = `{{ route('user.password.request') }}`;
                    registerUrl = `{{ route('user.register') }}`;
                    heading = `{{ __(@$loginAsBrand->data_values->heading) }}`;
                    subheading = `{{ __(@$loginAsBrand->data_values->subheading) }}`;
                    pageTitle = `{{ __(@$loginAsBrand->data_values->title) }}`;
                    shortDescription = `{{ __(@$loginAsBrand->data_values->short_description) }}`;
                } else {
                    action = `{{ route('influencer.login') }}`;
                    forgotUrl = `{{ route('influencer.password.request') }}`;
                    registerUrl = `{{ route('influencer.register') }}`;
                    heading = `{{ __(@$loginAsInfluencer->data_values->heading) }}`;
                    subheading = `{{ __(@$loginAsInfluencer->data_values->subheading) }}`;
                    pageTitle = `{{ __(@$loginAsInfluencer->data_values->title) }}`;
                    shortDescription = `{{ __(@$loginAsInfluencer->data_values->short_description) }}`;
                }

                $('form')[0].action = action;
                $('.forgot-password').attr('href', forgotUrl);
                $('.register-url').attr('href', registerUrl);
                $('.account-info__title').text(pageTitle);
                $('.account-info__description').text(shortDescription);
                $('.account-form__title').text(heading);
                $('.account-form__desc').text(subheading);
            }

        })(jQuery);
    </script>
@endpush
