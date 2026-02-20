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
                                @endphp
                                <h4 class="mb-3">@lang('Packages')</h4>
                                <div class="row">
                                    @for ($i = 1; $i <= 3; $i++)
                                        <div class="col-md-4">
                                            <div class="card bg--light mb-4">
                                                <div class="card-header bg--primary text-white">
                                                    <h5 class="mb-0 text-white">@lang('Package') {{ $i }}</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group mb-2">
                                                        <label class="form--label">@lang('Title')</label>
                                                        <input type="text" name="package[{{ $i }}][name]" class="form-control form--control" value="{{ old("package.$i.name") }}" required placeholder="@lang('e.g. Basic Shoutout')">
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label class="form--label">@lang('Platform')</label>
                                                        <select name="package[{{ $i }}][platform_id]" class="form-control form--control">
                                                            <option value="">@lang('Select One')</option>
                                                            @foreach($platforms as $platform)
                                                                <option value="{{ $platform->id }}" @selected(old("package.$i.platform_id") == $platform->id)>{{ __($platform->name) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-6 pe-1">
                                                            <label class="form--label">@lang('Price') ({{ gs('cur_sym') }})</label>
                                                            <input type="number" step="any" name="package[{{ $i }}][price]" class="form-control form--control" value="{{ old("package.$i.price") }}" required placeholder="0.00">
                                                        </div>
                                                        <div class="col-6 ps-1">
                                                            <label class="form--label">@lang('Delivery')</label>
                                                            <input type="number" name="package[{{ $i }}][delivery_time]" class="form-control form--control" value="{{ old("package.$i.delivery_time", 7) }}">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-6 pe-1">
                                                            <label class="form--label">@lang('Post Count')</label>
                                                            <input type="number" name="package[{{ $i }}][post_count]" class="form-control form--control" value="{{ old("package.$i.post_count", 1) }}">
                                                        </div>
                                                        <div class="col-6 ps-1">
                                                            <label class="form--label">@lang('Video Sec')</label>
                                                            <input type="number" name="package[{{ $i }}[video_length]" class="form-control form--control" value="{{ old("package.$i.video_length") }}" placeholder="@lang('Optional')">
                                                        </div>
                                                    </div>
                                <div class="form-group">
                                                        <label class="form--label">@lang('Description')</label>
                                                        <textarea name="package[{{ $i }}][description]" class="form-control form--control" required placeholder="@lang('What does this package include?')">{{ old("package.$i.description") }}</textarea>
                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>

                                <hr class="my-4">

                                <h4>@lang('About Me')</h4>
                                <div class="form-group">
                                    <label class="form--label">@lang('Tell brands about yourself') <span class="text--danger">*</span></label>
                                    <textarea name="about" class="form-control form--control" rows="5" required>{{ old('about') }}</textarea>
                                </div>

                                <hr class="my-4">

                                <h4>@lang('Portfolio Images')</h4>
                                <div class="form-group">
                                    <label class="form--label">@lang('Upload up to 12 images of your work') <span class="text--danger">*</span></label>
                                    <input type="file" name="images[]" class="form-control form--control" multiple required accept=".jpg,.jpeg,.png">
                                    <small class="text--muted">@lang('Maximum 12 images. Supported formats: .jpg, .jpeg, .png')</small>
                                </div>

                                <div class="col-sm-12 mt-4">
                                    <button class="btn btn--base w-100" type="submit">@lang('Complete Registration')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

