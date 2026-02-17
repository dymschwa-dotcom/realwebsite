<div class="tab-pane fade show active" id="pills-content" role="tabpanel" aria-labelledby="pills-content-tab">
    {{-- Null Shield: Use 'pending' if slug is missing to prevent 500 error on route generation --}}
    <form id="contentForm" action="{{ route('user.campaign.content', $campaign->slug ?? 'pending') }}" method="POST">
        @csrf
        <div class="row gap-3">
            
            @php
                // Safely get platform IDs
                $platformIds = $campaign->platforms ? $campaign->platforms->pluck('id')->toArray() : [];
                
                // Safely decode requirements if they aren't already an object (failsafe for manual encoding)
                $requirements = $campaign->content_requirements;
                if (is_string($requirements)) {
                    $requirements = json_decode($requirements);
                }
            @endphp

            {{-- Facebook Section (ID: 1) --}}
            @if (in_array(1, $platformIds))
                <div class="platform__box">
                    <div class="social-media">
                        <h6 class="d-flex gap-2">
                            <i class="fab fa-facebook text--facebook"></i>
                            <span> @lang('Facebook')</span>
                        </h6>
                    </div>
                    <div class="form-group common-style mb-4">
                        <div class="create-header mb-4">
                            <label class="form--label mb-0">@lang('Content Type ?') <span class="text--danger">*</span></label>
                            <p class="campaign-desc">@lang('Select the ways in which your brand will be promoted on Facebook.')</p>
                        </div>

                        <div class="d-flex flex-wrap gap-3">
                            @foreach(['photo', 'video', 'text'] as $type)
                                <div class="custom--check">
                                    <div class="d-flex gap-2">
                                        <div class="form--check d-inline-block">
                                            <input class="form-check-input" id="facebook_type_{{ $type }}" name="facebook_type[]" type="checkbox" value="{{ $type }}" 
                                                @checked(in_array($type, (array)(@$requirements->facebook_type ?? [])))>
                                        </div>
                                        <label class="title" for="facebook_type_{{ $type }}">@lang(ucfirst($type))</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group common-style mb-4">
                        <div class="create-header mb-4">
                            <label class="form--label mb-0">@lang('Content Placement ?') <span class="text--danger">*</span></label>
                            <p class="campaign-desc">@lang('Where will the influencer post?')</p>
                        </div>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach(['post', 'story', 'reels'] as $place)
                                <div class="custom--check">
                                    <div class="d-flex gap-2">
                                        <div class="form--check d-inline-block">
                                            <input class="form-check-input" id="facebook_placement_{{ $place }}" name="facebook_placement[]" type="checkbox" value="{{ $place }}" 
                                                @checked(in_array($place, (array)(@$requirements->facebook_placement ?? [])))>
                                        </div>
                                        <label class="title" for="facebook_placement_{{ $place }}">@lang(ucfirst($place))</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="common-style border-0 p-0">
                        <label class="form--label">@lang('Required Facebook Post Count')</label>
                        <div class="input-group product-qty mb-3">
                            <span class="input-group-text product-qty__decrement"><i class="fas fa-minus"></i></span>
                            <input class="form-control product-qty__value" name="facebook_post_count" type="number" value="{{ @$requirements->facebook_post_count ?? 1 }}" required min="1">
                            <span class="input-group-text product-qty__increment"><i class="las la-plus"></i></span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Instagram Section (ID: 2) --}}
            @if (in_array(2, $platformIds))
                <div class="platform__box">
                    <div class="social-media">
                        <h6 class="d-flex gap-2">
                            <i class="fab fa-instagram text--instagram"></i>
                            <span>@lang('Instagram')</span>
                        </h6>
                    </div>
                    
                    <div class="form-group common-style mb-4">
                        <div class="create-header mb-4">
                            <label class="form--label mb-0">@lang('Content Type ?')</label>
                        </div>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach(['photo', 'video', 'text'] as $type)
                                <div class="custom--check">
                                    <div class="d-flex gap-2">
                                        <div class="form--check d-inline-block">
                                            <input class="form-check-input" id="instagram_type_{{ $type }}" name="instagram_type[]" type="checkbox" value="{{ $type }}" 
                                                @checked(in_array($type, (array)(@$requirements->instagram_type ?? [])))>
                                        </div>
                                        <label class="title" for="instagram_type_{{ $type }}">@lang(ucfirst($type))</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="common-style border-0 p-0">
                        <label class="form--label">@lang('Required Instagram Post Count')</label>
                        <div class="input-group product-qty mb-3">
                            <span class="input-group-text product-qty__decrement"><i class="fas fa-minus"></i></span>
                            <input class="form-control product-qty__value" name="instagram_post_count" type="number" value="{{ @$requirements->instagram_post_count ?? 1 }}" required min="1">
                            <span class="input-group-text product-qty__increment"><i class="las la-plus"></i></span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Video Length (Conditional Area) --}}
            <div class="video-length-area d-none platform__box">
                <div class="common-style border-0 p-0">
                    <div class="create-header mb-3">
                        <label class="form--label mb-0">@lang('Video Length') <span class="text--danger">*</span></label>
                    </div>
                    <div class="input-group">
                        <input class="form-control form--control" name="video_length" type="number" value="{{ @$requirements->video_length }}">
                        <span class="input-group-text">@lang('minutes')</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <button class="btn btn--gray preContentBtn" type="button" data-pre="basic"> 
                <i class="las la-arrow-left"></i> @lang('Previous')
            </button>
            <button class="btn btn--base" type="submit"> 
                @lang('Next') <i class="las la-arrow-right"></i>
            </button>
        </div>
    </form>
</div>

<script>
    (function($){
        "use strict";
        
        // Define the video checkboxes
        var checkboxes = [
            '#facebook_type_video',
            '#instagram_type_video'
        ];

        function toggleVideoLengthArea() {
            var isChecked = checkboxes.some(selector => $(selector).is(":checked"));
            if (isChecked) {
                $(".video-length-area").removeClass("d-none");
            } else {
                $(".video-length-area").addClass("d-none");
            }
        }

        // Attach event listener using delegation to ensure it works with AJAX loaded HTML
        $(document).on("change", checkboxes.join(", "), toggleVideoLengthArea);
        
        // Run once on load
        toggleVideoLengthArea();
        
        // Re-initialize UI helpers
        if(typeof productCount === 'function') productCount();
        
    })(jQuery);
</script>