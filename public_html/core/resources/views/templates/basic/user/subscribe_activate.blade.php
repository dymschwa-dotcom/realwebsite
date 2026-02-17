@extends($activeTemplate.'layouts.master')
@section('content')
<div class="container padding-top padding-bottom">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card custom--card border--warning">
                <div class="card-header bg--warning text-center">
                    <h5 class="title text-white">@lang('Final Step: Account Activation')</h5>
                </div>
                <div class="card-body">
                    <p class="mb-4 text-center">@lang('Your profile is ready! To start discovering influencers and posting campaigns, please activate your monthly subscription.')</p>
                    
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            @lang('Subscription Fee')
                            <span class="fw-bold">$50.00</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            @lang('Your Current Balance')
                            <span class="fw-bold text--base">{{ showAmount(auth()->user()->balance) }} {{ gs('cur_text') }}</span>
                        </li>
                    </ul>

                    <form action="{{ route('user.subscribe.now') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn--base w-100 mb-3">@lang('Activate Now')</button>
                    </form>

                    <div class="text-center">
                        <p class="small text-muted mb-2">@lang('Need to add funds?')</p>
                        <a href="{{ route('user.deposit.index') }}" class="btn btn-outline--base btn-sm">
                            <i class="las la-wallet"></i> @lang('Go to Deposit Page')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection