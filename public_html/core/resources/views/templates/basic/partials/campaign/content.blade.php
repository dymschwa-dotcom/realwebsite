<form id="contentForm" action="{{ route('user.campaign.content', @$campaign->id) }}" method="POST">
    @csrf
    <div class="row gap-3">
        @if (in_array(1, @$campaign->platformId ?? []))
            <div class="platform__box">
                <div class="social-media">
                    <h6 class="d-flex gap-2">
                        <i class="fab fa-facebook"></i>
                        <span> @lang('Facebook')</span>
                    </h6>
                </div>
                <div class="form-group common-style mb-4">
                    <div class="create-header mb-4">
                        <label class="form--label mb-0">@lang('Content Type ?') <span
                                  class="text--danger">*</span></label>
                        <p class="campaign-desc">@lang('Select the ways in which your brand will be promoted on Facebook.')</p>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <div class="custom--check">
                            <label class="custom--check-label" for="facebook_type_photo"></label>
                            <div class="d-flex gap-2">
                                <div class="form--check d-inline-block">
                                    <input class="form-check-input" id="facebook_type_photo" name="facebook_type[]" type="checkbox" value="photo" @checked(in_array('photo', old('facebook_type', @$campaign->content_requirements->facebook_type) ?? []))>
                                </div>
                                <span class="title">@lang('Photo')</span>
                            </div>
                        </div>
                        <div class="custom--check">
                            <label class="custom--check-label" for="facebook_type_video"></label>
                            <div class="d-flex gap-2">
                                <div class="form--check d-inline-block">
                                    <input class="form-check-input" id="facebook_type_video" name="facebook_type[]" type="checkbox" value="video" @checked(in_array('video', old('facebook_type', @$campaign->content_requirements->facebook_type) ?? []))>
                                </div>
                                <span class="title">@lang('Video')</span>
                            </div>
                        </div>
                        <div class="custom--check">
                            <label class="custom--check-label" for="facebook_type_text"></label>
                            <div class="d-flex gap-2">
                                <div class="form--check d-inline-block">
                                    <input class="form-check-input" id="facebook_type_text" name="facebook_type[]" type="checkbox" value="text" @checked(in_array('text', old('facebook_type', @$campaign->content_requirements->facebook_type) ?? []))>
                                </div>
                                <span class="title">@lang('Text')</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group common-style mb-4">
                    <div class="create-header mb-4">
                        <label class="form--label mb-0">@lang('Content Placement ?') <span
                                  class="text--danger">*</span></label>
                        <p class="campaign-desc">@lang('Select the content place where the influencer will post content to promote your brand')</p>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <div class="custom--check">
                            <label class="custom--check-label" for="facebook_placement_post"></label>
                            <div class="d-flex gap-2">
                                <div class="form--check d-inline-block">
                                    <input class="form-check-input" id="facebook_placement_post" name="facebook_placement[]" type="checkbox" value="post" @checked(in_array('post', old('facebook_placement', @$campaign->content_requirements->facebook_placement) ?? []))>
                                </div>
                                <span class="title">@lang('Post')</span>
                            </div>
                        </div>
                        <div class="custom--check">
                            <label class="custom--check-label" for="facebook_placement_story"></label>
                            <div class="d-flex gap-2">
                                <div class="form--check d-inline-block">
                                    <input class="form-check-input" id="facebook_placement_story" name="facebook_placement[]" type="checkbox" value="story" @checked(in_array('story', old('facebook_placement', @$campaign->content_requirements->facebook_placement) ?? []))>
                                </div>
                                <span class="title">@lang('Story')</span>
                            </div>
                        </div>
                        <div class="custom--check">
                            <label class="custom--check-label" for="facebook_placement_reels"></label>
                            <div class="d-flex gap-2">
                                <div class="form--check d-inline-block">
                                    <input class="form-check-input" id="facebook_placement_reels" name="facebook_placement[]" type="checkbox" value="reels" @checked(in_array('reels', old('facebook_placement', @$campaign->content_requirements->facebook_placement) ?? []))>
                                </div>
                                <span class="title">@lang('Reels')</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="common-style border-0 p-0">
                    <div class="create-header mb-4">
                        <label class="form--label mb-0">@lang('Required number of posts or stories or reels on Facebook') <span class="text--danger">*</span></label>
                    </div>
                    <div class="input-group product-qty mb-3">
                        <span class="input-group-text product-qty__decrement"><i class="fas fa-minus"></i></span>
                        <input class="form-control product-qty__value" name="facebook_post_count" type="number" value="{{ old('facebook_post_count', @$campaign->content_requirements->facebook_post_count ?? 1) }}" required>
                        <span class="input-group-text product-qty__increment"><i class="las la-plus"></i></span>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array(2, @$campaign->platformId ?? []))
            <div class="platform__box">
                <div class="social-media">
                    <h6 class="d-flex gap-2">
                        <i class="fab fa-instagram"></i>
                        <span>@lang('Instagram')</span>
                    </h6>
                </div>
                <div class="form-group common-style mb-4">
                    <div class="create-header mb-4">
                        <label class="form--label mb-0">@lang('Content Type ?') <span
                                  class="text--danger">*</span></label>
                        <p class="campaign-desc">@lang('Select the ways in which your brand will be promoted on Instagram.')</p>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <div class="custom--check">
                            <label class="custom--check-label" for="instagram_type_photo"></label>
                            <div class="d-flex gap-2">
                                <div class="form--check d-inline-block">
                                    <input class="form-check-input" id="instagram_type_photo" name="instagram_type[]" type="checkbox" value="photo" @checked(in_array('photo', old('instagram_type', @$campaign->content_requirements->instagram_type) ?? []))>
                                </div>
                                <span class="title">@lang('Photo')</span>
                            </div>
                        </div>
                        <div class="custom--check">
                            <label class="custom--check-label" for="instagram_type_video"></label>
                            <div class="d-flex gap-2">
                                <div class="form--check d-inline-block">
                                    <input class="form-check-input" id="instagram_type_video" name="instagram_type[]" type="checkbox" value="video" @checked(in_array('video', old('instagram_type', @$campaign->content_requirements->instagram_type) ?? []))>
                                </div>
                                <span class="title">@lang('Video')</span>
                            </div>
                        </div>
                        <div class="custom--check">
                            <label class="custom--check-label" for="instagram_type_text"></label>
                            <div class="d-flex gap-2">
                                <div class="form--check d-inline-block">
                                    <input class="form-check-input" id="instagram_type_text" name="instagram_type[]" type="checkbox" value="text" @checked(in_array('text', old('instagram_type', @$campaign->content_requirements->instagram_type) ?? []))>
                                </div>
                                <span class="title">@lang('Text')</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group common-style mb-4">
                    <div class="create-header mb-4">
                        <label class="form--label mb-0">@lang('Content Placement ?') <span
                                  class="text--danger">*</span></label>
                        <p class="campaign-desc">@lang('Select the content place where the influencer will post content to promote your brand')</p>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <div class="custom--check">
                            <label class="custom--check-label" for="instagram_placement_post"></label>
                            <div class="d-flex gap-2">
                                <div class="form--check d-inline-block">
                                    <input class="form-check-input" id="instagram_placement_post" name="instagram_placement[]" type="checkbox" value="post" @checked(in_array('post', old('instagram_placement', @$campaign->content_requirements->instagram_placement) ?? []))>
                                </div>
                                <span class="title">@lang('Post')</span>
                            </div>
                        </div>
                        <div class="custom--check">
                            <label class="custom--check-label" for="instagram_placement_story"></label>
                            <div class="d-flex gap-2">
                                <div class="form--check d-inline-block">
                                    <input class="form-check-input" id="instagram_placement_story" name="instagram_placement[]" type="checkbox" value="story" @checked(in_array('story', old('instagram_placement', @$campaign->content_requirements->instagram_placement) ?? []))>
                                </div>
                                <span class="title">@lang('Story')</span>
                            </div>
                        </div>
                        <div class="custom--check">
                            <label class="custom--check-label" for="instagram_placement_reels"></label>
                            <div class="d-flex gap-2">
                                <div class="form--check d-inline-block">
                                    <input class="form-check-input" id="instagram_placement_reels" name="instagram_placement[]" type="checkbox" value="reels" @checked(in_array('reels', old('instagram_placement', @$campaign->content_requirements->instagram_placement) ?? []))>
                                </div>
                                <span class="title">@lang('Reels')</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="common-style border-0 p-0">
                    <div class="create-header mb-4">
                        <label class="form--label mb-0">@lang('Required number of posts or stories or reels on Instagram') <span class="text--danger">*</span></label>
                    </div>
                    <div class="input-group product-qty mb-3">
                        <span class="input-group-text product-qty__decrement"><i class="fas fa-minus"></i></span>
                        <input class="form-control product-qty__value" name="instagram_post_count" type="number" value="{{ old('instagram_post_count', @$campaign->content_requirements->instagram_post_count ?? 1) }}" required>
                        <span class="input-group-text product-qty__increment"><i class="las la-plus"></i></span>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array(3, @$campaign->platformId ?? []))
            <div class="platform__box">
                <div class="social-media">
                    <h6 class="d-flex gap-2">
                        <i class="fab fa-youtube"></i>
                        <span>@lang('Youtube')</span>
                    </h6>
                </div>
                <div class="form-group common-style mb-4">
                    <div class="create-header mb-4">
                        <label class="form--label mb-0">@lang('Content Type ?') <span
                                  class="text--danger">*</span></label>
                        <p class="campaign-desc">@lang('Select the ways in which your brand will be promoted on Facebook.')</p>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <div class="custom--check">
                            <label class="custom--check-label" for="youtube_type_video"></label>
                            <div class="d-flex gap-2">
                                <div class="form--check d-inline-block">
                                    <input class="form-check-input" id="youtube_type_video" name="youtube_placement[]" type="checkbox" value="video" @checked(in_array('video', old('youtube_placement', @$campaign->content_requirements->youtube_placement) ?? []))>
                                </div>
                                <span class="title">@lang('Video')</span>
                            </div>
                        </div>
                        <div class="custom--check">
                            <label class="custom--check-label" for="youtube_type_short_video"></label>
                            <div class="d-flex gap-2">
                                <div class="form--check d-inline-block">
                                    <input class="form-check-input" id="youtube_type_short_video" name="youtube_placement[]" type="checkbox" value="short_video" @checked(in_array('short_video', old('youtube_placement', @$campaign->content_requirements->youtube_placement) ?? []))>
                                </div>
                                <span class="title">@lang('Short Video')</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="common-style border-0 p-0">
                    <div class="create-header mb-4">
                        <label class="form--label mb-0">@lang('Required number of video on Youtube') <span class="text--danger">*</span></label>
                    </div>
                    <div class="input-group product-qty mb-3">
                        <span class="input-group-text product-qty__decrement"><i class="fas fa-minus"></i></span>
                        <input class="form-control product-qty__value" name="youtube_video_count" type="number" value="{{ old('youtube_video_count', @$campaign->content_requirements->youtube_video_count ?? 1) }}" required>
                        <span class="input-group-text product-qty__increment"><i class="las la-plus"></i></span>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array(4, @$campaign->platformId ?? []))
            <div class="platform__box">
                <div class="social-media">
                    <h6 class="d-flex gap-2">
                        <i class="fab fa-tiktok"></i>
                        <span>@lang('TikTok')</span>
                    </h6>
                </div>
                <div class="form-group common-style mb-4">
                    <div class="create-header mb-4">
                        <label class="form--label mb-0">@lang('Content Type ?') <span
                                  class="text--danger">*</span></label>
                        <p class="campaign-desc">@lang('Select the ways in which your brand will be promoted on TikTok.')</p>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <div class="custom--check">
                            <label class="custom--check-label" for="tiktok_type_video"></label>
                            <div class="d-flex gap-2">
                                <div class="form--check d-inline-block">
                                    <input class="form-check-input" id="tiktok_type_video" name="tiktok_type[]" type="checkbox" value="video" @checked(in_array('video', old('tiktok_type', @$campaign->content_requirements->tiktok_type) ?? []))>
                                </div>
                                <span class="title">@lang('Video')</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group common-style mb-4">
                    <div class="create-header mb-4">
                        <label class="form--label mb-0">@lang('Content Placement ?') <span
                                  class="text--danger">*</span></label>
                        <p class="campaign-desc">@lang('Select the content place where the influencer will post content to promote your brand')</p>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <div class="custom--check">
                            <label class="custom--check-label" for="tiktok_placement_video"></label>
                            <div class="d-flex gap-2">
                                <div class="form--check d-inline-block">
                                    <input class="form-check-input" id="tiktok_placement_video" name="tiktok_placement[]" type="checkbox" value="video" @checked(in_array('video', old('tiktok_placement', @$campaign->content_requirements->tiktok_placement) ?? []))>
                                </div>
                                <span class="title">@lang('Video')</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="common-style border-0 p-0">
                    <div class="create-header mb-4">
                        <label class="form--label mb-0">@lang('Required number of video on TikTok') <span class="text--danger">*</span></label>
                    </div>
                    <div class="input-group product-qty mb-3">
                        <span class="input-group-text product-qty__decrement"><i class="fas fa-minus"></i></span>
                        <input class="form-control product-qty__value" name="tiktok_video_count" type="number" value="{{ old('tiktok_video_count', @$campaign->content_requirements->tiktok_video_count ?? 1) }}" required>
                        <span class="input-group-text product-qty__increment"><i class="las la-plus"></i></span>
                    </div>
                </div>
            </div>
        @endif

        <div class="video-length-area d-none platform__box">
            <div class="common-style border-0 p-0">
                <div class="create-header mb-3">
                    <label class="form--label mb-0">@lang('Video Length') <span class="text--danger">*</span></label>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input class="form-control form--control" name="video_length" type="number" value="{{ old('video_length', @$campaign->content_requirements->video_length) }}">
                            <span class="input-group-text">@lang('minutes')</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between mt-4 text-end">
        <button class="btn btn--gray preContentBtn" type="button"> <i class="las la-arrow-left"></i> @lang('Previous')</button>
        <button class="btn btn--base" type="submit"> @lang('Next') <i class="las la-arrow-right"></i></button>
    </div>
</form>

@push('script')
    <script>
        "use strict";
        var checkboxes = [
            '#facebook_type_video',
            '#instagram_type_video',
            '#youtube_type_video',
            '#youtube_type_short_video',
                        '#tiktok_type_video'
        ];

        function toggleVideoLengthArea() {
            var videoLengthArea = $(".video-length-area");
            var isAnyCheckboxChecked = checkboxes.map(function(checkbox) {
                return $(checkbox).is(":checked");
            });

            if (isAnyCheckboxChecked.includes(true)) {
                videoLengthArea.removeClass("d-none");
            } else {
                videoLengthArea.addClass("d-none");
            }
        }
        $(document).on("change", checkboxes.join(", "), toggleVideoLengthArea)
        toggleVideoLengthArea();
    </script>
@endpush




