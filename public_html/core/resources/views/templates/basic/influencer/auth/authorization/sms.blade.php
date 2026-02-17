@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="py-120">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="verification-code-wrapper">
                    <div class="verification-area">
                        <form class="submit-form" action="{{ route('influencer.verify.mobile') }}" method="POST">
                            @csrf
                            <p class="mb-3">@lang('A 6 digit verification code sent to your mobile number') : +{{ showMobileNumber(auth()->guard('influencer')->user()->mobileNumber) }}</p>
                            @include($activeTemplate . 'partials.verification_code')
                            <div class="mb-3">
                                <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                            </div>
                            <p>
                                @lang('If you don\'t get any code'), <span class="countdown-wrapper">@lang('try again after') <span class="fw-bold" id="countdown">--</span> @lang('seconds')</span> <a class="text--base try-again-link d-none" href="{{ route('influencer.send.verify.code', 'sms') }}"> @lang('Try again')</a>
                            </p>
                            <a href="{{ route('influencer.logout') }}" class="btn btn--base outline btn--sm">@lang('Logout')</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        var distance = Number("{{ @$influencer->ver_code_send_at->addMinutes(2)->timestamp - time() }}");
        var x = setInterval(function() {
            distance--;
            document.getElementById("countdown").innerHTML = distance;
            if (distance <= 0) {
                clearInterval(x);
                document.querySelector('.countdown-wrapper').classList.add('d-none');
                document.querySelector('.try-again-link').classList.remove('d-none');
            }
        }, 1000);
    </script>
@endpush
