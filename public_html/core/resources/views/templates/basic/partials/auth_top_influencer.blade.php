@php
    // UPDATED: Changed socialLink to socialLinks and added the 'active' scope for safety
    $influencers = App\Models\Influencer::active()
        ->with('socialLinks.platform')
        ->withSum('socialLinks', 'followers')
        ->orderBy('order_completed', 'desc')
        ->orderBy('rating', 'desc')
        ->take(8)
        ->get();
@endphp

@if ($influencers->count() > 0)
    <div class="top-influencer d-none d-lg-block">
        <h5 class="title">@lang('Top Influencers')</h5>
        <div class="influencer-slider">
            @foreach ($influencers as $key => $influencer)
                <div class="influencer-slider__slide">
                    <a href="{{ route('influencer.profile', slug($influencer->username)) }}" class="influencer-card">
                        <img class="influencer-card___thumb" src="{{ getImage(getFilePath('influencer') . '/thumb_' . $influencer->image, getFileSize('influencer'), true) }}" alt="{{ $influencer->fullname }}">
                        <div class="influencer-card__content">
                            <h6 class="influencer-card__name">{{ __($influencer->fullname) }}</h6>
                            {{-- UPDATED: variable name changed to match the plural relationship sum --}}
                            <span class="influencer-card__followers">
                                {{ getFollowerCount($influencer->social_links_sum_followers) }} @lang('Followers')
                            </span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif