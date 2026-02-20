<div class="dashboard-profile">
    <button class="btn profile-edit btn--base btn--sm editBtn outline"><i class="lar la-edit"></i>
        @lang('Edit')</button>
    <img class="profile-shape-one" src="{{ getImage($activeTemplateTrue . 'images/profile-shape-2.png') }}" alt="@lang('image')">
    <img class="profile-shape-two" src="{{ getImage($activeTemplateTrue . 'images/profile-shape.png') }}" alt="@lang('image')">
    <div class="dashboard-profile__thumb">
        <img src="{{ getImage(getFilePath('influencer') . '/thumb_' . @$influencer->image, getFileSize('influencer'), true) }}" alt="@lang('image')">
    </div>
    <div class="dashboard-profile__information">
        <h4>{{ __($influencer->fullname) }}</h4>
        <span>@lang('Joined On'): {{ showDateTime($influencer->created_at, 'd M, Y') }}</span>
        <div class="dashboard-profile__link">
            <a href="{{ route('influencer.profile.setting') }}"><i class="lar la-user"></i> {{ $influencer->username }}</a>
            <a href="mailto:{{ $influencer->email }}"><i class="lar la-envelope"></i>{{ $influencer->email }}</a>
        </div>
        <ul class="rating-list mt-2">
            @php
                echo showRatings($influencer->rating);
            @endphp
            <li class="rating-list__text">({{ getAmount($influencer->total_review) }})</li>
        </ul>
        <ul class="rating-list mt-2 gap-2">
            @foreach (@$influencer->categories ?? [] as $category)
                <li class="rating-list__text"> <span class="badge badge--dark">{{ __(@$category->name) }}</span></li>
            @endforeach
        </ul>
    </div>
</div>

