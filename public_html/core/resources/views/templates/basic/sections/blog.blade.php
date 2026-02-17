@php
    $blogContent = getContent('blog.content', true);
    $blogList = App\Models\Frontend::where('data_keys', 'blog.element');
    $count = (clone $blogList)->count();
    $blogs = $blogList->latest()->take(4)->get();
@endphp
<section class="blog py-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading style-three">
                    <h2 class="section-heading__title">{{ __(@$blogContent->data_values->heading) }}</h2>
                    @if ($count > 4)
                        <a href="{{ route('blog') }}">@lang('View All') <i class="las la-angle-double-right"></i></a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @include($activeTemplate . 'partials.filtered_blog')
        </div>
    </div>
</section>
