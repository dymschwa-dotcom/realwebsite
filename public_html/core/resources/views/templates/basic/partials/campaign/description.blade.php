<form id="descriptionForm" action="{{ route('user.campaign.description', $campaign->slug ?? 'pending') }}" method="POST">
    @csrf

    {{-- Campaign Description --}}
    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0">@lang('Campaign Description')<span class="text--danger">*</span></label>
            <p class="campaign-desc">@lang('Provide a detailed description of your campaign so influencers understand your brand goals and tone.')</p>
        </div>
        <div class="form-group mb-0">
            <textarea class="form--control nicEdit" id="description" name="description" autocomplete="off" rows="6">{{ old('description', @$campaign->description) }}</textarea>
        </div>
    </div>

    {{-- Review Process --}}
    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0">@lang('Review Process')<span class="text--danger">*</span> </label>
            <p class="campaign-desc">@lang('Inform the influencer how their draft or work will be reviewed before posting.')</p>
        </div>
        <div class="form-group mb-0">
            <textarea class="form--control" name="review_process" rows="3" required placeholder="@lang('Example: Send a draft via email for approval 2 days before the live date.')">{{ old('review_process', @$campaign->review_process) }}</textarea>
        </div>
    </div>

    {{-- Approval Process --}}
    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0">@lang('Approval Process')<span class="text--danger">*</span></label>
            <p class="campaign-desc">@lang('Explain the final steps for content to be marked as complete.')</p>
        </div>
        <div class="form-group mb-0">
            <textarea class="form--control" name="approval_process" rows="3" required placeholder="@lang('Example: Content will be approved once live URL is submitted and insights are shared.')">{{ old('approval_process', @$campaign->approval_process) }}</textarea>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="mt-4 text-end d-flex justify-content-between">
        <button class="btn btn--gray preDescBtn" type="button" data-pre="content"> 
            <i class="las la-arrow-left"></i> @lang('Previous')
        </button>
        <button class="btn btn--base" type="submit">
            @lang('Next') <i class="las la-arrow-right"></i>
        </button>
    </div>
</form>

<script>
    (function($) {
        "use strict";
        
        // Re-initialize NicEdit for AJAX loaded content
        if (typeof initNicEditor === "function") {
            initNicEditor();
        }
        
    })(jQuery);
</script>