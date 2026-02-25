@extends($activeTemplate . 'layouts.master')
@section('content')
        <div class="card custom--card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <h5 class="card-title fw-bold">@lang('Profile Setting')</h5>
            </div>
            <div class="card-body px-4 pb-4">
                <form action="{{ route('influencer.profile.setting') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row gy-4">
                        {{-- Profile Image Section --}}
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label class="form--label fw-bold">@lang('Profile Image')</label>
                                <div class="image-upload position-relative">
                                    <div class="thumb">
                                        <div class="avatar-preview shadow-sm" style="aspect-ratio: 1 / 1; height: auto;">
                                            <div class="profilePicPreview" style="background-image: url({{ getImage(getFilePath('influencer') . '/' . $influencer->image, getFileSize('influencer')) }}); background-position: center 20%;">
                                            </div>
                                        </div>
                                        <div class="avatar-edit mt-3">
                                            <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                            <label for="profilePicUpload1" class="btn btn--base w-100 rounded-pill shadow-sm">
                                                <i class="las la-camera"></i> @lang('Upload Image')
                                            </label>
                                            <small class="mt-2 d-block text-center text-muted">@lang('Supported'): JPG, PNG (Max 5MB)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Basic Info Section --}}
                        <div class="col-md-8">
                            <div class="row gy-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="form--label fw-bold">@lang('First Name')</label>
                                        <input type="text" class="form-control form--control shadow-none" name="firstname" value="{{ $influencer->firstname }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="form--label fw-bold">@lang('Last Name')</label>
                                        <input type="text" class="form-control form--control shadow-none" name="lastname" value="{{ $influencer->lastname }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="form--label fw-bold">@lang('Gender')</label>
                                        <select name="gender" class="form-control form--control shadow-none">
                                            <option value="male" @selected($influencer->gender == 'male')>@lang('Male')</option>
                                            <option value="female" @selected($influencer->gender == 'female')>@lang('Female')</option>
                                            <option value="other" @selected($influencer->gender == 'other')>@lang('Other')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="form--label fw-bold">@lang('Birth Date')</label>
                                        <input type="date" class="form-control form--control shadow-none" name="birth_date" value="{{ $influencer->birth_date }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="form--label fw-bold">@lang('Address')</label>
                                        <input type="text" class="form-control form--control shadow-none" name="address" value="{{ $influencer->address }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="form--label fw-bold">@lang('Region / State')</label>
                                        <select name="region" class="form-control form--control shadow-none"required>
                                            <option value="">@lang('Select Region')</option>
                                            @php
                                                $regions = json_decode(file_get_contents(resource_path('views/partials/regions.json')), true);
                                                $currentCountry = $influencer->country_name ?? 'New Zealand';
                                                $countryRegions = $regions[$currentCountry] ?? [];
                                            @endphp
                                            @foreach($countryRegions as $region)
                                                <option value="{{ $region }}" @selected($influencer->region == $region)>{{ __($region) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="form--label fw-bold">@lang('City')</label>
                                        <input type="text" class="form-control form--control shadow-none" name="city" value="{{ $influencer->city }}" placeholder="@lang('e.g. Auckland Central')"required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="form--label fw-bold">@lang('IRD Number / TFN')</label>
                                        <input type="text" class="form-control form--control shadow-none" name="tax_number" value="{{ $influencer->tax_number }}"required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label class="form--label fw-bold">@lang('Are you GST/VAT Registered?')</label>
                                        <select name="is_gst_registered" class="form-control form--control shadow-none"required>
                                            <option value="0" @selected(!$influencer->is_gst_registered)>@lang('No')</option>
                                            <option value="1" @selected($influencer->is_gst_registered)>@lang('Yes')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 {{ $influencer->is_gst_registered ? '' : 'd-none' }}" id="gst-number-container">
                                    <div class="form-group mb-0">
                                        <label class="form--label fw-bold">@lang('GST/VAT Number')</label>
                                        <input type="text" class="form-control form--control shadow-none" name="gst_number" value="{{ $influencer->gst_number }}" {{ $influencer->is_gst_registered ? 'required' : '' }}>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <label class="form--label fw-bold">@lang('Bio')</label>
                                        <textarea name="bio" class="form-control form--control shadow-none" rows="4"required>{{ $influencer->bio }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <label class="form--label fw-bold">@lang('Categories')</label>
                                        <select name="category[]" class="form-control form--control select2 shadow-none" multiple required>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" @selected(in_array($category->id, $influencer->categoryId ?? []))>{{ __($category->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Social Links --}}
                        <div class="col-12 mt-5">
                            <h5 class="mb-4 fw-bold">@lang('Social Presence')</h5>
                            <div class="row gy-3">
                                @foreach ($platforms as $platform)
                                    @php
                                        $socialLink = $influencer->socialLink->where('platform_id', $platform->id)->first();
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="card p-3 border-0 shadow-sm rounded-4 h-100 bg-light">
                                            <div class="d-flex align-items-center mb-3">
                                                <span class="me-2 fs-4">@php echo $platform->icon @endphp</span>
                                                <label class="form--label mb-0 fw-bold">{{ __($platform->name) }}</label>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-8">
                                                    <input type="text" class="form-control form--control shadow-none bg-white social-link-input" 
                                                           name="social_link[{{ $platform->id }}]" 
                                                           value="{{ @$socialLink->social_link }}" 
                                                           placeholder="@lang('Profile URL')"
                                                           data-platform-id="{{ $platform->id }}">
                                                </div>
                                                <div class="col-4">
                                                    <input type="number" class="form-control form--control shadow-none bg-white follower-input" 
                                                           name="followers[{{ $platform->id }}]" 
                                                           value="{{ @$socialLink->followers }}" 
                                                           placeholder="@lang('Followers')"
                                                           data-platform-id="{{ $platform->id }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Packages Section --}}
                        <div class="col-12 mt-5">
                            <h5 class="mb-4 fw-bold">@lang('Service Packages')</h5>
                            
                            <div id="packages-wrapper">
                                @php
                                    $existingPackages = $influencer->packages->count();
                                    $totalPackages = max($existingPackages, 1); 
                                @endphp

                                @for ($i = 0; $i < $totalPackages; $i++)
                                    @php
                                        $package = @$influencer->packages[$i];
                                        $isRequired = $i < 3; 
                                    @endphp
                                    <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 package-item bg-white" id="package-{{ $i }}">
                                        <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-light p-2 rounded-circle">
                                                    <i class="las la-cube fs-4 text--base"></i>
                                                </div>
                                                <h6 class="mb-0 fw-bold">
                                                    @lang('Package') #<span class="package-index">{{ $i + 1 }}</span>
                                                    @if($i < 3) 
                                                        <span class="badge badge--danger rounded-pill px-3 ms-2">@lang('Required')</span> 
                                                    @else
                                                        <span class="badge badge--info rounded-pill px-3 ms-2">@lang('Optional')</span>
                                                    @endif
                                                </h6>
                                            </div>
                                            @if($i >= 3)
                                                <button type="button" class="btn btn--sm btn--danger outline rounded-pill px-3 removePackageBtn">
                                                    <i class="la la-trash"></i> @lang('Remove')
                                                </button>
                                            @endif
                                        </div>

                                        <input type="hidden" name="package[{{ $i }}][id]" value="{{ @$package->id }}">
                                        
                                        <div class="row gy-3">
                                            <div class="col-md-8">
                                                <div class="form-group mb-0">
                                                    <label class="form--label fw-bold">@lang('Package Name')</label>
                                                    <input type="text" class="form-control form--control shadow-none" name="package[{{ $i }}][name]" value="{{ @$package->name }}" {{ $isRequired ? 'required' : '' }} placeholder="e.g. Premium Bundle">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-0">
                                                    <label class="form--label fw-bold">@lang('Platform')</label>
                                                    <select name="package[{{ $i }}][platform_id]" class="form-control form--control shadow-none package-platform-select" {{ $isRequired ? 'required' : '' }}>
                                                        <option value="">@lang('Select One')</option>
                                                        @foreach($platforms as $platform)
                                                            <option value="{{ $platform->id }}" class="platform-option platform-{{ $platform->id }}" 
                                                                @selected(@$package->platform_id == $platform->id)>{{ __($platform->name) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <label class="form--label fw-bold">@lang('Price ($NZD)')</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg--base text-white border-0">$</span>
                                                        <input type="number" step="1" class="form-control form--control shadow-none" name="package[{{ $i }}][price]" value="{{ intval(@$package->price) }}" {{ $isRequired ? 'required' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <label class="form--label fw-bold">@lang('Delivery (Days)')</label>
                                                    <input type="number" class="form-control form--control shadow-none" name="package[{{ $i }}][delivery_time]" value="{{ @$package->delivery_time ?? 7 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <label class="form--label fw-bold">@lang('Post Count')</label>
                                                    <input type="number" class="form-control form--control shadow-none" name="package[{{ $i }}][post_count]" value="{{ @$package->post_count ?? 1 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <label class="form--label fw-bold">@lang('Video Sec (Optional)')</label>
                                                    <input type="number" class="form-control form--control shadow-none" name="package[{{ $i }}][video_length]" value="{{ @$package->video_length }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb-0">
                                                    <label class="form--label fw-bold">@lang('Description')</label>
                                                    <textarea class="form-control form--control shadow-none" rows="3" name="package[{{ $i }}][description]" {{ $isRequired ? 'required' : '' }} placeholder="Describe exactly what the brand will receive...">{{ @$package->description }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            <button type="button" class="btn btn--base border-2 w-100 py-3 rounded-pill addPackageBtn fw-bold d-flex align-items-center justify-content-center gap-2">
                                <i class="las la-plus-circle fs-4"></i> @lang('Add Another Package')
                            </button>
                        </div>

                        {{-- Portfolio Upload --}}
                        <div class="col-12 mt-5">
                            <h5 class="mb-4 fw-bold">@lang('Portfolio Gallery')</h5>
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="upload-zone p-4 text-center border-2 border-dashed rounded-4 bg-light h-100 d-flex flex-column justify-content-center">
                                        <div class="mb-3">
                                            <i class="las la-image fs-1 text-muted"></i>
                                        </div>
                                        <h6 class="fw-bold">@lang('Upload Images')</h6>
                                        <p class="small text-muted mb-3">@lang('JPG, PNG (Max 10MB)')</p>
                                        <input type="file" name="images[]" multiple class="form-control form--control d-none" id="galleryUpload" accept="image/*">
                                        <label for="galleryUpload" class="btn btn--base px-4 rounded-pill shadow-sm">@lang('Select Images')</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="upload-zone p-4 text-center border-2 border-dashed rounded-4 bg-light h-100 d-flex flex-column justify-content-center">
                                        <div class="mb-3">
                                            <i class="las la-video fs-1 text-muted"></i>
                                        </div>
                                        <h6 class="fw-bold">@lang('Add Video Link')</h6>
                                        <p class="small text-muted mb-3">@lang('YouTube, Vimeo or TikTok URL')</p>
                                        <div class="input-group px-3">
                                            <input type="url" name="video_url" class="form-control form--control shadow-none bg-white border" placeholder="https://youtube.com/watch?v=...">
                                        </div>
                                        <small class="text-muted mt-2">@lang('Saved when you click "Save All Changes"')</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-5 mb-3">
                            <button type="submit" class="btn btn--base w-100 py-3 rounded-pill fs-5 shadow fw-bold">@lang('Save All Changes')</button>
                        </div>
                    </div>
                    @if ($errors->any())
    <div class="alert alert-danger mb-4 rounded-4 border-0">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                </form>
            </div>
        </div>

                {{-- Existing Gallery Images --}}
        @if($galleries->count() > 0)
        <div class="card custom--card mt-4 border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="card-title fw-bold mb-0">@lang('Your Portfolio')</h5>
                <small class="text-muted"><i class="las la-info-circle"></i> @lang('Drag items to reorder. The first 3 images will be your cover gallery.')</small>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-3 sortable-gallery" id="sortable-gallery">
                    @foreach ($galleries as $gallery)
                        <div class="col-md-3 col-6 gallery-sort-item" data-id="{{ $gallery->id }}">
                            <div class="position-relative gallery-item shadow-sm rounded-3 overflow-hidden {{ $loop->index < 3 ? 'border border-primary border-3' : '' }}">
                                @if($loop->index < 3)
                                    <span class="position-absolute top-0 start-0 bg-primary text-white px-2 py-1 small fw-bold" style="z-index: 2; border-bottom-right-radius: 8px;">
                                        @lang('Cover') #{{ $loop->index + 1 }}
                                    </span>
                                @endif
                                
                                <img src="{{ getImage(getFilePath('profileGallery') . '/' . $gallery->image) }}" class="img-fluid w-100" style="height: 200px; object-fit: cover;">
                                
                                @if($gallery->video_url)
                                    <div class="video-indicator position-absolute top-50 start-50 translate-middle text-white fs-1" style="pointer-events: none; z-index: 1;">
                                        <i class="las la-play-circle"></i>
                                    </div>
                                @endif

                                <div class="gallery-overlay">
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        <div class="btn btn-light btn-sm rounded-circle shadow drag-handle cursor-move">
                                            <i class="la la-arrows-alt"></i>
                                        </div>
                                        @if($gallery->video_url)
                                            <a href="{{ $gallery->video_url }}" target="_blank" class="btn btn-primary btn-sm rounded-circle shadow">
                                                <i class="la la-external-link"></i>
                                            </a>
                                        @endif
                                        <button type="button" class="btn btn-danger btn-sm rounded-circle shadow confirmationBtn" 
                                            data-action="{{ route('influencer.gallery.image.remove', $gallery->id) }}"
                                            data-question="@lang('Are you sure you want to remove this item?')">
                                            <i class="la la-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    <x-confirmation-modal />
@endsection

@push('style')
<style>
    .avatar-preview {
        width: 100%;
        height: 280px;
        border-radius: 20px;
        background-size: cover;
        background-position: center;
        border: 4px solid #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .profilePicPreview {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        border-radius: 16px;
    }
    .avatar-edit input { display: none; }
    
    .form--label {
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 8px;
    }
    
    .form--control {
        border: 1px solid #eee;
        background-color: #fcfcfc;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.2s;
    }
    .form--control:focus {
        background-color: #fff;
        border-color: var(--base-color);
        box-shadow: 0 0 0 4px rgba(var(--base-r), var(--base-g), var(--base-b), 0.1) !important;
    }

    .package-item {
        border: 1px solid #f0f0f0 !important;
        transition: transform 0.2s;
    }
    .package-item:hover {
        border-color: #e0e0e0 !important;
    }

    .dashed-border-btn {
        border-style: dashed !important;
        background: transparent;
        color: var(--base-color);
        border-color: var(--base-color) !important;
    }
    .dashed-border-btn:hover {
        background: rgba(var(--base-r), var(--base-g), var(--base-b), 0.05);
    }

    .border-dashed { border-style: dashed !important; }

    .gallery-item:hover .gallery-overlay { opacity: 1; }
    .gallery-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .platform-option { display: none; }
    .platform-option.visible { display: block; }
    .cursor-move { cursor: move; }
    .sortable-ghost { opacity: 0.4; background-color: #eee; }
</style>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/profile-pic-setup.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
@endpush

@push('script')
<script>
    (function($) {
        "use strict";
        
        $('.select2').select2();
        
        $('select[name="is_gst_registered"]').on('change', function() {
    if($(this).val() == 1) {
        $('#gst-number-container').removeClass('d-none');
        $('input[name="gst_number"]').attr('required', true);
    } else {
        $('#gst-number-container').addClass('d-none');
        $('input[name="gst_number"]').attr('required', false);
    }
});
        setupProfilePicPreview("#profilePicUpload1", ".profilePicPreview", 5);

                // --- SORTABLE GALLERY LOGIC ---
        if(document.getElementById('sortable-gallery')) {
            const el = document.getElementById('sortable-gallery');
            Sortable.create(el, {
                animation: 150,
                handle: '.drag-handle',
                onEnd: function() {
                    const order = [];
                    $('.gallery-sort-item').each(function() {
                        order.push($(this).data('id'));
                    });

                    $.post("{{ route('influencer.gallery.update.order') }}", {
                        _token: "{{ csrf_token() }}",
                        order: order
                    }, function(response) {
                        if(response.success) {
                            location.reload(); // Refresh to update "Cover" badges and border styling
                        }
                    });
                }
            });
        }

        // --- PLATFORM VISIBILITY LOGIC ---
        function updatePlatformOptions() {
            // Hide all options first
            $('.platform-option').hide().removeClass('visible');
            
            // Loop through social inputs
            $('.social-link-input').each(function() {
                const platformId = $(this).data('platform-id');
                const linkValue = $(this).val();
                
                // If link exists, show this platform in all package dropdowns
                if(linkValue && linkValue.trim() !== '') {
                    $('.platform-' + platformId).show().addClass('visible');
                }
            });

            // Reset dropdowns if selected value is now hidden
            $('.package-platform-select').each(function() {
                const selectedVal = $(this).val();
                if(selectedVal && !$(`.platform-${selectedVal}`).hasClass('visible')) {
                    $(this).val('');
                }
            });
        }

        // Run on load
        updatePlatformOptions();

        // Run on social link change
        $(document).on('input', '.social-link-input', function() {
            updatePlatformOptions();
        });

        // --- DYNAMIC PACKAGES LOGIC ---
        let packageIndex = {{ $totalPackages }};
        
        $('.addPackageBtn').on('click', function() {
            let i = packageIndex;
            let html = `
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 package-item bg-white" id="package-${i}">
                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-light p-2 rounded-circle">
                                <i class="las la-cube fs-4 text--base"></i>
                            </div>
                            <h6 class="mb-0 fw-bold">
                                @lang('Package') #<span class="package-index">${i + 1}</span>
                                <span class="badge badge--info rounded-pill px-3 ms-2">@lang('Optional')</span>
                            </h6>
                        </div>
                        <button type="button" class="btn btn--sm btn--danger outline rounded-pill px-3 removePackageBtn">
                            <i class="la la-trash"></i> @lang('Remove')
                        </button>
                    </div>
                    
                    <div class="row gy-3">
                        <div class="col-md-8">
                            <div class="form-group mb-0">
                                <label class="form--label fw-bold">@lang('Package Name')</label>
                                <input type="text" class="form-control form--control shadow-none" name="package[${i}][name]" placeholder="e.g. Bundle">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label class="form--label fw-bold">@lang('Platform')</label>
                                <select name="package[${i}][platform_id]" class="form-control form--control shadow-none package-platform-select">
                                    <option value="">@lang('Select One')</option>
                                    @foreach($platforms as $platform)
                                        <option value="{{ $platform->id }}" class="platform-option platform-{{ $platform->id }}">{{ __($platform->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <label class="form--label fw-bold">@lang('Price ($NZD)')</label>
                                <div class="input-group">
                                    <span class="input-group-text bg--base text-white border-0">$</span>
                                    <input type="number" step="1" class="form-control form--control shadow-none" name="package[${i}][price]">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <label class="form--label fw-bold">@lang('Delivery (Days)')</label>
                                <input type="number" class="form-control form--control shadow-none" name="package[${i}][delivery_time]" value="7">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <label class="form--label fw-bold">@lang('Post Count')</label>
                                <input type="number" class="form-control form--control shadow-none" name="package[${i}][post_count]" value="1">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <label class="form--label fw-bold">@lang('Video Sec (Optional)')</label>
                                <input type="number" class="form-control form--control shadow-none" name="package[${i}][video_length]">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <label class="form--label fw-bold">@lang('Description')</label>
                                <textarea class="form-control form--control shadow-none" rows="3" name="package[${i}][description]" placeholder="Describe exactly what the brand will receive..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#packages-wrapper').append(html);
            packageIndex++;
            renumberPackages();
            updatePlatformOptions(); // Ensure newly added package has correct options
        });

        $(document).on('click', '.removePackageBtn', function() {
            $(this).closest('.package-item').remove();
            renumberPackages();
        });

        function renumberPackages() {
            $('.package-item').each(function(idx) {
                $(this).find('.package-index').text(idx + 1);
            });
        }

    })(jQuery);
</script>
@endpush

