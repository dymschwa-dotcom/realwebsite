@forelse ($influencers as $influencer)
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="influencer-minimal-card mb-4">
            <div class="influencer-img-container position-relative shadow-sm border">
                <a href="{{ route('influencer.profile', $influencer->username) }}">
                    <img src="{{ getImage(getFilePath('influencer') . '/' . $influencer->image, getFileSize('influencer')) }}" 
                         alt="{{ __($influencer->fullname) }}" 
                         class="influencer-hero-img">
                </a>
                
                {{-- Top Badges --}}
                <div class="rating-mini-badge">
                    <i class="las la-star"></i>
                    <span>{{ getAmount($influencer->rating) }}</span>
                </div>
                
                <div class="platform-badge-group">
                    @foreach ($influencer->socialLink->take(2) as $social)
                        <div class="platform-mini-badge">
                            @php echo $social->platform->icon @endphp
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Info Underneath --}}
            <div class="influencer-info-bottom mt-2 px-1">
                <div class="d-flex justify-content-between align-items-start w-100">
                    <div class="overflow-hidden pe-2">
                        <h6 class="text-dark fw-bold mb-0 text-truncate">{{ $influencer->firstname }}</h6>
                        <span class="text-muted small text-truncate d-block">
                            {{ $influencer->categories->first()?->name }}
                        </span>
                    </div>
                    <div class="text-dark fw-bold small whitespace-nowrap">
                        {{ showAmount($influencer->packages->min('price')) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12 text-center py-5">
        <div class="empty-state">
            <img src="{{ getImage('assets/images/frontend/empty_data/empty.png') }}" alt="empty" style="width: 100px; opacity: 0.3;">
            <p class="text-muted mt-3">@lang('No influencers match your current filters.')</p>
        </div>
    </div>
@endforelse

<style>
    .influencer-minimal-card {
        background: transparent;
        border: none;
    }
    .influencer-img-container {
        width: 100%;
        aspect-ratio: 16 / 10;
        overflow: hidden;
        border-radius: 16px !important;
        background: #fff;
        position: relative;
    }
    .influencer-hero-img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        object-position: center 20% !important;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: block;
    }
    .influencer-minimal-card:hover .influencer-hero-img {
        transform: scale(1.1);
    }
    .rating-mini-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(255, 255, 255, 0.95);
        padding: 4px 10px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        font-weight: 800;
        color: #000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        z-index: 3;
    }
    .rating-mini-badge i {
        color: #ffb400;
        font-size: 14px;
    }
    .platform-badge-group {
        position: absolute;
        top: 12px;
        left: 12px;
        display: flex;
        gap: 6px;
        z-index: 3;
    }
    .platform-mini-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        color: #fff;
        border: 1px solid rgba(255,255,255,0.3);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .whitespace-nowrap { white-space: nowrap; }
    .influencer-info-bottom {
        padding-top: 5px;
    }
</style>
