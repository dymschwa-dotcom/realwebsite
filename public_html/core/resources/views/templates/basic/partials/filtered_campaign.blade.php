@forelse ($campaigns as $campaign)
    @php
        $fallbacks = [
            'fashion'   => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=800&auto=format&fit=crop',
            'lifestyle' => 'https://images.unsplash.com/photo-1511895426328-dc8714191300?q=80&w=800&auto=format&fit=crop',
            'tech'      => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=800&auto=format&fit=crop',
            'beauty'    => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?q=80&w=800&auto=format&fit=crop',
            'food'      => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=800&auto=format&fit=crop',
            'travel'    => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=800&auto=format&fit=crop',
            'fitness'   => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=800&auto=format&fit=crop',
        ];
        
        $randomPool = [
            'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=800&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1557804506-669a67965ba0?q=80&w=800&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=800&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=800&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1523240715639-9a67105471f0?q=80&w=800&auto=format&fit=crop'
        ];

        $campaignImage = $campaign->image ? getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) : null;

        if (!$campaignImage || str_contains($campaignImage, 'default.png') || str_contains($campaignImage, 'placeholder')) {
            $firstCategory = $campaign->categories->first()?->slug;
            if (isset($fallbacks[$firstCategory])) {
                $campaignImage = $fallbacks[$firstCategory];
            } else {
                $campaignImage = $randomPool[$loop->index % count($randomPool)];
            }
        }
    @endphp

    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="campaign-minimal-card mb-4">
            <div class="campaign-img-container position-relative shadow-sm border">
                <a href="{{ route('campaign.detail', [slug($campaign->title), $campaign->id]) }}">
                    <img src="{{ $campaignImage }}" 
                         alt="{{ __($campaign->title) }}" 
                         class="campaign-hero-img">
                </a>
                
                {{-- Bottom Info Overlay --}}
                <div class="card-overlay-bottom">
                    <h6 class="text-white fw-bold mb-0 text-truncate">{{ __($campaign->title) }}</h6>
                    <span class="text-white-50 small text-truncate d-block">
                        {{ $campaign->categories->first()?->name ?? 'Campaign' }}
                    </span>
                </div>

                {{-- Platform Badges Overlay --}}
                <div class="platform-badge-group">
                    @foreach ($campaign->platforms as $platform)
                        <div class="platform-mini-badge">
                            @php echo $platform->icon @endphp
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12 text-center py-5">
        <div class="empty-state">
            <img src="{{ getImage('assets/images/frontend/empty_data/empty.png') }}" alt="empty" style="width: 100px; opacity: 0.3;">
            <p class="text-muted mt-3">@lang('No campaigns match your current filters.')</p>
        </div>
    </div>
@endforelse

<style>
    .campaign-minimal-card {
        background: transparent;
        border: none;
    }
    .campaign-img-container {
        width: 100%;
        aspect-ratio: 16 / 10;
        overflow: hidden;
        border-radius: 16px !important;
        background: #000;
        position: relative;
    }
    .campaign-hero-img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: block;
    }
    .campaign-minimal-card:hover .campaign-hero-img {
        transform: scale(1.1);
    }
    .card-overlay-bottom {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 30px 15px 15px;
        background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0) 100%);
        z-index: 2;
        pointer-events: none;
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
    }
</style>


