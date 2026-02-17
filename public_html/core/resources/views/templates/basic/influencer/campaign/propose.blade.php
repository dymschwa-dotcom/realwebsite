@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="row gy-4 justify-content-center">
    <div class="col-lg-8">
        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card custom--card mb-4">
            <div class="card-header bg--dark">
                <h5 class="m-0 text-white">@lang('Submit Your Proposal')</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('influencer.campaign.proposal.final.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">

                    <div class="form-group mb-4">
                        <label class="form-label fw-bold">@lang('Your Pitch / Cover Letter')</label>
                        <textarea name="message" class="form-control form--control" rows="12" required 
                            placeholder="@lang('Explain why you are the perfect fit. Mention your strategy, your audience engagement, and what content you plan to create...')">{{ old('message') }}</textarea>
                        <small class="text-muted">@lang('Tip: Brands prefer influencers who show they have read the requirements.')</small>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <a href="{{ url()->previous() }}" class="btn btn--danger outline">@lang('Back')</a>
                        <button type="submit" class="btn btn--base px-5">
                            <i class="las la-paper-plane"></i> @lang('Submit Proposal')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Detailed Sidebar Brief --}}
    <div class="col-lg-4">
        <div class="card custom--card sticky-sidebar">
            <div class="card-header">
                <h5 class="m-0">@lang('Campaign Brief')</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">@lang('Budget')</span>
                        <span class="fw-bold text--success">{{ $general->cur_sym }}{{ showAmount($campaign->budget) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">@lang('Deadline')</span>
                        <span>{{ showDateTime($campaign->end_date, 'd M, Y') }}</span>
                    </li>
                    <li class="list-group-item">
                        <span class="text-muted d-block mb-2">@lang('Target Platforms')</span>
                        <div class="d-flex gap-2">
                            @foreach($campaign->platforms as $platform)
                                <span class="badge badge--dark p-2">@php echo $platform->icon @endphp {{ __($platform->name) }}</span>
                            @endforeach
                        </div>
                    </li>
                    <li class="list-group-item">
                        <span class="text-muted d-block mb-2">@lang('Gender Requirement')</span>
                        @foreach($campaign->influencer_requirements->gender as $gender)
                            <span class="badge badge--info">{{ __(ucfirst($gender)) }}</span>
                        @endforeach
                    </li>
                </ul>
            </div>
            <div class="card-footer bg-white p-3">
                <h6 class="fs-14 mb-2">@lang('Full Description'):</h6>
                <div class="small text-muted" style="max-height: 300px; overflow-y: auto;">
                    @php echo $campaign->description @endphp
                </div>
            </div>
        </div>
    </div>
</div>
@endsection