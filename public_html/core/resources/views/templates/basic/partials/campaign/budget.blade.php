<form id="budgetForm" action="{{ route('user.campaign.budget', @$campaign->id) }}" method="POST">
    @csrf

    @if ($campaign->payment_type == 'paid')
        <div class="form-group common-style mb-4">
            <div class="create-header mb-4">
                <label class="form--label mb-0">@lang('Campaign Budget')</label>
                <p class="campaign-desc">
                    @lang('Campaign budget represents how much remuneration influencers will get after successfully completing this campaign')
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
            <label class="form--label mb-0"> @lang('Start date')</label>
            <p class="campaign-desc">
                @lang('The campaign will start this time, and influencers can apply it after this time.')
            </p>
        </div>
        <input class="form--control" name="start_date" type="text" value="{{ @$campaign->start_date }}" autocomplete="off" required>

    </div>
    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0"> @lang('End date')</label>
            <p class="campaign-desc">
                @lang('The campaign will end this time. After this time, influencers cannot apply this campaign.')
            </p>
        </div>
        <input class="form--control" name="end_date" type="text" value="{{ @$campaign->end_date }}" autocomplete="off" required>
    </div>

    <div class="d-flex justify-content-between text-end">

        <button class="btn btn--gray preBudgetBtn" type="button"> <i class="las la-arrow-left"></i> @lang('Previous')</button>
        <button class="btn btn--base" type="submit"> @lang('Submit') <i class="las la-arrow-right"></i></button>
    </div>
</form>
