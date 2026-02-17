{{-- FIX: Change @$campaign->id to $campaign->slug --}}
<form id="budgetForm" action="{{ route('user.campaign.budget', $campaign->slug ?? 'pending') }}" method="POST">
    @csrf

    @if ($campaign->payment_type == 'paid')
        <div class="form-group common-style mb-4">
            <div class="create-header mb-4">
                <label class="form--label mb-0">@lang('Campaign Budget')</label>
                <p class="campaign-desc">
                    @lang('How much remuneration will influencers get after successfully completing this campaign?')
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
                @lang('When should influencers be able to start applying?')
            </p>
        </div>
        {{-- Added 'datepicker-here' class in case your theme uses it --}}
        <input class="form--control datepicker-here" name="start_date" type="text" value="{{ @$campaign->start_date }}" autocomplete="off" required data-language="en">
    </div>

    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0"> @lang('End date')</label>
            <p class="campaign-desc">
                @lang('After this time, influencers can no longer apply.')
            </p>
        </div>
        <input class="form--control datepicker-here" name="end_date" type="text" value="{{ @$campaign->end_date }}" autocomplete="off" required data-language="en">
    </div>

    <div class="d-flex justify-content-between text-end">
        <button class="btn btn--gray preBudgetBtn" type="button" data-pre="requirement"> <i class="las la-arrow-left"></i> @lang('Previous')</button>
        <button class="btn btn--base" type="submit"> @lang('Complete Campaign') <i class="las la-arrow-right"></i></button>
    </div>
</form>