@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-body">
        <div class="card custom--card">
            <div class="card-header">
                <h5 class="card-title">@lang('Profile Setting')</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('influencer.profile.setting') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form--label">@lang('Profile Image')</label>
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview" style="background-image: url({{ getImage(getFilePath('influencer') . '/' . $influencer->image, getFileSize('influencer')) }})">
                                            </div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                            <label for="profilePicUpload1" class="bg--base">@lang('Upload Image')</label>
                                            <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg'), @lang('png')</b>. @lang('Image will be resized into') {{ getFileSize('influencer') }}@lang('px') </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('First Name')</label>
                                    <input type="text" class="form-control form--control" name="firstname" value="{{ $influencer->firstname }}" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('Last Name')</label>
                                    <input type="text" class="form-control form--control" name="lastname" value="{{ $influencer->lastname }}" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('Gender')</label>
                                    <select name="gender" class="form-control form--control">
                                        <option value="male" @selected($influencer->gender == 'male')>@lang('Male')</option>
                                        <option value="female" @selected($influencer->gender == 'female')>@lang('Female')</option>
                                        <option value="other" @selected($influencer->gender == 'other')>@lang('Other')</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('Birth Date')</label>
                                    <input type="date" class="form-control form--control" name="birth_date" value="{{ $influencer->birth_date }}">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('Region / State')</label>
                                    <select name="region" class="form-control form--control">
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
                                <div class="form-group col-sm-6">
                                    <label class="form--label">@lang('City')</label>
                                    <input type="text" class="form-control form--control" name="city" value="{{ $influencer->city }}" placeholder="@lang('e.g. Auckland Central')">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label class="form--label">@lang('Bio')</label>
                                    <textarea name="bio" class="form-control form--control">{{ $influencer->bio }}</textarea>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label class="form--label">@lang('Categories')</label>
                                    <select name="category[]" class="form-control form--control select2" multiple required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @selected(in_array($category->id, $influencer->categoryId ?? []))>{{ __($category->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
<!-- The rest of your form elements would go here -->
</div>

@push('script')
<script>
    (function($) {
        "use strict";
        $('.select2').select2();
    })(jQuery);
</script>
@endpush

                        <div class="col-12 mt-4">
                            <h5 class="mb-3">@lang('Social Links')</h5>
                            <div class="row">
                                @foreach ($platforms as $platform)
                                @php
                                    $socialLink = $influencer->socialLink->where('platform_id', $platform->id)->first();
                                @endphp
                                <div class="col-md-6 mb-3">
                                    <div class="card p-3 border shadow-none h-100">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="me-2">@php echo $platform->icon @endphp</span>
                                            <label class="form--label mb-0">{{ __($platform->name) }}</label>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-8">
                                                <input type="text" class="form-control form--control" name="social_link[{{ $platform->id }}]" value="{{ @$socialLink->social_link }}" placeholder="@lang('Link')">
                                            </div>
                                            <div class="col-4">
                                                <input type="number" class="form-control form--control" name="followers[{{ $platform->id }}]" value="{{ @$socialLink->followers }}" placeholder="@lang('Followers')">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <h5 class="mb-3">@lang('Packages')</h5>
                            <div class="row">
                                @for ($i = 0; $i < 3; $i++)
                                @php
                                    $package = @$influencer->packages[$i];
                                @endphp
                                <div class="col-md-4 mb-3">
                                    <div class="card p-3 border shadow-none">
                                        <input type="hidden" name="package[{{ $i }}][id]" value="{{ @$package->id }}">
                                        <div class="form-group mb-2">
                                            <label class="form--label">@lang('Package Name')</label>
                                            <input type="text" class="form-control form--control" name="package[{{ $i }}][name]" value="{{ @$package->name }}" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form--label">@lang('Platform')</label>
                                            <select name="package[{{ $i }}][platform_id]" class="form-control form--control">
                                                <option value="">@lang('Select One')</option>
                                                @foreach($platforms as $platform)
                                                    <option value="{{ $platform->id }}" @selected(@$package->platform_id == $platform->id)>{{ __($platform->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="form--label">@lang('Price ($NZD)')</label>
                                                <input type="number" step="1" class="form-control form--control" name="package[{{ $i }}][price]" value="{{ intval(@$package->price) }}" required>
                                            </div>
                                            <div class="col-6">
                                                <label class="form--label">@lang('Delivery (Days)')</label>
                                                <input type="number" class="form-control form--control" name="package[{{ $i }}][delivery_time]" value="{{ @$package->delivery_time ?? 7 }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="form--label">@lang('Post Count')</label>
                                                <input type="number" class="form-control form--control" name="package[{{ $i }}][post_count]" value="{{ @$package->post_count ?? 1 }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form--label">@lang('Video Sec (Optional)')</label>
                                                <input type="number" class="form-control form--control" name="package[{{ $i }}][video_length]" value="{{ @$package->video_length }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form--label">@lang('Description')</label>
                                            <textarea class="form-control form--control" name="package[{{ $i }}][description]" required>{{ @$package->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endfor
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <h5 class="mb-3">@lang('Portfolio Gallery')</h5>
                            <div class="form-group mb-3">
                                <label class="form--label">@lang('Upload Images')</label>
                                <input type="file" name="images[]" multiple class="form-control form--control" accept="image/*">
                                <small class="text-muted">@lang('Maximum') {{ gs('max_image_upload') }} @lang('images at once')</small>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn--base w-100">@lang('Save Changes')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card custom--card mt-4">
            <div class="card-header">
                <h5 class="card-title">@lang('Portfolio Gallery')</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($galleries as $gallery)
                        <div class="col-md-3 mb-3">
                            <div class="position-relative">
                                <img src="{{ getImage(getFilePath('profileGallery') . '/' . $gallery->image) }}" class="img-fluid rounded border">
                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 confirmationBtn" 
                                    data-action="{{ route('influencer.gallery.image.remove', $gallery->id) }}"
                                    data-question="@lang('Are you sure you want to remove this image?')">
                                    <i class="la la-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('style')
<style>
    .avatar-preview {
        width: 100%;
        height: 250px;
        border-radius: 10px;
        background-size: cover;
        background-position: center;
        border: 2px dashed #ddd;
    }
    .profilePicPreview {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
    }
    .avatar-edit input {
        display: none;
    }
    .avatar-edit label {
        display: block;
        padding: 10px;
        text-align: center;
        cursor: pointer;
        border-radius: 0 0 10px 10px;
    }
</style>
@endpush



