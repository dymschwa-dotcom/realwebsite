<div class="empty-results-wrapper py-5">
    <div class="animation-container mb-4">
        <div class="fun-search-animation">
            <div class="magnifying-glass">
                <div class="glass-inner"></div>
            </div>
            <div class="sparkles">
                <div class="sparkle one"></div>
                <div class="sparkle two"></div>
                <div class="sparkle three"></div>
            </div>
        </div>
    </div>
    <div class="content-container text-center">
        <h4 class="fw-bold text-dark mb-2">@lang('No matches found!')</h4>
        <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">
            @lang("We couldn't find any results matching your filters. Try shaking things up or expanding your search!")
        </p>
        <a href="{{ $resetRoute }}" class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm transition-all hover-scale">
            <i class="las la-undo-alt me-1"></i> @lang('Reset All Filters')
        </a>
    </div>
</div>

<style>
    .empty-results-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 400px;
        width: 100%;
    }

    /* Magnifying Glass Animation */
    .fun-search-animation {
        position: relative;
        width: 120px;
        height: 120px;
    }

    .magnifying-glass {
        position: absolute;
        width: 80px;
        height: 80px;
        border: 8px solid #000;
        border-radius: 50%;
        animation: searchFloat 3s ease-in-out infinite;
    }

    .magnifying-glass::after {
        content: '';
        position: absolute;
        bottom: -25px;
        right: -15px;
        width: 8px;
        height: 40px;
        background: #000;
        transform: rotate(-45deg);
        border-radius: 4px;
    }

    .glass-inner {
        position: absolute;
        top: 10%;
        left: 10%;
        width: 80%;
        height: 80%;
        background: rgba(0, 123, 255, 0.05);
        border-radius: 50%;
        overflow: hidden;
    }

    .glass-inner::before {
        content: '';
        position: absolute;
        top: 15%;
        left: 15%;
        width: 30%;
        height: 15%;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 20px;
        transform: rotate(-45deg);
    }

    /* Sparkles */
    .sparkles .sparkle {
        position: absolute;
        background: #ff385c;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        opacity: 0;
    }

    .sparkle.one { top: 10%; right: 10%; animation: twinkle 2s infinite 0.5s; }
    .sparkle.two { bottom: 20%; left: 0%; animation: twinkle 2s infinite 1.2s; }
    .sparkle.three { top: 40%; left: -20%; animation: twinkle 2s infinite 0.8s; }

    @keyframes searchFloat {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        25% { transform: translate(15px, -10px) rotate(5deg); }
        50% { transform: translate(-10px, 15px) rotate(-5deg); }
        75% { transform: translate(10px, 10px) rotate(3deg); }
    }

    @keyframes twinkle {
        0%, 100% { transform: scale(0); opacity: 0; }
        50% { transform: scale(1.5); opacity: 1; }
    }

    .hover-scale:hover {
        transform: scale(1.05);
    }
    
    .transition-all {
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
</style>
