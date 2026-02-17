@foreach ($reviews as $review)
    <div class="single-review style-two">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-4">
            <div class="left">
                <div class="review-profile">
                    <div class="thumb">
                        <img src="{{ getImage(getFilePath('brand') . '/' . @$review->user->image) }}"
                             alt="@lang('image')">
                    </div>
                    <div class="content">
                        <h6 class="mb-0">{{ __(@$review->user->username) }}</h6>
                        <span class="date">{{ showDateTime($review->created_at, 'd M, Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="infuencer-item__rating">
                    <ul class="rating-list">
                        @php
                            echo showRatings(@$review->star);
                        @endphp
                    </ul>
                </div>
            </div>
        </div>
        <p class="mt-2 review-text">{{ __($review->review) }}</p>
    </div>
@endforeach
