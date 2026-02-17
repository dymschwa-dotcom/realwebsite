@php
    $categories = \App\Models\Category::active()->orderBy('name', 'asc')->get();
    $platforms = \App\Models\Platform::active()->get(); 
    $selectedCategories = $influencer->categories->pluck('id')->toArray() ?? [];
    
    // REINFORCED FETCH: Load the relationship and the platform details together
    // This ensures $link->platform_id and $link->url are ready for the boxes
    $socialLinks = $influencer->socialLink()->with('platform')->get();
@endphp

<div class="dashboard-profile mb-4">
    <img class="profile-shape-one" src="{{ getImage($activeTemplateTrue . 'images/profile-shape-2.png') }}" alt="@lang('image')">
    <img class="profile-shape-two" src="{{ getImage($activeTemplateTrue . 'images/profile-shape.png') }}" alt="@lang('image')">
    <div class="dashboard-profile__thumb">
        <img src="{{ getImage(getFilePath('influencer') . '/thumb_' . @$influencer->image, getFileSize('influencer'), true) }}" alt="@lang('image')">
    </div>
    <div class="dashboard-profile__information">
        <h4 class="text-dark">{{ __($influencer->fullname) }}</h4>
        <span class="text-muted small">@lang('Member since') {{ showDateTime($influencer->created_at, 'M Y') }}</span>
        <div class="dashboard-profile__link">
            <a href="{{ route('influencer.profile.setting') }}"><i class="lar la-user text--danger"></i> {{ $influencer->username }}</a>
            <a href="mailto:{{ $influencer->email }}"><i class="lar la-envelope text--danger"></i> {{ $influencer->email }}</a>
        </div>
        <ul class="rating-list mt-2 gap-2">
            @foreach ($influencer->categories as $category)
                <li class="rating-list__text"> <span class="badge badge--danger px-3">{{ __($category->name) }}</span></li>
            @endforeach
        </ul>
    </div>
</div>