<div class="card custom--card dashboard-edit-profile d-none">
    <div class="card-body">
        <form action="{{ route('influencer.profile.setting') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="dashboard-edit-profile__thumb mb-4">
                <div class="file-upload">
                    <label class="edit-pen" for="update-photo"><i class="lar la-edit"></i></label>
                    <input class="form-control form--control" id="update-photo" name="image" type="file" accept=".jpg,.jpeg,.png" hidden="">
                </div>
                <img id="upload-img" src="{{ getImage(getFilePath('influencer') . '/thumb_' . @$influencer->image, getFileSize('influencer'), true) }}">
            </div>
            <div class="text-center">
                <label class="form--label mb-0">@lang('Upload Profile')<span class="text--danger">*</span></label><br>
                <small>@lang('File type will be .jpg, .jpeg, .png') | @lang('File size will be '){{ getFileSize('influencer') }} @lang('px')</small>
            </div>

            <div class="row mt-4">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form--label">@lang('First Name')</label>
                        <input class="form--control" name="firstname" type="text" value="{{ $influencer->firstname }}" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form--label">@lang('Last Name')</label>
                        <input class="form--control" name="lastname" type="text" value="{{ $influencer->lastname }}" required>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form--label">@lang('Category')</label>
                        <select class="form--control select2-multi-select" name="category[" multiple required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if (in_array($category->id, $influencer->categoryId)) selected @endif>
                                    {{ __($category->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form--label">@lang('Gender')</label>
                        <select class="form--control select" name="gender" required>
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="male" @selected(@$influencer->gender == 'male')>@lang('Male')</option>
                            <option value="female" @selected(@$influencer->gender == 'female')>@lang('Female')</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form--label">@lang('Date of Birth')</label>
                        <input class="birthdate form-control form--control" name="birth_date" data-language='en' data-date-format="yyyy-mm-dd" data-position='bottom left' type="text" value="{{ $influencer->birth_date }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form--label" for="address">@lang('Address')</label>
                        <input class="form-control form--control" id="address" name="address" type="text" value="{{ @$influencer->address }}" placeholder="@lang('Address')">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form--label" for="city">@lang('City')</label>
                        <input class="form-control form--control" id="city" name="city" type="text" value="{{ @$influencer->city }}" placeholder="@lang('City')">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form--label" for="state">@lang('State')</label>
                        <input class="form-control form--control" id="state" name="state" type="text" value="{{ @$influencer->state }}" placeholder="@lang('State')">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form--label" for="zip">@lang('Zip Code')</label>
                        <input class="form-control form--control" id="zip" name="zip" type="text" value="{{ @$influencer->zip }}" placeholder="@lang('Zip Code')">
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="form--label">@lang('About Me')</label>
                        <textarea class="form--control" name="bio">{{ old('bio', $influencer->bio) }}</textarea>
                    </div>
                </div>
                <hr class="my-4">
                <h5>@lang('Social Accounts')</h5>
                @foreach ($platforms as $platform)
                    @php
                        $social = $influencer->socialLink->where('platform_id', $platform->id)->first();
                    @endphp
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form--label">{{ __(ucfirst($platform->name)) }} @lang('Link')</label>
                                    <input type="url" name="social_link[{{ $platform->id }}]" class="form--control" value="{{ $social ? $social->social_link : '' }}" placeholder="https://...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form--label">@lang('Followers')</label>
                                    <input type="number" name="followers[{{ $platform->id }}]" class="form--control" value="{{ $social ? $social->followers : '' }}" placeholder="0">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <hr class="my-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">@lang('Packages')</h5>
                    <button type="button" class="btn btn--base btn--sm addPackageBtn"><i class="las la-plus"></i> @lang('Add New')</button>
                </div>

                <div class="packages-container">
                    @forelse ($influencer->packages as $index => $package)
                        <div class="package-item card bg--light mb-3" data-index="{{ $index }}">
                            <input type="hidden" name="package[{{ $index }}][id]" value="{{ $package->id }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Title')</label>
                                            <input type="text" name="package[{{ $index }}][name]" class="form-control form--control" value="{{ $package->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Description')</label>
                                            <textarea name="package[{{ $index }}][description]" class="form-control form--control" required>{{ $package->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Price')</label>
                                            <input type="number" step="any" name="package[{{ $index }}][price]" class="form-control form--control" value="{{ getAmount($package->price) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center justify-content-center">
                                        <button type="button" class="btn btn--danger btn--sm removePackageBtn"><i class="las la-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        @for ($i = 0; $i < 3; $i++)
                            <div class="package-item card bg--light mb-3" data-index="{{ $i }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form--label">@lang('Title')</label>
                                                <input type="text" name="package[{{ $i }}][name]" class="form-control form--control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="form--label">@lang('Description')</label>
                                                <textarea name="package[{{ $i }}][description]" class="form-control form--control" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="form--label">@lang('Price')</label>
                                                <input type="number" step="any" name="package[{{ $i }}][price]" class="form-control form--control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                                            <button type="button" class="btn btn--danger btn--sm removePackageBtn"><i class="las la-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    @endforelse
                </div>

                <div class="col-sm-12">
                    <div class="form-group mb-0 text-end">
                        <button class="btn btn--black btn--sm cancelButton" type="button"> @lang('Cancel')</button>
                        <button class="btn btn--base btn--sm" type="submit"> @lang('Submit')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('style-lib')
    <link type="text/css" href="{{ asset('assets/admin/css/daterangepicker.css') }}" rel="stylesheet" />
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/daterangepicker.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            let packageIndex = {{ count($influencer->packages) > 0 ? count($influencer->packages) : 3 }};
            $('.addPackageBtn').on('click', function() {
                let html = `
                    <div class="package-item card bg--light mb-3" data-index="${packageIndex}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Title')</label>
                                        <input type="text" name="package[${packageIndex}][name]" class="form-control form--control" required>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Description')</label>
                                        <textarea name="package[${packageIndex}][description]" class="form-control form--control" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Price')</label>
                                        <input type="number" step="any" name="package[${packageIndex}][price]" class="form-control form--control" required>
                                    </div>
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-center">
                                    <button type="button" class="btn btn--danger btn--sm removePackageBtn"><i class="las la-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $('.packages-container').append(html);
                packageIndex++;
            });

            $(document).on('click', '.removePackageBtn', function() {
                if ($('.package-item').length <= 3) {
                    notify('error', 'You must have at least 3 packages.');
                    return;
                }
                $(this).closest('.package-item').remove();
            });

            $('.editBtn').on('click', function() {
                $('.dashboard-edit-profile').removeClass('d-none');
                $('.dashboard-profile').addClass('d-none');
                $('.select2-multi-select').select2();
                birthday()
            });

            $('.cancelButton').on('click', function() {
                $('.dashboard-edit-profile').addClass('d-none');
                $('.dashboard-profile').removeClass('d-none');
            });


            function birthday() {
                var maxDate = `{{ showDateTime(now(), 'Y-m-d') }}`;
                $('input[name="birth_date"').daterangepicker({
                    "singleDatePicker": true,
                    "maxDate": maxDate,
                    "opens": "right",
                    "locale": {
                        "format": "YYYY-MM-DD",
                    }
                });
            }


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
        })(jQuery)
    </script>
@endpush

