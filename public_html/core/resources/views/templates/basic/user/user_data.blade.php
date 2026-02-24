@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="section-py">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-8 mx-auto">
                    <div class="card custom--card">
                        <div class="card-body">
                            <div class="alert alert-warning" role="alert">
                                <strong> <i class="la la-info-circle"></i> @lang('You need to complete your profile to get access to your dashboard')</strong>
                            </div>

                            <form method="POST" action="{{ route('user.data.submit') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="dashboard-edit-profile__thumb mb-4">
                                    <div class="file-upload">
                                        <label class="edit-pen" for="update-photo"><i class="lar la-edit"></i></label>
                                        <input class="form-control form--control" id="update-photo" name="image" type="file" hidden="" accept=".jpg,.jpeg,.png">
                                    </div>
                                    <div class="upload-img-box">
                                        <img id="upload-img" src="{{ getImage(getFilePath('brand') . '/' . $user->image) }}" alt="@lang('image')">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <label class="form--label mb-0">@lang('Upload Brand Logo')<span class="text--danger">*</span></label><br>
                                    <small>@lang('File type will be .jpg, .jpeg, .png')</small>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Username')</label>
                                            <input type="text" class="form-control form--control checkUser" name="username" value="{{ old('username') }}" required>
                                            <small class="text--danger usernameExist"></small>
                                            <small class="text--success usernameAvailable"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Country')</label>
                                            <select name="country" class="form-control form--control select2" required>
                                                @foreach ($countries as $key => $country)
                                                    <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}" @selected($country->country == 'New Zealand')>{{ __($country->country) }}
                                                    </option>
                                                @endforeach
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

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Brand')</label>
                                            <input class="form--control" name="brand_name" type="text" value="{{ old('brand_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Website')</label>
                                            <input class="form--control" name="website" type="text" value="{{ old('website') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Company Name')</label>
                                            <input class="form--control" name="company_name" type="text" value="{{ old('company_name') }}">
                                        </div>
                                    </div>
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

@push('script')
    <script>
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
            @else
                $(`option[value="New Zealand"]`).attr('selected', '');
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
                var url = '{{ route('user.checkUser') }}';
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
                        $(`.${response.type}Available`).text('');
                    } else {
                        $(`.${response.type}Exist`).text('');
                        if(name == 'username' && value.length >= 6){
                            $(`.${response.type}Available`).text(`${response.field} is available`).addClass('text--success').removeClass('text--danger');
                        }
                    }
                });
            }

        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .upload-img-box {
            height: 100% !important;
            width: 100% !important;
        }
    </style>
@endpush


