<form id="requirementForm" action="{{ route('user.campaign.requirement', @$campaign->id) }}" method="POST">
    @csrf
    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0">@lang('Category')<span class="text--danger">*</span></label>
        </div>
        <div class="form-group mb-0">
            <select class="form--control select2" name="category_id[]" multiple required>
                <option value="" disabled>@lang('Select One')</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(in_array($category->id, old('category_id', @$campaign->categoryId) ?? []))>{{ __($category->name) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0">@lang('Required Number of Influencer')</label>
        </div>
        <div class="input-group product-qty mb-3">
            <span class="input-group-text product-qty__decrement"><i class="fas fa-minus"></i></span>
            <input class="form-control product-qty__value" name="required_influencer" type="number" value="{{ old('required_influencer', @$campaign->influencer_requirements->required_influencer ?? 1) }}" required>
            <span class="input-group-text product-qty__increment"><i class="las la-plus"></i></span>
        </div>
    </div>
    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0">@lang('Influencer Gender')<span class="text--danger">*</span></label>
        </div>
        <div class="d-flex flex-wrap gap-3">
            <div class="custom--check">
                <label class="custom--check-label" for="male"></label>
                <div class="d-flex gap-2">
                    <div class="form--check d-inline-block">
                        <input class="form-check-input" id="male" name="gender[]" type="checkbox" value="male" @checked(in_array('male', old('gender', @$campaign->influencer_requirements->gender) ?? []))>
                    </div>
                    <span class="title">@lang('Male')</span>
                </div>
            </div>

            <div class="custom--check">
                <label class="custom--check-label" for="female"></label>
                <div class="d-flex gap-2">
                    <div class="form--check d-inline-block">
                        <input class="form-check-input" id="female" name="gender[]" type="checkbox" value="female" @checked(in_array('female', old('gender', @$campaign->influencer_requirements->gender) ?? []))>
                    </div>
                    <span class="title">@lang('Female')</span>
                </div>
            </div>

            <div class="custom--check">
                <label class="custom--check-label" for="other"></label>
                <div class="d-flex gap-2">
                    <div class="form--check d-inline-block">
                        <input class="form-check-input" id="other" name="gender[]" type="checkbox" value="other" @checked(in_array('other', old('gender', @$campaign->influencer_requirements->gender) ?? []))>
                    </div>
                    <span class="title">@lang('Other')</span>
                </div>
            </div>
        </div>
    </div>
    @if (in_array(1, @$campaign->platformId ?? []))
        <div class="form-group common-style mb-4">
            <div class="create-header mb-4">
                <label class="form--label mb-0"> @lang('Follower Range On Facebook') <span class="text--danger">*</span></label>
            </div>
            <div class="row gy-3">
                <div class="col-sm-3 col-6">
                    <input class="form--control" name="follower[facebook_start]" type="number" value="{{ old('follower.facebook_start', @$campaign->influencer_requirements->follower_facebook_start) }}" placeholder="@lang('minimum')">
                </div>
                <div class="col-sm-3 col-6">
                    <input class="form--control" name="follower[facebook_end]" type="number" value="{{ old('follower.facebook_end', @$campaign->influencer_requirements->follower_facebook_end) }}" placeholder="@lang('maximum')">
                </div>
            </div>
        </div>
    @endif
    @if (in_array(2, @$campaign->platformId ?? []))
        <div class="form-group common-style mb-4">
            <div class="create-header mb-4">
                <label class="form--label mb-0"> @lang('Follower Range On Instagram') <span class="text--danger">*</span></label>
            </div>
            <div class="row gy-3">
                <div class="col-sm-3 col-6">
                    <input class="form--control" name="follower[instagram_start]" type="number" value="{{ old('follower.instagram_start', @$campaign->influencer_requirements->follower_instagram_start) }}" placeholder="@lang('minimum')">
                </div>
                <div class="col-sm-3 col-6">
                    <input class="form--control" name="follower[instagram_end]" type="number" value="{{ old('follower.instagram_end', @$campaign->influencer_requirements->follower_instagram_end) }}" placeholder="@lang('maximum')">
                </div>
            </div>
        </div>
    @endif
    @if (in_array(3, @$campaign->platformId ?? []))
        <div class="form-group common-style mb-4">
            <div class="create-header mb-4">
                <label class="form--label mb-0"> @lang('Follower Range On Youtube') <span class="text--danger">*</span></label>
            </div>
            <div class="row gy-3">
                <div class="col-sm-3 col-6">
                    <input class="form--control" name="follower[youtube_start]" type="number" value="{{ old('follower.youtube_start', @$campaign->influencer_requirements->follower_youtube_start) }}" placeholder="@lang('minimum')">
                </div>
                <div class="col-sm-3 col-6">
                    <input class="form--control" name="follower[youtube_end]" type="number" value="{{ old('follower.youtube_end', @$campaign->influencer_requirements->follower_youtube_end) }}" placeholder="@lang('maximum')">
                </div>
            </div>
        </div>
    @endif
    @if (in_array(4, @$campaign->platformId ?? []))
        <div class="form-group common-style mb-4">
            <div class="create-header mb-4">
                <label class="form--label mb-0"> @lang('Follower Range On TikTok') <span class="text--danger">*</span></label>
            </div>
            <div class="row gy-3">
                <div class="col-sm-3 col-6">
                    <input class="form--control" name="follower[tiktok_start]" type="number" value="{{ old('follower.tiktok_start', @$campaign->influencer_requirements->follower_tiktok_start) }}" placeholder="@lang('minimum')">
                </div>
                <div class="col-sm-3 col-6">
                    <input class="form--control" name="follower[tiktok_end]" type="number" value="{{ old('follower.tiktok_end', @$campaign->influencer_requirements->follower_tiktok_end) }}" placeholder="@lang('maximum')">
                </div>
            </div>
        </div>
    @endif
    <div class="d-flex justify-content-between text-end">
        <button class="btn btn--gray preReqBtn" type="button"><i class="las la-arrow-left"></i> @lang('Back') </button>
        <button class="btn btn--base" type="submit"><i class="las la-arrow-right"></i> @lang('Next') </button>
    </div>
</form>


@push('script')
    <script>
        (function($) {
            "use strict";
            $('.select2').each(function(index, element) {
                $(element).select2();
            });
        })(jQuery)
    </script>
@endpush

