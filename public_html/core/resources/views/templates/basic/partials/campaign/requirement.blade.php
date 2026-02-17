<form id="requirementForm" action="{{ route('user.campaign.requirement', $campaign->slug ?? 'pending') }}" method="POST">
    @csrf

    <div class="form-group common-style mb-4">
    <div class="create-header mb-4">
        <label class="form--label mb-0">@lang('Required Number of Influencers') <span class="text--danger">*</span></label>
    </div>
    <div class="input-group product-qty mb-3">
        <span class="input-group-text product-qty__decrement" style="cursor: pointer"><i class="fas fa-minus"></i></span>
        
        {{-- This is the typeable number field --}}
        <input type="number" 
               name="required_influencer" 
               class="form-control product-qty__value text-center" 
               value="{{ old('required_influencer', @$campaign->influencer_requirements->required_influencer ?? 1) }}" 
               min="1" 
               required>
               
        <span class="input-group-text product-qty__increment" style="cursor: pointer"><i class="las la-plus"></i></span>
    </div>
</div>

    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0">@lang('Influencer Gender')<span class="text--danger">*</span></label>
        </div>
        <div class="d-flex flex-wrap gap-3">
            @foreach(['male', 'female', 'other'] as $gender)
            <div class="custom--check">
                <div class="d-flex gap-2">
                    <div class="form--check d-inline-block">
                        <input class="form-check-input" id="{{ $gender }}" name="gender[]" type="checkbox" value="{{ $gender }}" @checked(in_array($gender, (array)(old('gender', @$campaign->influencer_requirements->gender) ?? [])))>
                    </div>
                    <label class="title" for="{{ $gender }}">@lang(ucfirst($gender))</label>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @php
        $selectedPlatforms = $campaign->platforms->pluck('id')->toArray();
    @endphp

    {{-- Facebook (ID: 1) --}}
    @if (in_array(1, $selectedPlatforms))
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

    {{-- Instagram (ID: 2) --}}
    @if (in_array(2, $selectedPlatforms))
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

    <div class="d-flex justify-content-between text-end mt-4">
        <button class="btn btn--gray preReqBtn" type="button" data-pre="description"><i class="las la-arrow-left"></i> @lang('Back') </button>
        <button class="btn btn--base" type="submit">@lang('Next') <i class="las la-arrow-right"></i></button>
    </div>
</form>

<script>
    (function($) {
        "use strict";
        // Initialize select2 for newly loaded content
        $('.select2').select2({
            width: '100%',
            dropdownParent: $('#pills-requirement')
        });
        
        // Re-init qty buttons
        if(typeof productCount === 'function') productCount();
    })(jQuery)
</script>