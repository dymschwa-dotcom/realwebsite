@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="section-py">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card custom--card">
                        <div class="card-body">
                            <div class="alert alert-warning" role="alert">
                                <strong> <i class="la la-info-circle"></i> @lang('You need to complete your profile to get access to your dashboard')</strong>
                            </div>

                            <form method="POST" action="{{ route('influencer.data.submit') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="dashboard-edit-profile__thumb mb-4">
                                    <div class="file-upload">
                                        <label class="edit-pen" for="update-photo"><i class="lar la-edit"></i></label>
                                        <input class="form-control form--control" id="update-photo" name="image" type="file" hidden="" accept=".jpg,.jpeg,.png">
                                    </div>
                                    <div class="upload-img-box">
                                        <img id="upload-img" src="{{ getImage(getFilePath('influencer') . '/' . $influencer->image, avatar: true) }}" alt="@lang('image')">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <label class="form--label mb-0">@lang('Upload Profile')<span
                                              class="text--danger">*</span></label><br>
                                    <small>@lang('File type will be .jpg, .jpeg, .png')</small>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Username')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form--control checkUser" name="username" value="{{ old('username') }}" required>
                                                <span class="input-group-text username-check"></span>
                                            </div>
                                            <small class="text--danger usernameExist"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
    <div class="form-group">
        <label class="form-label">@lang('Country')</label>
        <select name="country" class="form-control form--control select2" required>
            @foreach ($countries as $key => $country)
                @if(in_array($country->country, ['New Zealand', 'Australia']))
                    <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}" @selected($country->country == 'New Zealand')>{{ __($country->country) }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label class="form-label">@lang('Region / State')</label>
        <select name="region" class="form-control form--control select2" required>
            <option value="">@lang('Select Region')</option>
        </select>
    </div>
</div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Mobile')</label>
                                            <div class="input-group ">
                                                <span class="input-group-text mobile-code">

                                                </span>
                                                <input type="hidden" name="mobile_code">
                                                <input type="hidden" name="country_code">
                                                <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control form--control checkUser"
                                                       required>
                                            </div>
                                            <small class="text--danger mobileExist"></small>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label">@lang('City')</label>
                                        <input type="text" class="form-control form--control" name="city" value="{{ old('city') }}">
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="gender-box form-group mb-4">
                                            <div class="create-header mb-2">
                                                <label class="form--label mb-0">@lang('Influencer Gender')<span class="text--danger">*</span></label>
                                            </div>
                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="custom--check">
                                                    <label class="custom--check-label" for="male"></label>
                                                    <div class="d-flex gap-2">
                                                        <div class="form--check d-inline-block">
                                                            <input class="form-check-input" id="male" name="gender" type="radio" value="male" @checked(old('gender') == 'male')>
                                                        </div>
                                                        <span class="title">@lang('Male')</span>
                                                    </div>
                                                </div>

                                                <div class="custom--check">
                                                    <label class="custom--check-label" for="female"></label>
                                                    <div class="d-flex gap-2">
                                                        <div class="form--check d-inline-block">
                                                            <input class="form-check-input" id="female" name="gender" type="radio" value="female" @checked(old('gender') == 'female')>
                                                        </div>
                                                        <span class="title">@lang('Female')</span>
                                                    </div>
                                                </div>

                                                <div class="custom--check">
                                                    <label class="custom--check-label" for="other"></label>
                                                    <div class="d-flex gap-2">
                                                        <div class="form--check d-inline-block">
                                                            <input class="form-check-input" id="other" name="gender" type="radio" value="other" @checked(old('gender') == 'other')>
                                                        </div>
                                                        <span class="title">@lang('Other')</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Date of Birth')</label>
                                            <input class="form--control" name="birth_date" type="text" value="" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Category')</label>
                                            <small class="text--info d-block mb-1">@lang('Choose one or more categories')</small>
                                            <select class="form--control select2-auto-tokenize" name="category[]" multiple
                                                    required>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" @selected(in_array($category->id, old('category') ?? []))>
                                                        {{ __($category->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mt-4">
                                        <h5>@lang('Social Accounts')</h5>
                                        <small class="text--info d-block mb-2">@lang('Please provide at least one social media link and your follower count.')</small>
                                    </div>
                                    @foreach ($platforms as $platform)
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="form--label">{{ __(ucfirst($platform->name)) }} @lang('Link')</label>
                                                        <input type="url" name="social_link[{{ $platform->id }}]" class="form--control" value="{{ old('social_link.' . $platform->id) }}" placeholder="https://...">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form--label">@lang('Followers')</label>
                                                        <input type="number" name="followers[{{ $platform->id }}]" class="form--control" value="{{ old('followers.' . $platform->id) }}" placeholder="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="col-sm-12">
                                    <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style-lib')
    <link type="text/css" href="{{ asset('assets/admin/css/daterangepicker.css') }}" rel="stylesheet" />
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/daterangepicker.min.js') }}"></script>
@endpush

@push('script')
    <script>
        // Add this inside the jQuery closure
const regions = @json(json_decode(file_get_contents(resource_path('views/partials/regions.json')), true));

function updateRegions(country) {
    const regionSelect = $('select[name=region]');
    regionSelect.empty();
    regionSelect.append('<option value="">@lang('Select Region')</option>');
    
    if (regions[country]) {
        regions[country].forEach(function(region) {
            regionSelect.append(`<option value="${region}">${region}</option>`);
        });
    }
}
// Update regions when country changes
$('select[name=country]').on('change', function() {
    updateRegions($(this).val());
});

// Initialize on page load
updateRegions($('select[name=country]').val());

        (function($) {
            "use strict";

            $("#update-photo").on('change', function() {
                proPicURL(this);
            });

            function proPicURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        const result = reader.result;
                        $("#upload-img").attr('src', result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').on('change', function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
                var value = $('[name=mobile]').val();
                var name = 'mobile';
                checkUser(value, name);
            });

            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));


            $('.checkUser').on('focusout', function(e) {
                var value = $(this).val();
                var name = $(this).attr('name')
                checkUser(value, name);
            });

            function checkUser(value, name) {
                var url = '{{ route('influencer.checkUser') }}';
                var token = '{{ csrf_token() }}';

                if (name == 'mobile') {
                    var mobile = `${value}`;
                    var data = {
                        mobile: mobile,
                        mobile_code: $('.mobile-code').text().substr(1),
                        _token: token
                    }
                }
                if (name == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.field} already exist`);
                        if (name == 'username') {
                            $('.username-check').html('<i class="las la-times text-danger"></i>');
                            $('[name=username]').addClass('is-invalid').removeClass('is-valid');
                        }
                    } else {
                        $(`.${response.type}Exist`).text('');
                        if (name == 'username') {
                            $('.username-check').html('<i class="las la-check text-success"></i>');
                            $('[name=username]').addClass('is-valid').removeClass('is-invalid');
                        }
                    }
                });
            }

            var maxDate = `{{ showDateTime(now(), 'Y-m-d') }}`;
            $('input[name="birth_date"]').daterangepicker({
                "singleDatePicker": true,
                "opens": "right",
                "maxDate":maxDate,
                "locale": {
                    "format": "YYYY-MM-DD",
                }
            });

        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .gender-box .custom--check {
            padding-right: 20px;
        }
    </style>
@endpush

@push('style')
    <style>
        .upload-img-box {
            height: 100% !important;
            width: 100% !important;
        }
    </style>
@endpush

