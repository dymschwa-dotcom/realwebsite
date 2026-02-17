@extends($activeTemplate . 'layouts.frontend')
@section('content')
<section class="pt-80 pb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card custom--card border-0 shadow-sm">
                    <div class="card-header bg--dark p-4 text-center">
                        <h4 class="text-white mb-0">@lang('Step 2: Complete Your Influencer Profile')</h4>
                    </div>
                    <div class="card-body p-4 p-lg-5">
                        <form action="{{ route('influencer.data.submit') }}" method="POST" enctype="multipart/form-data" id="onboardingForm">
                            @csrf
                            <div class="row gy-3">
                                
                                {{-- 1. Avatar with Pencil Overlay & Real-time Validation --}}
                                <div class="col-12 mb-4 text-center">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' name="image" id="imageUpload" accept=".png, .jpg, .jpeg" class="required-field" />
                                            <label for="imageUpload"><i class="las la-pen"></i></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview" style="background-image: url('https://api.dicebear.com/7.x/shapes/svg?seed=Influencer&backgroundColor=ffdfbf,ffd5dc,d1d4f9');">
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-2 small">@lang('Upload profile photo') <span class="text-danger">*</span></p>
                                    {{-- File Error Message --}}
                                    <div id="avatar-error" class="text-danger small fw-bold d-none"></div>
                                </div>

                                {{-- Username --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">@lang('Username') <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">@</span>
                                        <input type="text" class="form-control form--control required-field checkUser" name="username" value="{{ old('username') }}" placeholder="kiwicreator" required autocomplete="off">
                                    </div>
                                    <small class="user-status-message mt-1 d-block"></small>
                                </div>

                                {{-- Country & City --}}
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">@lang('Country') <span class="text-danger">*</span></label>
                                    <select name="country" id="country_select" class="form-select form--control required-field" required>
                                        @foreach($countries as $key => $country)
                                            <option value="{{ $country->country }}" data-mobile_code="{{ $country->dial_code }}" data-code="{{ $key }}" {{ $country->country == 'New Zealand' ? 'selected' : '' }}>{{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 position-relative">
                                    <label class="form-label fw-bold">@lang('City') <span class="text-danger">*</span></label>
                                    <input type="text" name="city" id="city_input" class="form-control form--control required-field" placeholder="@lang('Search city...')" autocomplete="off" required>
                                    <div id="city_list" class="autocomplete-suggestions"></div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">@lang('Mobile Number') <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text mobile-code bg-light"></span>
                                        <input type="hidden" name="mobile_code">
                                        <input type="hidden" name="country_code">
                                        <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control form--control required-field" required>
                                    </div>
                                </div>

                                {{-- Gender & Birthdate --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">@lang('Gender') <span class="text-danger">*</span></label>
                                    <select name="gender" class="form-select form--control required-field" required>
                                        <option value="male">@lang('Male')</option>
                                        <option value="female">@lang('Female')</option>
                                        <option value="other">@lang('Other')</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">@lang('Birth Date') <span class="text-danger">*</span></label>
                                    <input type="text" name="birth_date" id="birth_date" class="form-control form--control required-field" placeholder="DD-MM-YYYY" autocomplete="off" required>
                                </div>

                                {{-- Categories --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold mb-0">@lang('Category') <span class="text-danger">*</span></label>
                                    <div class="category-checkbox-grid mt-2">
                                        @foreach($categories as $category)
                                            <div class="form-check custom--check">
                                                <input class="form-check-input category-checkbox" type="checkbox" name="category[]" value="{{ $category->id }}" id="cat_{{ $category->id }}">
                                                <label class="form-check-label" for="cat_{{ $category->id }}">
                                                    {{ __($category->name) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <hr class="my-4">
                                <h5 class="mb-1 text--danger">@lang('Social Media Accounts')</h5>
                                <p class="text-muted small mb-3">@lang('Enter at least one platform with a valid URL and follower count.')</p>

                                <div class="row gy-3">
                                    @foreach($platforms as $platform)
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">@php echo $platform->icon @endphp {{ $platform->name }} URL</label>
                                        <input type="url" name="social_link[{{ $platform->id }}]" class="form-control form--control social-link-field" placeholder="https://...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">{{ $platform->name }} @lang('Followers')</label>
                                        <input type="number" name="followers[{{ $platform->id }}]" class="form-control form--control follower-field" placeholder="0">
                                    </div>
                                    @endforeach
                                </div>

                                <div class="col-12 mt-5 text-center">
                                    <button type="submit" id="submitBtn" class="btn btn--danger w-100 py-3 fw-bold rounded-pill disabled-btn" disabled>
                                        @lang('Next: Create Packages')
                                    </button>
                                </div>
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
    .btn--danger.disabled-btn { background-color: #ffffff !important; color: #dc3545 !important; border: 2px solid #dc3545 !important; cursor: not-allowed; opacity: 0.6; }
    .btn--danger:not(.disabled-btn) { background-color: #dc3545 !important; color: #ffffff !important; }
    .text--danger { color: #dc3545 !important; }
    .avatar-upload { position: relative; max-width: 130px; margin: 0 auto; }
    .avatar-edit { position: absolute; right: 10px; z-index: 5; top: 10px; }
    .avatar-edit input { display: none !important; }
    .avatar-edit label { display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 100%; background: #ffffff; border: 1px solid #ddd; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .avatar-preview { width: 130px; height: 130px; border-radius: 100%; border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow: hidden; }
    .avatar-preview > div { width: 100%; height: 100%; background-size: cover; background-position: center; }
    .category-checkbox-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; padding: 15px; background: #fdfdfd; border: 1px solid #eee; border-radius: 8px; max-height: 250px; overflow-y: auto; }
    .custom--check .form-check-input:checked { background-color: #dc3545; border-color: #dc3545; }
    .autocomplete-suggestions { position: absolute; width: 100%; z-index: 999; background: #fff; border: 1px solid #ddd; max-height: 200px; overflow-y: auto; display: none; }
    .suggestion-item { padding: 10px 15px; cursor: pointer; }
    .suggestion-item:hover { background-color: #f1f1f1; }
</style>
@endpush

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    (function($){
        "use strict";

        $('#birth_date').mask('00-00-0000');

        function validateForm() {
            let isValid = true;
            
            $('.required-field').each(function() {
                if ($(this).val() === "" || $(this).val() === null || ($(this).is(':file') && this.files.length === 0)) {
                    isValid = false;
                }
            });

            if ($('.category-checkbox:checked').length === 0) isValid = false;
            if ($('.checkUser').hasClass('is-invalid')) isValid = false;

            let completeSocials = 0;
            $('.social-link-field').each(function() {
                let url = $(this).val().trim();
                let followers = $(this).closest('.col-md-6').next('.col-md-6').find('.follower-field').val();
                if (url !== "" && followers !== "" && parseInt(followers) > 0) completeSocials++;
            });
            if (completeSocials === 0) isValid = false;

            if (isValid) {
                $('#submitBtn').removeClass('disabled-btn').prop('disabled', false);
            } else {
                $('#submitBtn').addClass('disabled-btn').prop('disabled', true);
            }
        }

        // --- IMAGE VALIDATION FIX ---
        $("#imageUpload").change(function() {
            const file = this.files[0];
            const $errorDiv = $('#avatar-error');
            const maxSize = 2 * 1024 * 1024; // 2MB
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

            if (file) {
                if (!allowedTypes.includes(file.type)) {
                    $errorDiv.text("Only jpg, jpeg, and png files are allowed.").removeClass('d-none');
                    $(this).val(''); 
                    validateForm();
                    return;
                }

                if (file.size > maxSize) {
                    $errorDiv.text("File is too large. Maximum size is 2MB.").removeClass('d-none');
                    $(this).val(''); 
                    validateForm();
                    return;
                }

                var reader = new FileReader();
                reader.onload = function(e) { $('#imagePreview').css('background-image', 'url('+e.target.result +')'); }
                reader.readAsDataURL(file);
                $errorDiv.addClass('d-none');
            }
            validateForm();
        });

        // --- AJAX Username Check ---
        $('.checkUser').on('blur', function() {
            let username = $(this).val();
            let $message = $('.user-status-message');
            if (username.length < 6) {
                $message.html('<span class="text-danger">Min 6 characters</span>');
                $(this).addClass('is-invalid');
                validateForm();
                return;
            }
            $.post("{{ route('influencer.checkUser') }}", {username: username, _token: "{{ csrf_token() }}"}, function(response) {
                if (response.exists) {
                    $message.html('<span class="text-danger">Taken</span>');
                    $('.checkUser').addClass('is-invalid');
                } else {
                    $message.html('<span class="text-success">Available</span>');
                    $('.checkUser').removeClass('is-invalid');
                }
                validateForm();
            });
        });

        $(document).on('input change keyup', 'input, select', function() { validateForm(); });

        $('#country_select').on('change', function(){
            let selected = $(this).find(':selected');
            $('.mobile-code').text('+' + selected.data('mobile_code'));
            $('input[name=mobile_code]').val(selected.data('mobile_code'));
            $('input[name=country_code]').val(selected.data('code'));
            validateForm();
        }).change();

        $('#city_input').on('keyup', function() {
            var query = $(this).val();
            var countryCode = $('#country_select :selected').data('code');
            if (query.length < 3) { $('#city_list').hide(); return; }
            var url = `https://secure.geonames.org/searchJSON?q=${query}&country=${countryCode}&maxRows=5&username=demo`;
            $.getJSON(url, function(data) {
                $('#city_list').empty().show();
                $.each(data.geonames, function(i, item) {
                    $('#city_list').append(`<div class="suggestion-item" data-city="${item.name}">${item.name}</div>`);
                });
            });
        });

        $(document).on('click', '.suggestion-item', function() {
            $('#city_input').val($(this).data('city'));
            $('#city_list').hide();
            validateForm();
        });

        validateForm();
    })(jQuery);
</script>
@endpush