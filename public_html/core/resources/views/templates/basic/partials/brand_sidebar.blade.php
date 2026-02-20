@php
    $user = auth()->user();
@endphp
<div class="sidebar-menu">
    <span class="sidebar-menu__close d-lg-none d-block"><i class="las la-times"></i></span>
    <div class="sidebar-menu__profile text-center">
        <div class="thumb">
            <img src="{{ getImage(getFilePath('brand') . '/' . $user->image, null, true) }}" alt="profile">
        </div>
        <div class="sidebar-menu__profile-content d-flex justify-content-between gap-2">
            <div class="left text-start">
                <h5 class="title">{{ __($user->fullname) }}</h5>
                <p class="fs-14"><span>@</span>{{ __($user->username) }}</p>
                <span class="date fs-14"> @lang('Joined at') {{ showDateTime($user->created_at, 'm D, Y') }}</span>
            </div>
            <div class="right">
                <div class="dropdown profile-action">
                    <span class="" id="dropdownMenuLink" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                    </span>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="">
                        <li><a class="dropdown-item" href="{{ route('user.profile.setting') }}">@lang('Profile Setting')</a></li>
                        <li><a class="dropdown-item" href="{{ route('user.change.password') }}">@lang('Change Password')</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="sidebar-menu-title">
        <p>@lang('Menus')</p>
    </div>
    <ul class="sidebar-menu-list">
        <li class="sidebar-menu-list__item {{ menuActive('user.home') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.home') }}">
                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19">
                        <path
                              d="M1 9H7C7.26522 9 7.51957 8.89464 7.70711 8.70711C7.89464 8.51957 8 8.26522 8 8V2C8 1.73478 7.89464 1.48043 7.70711 1.29289C7.51957 1.10536 7.26522 1 7 1H1C0.734784 1 0.48043 1.10536 0.292893 1.29289C0.105357 1.48043 0 1.73478 0 2V8C0 8.26522 0.105357 8.51957 0.292893 8.70711C0.48043 8.89464 0.734784 9 1 9ZM1 19H7C7.26522 19 7.51957 18.8946 7.70711 18.7071C7.89464 18.5196 8 18.2652 8 18V12C8 11.7348 7.89464 11.4804 7.70711 11.2929C7.51957 11.1054 7.26522 11 7 11H1C0.734784 11 0.48043 11.1054 0.292893 11.2929C0.105357 11.4804 0 11.7348 0 12V18C0 18.2652 0.105357 18.5196 0.292893 18.7071C0.48043 18.8946 0.734784 19 1 19ZM11 19H17C17.2652 19 17.5196 18.8946 17.7071 18.7071C17.8946 18.5196 18 18.2652 18 18V12C18 11.7348 17.8946 11.4804 17.7071 11.2929C17.5196 11.1054 17.2652 11 17 11H11C10.7348 11 10.4804 11.1054 10.2929 11.2929C10.1054 11.4804 10 11.7348 10 12V18C10 18.2652 10.1054 18.5196 10.2929 18.7071C10.4804 18.8946 10.7348 19 11 19ZM18.293 4.293L14.707 0.707C14.6142 0.614055 14.504 0.540317 14.3827 0.490006C14.2614 0.439695 14.1313 0.413799 14 0.413799C13.8687 0.413799 13.7386 0.439695 13.6173 0.490006C13.496 0.540317 13.3858 0.614055 13.293 0.707L9.707 4.293C9.61405 4.38579 9.54032 4.49599 9.49001 4.61731C9.43969 4.73862 9.4138 4.86867 9.4138 5C9.4138 5.13133 9.43969 5.26138 9.49001 5.38269C9.54032 5.50401 9.61405 5.61421 9.707 5.707L13.293 9.293C13.3858 9.38595 13.496 9.45968 13.6173 9.50999C13.7386 9.56031 13.8687 9.5862 14 9.5862C14.1313 9.5862 14.2614 9.56031 14.3827 9.50999C14.504 9.45968 14.6142 9.38595 14.707 9.293L18.293 5.707C18.3859 5.61421 18.4597 5.50401 18.51 5.38269C18.5603 5.26138 18.5862 5.13133 18.5862 5C18.5862 4.86867 18.5603 4.73862 18.51 4.61731C18.4597 4.49599 18.3859 4.38579 18.293 4.293Z" />
                    </svg></span>
                <span class="text">@lang('Dashboard')</span>
            </a>
        </li>

        <li class="sidebar-menu-list__item {{ menuActive(['user.deposit.index', 'user.deposit.history']) }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.deposit.index') }}">
                <span class="icon">
                    <i class="fa-solid fa-money-bill"></i>
                </span>
                <span class="text">@lang('Deposit Now')</span>
            </a>
        </li>

        <li class="sidebar-menu-list__item {{ menuActive('user.campaign*') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.campaign.index') }}">
                <span class="icon">
                    <i class="fa-solid fa-bullhorn"></i>
                </span>
                <span class="text">@lang('Campaigns')</span>
            </a>
        </li>

        <li class="sidebar-menu-list__item {{ menuActive('user.review*') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.review.index') }}">
                <span class="icon">
                    <i class="fa-regular fa-star"></i>
                </span>
                <span class="text">@lang('Reviews')</span>
            </a>
        </li>

        <li class="sidebar-menu-list__item {{ menuActive('user.favorite*') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.favorite.list') }}">
                <span class="icon">
                    <i class="far fa-heart"></i>
                </span>
                <span class="text">@lang('Favorites')</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('ticket*') }}">
            <a class="sidebar-menu-list__link" href="{{ route('ticket.index') }}">
                <span class="icon">
                    <i class="fa-regular fa-message"></i>
                </span>
                <span class="text">@lang('Support Ticket')</span>
            </a>
        </li>


        <li class="sidebar-menu-list__item">
            <a class="sidebar-menu-list__link" href="{{ route('user.transactions') }}">
                <span class="icon">
                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                </span>
                <span class="text">@lang('Transactions')</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item">
            <a class="sidebar-menu-list__link" href="{{ route('user.logout') }}">
                <span class="icon">
                    <i class="fas fa-sign-out-alt"></i>
                </span>
                <span class="text">@lang('Logout')</span>
            </a>
        </li>
    </ul>
</div>
