@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-body">
            <div class="brand-profile">
                <div class="nav nav-tabs brand-profile-tabs" id="nav-tab" role="tablist">
                    <a class="nav-link active" href="{{ route('user.profile.setting') }}">@lang('Profile Setting') </a>
                    <a class="nav-link" href="{{ route('user.change.password') }}">@lang('Change password')</a>
                </div>

                <div class="mt-4">
                    <form action="{{ route('user.profile.setting') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="dashboard-edit-profile__thumb mb-4">
                            <div class="file-upload">
                                <label class="edit-pen" for="update-photo"><i class="lar la-edit"></i></label>
                                <input type="file" name="image" class="form-control form--control" id="update-photo" hidden="">
                            </div>
                            <img id="upload-img" src="{{ getImage(getFilePath('brand') . '/' . $user->image,null,true) }}" alt="@lang('image')">
                        </div>
                        <div class="text-center">
                            <label class="form--label mb-0">@lang('Upload Brand Logo')<span class="text--danger">*</span></label><br>
                            <small>@lang('File type will be .jpg, .jpeg, .png')</small>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('First Name')</label>
                                    <input class="form--control" name="firstname" type="text" value="{{ $user->firstname }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Last Name')</label>
                                    <input class="form--control" name="lastname" type="text" value="{{ $user->lastname }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Username')</label>
                                    <input class="form--control" type="text" value="{{ $user->username }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Email Address')</label>
                                    <input class="form--control" type="text" value="{{ $user->email }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Brand Name')</label>
                                    <input class="form--control" type="text" name="brand_name" value="{{ $user->brand_name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Brand Website')</label>
                                    <input class="form--control" type="text" name="website" value="{{ $user->website }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Company Name')</label>
                                    <input class="form--control" name="company_name" type="text" value="{{ $user->company_name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Address')</label>
                                    <input class="form--control" name="address" type="text" value="{{ $user->address }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('IRD Number / TFN')</label>
                                    <input class="form--control" name="tax_number" type="text" value="{{ $user->tax_number }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Are you GST/VAT Registered?')</label>
                                    <select name="is_gst_registered" class="form-control form--control">
                                        <option value="0" @selected(!$user->is_gst_registered)>@lang('No')</option>
                                        <option value="1" @selected($user->is_gst_registered)>@lang('Yes')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 {{ $user->is_gst_registered ? '' : 'd-none' }}" id="gst-number-container">
                                <div class="form-group">
                                    <label class="form--label">@lang('GST/VAT Number')</label>
                                    <input class="form--control" name="gst_number" type="text" value="{{ $user->gst_number }}">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            
            $('select[name="is_gst_registered"]').on('change', function() {
                if($(this).val() == 1) {
                    $('#gst-number-container').removeClass('d-none');
                } else {
                    $('#gst-number-container').addClass('d-none');
                }
            });

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
        })(jQuery);
    </script>
@endpush

