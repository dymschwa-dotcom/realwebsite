@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="section-py">
        <div class="container">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="card custom--card">
                        <div class="card-body">
                            <div class="alert alert-warning" role="alert">
                                <strong> <i class="la la-info-circle"></i> @lang('Final Step: Set up your packages and portfolio to go live.')</strong>
                            </div>

                            <form method="POST" action="{{ route('influencer.packages.submit') }}" enctype="multipart/form-data">
                                @csrf
                                @php
                                    $platforms = \App\Models\Platform::active()->get();
                                    $connectedPlatforms = $influencer->socialLink->pluck('platform_id')->toArray();
                                @endphp
                                
                                <h4 class="mb-4">@lang('Service Packages')</h4>
                                <div class="row gy-4">
                                    @for ($i = 1; $i <= 3; $i++)
                                        @php
                                            $package = $influencer->packages->get($i-1);
                                        @endphp
                                        <div class="col-lg-4">
                                            <div class="card shadow-sm border-0 bg-light rounded-4 h-100">
                                                <div class="card-header bg--base text-white border-0 rounded-top-4 py-3">
                                                    <h5 class="mb-0 text-white text-center">@lang('Package') {{ $i }}</h5>
                                                </div>
                                                <div class="card-body p-4">
                                                    @php
                                                        $packageName = old("package.$i.name", @$package->name);
                                                    @endphp
                                                    <div class="form-group mb-3">
                                                        <label class="form-label fw-bold">@lang('Title')</label>
                                                        <input type="text" name="package[{{ $i }}][name]" class="form-control form--control" value="{{ $packageName }}" required placeholder="@lang('e.g. Basic Shoutout')">
                                                    </div>
                                                    
                                                    <div class="form-group mb-3">
                                                        <label class="form-label fw-bold">@lang('Platform')</label>
                                                        <select name="package[{{ $i }}][platform_id]" class="form-control form--control select2" required>
                                                            <option value="">@lang('Select Platform')</option>
                                                            @foreach($platforms as $platform)
                                                                @if(in_array($platform->id, $connectedPlatforms))
                                                                <option value="{{ $platform->id }}" @selected(old("package.$i.platform_id", @$package->platform_id) == $platform->id)>{{ __($platform->name) }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-6">
                                                            <label class="form-label fw-bold">@lang('Price') ({{ gs('cur_sym') }})</label>
                                                            <input type="number" step="any" name="package[{{ $i }}][price]" class="form-control form--control" value="{{ old("package.$i.price", @$package->price) }}" required placeholder="0.00">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label fw-bold">@lang('Delivery')</label>
                                                            <div class="input-group">
                                                                <input type="number" name="package[{{ $i }}][delivery_time]" class="form-control form--control" value="{{ old("package.$i.delivery_time", @$package->delivery_time ?? 7) }}">
                                                                <span class="input-group-text bg-white border-start-0 text-muted small">Days</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-6">
                                                            <label class="form-label fw-bold">@lang('Post Count')</label>
                                                            <input type="number" name="package[{{ $i }}][post_count]" class="form-control form--control" value="{{ old("package.$i.post_count", @$package->post_count ?? 1) }}">
                                                        </div>
                                                        <div class="col-6 ps-1">
                                                            <label class="form-label fw-bold">@lang('Video Sec')</label>
                                                            <input type="number" name="package[{{ $i }}][video_length]" class="form-control form--control" value="{{ old("package.$i.video_length", @$package->video_length) }}" placeholder="@lang('Optional')">
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-0">
                                                        <label class="form-label fw-bold">@lang('Description')</label>
                                                        <textarea name="package[{{ $i }}][description]" class="form-control form--control" rows="3" required placeholder="@lang('What does this package include?')">{{ old("package.$i.description", @$package->description) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>

                                <div class="mt-5">
                                    <h4 class="mb-3">@lang('About Me')</h4>
                                    <div class="form-group">
                                        <label class="form-label fw-bold">@lang('Introduce yourself to brands') <span class="text--danger">*</span></label>
                                        <textarea name="about" class="form-control form--control" rows="6" required placeholder="@lang('Tell brands about your content style, audience, and why they should work with you...')">{{ old('about', $influencer->bio) }}</textarea>
                                        <small class="text-muted">@lang('Minimum 50 characters.')</small>
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <h4 class="mb-3">@lang('Portfolio Showcase')</h4>
                                    <div class="form-group">
                                        <label class="form-label fw-bold">@lang('Upload work samples') <span class="text--danger">*</span></label>
                                        
                                        {{-- Image Upload Box --}}
                                        <div class="portfolio-upload-area text-center border-dashed rounded-4 p-5 mb-3 position-relative" id="drop-area">
                                            <input type="file" id="portfolio-images" class="d-none" multiple accept=".jpg,.jpeg,.png">
                                            <div class="upload-icon mb-2">
                                                <i class="las la-cloud-upload-alt fs-1 text--base"></i>
                                            </div>
                                            <h5 class="mb-1">@lang('Click or Drag & Drop to Upload')</h5>
                                            <p class="text-muted small">@lang('Select multiple images. Minimum 3 total items required.')</p>
                                            <label for="portfolio-images" class="stretched-link cursor-pointer"></label>
                                            <div id="upload-progress" class="progress d-none mt-2" style="height: 5px;">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg--base" style="width: 0%"></div>
                                            </div>
                                        </div>

                                        {{-- Gallery Grid with Reordering --}}
                                        <div class="row g-3 sortable-gallery mb-4" id="sortable-container">
                                            @foreach($influencer->galleries as $index => $gallery)
                                                <div class="col-md-2 col-4 gallery-item-wrapper" data-id="{{ $gallery->id }}">
                                                    <div class="text-center mb-1 cover-status-container" style="min-height: 24px;">
                                                        @if($index < 3)
                                                            <span class="cover-badge badge bg-white border border-dark text-dark px-2 py-1 small fw-bold shadow-sm">
                                                                @lang('COVER GALLERY')
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="ratio ratio-1x1 rounded-3 overflow-hidden border position-relative shadow-sm group bg-dark">
                                                        
                                                        @if($gallery->video_url)
                                                            <div class="video-preview-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center text-white z-index-1" style="pointer-events: none;">
                                                                <i class="las la-play-circle fs-1"></i>
                                                            </div>
                                                            <img src="{{ $gallery->image }}" class="object-fit-cover w-100 h-100 opacity-50">
                                                        @else
                                                            <img src="{{ getImage(getFilePath('profileGallery') . '/' . $gallery->image) }}" class="object-fit-cover w-100 h-100">
                                                        @endif
                                                        
                                                        {{-- Action buttons at bottom --}}
                                                        <div class="gallery-actions position-absolute bottom-0 start-0 w-100 p-2 d-flex justify-content-center gap-2 z-index-2 bg-dark bg-opacity-25">
                                                            <button type="button" class="btn btn-danger btn-square remove-gallery" data-id="{{ $gallery->id }}" title="@lang('Remove')">
                                                                <i class="las la-trash-alt"></i>
                                                            </button>
                                                            <div class="drag-handle btn btn-dark btn-square cursor-move text-white" title="@lang('Drag to reorder')">
                                                                <i class="las la-arrows-alt"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="mt-4 bg-light p-4 rounded-4 border">
                                            <h6 class="mb-2"><i class="las la-video text--base"></i> @lang('Add Portfolio Video')</h6>
                                            <p class="text-muted small mb-3">@lang('Paste a YouTube or Vimeo link to showcase your video content.')</p>
                                            <div class="input-group">
                                                <input type="text" id="video-url" class="form-control form--control" placeholder="@lang('e.g. https://www.youtube.com/watch?v=...')">
                                                <button class="btn btn--base px-4" type="button" id="add-video-btn">
                                                    @lang('Add Link')
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 d-flex gap-3">
                                    <a href="{{ route('influencer.data') }}" class="btn btn-dark w-100 py-3 rounded-pill fw-bold">
                                        <i class="las la-arrow-left"></i> @lang('Back to Step 1')
                                    </a>
                                    <button class="btn btn--base w-100 py-3 rounded-pill fw-bold shadow-sm" type="submit">
                                        @lang('Publish Profile') <i class="las la-check-double"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
<style>
    .rounded-top-4 { border-top-left-radius: 1rem !important; border-top-right-radius: 1rem !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .bg--base { background-color: var(--base-color) !important; }
    .btn-outline-secondary { border: 2px solid #dee2e6; color: #6c757d; }
    .btn-outline-secondary:hover { background-color: #f8f9fa; border-color: #ced4da; color: #495057; }
    .form--control { border: 1px solid #e9ecef !important; }
    .form--control:focus { border-color: var(--base-color) !important; box-shadow: none !important; }
    .card-header h5 { font-size: 1.1rem; letter-spacing: 0.5px; }
    .input-group-text { border: 1px solid #e9ecef; background-color: #fff; }

    .btn-xs { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
    .btn-square { width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; padding: 0; border-radius: 6px !important; }
    .btn-dark { background-color: #212529 !important; border-color: #212529 !important; color: #fff !important; }
    .btn-dark:hover { background-color: #000 !important; border-color: #000 !important; }
    .btn-danger { background-color: #ea5455 !important; border-color: #ea5455 !important; color: #fff !important; }

    .border-dashed { border-style: dashed !important; border-width: 2px !important; border-color: #dee2e6 !important; }
    .portfolio-upload-area:hover { border-color: var(--base-color) !important; background-color: rgba(var(--base-color-rgb), 0.05); }
    .cursor-move { cursor: move; }
    .group:hover .group-hover-opacity-100 { opacity: 1; }
    .transition { transition: all 0.3s ease; }
    .z-index-1 { z-index: 1 !important; }
    .z-index-2 { z-index: 2 !important; }
    .rounded-bottom-end { border-bottom-right-radius: 0.5rem !important; }
    .cover-badge { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px; }
    
    /* Force Gallery Actions to bottom and prevent theme overrides */
    .gallery-actions {
        top: auto !important;
        bottom: 0 !important;
        left: 0 !important;
        width: 100% !important;
        background: rgba(0,0,0,0.4) !important;
        padding: 8px !important;
        display: flex !important;
        justify-content: center !important;
        gap: 10px !important;
        position: absolute !important;
        z-index: 5 !important;
    }
    
    .gallery-item-wrapper .ratio {
        display: flex !important;
        flex-direction: column !important;
    }
</style>
@endpush

@push('script-lib')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
@endpush

@push('script')
<script>
    (function($) {
        "use strict";

        // 1. Instant AJAX Upload for Portfolio
        $('#portfolio-images').on('change', function() {
            const files = this.files;
            if (!files.length) return;

            const progressBar = $('#upload-progress');
            progressBar.removeClass('d-none');

            Array.from(files).forEach(file => {
                const formData = new FormData();
                formData.append('image', file);
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: "{{ route('influencer.gallery.upload.ajax') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        const xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                const percentComplete = (evt.loaded / evt.total) * 100;
                                progressBar.find('.progress-bar').css('width', percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(response) {
                        if (response.success) {
                            const html = `
                                <div class="col-md-2 col-4 gallery-item-wrapper" data-id="${response.id}">
                                    <div class="ratio ratio-1x1 rounded-3 overflow-hidden border position-relative shadow-sm group">
                                        <img src="${response.src}" class="object-fit-cover w-100 h-100">
                                        <div class="gallery-actions position-absolute bottom-0 start-0 w-100 p-2 d-flex justify-content-center gap-2 z-index-2 bg-dark bg-opacity-25">
                                            <button type="button" class="btn btn-danger btn-square remove-gallery" data-id="${response.id}">
                                                <i class="las la-trash-alt"></i>
                                            </button>
                                            <div class="drag-handle btn btn-dark btn-square cursor-move text-white">
                                                <i class="las la-arrows-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('#sortable-container').append(html);
                            updateCoverBadges();
                        } else {
                            notify('error', response.message);
                        }
                    },
                    complete: function() {
                        setTimeout(() => {
                            progressBar.addClass('d-none').find('.progress-bar').css('width', '0%');
                        }, 1000);
                    }
                });
            });
        });

        // 2. Drag & Drop Reordering
        const el = document.getElementById('sortable-container');
        if (el) {
            Sortable.create(el, {
                animation: 150,
                handle: '.drag-handle',
                onEnd: function() {
                    updateCoverBadges();
                    const sortedIds = [];
                    $('.gallery-item-wrapper').each(function() {
                        sortedIds.push($(this).data('id'));
                    });

                    $.post("{{ route('influencer.gallery.sort') }}", {
                        sort: sortedIds,
                        _token: "{{ csrf_token() }}"
                    });
                }
            });
        }

        function updateCoverBadges() {
            $('.cover-status-container').empty();
            $('.gallery-item-wrapper').each(function(index) {
                if (index < 3) {
                    const badge = `<span class="cover-badge badge bg-white border border-dark text-dark px-2 py-1 small fw-bold shadow-sm">@lang('COVER GALLERY')</span>`;
                    $(this).find('.cover-status-container').append(badge);
                }
            });
        }

        // 3. AJAX Add Video Link
        $('#add-video-btn').on('click', function() {
            const url = $('#video-url').val();
            if (!url) {
                notify('error', 'Please paste a video URL');
                return;
            }

            const btn = $(this);
            btn.prop('disabled', true).html('<i class="las la-spinner la-spin"></i>');

            $.post("{{ route('influencer.gallery.add.video.ajax') }}", {
                video_url: url,
                _token: "{{ csrf_token() }}"
            }, function(response) {
                if (response.success) {
                    const html = `
                        <div class="col-md-2 col-4 gallery-item-wrapper" data-id="${response.id}">
                            <div class="ratio ratio-1x1 rounded-3 overflow-hidden border position-relative shadow-sm group bg-dark">
                                <div class="video-preview-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center text-white z-index-1" style="pointer-events: none;">
                                    <i class="las la-play-circle fs-1"></i>
                                </div>
                                <img src="${response.src}" class="object-fit-cover w-100 h-100 opacity-50">
                                <div class="gallery-actions position-absolute bottom-0 start-0 w-100 p-2 d-flex justify-content-center gap-2 z-index-2 bg-dark bg-opacity-25">
                                    <button type="button" class="btn btn-danger btn-square remove-gallery" data-id="${response.id}">
                                        <i class="las la-trash-alt"></i>
                                    </button>
                                    <div class="drag-handle btn btn-dark btn-square cursor-move text-white">
                                        <i class="las la-arrows-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#sortable-container').append(html);
                    updateCoverBadges();
                    $('#video-url').val('');
                    notify('success', 'Video added to portfolio');
                } else {
                    notify('error', response.message || 'Invalid video URL');
                }
            }).always(function() {
                btn.prop('disabled', false).text("@lang('Add Link')");
            });
        });

        // 4. AJAX Remove Gallery Image
        $('.remove-gallery').on('click', function() {
            if (confirm("@lang('Are you sure you want to remove this image?')")) {
                const btn = $(this);
                const id = btn.data('id');
                const url = "{{ route('influencer.gallery.remove', ':id') }}".replace(':id', id);

                $.post(url, { _token: "{{ csrf_token() }}" }, function(response) {
                    if (response.success) {
                        btn.closest('.gallery-item-wrapper').fadeOut(300, function() {
                            $(this).remove();
                            updateCoverBadges();
                        });
                        notify('success', response.message);
                    }

                });
            }
        });

        // 4. Drag & Drop Visual Effects
        const dropArea = document.getElementById('drop-area');
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.add('border-primary'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.remove('border-primary'), false);
        });

    })(jQuery);
</script>
@endpush