<div class="card custom--card dashboard-edit-profile mt-4 shadow-sm border-0">
    <div class="card-body p-4">
        <div class="border-bottom pb-3 mb-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0"><i class="las la-user-edit text--danger"></i> @lang('Update Professional Details')</h5>
            <span class="badge badge--dark px-3">@lang('ID'): #{{ $influencer->id }}</span>
        </div>
        
        <form action="{{ route('influencer.profile.setting') }}" method="post" enctype="multipart/form-data">
            @csrf
            
            <div class="dashboard-edit-profile__thumb mb-4">
                <div class="file-upload">
                    <label class="edit-pen shadow-sm" for="update-photo" style="background: #fff; border: 2px solid #dc3545; color: #dc3545; display: flex; align-items: center; justify-content: center; cursor: pointer; width: 35px; height: 35px; border-radius: 50%;">
                        <i class="lar la-edit"></i>
                    </label>
                    <input class="form-control form--control" id="update-photo" name="image" type="file" accept=".jpg,.jpeg,.png" hidden="">
                </div>
                <img id="upload-img" src="{{ getImage(getFilePath('influencer') . '/thumb_' . @$influencer->image, getFileSize('influencer'), true) }}" class="border border-danger border-2 shadow-sm">
            </div>

            <div class="row">
                <div class="col-sm-6 mb-3">
                    <div class="form-group">
                        <label class="form--label small text-uppercase fw-bold">@lang('First Name')</label>
                        <input class="form--control" name="firstname" type="text" value="{{ $influencer->firstname }}" required>
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="form-group">
                        <label class="form--label small text-uppercase fw-bold">@lang('Last Name')</label>
                        <input class="form--control" name="lastname" type="text" value="{{ $influencer->lastname }}" required>
                    </div>
                </div>

                <div class="col-sm-12 mb-4">
                    <div class="form-group">
                        <label class="form--label small text-uppercase fw-bold text--danger">
                            <i class="las la-quote-left"></i> @lang('Professional Bio')
                        </label>
                        <textarea class="form--control text-muted-writing" name="bio" rows="4" style="height: auto;" placeholder="@lang('Tell brands about your content style and audience...')">{{ old('bio', $influencer->bio) }}</textarea>
                    </div>
                </div>

                {{-- SOCIAL LINKS SECTION --}}
                <div class="col-sm-12 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label class="form--label small text-uppercase fw-bold text--danger mb-0">
                            @lang('Social Media Accounts')
                        </label>
                        <button type="button" class="btn btn--danger btn--sm addSocialBtn rounded-pill px-3">
                            <i class="las la-plus"></i> @lang('Add Platform')
                        </button>
                    </div>

                    <div class="social-links-container">
                        @forelse($socialLinks as $link)
                            <div class="card border shadow-none bg-light rounded-3 mb-3 social-row">
                                <div class="card-body p-3">
                                    <div class="row align-items-end g-3">
                                        <div class="col-md-3">
                                            <label class="extra-small fw-bold">@lang('Platform')</label>
                                            <select name="platform_id[]" class="form--control form-control-tall text-muted-writing">
                                                @foreach($platforms as $platform)
                                                    <option value="{{ $platform->id }}" @selected($link->platform_id == $platform->id)>
                                                        {{ __($platform->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="extra-small fw-bold">@lang('Profile URL')</label>
                                            <input type="url" name="social_url[]" class="form--control form-control-tall text-muted-writing" value="{{ $link->url }}" placeholder="https://instagram.com/username" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="extra-small fw-bold">@lang('Followers')</label>
                                            <input type="number" name="followers[]" class="form--control form-control-tall text-muted-writing" value="{{ $link->followers }}" placeholder="e.g. 1000" required>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn--outline-danger removeSocialBtn w-100 btn-tall"><i class="las la-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small text-center social-placeholder">@lang('No social accounts found. Click "Add Platform" to begin.')</p>
                        @endforelse
                    </div>
                </div>

                <div class="col-sm-12 mb-4">
                    <label class="form--label small text-uppercase fw-bold text--danger">@lang('My Niches / Categories')</label>
                    <div class="category-grid border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                        <div class="row g-2">
                            @foreach ($categories as $category)
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-check custom--check">
                                        <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->id }}" id="cat{{ $category->id }}" @checked(in_array($category->id, $selectedCategories))>
                                        <label class="form-check-label pointer text-muted-writing" for="cat{{ $category->id }}">
                                            {{ __($category->name) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <button class="btn btn--danger w-100 rounded-pill py-2 fw-bold shadow-sm" type="submit">
                        <i class="las la-save"></i> @lang('Save Profile Changes')
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('style')
<style>
    .category-grid::-webkit-scrollbar { width: 5px; }
    .category-grid::-webkit-scrollbar-thumb { background: #dc3545; border-radius: 10px; }
    .custom--check .form-check-input:checked { background-color: #dc3545; border-color: #dc3545; }
    .pointer { cursor: pointer; }
    .extra-small { font-size: 0.7rem; color: #666; display: block; margin-bottom: 2px; }
    .form-control-tall { height: 48px !important; font-size: 0.95rem; }
    .btn-tall { height: 48px; display: flex; align-items: center; justify-content: center; }
    .dashboard-edit-profile { border-top: 4px solid #dc3545 !important; }
    
    /* Lighter writing logic */
    .text-muted-writing { color: #aaa !important; }
    .text-muted-writing:focus, .text-muted-writing:not(:placeholder-shown) { color: #333 !important; }
</style>
@endpush

@push('script')
<script>
    (function($) {
        "use strict";

        function checkVal(el) {
            if ($(el).val()) { $(el).css('color', '#333'); }
            else { $(el).css('color', '#aaa'); }
        }

        $('.text-muted-writing').each(function() { checkVal(this); });
        $(document).on('input change', '.text-muted-writing', function() { checkVal(this); });

        $('.addSocialBtn').on('click', function() {
            $('.social-placeholder').remove();
            var html = `
                <div class="card border shadow-none bg-light rounded-3 mb-3 social-row">
                    <div class="card-body p-3">
                        <div class="row align-items-end g-3">
                            <div class="col-md-3">
                                <label class="extra-small fw-bold">@lang('Platform')</label>
                                <select name="platform_id[]" class="form--control form-control-tall text-muted-writing">
                                    <option value="" disabled selected>@lang('Select')</option>
                                    @foreach($platforms as $platform)
                                        <option value="{{ $platform->id }}">{{ __($platform->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="extra-small fw-bold">@lang('Profile URL')</label>
                                <input type="url" name="social_url[]" class="form--control form-control-tall text-muted-writing" placeholder="https://instagram.com/username" required>
                            </div>
                            <div class="col-md-3">
                                <label class="extra-small fw-bold">@lang('Followers')</label>
                                <input type="number" name="followers[]" class="form--control form-control-tall text-muted-writing" placeholder="e.g. 1000" required>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn--outline-danger removeSocialBtn w-100 btn-tall"><i class="las la-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>`;
            $('.social-links-container').append(html);
        });

        $(document).on('click', '.removeSocialBtn', function() {
            $(this).closest('.social-row').remove();
        });

        $("#update-photo").on('change', function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#upload-img").attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    })(jQuery);
</script>
@endpush