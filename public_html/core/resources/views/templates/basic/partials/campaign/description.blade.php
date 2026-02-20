<form id="descriptionForm" action="{{ route('user.campaign.description', @$campaign->id) }}" method="POST">
    @csrf

    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0">@lang('Description')<span class="text--danger">*</span></label>
            <p class="campaign-desc">@lang('Describe your campaign, your description will understand the influencers actually how you want to promote your brand')</p>
        </div>
        <div class="form-group mb-0">
            <textarea class="form--control nicEdit" id="description" name="description" autocomplete="off" rows="4">@php echo old('description',$campaign->description) @endphp</textarea>
        </div>
    </div>
    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0">@lang('Review Process')<span class="text--danger">* </span> </label>
            <p class="campaign-desc">@lang('The influencer must be informed in advance of how the influencer\'s work will be reviewed.')</p>
        </div>
        <div class="form-group mb-0">
            <textarea class="form--control" name="review_process" required>{{ old('review_process', @$campaign->review_process) }}</textarea>
        </div>
    </div>
    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0">@lang('Approval Process')<span class="text--danger">*</span></label>
            <p class="campaign-desc">@lang('The influencer must know in advance how the influencer\'s work will be approved or complete')</p>
        </div>
        <div class="form-group mb-0">
            <textarea class="form--control" name="approval_process" required>{{ old('approval_process', @$campaign->approval_process) }}</textarea>
        </div>
    </div>
    <div class="mt-4 text-end d-flex justify-content-between">
        <button class="btn btn--gray preDescBtn" type="button"> <i class="las la-arrow-left"></i> @lang('Previous')</button>
        <button class="btn btn--base" type="submit">@lang('Next') <i class="las la-arrow-right"></i></button>
    </div>
</form>

@push('script')
    <script>
        (function($) {
            "use strict";
            $(".select2-auto-tokenize").select2({
                tags: true,
                tokenSeparators: [","],
                dropdownParent: $(".card-body"),
                width: "100%",
                closeOnSelect: true
            });
        })(jQuery)
    </script>
@endpush

