@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-body">
            <div class="brand-profile">
                <div class="nav nav-tabs brand-profile-tabs" id="nav-tab" role="tablist">
                    <a class="nav-link" href="{{ route('user.profile.setting') }}">@lang('Profile Setting') </a>
                    <a class="nav-link active" href="{{ route('user.change.password') }}">@lang('Change password')</a>
                </div>

                <div class="mt-4">
                    <form method="post">
                        @csrf
                        <div class="form-group">
                            <label class="form--label">@lang('Current Password')</label>
                            <input class="form--control" name="current_password" type="password" required autocomplete="current-password">
                        </div>
                        <div class="form-group">
                            <label class="form--label">@lang('Password')</label>
                            <input class="form--control @if (gs('secure_password')) secure-password @endif" name="password" type="password" required autocomplete="current-password">
                        </div>
                        <div class="form-group">
                            <label class="form--label">@lang('Confirm Password')</label>
                            <input class="form--control" name="password_confirmation" type="password" required autocomplete="current-password">
                        </div>
                        <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
