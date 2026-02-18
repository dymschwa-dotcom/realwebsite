<form id="budgetForm" action="{{ route('user.campaign.budget', $campaign->slug ?? 'pending') }}" method="POST">
    @csrf
    @php
        $isInfluencer = auth()->guard('influencer')->check();
    @endphp

    @if ($campaign->payment_type == 'paid')
        <div class="form-group common-style mb-4">
            <div class="create-header mb-4">
                <label class="form--label mb-0">{{ $isInfluencer ? __('Your Proposed Fee') : __('Campaign Budget') }}</label>
                <p class="campaign-desc">
                    @if($isInfluencer)
                        @lang('What is your total fee for this proposed collaboration?')
                    @else
                        @lang('How much remuneration will influencers get after successfully completing this campaign?')
                    @endif
                </p>
            </div>
            <div class="input-group">
                <input class="form-control form--control" name="budget" type="number" value="{{ old('budget', @$campaign->budget > 0 ? getAmount(@$campaign->budget) : '') }}" step="any" required>
                <span class="input-group-text">{{ gs('cur_text') }}</span>
            </div>
        </div>
    @endif

    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0"> {{ $isInfluencer ? __('Proposed Start Date') : __('Start date') }}</label>
            <p class="campaign-desc">
                @if($isInfluencer)
                    @lang('When would you be available to start working on this project?')
                @else
                    @lang('When should influencers be able to start applying?')
                @endif
            </p>
        </div>
        {{-- Added 'datepicker-here' class in case your theme uses it --}}
        <input class="form--control datepicker-here" name="start_date" type="text" value="{{ @$campaign->start_date }}" autocomplete="off" required data-language="en">
    </div>

    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0"> {{ $isInfluencer ? __('Proposed Delivery Deadline') : __('End date') }}</label>
            <p class="campaign-desc">
                @if($isInfluencer)
                    @lang('By when do you plan to complete all deliverables?')
                @else
                    @lang('After this time, influencers can no longer apply.')
                @endif
            </p>
        </div>
        <input class="form--control datepicker-here" name="end_date" type="text" value="{{ @$campaign->end_date }}" autocomplete="off" required data-language="en">
    </div>

    <div class="d-flex justify-content-between text-end">
        <button class="btn btn--gray preBudgetBtn" type="button" data-pre="{{ $isInfluencer ? 'description' : 'requirement' }}"> <i class="las la-arrow-left"></i> @lang('Previous')</button>
        <button class="btn btn--base" type="submit"> {{ $isInfluencer ? __('Submit Proposal') : __('Complete Campaign') }} <i class="las la-arrow-right"></i></button>
    </div>
</form>