@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="pt-80 pb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card custom--card border-0 shadow-sm">
                    <div class="card-header bg--dark p-3">
                        <h5 class="text-white mb-0">@lang('Update Profile Details')</h5>
                    </div>
                    <div class="card-body p-4 p-lg-5">
                        <form action="{{ route('influencer.profile.setting.submit') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                
                                {{-- Profile Image Update --}}
                                <div class="col-12 mb-4 text-center">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' name="image" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                            <label for="imageUpload"><i class="las la-pen"></i></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview" style="background-image: url('{{ getImage(getFilePath('influencer') . '/' . $influencer->image) }}');">
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-2 small text-muted">@lang('Change your profile photo')</p>
                                </div>

                                {{-- Basic Info --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">@lang('First Name')</label>
                                    <input type="text" class="form-control form--control" name="firstname" value="{{ $influencer->firstname }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">@lang('Last Name')</label>
                                    <input type="text" class="form-control form--control" name="lastname" value="{{ $influencer->lastname }}" required>
                                </div>

                                {{-- Read-only Username/Email --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">@lang('Username')</label>
                                    <input type="text" class="form-control form--control bg-light" value="{{ $influencer->username }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">@lang('Email')</label>
                                    <input type="text" class="form-control form--control bg-light" value="{{ $influencer->email }}" readonly>
                                </div>

                                {{-- Country & City --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">@lang('Country')</label>
                                    <select name="country" class="form-select form--control">
                                        @foreach($countries as $key => $country)
                                            <option value="{{ $country->country }}" @selected($influencer->country_name == $country->country)>
                                                {{ __($country->country) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">@lang('City')</label>
                                    <input type="text" name="city" class="form-control form--control" value="{{ $influencer->city }}">
                                </div>

                                {{-- NEW: Bio Section --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold">@lang('About / Bio')</label>
                                    <textarea name="bio" class="form-control form--control" rows="4" placeholder="@lang('Tell brands about your style and audience...')">{{ $influencer->bio }}</textarea>
                                </div>

                                {{-- Categories --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold">@lang('My Categories')</label>
                                    <div class="category-grid border rounded p-3">
                                        @foreach($categories as $category)
                                            <div class="form-check custom--check d-inline-block me-3 mb-2">
                                                <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->id }}" id="cat_{{ $category->id }}" 
                                                @checked($influencer->categories->contains($category->id))>
                                                <label class="form-check-label" for="cat_{{ $category->id }}">{{ __($category->name) }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Social Links Section --}}
                                <div class="col-12 mt-4">
                                    <h5 class="border-bottom pb-2">@lang('Social Media Accounts')</h5>
                                    <div class="row gy-3 mt-1">
                                        @foreach($platforms as $platform)
                                            @php 
                                                $link = $influencer->socialLinks->firstWhere('platform_id', $platform->id);
                                            @endphp
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold">@php echo $platform->icon @endphp {{ $platform->name }} URL</label>
                                                <input type="url" name="social_link[{{ $platform->id }}]" 
                                                       class="form-control form--control" 
                                                       value="{{ $link ? $link->social_link : '' }}" 
                                                       placeholder="https://...">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold">@lang('Followers')</label>
                                                <input type="number" name="followers[{{ $platform->id }}]" 
                                                       class="form-control form--control" 
                                                       value="{{ $link ? $link->followers : '' }}" 
                                                       placeholder="0">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- NEW: Additional Gallery Images --}}
                                <div class="col-12 mt-4">
                                    <h5 class="border-bottom pb-2">@lang('Portfolio Gallery')</h5>
                                    <div class="form-group mb-3">
                                        <label class="form-label small fw-bold">@lang('Upload Additional Photos')</label>
                                        <input type="file" name="gallery[]" class="form-control form--control" multiple accept=".png, .jpg, .jpeg">
                                        <p class="text-muted small mt-1">@lang('You can select multiple images to showcase your work.')</p>
                                    </div>

                                    @if($influencer->galleries->count() > 0)
                                        <div class="row g-2 mt-2">
                                            @foreach($influencer->galleries as $gallery)
                                                <div class="col-md-2 col-4">
                                                    <div class="gallery-preview-item position-relative">
                                                        <img src="{{ getImage(getFilePath('profileGallery') . '/' . $gallery->image) }}" class="rounded w-100 shadow-sm" style="height: 80px; object-fit: cover;">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="col-12 mt-5 text-end">
                                    <button type="submit" class="btn btn--base w-100 py-3 fw-bold">@lang('Update Profile Details')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .bg--dark { background-color: #1a1a1a !important; }
    .btn--base { background-color: #ff3366; border: none; color: #fff; }
    .btn--base:hover { background-color: #e62e5c; color: #fff; }
    .avatar-upload { position: relative; max-width: 130px; margin: 0 auto; }
    .avatar-edit { position: absolute; right: 10px; z-index: 5; top: 10px; }
    .avatar-edit input { display: none; }
    .avatar-edit label { display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 100%; background: #fff; border: 1px solid #ddd; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .avatar-preview { width: 130px; height: 130px; border-radius: 100%; border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow: hidden; }
    .avatar-preview > div { width: 100%; height: 100%; background-size: cover; background-position: center; }
    .category-grid { background-color: #fdfdfd; max-height: 200px; overflow-y: auto; }
    .gallery-preview-item img { transition: transform 0.2s; }
    .gallery-preview-item img:hover { transform: scale(1.05); }
</style>
@endpush

@push('script')
<script>
    (function($){
        "use strict";
        $("#imageUpload").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) { $('#imagePreview').css('background-image', 'url('+e.target.result +')'); }
                reader.readAsDataURL(this.files[0]);
            }
        });
    })(jQuery);
</script>
@endpush