<div class="card custom--card mt-4">
    <div class="card-body">
        <div class="dashboard-hiring">
            <h5 class="title">@lang('Connect Social')</h5>
            <div class="dashboard-hiring__menu">
                <div class="tab-wrapper">
                    <ul class="custom--tab nav nav-pills template-tabs" id="pills-tab" role="tablist">
                        @foreach ($influencer->socialLink as $social)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if ($loop->first) active @endif"
                                        id="pills-{{ @$social->platform->name }}-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-{{ @$social->platform->name }}" type="button" role="tab"
                                        aria-controls="pills-{{ @$social->platform->name }}"
                                        aria-selected="true">{{ ucfirst(@$social->platform->name) }}</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="tab-content" id="pills-tabContent">
            @foreach ($influencer->socialLink as $social)
                @php
                    $channel = $social->platform;
                @endphp
                <div class="tab-pane fade @if ($loop->first) show active @endif"
                     id="pills-{{ @$channel->name }}" role="tabpanel" aria-labelledby="pills-{{ @$channel->name }}-tab"
                     tabindex="0">
                    <div class="chanel-connect text-center">
                        <div class="chanel-connect__icon social-links">
                            @php echo @$channel->icon @endphp
                        </div>
                        <p class="chanel-connect__dsc">
                            @lang('Connect your channel to see your insights & collaborate in campaigns.')
                        </p>

                        @if ($social->channel_connect)
                            <ul class="chanel-connect__list">
                                <li>
                                    <span data-bs-toggle="tooltip" data-bs-original-title="{{ $social->social_link }}"><i class="las fa-link"></i></span>
                                </li>
                                <li>
                                    <span data-bs-toggle="tooltip" data-bs-original-title="{{ getFollowerCount($social->followers) }}"><i class="las fa-users"></i></span>
                                </li>
                            </ul>
                        @endif
                        <div class="chanel-connect__btn mt-2">
                            <a class="btn btn--base outline btn--md" @if (!$social->channel_connect) href="{{ route('influencer.social.connect', strtolower($channel->name)) }}" @else href="javascript:void(0)" @endif>
                                @if (!$social->channel_connect)
                                    @lang('Connect Now')
                                @else
                                    @lang('Connected')
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
