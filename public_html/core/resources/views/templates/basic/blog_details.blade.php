@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="blog-detials py-120">
        <div class="container">
            <div class="row gy-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="blog-details">
                        <div class="blog-details__thumb">
                            <img src="{{ frontendImage('blog', @$blog->data_values->image, '860x450') }}" alt="@lang('image')">
                        </div>
                        <div class="blog-details__content">
                            <ul class="text-list d-flex gap-4">
                                <li class="text-list__item">
                                    <span class="text-list__item-icon"><i class="las la-calendar-alt"></i></span>{{ showDateTime($blog->created_at, 'd M, Y') }}
                                </li>
                            </ul>
                            <h3 class="blog-details__title"> {{ __(@$blog->data_values->title) }} </h3>
                            <p class="blog-details__desc">@php echo @$blog->data_values->description @endphp</p>

                            <div class="blog-details__share d-flex align-items-center justify-content-between flex-wrap mt-5">
                                <h5 class="social-share__title me-sm-3 d-inline-block mb-0 me-1">@lang('Share This Post')</h5>
                                <ul class="social-list">
                                    <li class="social-list__item">
                                        <a class="social-list__link" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank">
                                            <i class="fab fa-facebook"></i>
                                        </a>
                                    </li>
                                    <li class="social-list__item">
                                        <a class="social-list__link" href="https://twitter.com/intent/tweet?text={{ __(@$blog->data_values->title) }}&amp;url={{ urlencode(url()->current()) }}" target="_blank"> <i class="fa-brands fa-x-twitter"></i></a>
                                    </li>
                                    <li class="social-list__item">
                                        <a class="social-list__link" href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}&amp;title={{ __(@$blog->data_values->title) }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                    </li>
                                    <li class="social-list__item">
                                        <a class="social-list__link" href="http://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ __(@$blog->data_values->title) }}&media={{ getImage('assets/images/frontend/blog/' . $blog->data_values->image, '860x450') }}" target="_blank">
                                            <i class="lab la-pinterest"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="fb-comments" data-href="{{ url()->current() }}" data-numposts="5"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-sidebar-wrapper">
                        <div class="blog-sidebar">
                            <h5 class="blog-sidebar__title">@lang('Latest Blog')</h5>
                            @foreach ($latestBlogs as $latestBlog)
                                <div class="latest-blog">
                                    <div class="latest-blog__thumb">
                                        <a href="{{ route('blog.details', @$latestBlog->slug) }}"> <img src="{{ frontendImage('blog', 'thumb_' . @$latestBlog->data_values->image, '430x225') }}" alt="Blog"></a>
                                    </div>
                                    <div class="latest-blog__content">
                                        <h6 class="latest-blog__title"><a href="{{ route('blog.details', @$latestBlog->slug) }}">{{ __(@$latestBlog->data_values->title) }}</a></h6>
                                        <span class="latest-blog__date">{{ showDateTime($latestBlog->created_at, 'd M Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .blog-item__content {
            text-align: left;
        }
    </style>
@endpush

@push('fbComment')
    @php echo loadExtension('fb-comment') @endphp
@endpush
