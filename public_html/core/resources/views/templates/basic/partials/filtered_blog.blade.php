@foreach ($blogs as $blog)
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="blog-item">
            <div class="blog-item__thumb">
                <a href="{{ route('blog.details', @$blog->slug) }}" class="blog-item__thumb-link">
                    <img src="{{ frontendImage('blog', 'thumb_' . @$blog->data_values->image, '430x225') }}" alt="@lang('image')">
                </a>
            </div>
            <div class="blog-item__content">
                <ul class="text-list inline">
                    <li class="text-list__item">
                        <span class="text-list__item-icon"><i class="las la-calendar-alt"></i></span>
                        {{ showDateTime($blog->created_at, 'd M, Y') }}
                    </li>
                </ul>
                <h4 class="blog-item__title">
                    <a href="{{ route('blog.details', @$blog->slug) }}"
                       class="blog-item__title-link">
                        {{ __(strLimit(@$blog->data_values->title, 60)) }}
                    </a>
                </h4>
                <a href="{{ route('blog.details', $blog->slug) }}"
                   class="text--base">@lang('Read More')</a>
            </div>
        </div>
    </div>
@endforeach
