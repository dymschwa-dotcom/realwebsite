@foreach ($influencers as $influencer)
    <div class="col-xl-3 col-lg-4 col-sm-6 col-xsm-6 mb-4">
        <div class="collabstr-minimal-card">
            <a href="{{ route('influencer.profile', slug($influencer->username)) }}" class="d-block">
                <div class="influencer-image-container">
                    {{-- FIXED: Removed manual 'thumb_' string. getImage handles the pathing correctly using the filename and size --}}
                    <img src="{{ getImage(getFilePath('influencer') . '/' . $influencer->image, getFileSize('influencer'), true) }}" class="influencer-img" alt="{{ $influencer->fullname }}">

                    {{-- Favorite Heart (Top Right) --}}
                    @auth
                        <span class="favoriteBtn @if(in_array($influencer->id, @$favoriteInfluencer)) active @endif" data-influencer_id="{{ $influencer->id }}">
                            <i class="las la-heart"></i>
                        </span>
                    @endauth

                    {{-- The Bottom Overlay (Icons, Name, City) --}}
                    <div class="influencer-overlay">
                        {{-- Social Platform Icons --}}
                        <div class="overlay-platforms">
                            @foreach ($influencer->socialLinks->take(3) as $social)
                                <span class="platform-dot">
                                    @php echo @$social->platform->icon; @endphp
                                </span>
                            @endforeach
                        </div>

                        {{-- Name & Location --}}
                        <h6 class="overlay-name">
                            {{ $influencer->fullname }}
                            {{-- VERIFIED WORKFLOW: Display badge if influencer is KYC verified --}}
                            @if($influencer->kv == 1)
                                <i class="las la-check-circle text--info" title="@lang('Verified Influencer')"></i>
                            @endif
                        </h6>
                        <p class="overlay-location">{{ $influencer->city }}{{ $influencer->city ? ',' : '' }} {{ __($influencer->country_name) }}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endforeach

@push('style')
<style>
    .collabstr-minimal-card {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        line-height: 0;
    }

    .influencer-image-container {
        position: relative;
        aspect-ratio: 1 / 1.1;
        width: 100%;
    }

    .influencer-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .favoriteBtn {
        position: absolute;
        top: 10px;
        right: 10px;
        color: rgba(255, 255, 255, 0.9);
        font-size: 20px;
        z-index: 5;
        cursor: pointer;
        text-shadow: 0 1px 3px rgba(0,0,0,0.5);
    }
    .favoriteBtn.active { color: #ff385c; }

    .influencer-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 15px;
        z-index: 2;
        line-height: 1.2;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.4));
    }

    .overlay-platforms {
        display: flex;
        gap: 5px;
        margin-bottom: 5px;
    }

    .platform-dot {
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 10px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .overlay-name {
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 1px 2px rgba(0,0,0,0.8);
    }

    .overlay-name i {
        font-size: 15px;
        margin-left: 3px;
        vertical-align: middle;
    }

    .overlay-location {
        color: rgba(255, 255, 255, 0.9);
        font-size: 11px;
        margin: 0;
        text-shadow: 0 1px 2px rgba(0,0,0,0.8);
    }
    
    .text--info {
        color: #0dcaf0 !important;
    }
</style>
@endpush