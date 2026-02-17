@php
    $categoryContent = getContent('category.content', true);
    $categoryList = App\Models\Category::active()->withCount('influencers')->withSum('influencers', 'rating')->orderBy('name');
    $count = (clone $categoryList)->count();
    $categories = $categoryList->take(8)->get();
@endphp
@if ($categories->isNotEmpty())
    <div class="categories py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading style-center">
                        <h2 class="section-heading__title">{{ __($categoryContent->data_values->heading) }}</h2>
                    </div>
                </div>
            </div>
            <div class="categories-wrapper">
                <div class="row gy-4 justify-content-center">
                    @include($activeTemplate . 'partials.filtered_category')
                </div>
            </div>
            @if ($count > 8)
                <div class="more-btn text-center">
                    <a href="{{ route('categories') }}"class="btn btn--base outline btn--md">@lang('View All')</a>
                </div>
            @endif
        </div>
    </div>
@endif
