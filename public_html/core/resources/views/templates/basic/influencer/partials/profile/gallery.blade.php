<div class="card custom--card mt-4">
    <div class="card-header">
        <h6 class="mb-0">@lang('Portfolio Gallery')</h6>
    </div>
    <div class="card-body">
        @if (!blank($galleries))
            <div class="d-flex justify-content-center flex-wrap gap-4">
                @foreach ($galleries as $gallery)
                    <div class="generator-image__item">
                        <div class="generator-image__item-img" style="background-image: url({{ getImage(getFilePath('profileGallery') . '/' . $gallery->image, getFileThumb('profileGallery')) }})">
                            <div class="generator-image__view">
                                <ul>
                                    <li>
                                        <a class="image-popup" href="{{ getImage(getFilePath('profileGallery') . '/' . $gallery->image, getFileSize('profileGallery')) }}">
                                            <i class="lar la-eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="confirmationBtn" data-action="{{ route('influencer.gallery.image.remove', $gallery->id) }}" data-question="@lang('Are you sure to remove this image')?" href="javascript:void(0)">
                                            <i class="las la-times"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <form action="{{ route('influencer.upload.gallery.image') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="form-group">
                <div class="input-images"></div>
                <small class="text--warning"><i class="las la-exclamation-triangle"></i> @lang('Maximum ') 12 @lang('images can be uploaded') | @lang('File size will be ') {{ getFileSize('profileGallery') }} @lang('px')</small>
            </div>
            <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
        </form>
    </div>
</div>

@push('style-lib')
    <link href="{{ asset($activeTemplateTrue . 'css/image-uploader.min.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/magnific-popup.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/image-uploader.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/magnific-popup.min.js') }}"></script>
@endpush

@push('style')
    <style>
        @media (max-width:475px) {
            .upload-text span {
                font-size: 13px
            }
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            let preloaded = [];
            $('.input-images').imageUploader({
                extensions: ['.jpg', '.jpeg', '.png'],
                preloaded: preloaded,
                imagesInputName: 'images',
                preloadedInputName: 'old',
                maxFiles: 12
            });

            $(".image-popup").magnificPopup({
                type: "image",
                gallery: {
                    enabled: true,
                },
            });
            
        })(jQuery)
    </script>
@endpush

