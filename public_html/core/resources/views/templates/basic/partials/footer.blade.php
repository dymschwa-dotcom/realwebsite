@php
    $socialIcons = getContent('social_icon.element', false, null, true);
    $policyPages = getContent('policy_pages.element', false, null, true);
    $contact = getContent('contact_us.content', true);
    $footer = getContent('footer.content', true);
@endphp

<footer class="footer-area">
    <div class="pb-60 pt-60">
        <div class="container">
            <div class="row justify-content-center gy-5">
                <div class="col-xl-3 col-sm-6">
                    <div class="footer-item">
                        <div class="footer-item__logo">
                            <a href="{{ route('home') }}"> <img src="{{ siteLogo() }}" alt="logo"></a>
                        </div>
                        <p class="footer-item__desc"> {{ __(@$footer->data_values->description) }} </p>
                    </div>
                </div>
                <div class="col-xl-1 d-xl-block d-none"></div>
                <div class="col-xl-2 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Quick Links')</h5>
                        <ul class="footer-menu">
                            <li class="footer-menu__item">
                                <a href="{{ route('campaign.all') }}" class="footer-menu__link">@lang('Campaigns')</a>
                            </li>
                            <li class="footer-menu__item">
                                <a href="{{ route('influencer.all') }}" class="footer-menu__link">@lang('Influencers') </a>
                            </li>
                            <li class="footer-menu__item">
                                <a href="{{ route('contact') }}" class="footer-menu__link">@lang('Contact')</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Useful Links')</h5>
                        <ul class="footer-menu">
                            @foreach ($policyPages as $policy)
                                <li class="footer-menu__item">
                                    <a href="{{ route('policy.pages', $policy->slug) }}"
                                       class="footer-menu__link">
                                        {{ __(@$policy->data_values->title) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-1 d-xl-block d-none"></div>
                <div class="col-xl-3 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Contact Info')</h5>
                        <ul class="footer-menu">
                            <li class="footer-menu__item">
                                <a href="mailto:{{ @$contact->data_values->email_address }}" class="footer-menu__link"><i class="fas fa-envelope"></i> {{ @$contact->data_values->email_address }}</a>
                            </li>
                            <li class="footer-menu__item">
                                <a href="tel:{{ @$contact->data_values->contact_number }}" class="footer-menu__link"><i class="fas fa-phone"></i> {{ @$contact->data_values->contact_number }}</a>
                            </li>
                        </ul>
                        <ul class="social-list">
                            @foreach ($socialIcons as $social)
                                <li class="social-list__item">
                                    <a href="{{ @$social->data_values->url }}" class="social-list__link" target="_blank">
                                        @php
                                            echo @$social->data_values->social_icon;
                                        @endphp
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-footer-area section-bg">
        <div class="container">
            <div class="row gy-3">
                <div class="col-md-12 text-center">
                    <div class="bottom-footer   py-4">
                        <div class="bottom-footer-text"> &copy; @lang('Copyright') @php echo date('Y') @endphp <a href="{{ route('home') }}" class="text--base">{{ __(gs('site_name')) }}</a> @lang('All Right Reserved').
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
