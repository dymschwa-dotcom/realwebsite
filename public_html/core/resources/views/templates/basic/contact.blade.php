@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $contact = getContent('contact_us.content', true);
        $socials = getContent('contact_us.element', orderById: true);
    @endphp
    <section class="contact-section contact-bottom py-120">
        <div class="container">
            <div class="row gy-4 mb-4 mb-lg-5">
                <div class="col-sm-6 col-lg-4">
                    <div class="contact__info__wrapper">
                        <div class="contact__info-box">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail">
                                    <rect width="20" height="16" x="2" y="4" rx="2" />
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                </svg>
                            </div>
                            <div class="text">
                                <h4>@lang('Email')</h4>
                                <a href="mailto:{{ @$contact->data_values->email_address }}">{{ __(@$contact->data_values->email_address) }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="contact__info__wrapper">
                        <div class="contact__info-box">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                </svg>
                            </div>
                            <div class="text">
                                <h4>@lang('Phone')</h4>
                                <a href="tel:{{ @$contact->data_values->contact_number }}">{{ __(@$contact->data_values->contact_number) }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="contact__info__wrapper">
                        <div class="contact__info-box">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin">
                                    <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                    <circle cx="12" cy="10" r="3" />
                                </svg>
                            </div>
                            <div class="text">
                                <h4>@lang('Location')</h4>
                                <p class="mb-0">{{ __(@$contact->data_values->contact_details) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-inner">
                <div class="contact-inner__side one bg-img" data-background-image="{{ frontendImage('contact_us', @$contact->data_values->image, '648x826') }}">
                </div>
                <div class="contact-inner__side two">
                    <div class="contactus-form">
                        <div class="section-heading style-left">
                            <h2 class="section-heading__title mb-2">{{ __(@$contact->data_values->heading) }}</h2>
                            <p class="section-heading__desc">{{ __(@$contact->data_values->short_description) }}</p>
                        </div>
                        <form autocomplete="off" class="verify-gcaptcha" method="POST">
                            @csrf
                            <div class="row gx-3">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Name')</label>
                                        <input name="name" type="text" class="form--control" value="{{ old('name', @$user->fullname) }}" @if ($user && $user->profile_complete) readonly @endif required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Email')</label>
                                        <input name="email" type="email" class="form--control" value="{{ old('email', @$user->email) }}" @if ($user) readonly @endif required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Subject')</label>
                                        <input name="subject" type="text" class="form--control" value="{{ old('subject') }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Message')</label>
                                        <textarea name="message" class="form--control" required>{{ old('message') }}</textarea>
                                    </div>
                                </div>

                                <x-captcha />

                                <div class="col-sm-12">
                                    <div class="form-group mb-0">
                                        <button class="btn btn--base w-100" type="submit">@lang('Send Your Message')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="contact--map mt-4 mt-lg-5">
                <iframe src="{{ @$contact->data_values->map_link }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.bg-img').css('background', function() {
                var bg = 'url(' + $(this).data('background-image') + ')';
                return bg;
            });

        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        .custom--accordion .accordion-button {
            gap: 8px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .section-heading {
            margin-bottom: 30px;
        }

        .contact--map {
            padding: 20px;
            background-color: hsl(var(--white));
            border-radius: 12px;
            margin-bottom: 24px;
        }

        .contact--map iframe {
            height: 400px;
            width: 100%;
            border-radius: inherit;
            display: block;
        }

        .contact-bottom {
            background-color: hsl(var(--black) / .05)
        }

        .contactus-form {
            padding: 32px !important;
            border-radius: 15px;
            box-shadow: unset !important;
            background-color: hsl(var(--white));
        }

        textarea.form--control {
            height: 120px;
        }

        .form--control {
            padding: 12px 15px !important;
            background-color: hsl(var(--black) / .02);
            border: 0;
        }

        .form--control:focus {
            background-color: hsl(var(--black) / .02);
        }

        .contact__info__wrapper {
            background-color: hsl(var(--white));
            padding: 32px 24px;
            border-radius: 12px;
        }

        .contact__info-box:not(:last-child) {
            margin-bottom: 16px;
        }

        .contact__info-box {
            gap: 16px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            text-align: center;
            align-items: center;
        }

        .contact__info-box .icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            font-size: 22px;
            color: hsl(var(--base));
        }

        .contact__info-box .text h4 {
            font-size: 1.25rem;
            font-weight: 600;
            line-height: 1;
            color: hsl(var(--black)/0.8);
        }

        @media (max-width: 575px) {

            .contact__info__wrapper,
            .contactus-form {
                padding: 24px !important;
            }
        }

        @media (max-width: 425px) {

            .contact__info__wrapper,
            .contactus-form {
                padding: 16px !important;
            }
        }

        /* =============================== Contact Css Start ======================== */
        .contact-section .section-heading__desc {
            max-width: 700px;
        }

        .contact-section .contact-inner {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            border-radius: 12px;
            overflow: hidden;
            -webkit-box-shadow: var(--box-shadow);
            box-shadow: var(--box-shadow);
        }

        @media screen and (max-width: 991px) {
            .contact-section .contact-inner {
                grid-template-columns: repeat(1, 1fr);
                gap: 48px;
                border-radius: 0px;
                -webkit-box-shadow: none;
                box-shadow: none;
            }
        }

        .contact-section .contact-inner__side {
            padding: 48px;
        }

        @media screen and (max-width: 1199px) {
            .contact-section .contact-inner__side {
                padding: 72px 36px;
            }
        }

        @media screen and (max-width: 991px) {
            .contact-section .contact-inner__side {
                padding: 48px 24px;
            }
        }

        @media screen and (max-width: 767px) {
            .contact-section .contact-inner__side {
                border-radius: 6px;
                -webkit-box-shadow: var(--box-shadow);
                box-shadow: var(--box-shadow);
            }
        }

        .contact-section .contact-inner__side.one {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            background-color: hsl(var(--dark));
            position: relative;
            z-index: 1;
            background-position: center !important;
        }


        @media screen and (max-width: 991px) {
            .contact-section .contact-inner__side.one {
                display: none;
            }
        }

        @media screen and (max-width: 767px) {
            .contact-section .contact-inner__side.one {
                -webkit-box-ordinal-group: 2;
                -ms-flex-order: 1;
                order: 1;
            }
        }

        .contact-section .contact-inner__side.two {
            background-color: hsl(var(--white));
        }

        .contact-section .contact-info__title {
            color: hsl(var(--white));
            line-height: 1;
        }

        .contact-section .contact-info__title span {
            color: hsl(var(--base));
            display: inline-block;
            padding-left: 10px;
            border-left: 3px solid hsl(var(--base));
        }

        .contact-section .contact-info__desc {
            font-weight: 400;
            color: hsl(var(--body-bg));
        }

        .contact-section .contact-info-list {
            margin-top: 36px;
        }

        .contact-section .contact-info-list__item {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            gap: 12px;
        }

        .contact-section .contact-info-list__item:not(:last-child) {
            margin-bottom: 24px;
        }

        .contact-section .contact-info-list__item-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            color: hsl(var(--base));
            border: 3px solid hsl(var(--base)/0.25);
            font-size: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .contact-section .contact-info-list__item-icon::after {
            content: "";
            width: calc(100% - 6px);
            height: calc(100% - 6px);
            border-radius: 50%;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            z-index: -1;
            background-color: hsl(var(--base)/0.25);
        }

        .contact-section .contact-info-list__item-link,
        .contact-section .contact-info-list__item-text {
            font-size: 1.125rem;
            font-weight: 500;
            color: hsl(var(--white));
        }

        .contact-section .contact-info-list__item-link:hover,
        .contact-section .contact-info-list__item-link:focus {
            color: hsl(var(--base));
        }

        /* =============================== Contact Css End ========================== */
    </style>
@endpush
