@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-body">
            <form action="{{ route('influencer.kyc.submit') }}" method="post" enctype="multipart/form-data">
                @csrf

                <x-viser-form identifier="act" identifierValue="influencer_kyc" />

                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
            </form>
        </div>
    </div>
@endsection
