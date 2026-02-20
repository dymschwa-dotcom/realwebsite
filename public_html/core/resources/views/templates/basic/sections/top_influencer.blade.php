@php
    $influencerContent = getContent('top_influencer.content', true);
    $influencerList = App\Models\Influencer::active()->with('socialLink.platform')->withSum('socialLink', 'followers')->orderBy('order_completed', 'desc')->orderBy('rating', 'desc');
    $count = (clone $influencerList)->count();
    $influencers = $influencerList->take(8)->get();
    $favoriteInfluencer = App\Models\Favorite::where('user_id', auth()->id())->select('influencer_id')->pluck('influencer_id')->toArray();
@endphp
@if ($influencers->count() > 0)
    <div class="infuencer-section py-120 section-bg">
        <div class="container">
            <div class="section-heading style-three">
                <h2 class="section-heading__title">{{ __(@$influencerContent->data_values->heading) }}</h2>
                @if ($count > 4)
                    <a href="{{ route('influencer.all') }}">@lang('View All')<i class="las la-angle-double-right"></i></a>
                @endif
            </div>
            <div class="row gy-4 justify-content-center">
                @include($activeTemplate . 'partials.filtered_influencer')
            </div>
        </div>
    </div>
@endif

