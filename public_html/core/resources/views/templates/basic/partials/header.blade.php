<header class="header" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">

            <a class="navbar-brand logo" href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="logo"></a>
            <button class="navbar-toggler header-button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span id="hiddenNav"><i class="las la-bars"></i></span>
            </button>

            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-menu ms-auto me-lg-2 me-xl-0">
                    <li class="nav-item d-block d-lg-none">
                        <div class="top-button d-flex justify-content-end align-items-center flex-wrap">

                            <ul class="login-registration-list d-flex align-items-center flex-wrap">
                                @if (auth()->check())
                                    <li class="login-registration-list__item">
                                        @php $user = auth()->user(); @endphp
                                        @if($user->profile_complete == Status::YES)
                                            <a class="login-registration-list__link btn btn--base btn--sm" href="{{ route('user.home') }}"> <i class="las la-tachometer-alt"></i> @lang('Dashboard')</a>
                                        @else
                                            <a class="login-registration-list__link btn btn--base btn--sm" href="{{ route('user.data') }}"> <i class="las la-user-edit"></i> @lang('Complete Sign Up')</a>
                                        @endif
                                    </li>
                                @elseif(auth()->guard('influencer')->check())
                                    <li class="login-registration-list__item">
                                        @php $influencer = auth()->guard('influencer')->user(); @endphp
                                        @if($influencer->profile_complete == Status::YES && $influencer->profile_step > 2)
                                            <a class="login-registration-list__link btn btn--base btn--sm" href="{{ route('influencer.home') }}"> <i class="las la-tachometer-alt"></i> @lang('Dashboard')</a>
                                        @else
                                            <a class="login-registration-list__link btn btn--base btn--sm" href="{{ route('influencer.data') }}"> <i class="las la-user-edit"></i> @lang('Complete Sign Up')</a>
                                        @endif
                                    </li>
                                @else
                                    <li class="login-registration-list__item">
                                        <a class="login-registration-list__link btn btn--base btn--sm" href="{{ route('user.login') }}"> <i class="las la-user"></i> @lang('Login')</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('home') }}" href="{{ route('home') }}" aria-current="page">@lang('Home')</a>
                    </li>

                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#how-it-works">@lang('How it Works')</a>
                        </li>

                    @foreach ($pages as $k => $data)
                    <li class="nav-item">
                            <a class="nav-link {{ menuActive('pages', null, $data->slug) }}" href="{{ route('pages', [$data->slug]) }}" aria-current="page">{{ __($data->name) }}</a>
                    </li>
                    @endforeach

                    @if(auth()->guard('influencer')->check())
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('campaign.all') }}" href="{{ route('campaign.all') }}" aria-current="page">@lang('Campaigns')</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('influencer.all') }}" href="{{ route('influencer.all') }}" aria-current="page">@lang('Influencers')</a>
                        </li>
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('pricing') }}" href="{{ route('pricing') }}">@lang('Pricing')</a>
                    </li>
                    @if (!auth()->check() && !auth()->guard('influencer')->check())
                        <li class="nav-item ">
                            <a class="nav-link {{ menuActive('contact') }}" href="{{ route('contact') }}">@lang('Contact')</a>
                            </li>
                        @endif
                    </ul>
                <div class="d-none d-lg-block">
                    <ul class="header-login list primary-menu">



                        @if (auth()->check())
                            <li class="header-login__item">
                                @php $user = auth()->user(); @endphp
                                @if($user->profile_complete == Status::YES)
                                    <a class="btn btn--base btn--sm" href="{{ route('user.home') }}"><i class="las la-tachometer-alt"></i> @lang('Dashboard')</a>
                                @else
                                    <a class="btn btn--base btn--sm" href="{{ route('user.data') }}"><i class="las la-user-edit"></i> @lang('Complete Sign Up')</a>
                                @endif
                            </li>
                        @elseif(auth()->guard('influencer')->check())
                            <li class="header-login__item">
                                @php $influencer = auth()->guard('influencer')->user(); @endphp
                                @if($influencer->profile_complete == Status::YES && $influencer->profile_step > 2)
                                    <a class="btn btn--base btn--sm" href="{{ route('influencer.home') }}"><i class="las la-tachometer-alt"></i> @lang('Dashboard')</a>
                                @else
                                    <a class="btn btn--base btn--sm" href="{{ route('influencer.data') }}"><i class="las la-user-edit"></i> @lang('Complete Sign Up')</a>
                                @endif
                            </li>
                        @else
                            <li class="header-login__item">
                                <a class="btn btn--base btn--sm" href="{{ route('user.login') }}"> <i class="las la-sign-in-alt"></i> @lang('Login')</a>
                            </li>
                        @endif
                    </ul>
    </div>
    </div>
        </nav>
    </div>
</header>

