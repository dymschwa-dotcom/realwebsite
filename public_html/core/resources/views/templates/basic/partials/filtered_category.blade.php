@foreach ($categories as $category)
    <div class="col-12 col-xsm-6 col-sm-6 col-lg-4 col-xl-3">
        <div class="categories-item">
            <a href="{{ route('influencer.all') }}?category[]={{ $category->slug }}" class="categories-item__icon">
                <img src="{{ getImage(getFilePath('category') . '/' . $category->image, getFileSize('category')) }}" alt="@lang('image')">
            </a>
            <h6 class="categories-item__title"> <a href="{{ route('influencer.all') }}?category[]={{ $category->slug }}">{{ __($category->name) }}</a></h6>

            <div class="categories-item-info">
                <div class="category-rating">
                    <span class="categories-item-label">@lang('Ratings')</span>
                    <ul class="rating-list">
                        @php
                            echo showRatings(@$category->influencers_sum_rating ?? 0);
                        @endphp
                    </ul>
                </div>

                <div class="category-influencer">
                    <span class="categories-item-label">@lang('Influencers')</span>
                    <span>{{ @$category->influencers_count }}</span>
                </div>
            </div>
            <div class="categories-item-view-btn">
                <a class="btn btn--base btn--sm" href="{{ route('influencer.all') }}?category[]={{ $category->slug }}">@lang('View All')</a>
            </div>
        </div>
    </div>
@endforeach
