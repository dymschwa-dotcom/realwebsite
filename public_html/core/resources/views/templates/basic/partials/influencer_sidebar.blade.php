<div class="sidebar-menu">
    <span class="sidebar-menu__close d-lg-none d-block"><i class="las la-times"></i></span>
    <div class="sidebar-menu__profile text-center">
        <div class="thumb">
            <img src="{{ getImage(getFilePath('influencer') . '/' . auth()->guard('influencer')->user()->image, getFileSize('influencer')) }}" alt="profile">
        </div>
        <div class="sidebar-menu__profile-content d-flex justify-content-between gap-2">
            <div class="left text-start">
                <h5 class="title">{{ __(auth()->guard('influencer')->user()->fullname) }}</h5>
                <p class="fs-14"><span>@</span>{{ __(auth()->guard('influencer')->user()->username) }}</p>
                <span class="date fs-14"> @lang('Joined at') {{ showDateTime(auth()->guard('influencer')->user()->created_at, 'M d, Y') }}</span>
            </div>
            <div class="right">
                <div class="dropdown profile-action">
                    <span class="" id="dropdownMenuLink" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                    </span>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ route('influencer.profile.setting') }}">@lang('Profile Setting')</a></li>
                        <li><a class="dropdown-item" href="{{ route('influencer.change.password') }}">@lang('Change Password')</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="sidebar-menu-title">
        <p>@lang('Menus')</p>
    </div>
    <ul class="sidebar-menu-list">
        {{-- Dashboard --}}
        <li class="sidebar-menu-list__item {{ menuActive('influencer.home') }}">
            <a class="sidebar-menu-list__link" href="{{ route('influencer.home') }}">
                <span class="icon"><i class="las la-home"></i></span>
                <span class="text">@lang('Dashboard')</span>
            </a>
        </li>

        {{-- Messages - Stays active for index and specific views --}}
        <li class="sidebar-menu-list__item {{ menuActive(['influencer.conversation.index', 'influencer.conversation.view']) }}">
            <a class="sidebar-menu-list__link" href="{{ route('influencer.conversation.index') }}">
                <span class="icon"><i class="las la-comments"></i></span>
                <span class="text">@lang('Messages')</span>
            </a>
        </li>


        {{-- Campaigns/Orders --}}
        <li class="sidebar-menu-list__item {{ menuActive('influencer.campaign.*') }}">
            <a class="sidebar-menu-list__link" href="{{ route('influencer.campaign.log') }}">
                <span class="icon"><i class="las la-layer-group"></i></span>
                <span class="text">@lang('My Campaigns')</span>
            </a>
        </li>

        {{-- Packages --}}
        <li class="sidebar-menu-list__item {{ menuActive('influencer.services.add') }}">
            <a class="sidebar-menu-list__link" href="{{ route('influencer.services.add') }}">
                <span class="icon"><i class="las la-box"></i></span>
                <span class="text">@lang('Manage Packages')</span>
            </a>
        </li>

        {{-- Withdrawals --}}
        <li class="sidebar-menu-list__item {{ menuActive('influencer.withdraw*') }}">
            <a class="sidebar-menu-list__link" href="{{ route('influencer.withdraw.history') }}">
                <span class="icon"><i class="las la-wallet"></i></span>
                <span class="text">@lang('Withdrawals')</span>
            </a>
        </li>

        <div class="sidebar-menu-title">
            <p>@lang('Account Settings')</p>
        </div>

        {{-- Profile Settings --}}
        <li class="sidebar-menu-list__item {{ menuActive('influencer.profile.setting') }}">
            <a class="sidebar-menu-list__link" href="{{ route('influencer.profile.setting') }}">
                <span class="icon"><i class="las la-user-edit"></i></span>
                <span class="text">@lang('Update Details')</span>
            </a>
        </li>

        {{-- 2FA Security --}}
        <li class="sidebar-menu-list__item {{ menuActive('influencer.twofactor') }}">
            <a class="sidebar-menu-list__link" href="{{ route('influencer.twofactor') }}">
                <span class="icon"><i class="las la-shield-alt"></i></span>
                <span class="text">@lang('2FA Security')</span>
            </a>
        </li>

        {{-- Logout --}}
        <li class="sidebar-menu-list__item">
            <a class="sidebar-menu-list__link" href="{{ route('influencer.logout') }}">
                <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                <span class="text">@lang('Logout')</span>
            </a>
        </li>
    </ul>
</div>