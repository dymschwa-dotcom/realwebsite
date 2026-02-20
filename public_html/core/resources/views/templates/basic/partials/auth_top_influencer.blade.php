@php
    $influencers = App\Models\Influencer::active()->with('socialLink.platform')->withSum('socialLink', 'followers')->orderBy('order_completed', 'desc')->orderBy('rating', 'desc')->take(8)->get();
@endphp
@if ($influencers->count() > 0)
    <div class="top-influencer d-none d-lg-block">
        <h5 class="title">@lang('Top Influencers')</h5>
        <div class="influencer-slider">
            @foreach ($influencers as $key => $influencer)
                <div class="influencer-slider__slide">
                    <a href="{{ route('influencer.profile', slug($influencer->username)) }}" class="influencer-card">
                        <img class="influencer-card___thumb" src="{{ getImage(getFilePath('influencer') . '/thumb_' . $influencer->image, getFileSize('influencer'), true) }}" alt="">
                        <div class="influencer-card__content">
                            <h6 class="influencer-card__name">{{ __($influencer->fullname) }}</h6>
                            <span class="influencer-card__followers">{{ getFollowerCount($influencer->social_link_sum_followers) }} @lang('Followers')</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif

