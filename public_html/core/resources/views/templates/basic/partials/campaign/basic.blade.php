<form method="POST" id="basicForm" enctype="multipart/form-data">
    @csrf

    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0"> @lang('Campaign Type') <span class="text--danger">*</span></label>
            <p class="campaign-desc">@lang('General campaigns are open to all influencers, while Invite campaigns require brand invitations for participation.')</p>
        </div>

        <div class="d-flex flex-wrap gap-3">
            <div class="custom--check">
                <label class="custom--check-label" name="campaign_type" for="invite"></label>
                <div class="d-flex gap-2">
                    <div class="form--check d-inline-block">
                        <input class="form-check-input" id="invite" name="campaign_type" type="radio" value="general" @checked(old('campaign_type', @$campaign->campaign_type) == 'general')>
                    </div>
                    <span class="title">@lang('General Campaign')</span>
                </div>
            </div>
            <div class="custom--check">
                <label class="custom--check-label" name="campaign_type" for="general"></label>
                <div class="d-flex gap-2">
                    <div class="form--check d-inline-block">
                        <input class="form-check-input" id="general" name="campaign_type" type="radio" value="invite" @checked(old('campaign_type', @$campaign->campaign_type) == 'invite')>
                    </div>
                    <span class="title">@lang('Invite-Only Campaign')</span>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0">@lang('Payment Type') <span
                      class="text--danger">*</span></label>
            <p class="campaign-desc"> @lang('Influencers have the option to participate in either Paid campaigns or Gift campaigns')
            </p>
        </div>
        <div class="d-flex flex-wrap gap-3">
            <div class="custom--check">
                <label class="custom--check-label" for="paid"></label>
                <div class="d-flex gap-2">
                    <div class="form--check d-inline-block">
                        <input class="form-check-input" id="paid" name="payment_type" type="radio" value="paid" @checked(old('payment_type', @$campaign->payment_type) == 'paid')>
                    </div>
                    <span class="title">@lang('Paid')</span>
                </div>
            </div>
            <div class="custom--check">
                <label class="custom--check-label" for="giveway"></label>
                <div class="d-flex gap-2">
                    <div class="form--check d-inline-block">
                        <input class="form-check-input" id="giveway" name="payment_type" type="radio" value="giveway" @checked(old('payment_type', @$campaign->payment_type) == 'giveway')>
                    </div>
                    <span class="title">@lang('Free Giveaway')</span>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label required mb-0" for="title">@lang('Campaign Title')</label>
            <p class="campaign-desc">@lang('Write the campaign title so that the influences understand what you really want?')</p>
        </div>
        <input class="form-control form--control" id="title" name="title" type="text" value="{{ old('title', @$campaign->title) }}" required>
    </div>

    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0">@lang('Platform') <span class="text--danger">*</span></label>
            <p class="campaign-desc">@lang('Platform means on which platform you want to promote your brand')</p>
        </div>
        <div class="flex-wrap gap-3">
            @foreach ($allPlatform as $platform)
                <div class="custom--check">
                    <label class="custom--check-label" for="{{ $platform->name }}"></label>
                    <div class="d-flex align-items-center gap-2">
                        <div class="form--check d-inline-block">
                            <input class="form-check-input" id="{{ $platform->name }}" name="platform[]" type="checkbox" value="{{ $platform->id }}" @checked(in_array($platform->id, old('platform', @$campaign->platformId) ?? []))>
                        </div>
                        <span class="title">{{ $platform->name }}
                            @php echo $platform->icon @endphp
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0"> @lang('What are you promoting?') <span class="text--danger">*</span></label>
            <p class="campaign-desc">@lang('Select the product type for the campaign')</p>
        </div>
        <div class="d-flex flex-wrap gap-3">
            <div class="custom--check">
                <label class="custom--check-label" name="promoting_type" for="physical"></label>
                <div class="d-flex gap-2">
                    <div class="form--check d-inline-block">
                        <input class="form-check-input" id="physical" name="promoting_type" type="radio" value="physical" @checked(old('promoting_type', @$campaign->promoting_type) == 'physical')>
                    </div>
                    <span class="title">@lang('Physical Product')</span>
                </div>
            </div>
            <div class="custom--check">
                <label class="custom--check-label" name="promoting_type" for="digital"></label>
                <div class="d-flex gap-2">
                    <div class="form--check d-inline-block">
                        <input class="form-check-input" id="digital" name="promoting_type" type="radio" value="digital" @checked(old('promoting_type', @$campaign->promoting_type) == 'digital')>
                    </div>
                    <span class="title">@lang('Digital Product')</span>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0"> @lang('Will you be sending product to the influencer?') <span class="text--danger">*</span></label>
            <p class="campaign-desc">@lang('If you want to promote products with content you create, you can give content to influencer')</p>
        </div>
        <div class="d-flex flex-wrap gap-3">
            <div class="custom--check">
                <label class="custom--check-label" name="send_product" for="yes"></label>
                <div class="d-flex gap-2">
                    <div class="form--check d-inline-block">
                        <input class="form-check-input" id="yes" name="send_product" type="radio" value="yes" @checked(old('send_product', @$campaign->send_product) == 'yes')>
                    </div>
                    <span class="title">@lang('Yes')</span>
                </div>
            </div>

            <div class="custom--check">
                <label class="custom--check-label" name="send_product" for="no"></label>
                <div class="d-flex gap-2">
                    <div class="form--check d-inline-block">
                        <input class="form-check-input" id="no" name="send_product" type="radio" value="no" @checked(old('send_product', @$campaign->send_product) == 'no')>
                    </div>
                    <span class="title">@lang('No')</span>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group common-style monetary-value @if (@$campaign->send_product != 'yes') d-none @endif">
        <div class="row gy-2 align-items-center">
            <div class="col-md-12">
                <label class="form--label">@lang('Sending Product Value')</label>
                <p class="campaign-desc">@lang('If you want to send a product to the influencer, give the product price')</p>
                <div class="input-group mt-2">
                    <input class="form-control form--control" name="monetary_value" type="number" step="any" value="{{ old('monetary_value', getAmount(@$campaign->monetary_value)) }}">
                    <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0"> @lang('Who will create the content?') <span class="text--danger">*</span></label>
            <p class="campaign-desc">
                @lang('Product promotion campaigns involve content that influencers will use to showcase and discuss your product. You have the choice to either provide the content yourself or let the influencer create it according to their style and audience')
            </p>
        </div>
        <div class="d-flex flex-wrap gap-3">
            <div class="custom--check">
                <label class="custom--check-label" name="influencer" for="influencer"></label>
                <div class="d-flex gap-2">
                    <div class="form--check d-inline-block">
                        <input class="form-check-input" id="influencer" name="content_creator" type="radio" value="influencer" @checked(old('content_creator', @$campaign->content_creator) == 'influencer')>
                    </div>
                    <span class="title">@lang('Influencer')</span>
                </div>
            </div>

            <div class="custom--check">
                <label class="custom--check-label" name="influencer" for="yourself"></label>
                <div class="d-flex gap-2">
                    <div class="form--check d-inline-block">
                        <input class="form-check-input" id="yourself" name="content_creator" type="radio" value="yourself" @checked(old('content_creator', @$campaign->content_creator) == 'yourself')>
                    </div>
                    <span class="title">@lang('Yourself')</span>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group common-style yourself-content d-none @if (@$campaign->content_creator != 'yourself') d-none @endif mb-4"">
        <div class="row gy-2 align-items-center">
            <div class="col-12">
                <label class="form--label mb-0">@lang('Upload Content')</label>
                <p class="campaign-desc">@lang('if you provide the content then upload it. obviously, the content type will be .pdf, .doc, .docx, .txt, .jpg, .jpeg, .png, .zip')</p>
                <div class="mt-3">
                    <input class="form--control" name="content" type="file" accept="png,.jpg,.jpeg,.pdf,.doc,.docx,.txt,.zip">
                </div>
            </div>
        </div>
    </div>

    <div class="form-group common-style mb-4">
        <div class="create-header mb-4">
            <label class="form--label mb-0">@lang('Campaign Thumbnail')</label>
            <p class="campaign-desc">@lang('Upload the campaign thumbnail')</p>
        </div>
        <div class="campaign-box-image">
            <x-image-uploader class="w-100" type="campaign" image="{{ @$campaign->image }}" labelBg="bg--base text-white" :required=false />
        </div>
    </div>
    <div class="text-end">
        <button class="btn btn--base" type="submit"><i class="las la-arrow-right"></i> @lang('Next')</button>
    </div>

</form>

@push('script')
    <script>
        (function($) {
            "use strict";
            $(document).on('change', '[name=send_product]', function(e) {
                if ($(this).val() == 'yes') {
                    $('.monetary-value').removeClass('d-none');
                } else {
                    $('.monetary-value').addClass('d-none');
                }
            }).change();

            $(document).on('change', '[name=content_creator]', function(e) {
                if ($(this).val() == 'influencer') {
                    $('.yourself-content').addClass('d-none');
                } else {
                    $('.yourself-content').removeClass('d-none');
                }
            }).change();
        })(jQuery)
    </script>
@endpush
