<form id="descriptionForm" action="{{ route('user.campaign.description', $campaign->slug ?? 'pending') }}" method="POST">
    @csrf
    @php
        $isInfluencer = auth()->guard('influencer')->check();
    @endphp

    {{-- Campaign Description --}}
    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0">{{ $isInfluencer ? __('Your Creative Vision') : __('Campaign Description') }}<span class="text--danger">*</span></label>
            <p class="campaign-desc">
                @if($isInfluencer)
                    @lang('Describe your plan for this collaboration. What kind of content will you create and how will it benefit the brand?')
                @else
                    @lang('Provide a detailed description of your campaign so influencers understand your brand goals and tone.')
                @endif
            </p>
        </div>
        <div class="form-group mb-0">
            <textarea class="form--control nicEdit" id="description" name="description" autocomplete="off" rows="6">{{ old('description', @$campaign->description) }}</textarea>
        </div>
    </div>

    {{-- Review Process --}}
    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0">@lang('Review Process')<span class="text--danger">*</span> </label>
            <p class="campaign-desc">
                @if($isInfluencer)
                    @lang('How do you plan to share drafts or progress with the brand for their feedback?')
                @else
                    @lang('Inform the influencer how their draft or work will be reviewed before posting.')
                @endif
            </p>
        </div>
        <div class="form-group mb-0">
            <textarea class="form--control" name="review_process" rows="3" required placeholder="@if($isInfluencer) @lang('Example: I will send a draft via the platform for your approval before going live.') @else @lang('Example: Send a draft via email for approval 2 days before the live date.') @endif">{{ old('review_process', @$campaign->review_process) }}</textarea>
        </div>
    </div>

    {{-- Approval Process --}}
    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0">@lang('Approval Process')<span class="text--danger">*</span></label>
            <p class="campaign-desc">
                @if($isInfluencer)
                    @lang('How will the final content be delivered and confirmed as complete?')
                @else
                    @lang('Explain the final steps for content to be marked as complete.')
                @endif
            </p>
        </div>
        <div class="form-group mb-0">
            <textarea class="form--control" name="approval_process" rows="3" required placeholder="@if($isInfluencer) @lang('Example: The project is complete once the live link and performance stats are shared.') @else @lang('Example: Content will be approved once live URL is submitted and insights are shared.') @endif">{{ old('approval_process', @$campaign->approval_process) }}</textarea>
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