@foreach ($categories as $category)
    <div class="col-12 col-xsm-6 col-sm-6 col-lg-4 col-xl-3">
        <a href="{{ route('influencer.all') }}?category[]={{ $category->slug }}" class="category-card-custom shadow-sm">
            <img src="{{ getImage(getFilePath('category') . '/' . $category->image, getFileSize('category')) }}" alt="{{ __($category->name) }}">
            <div class="category-card-overlay">
                <h5 class="category-card-title">{{ __($category->name) }}</h5>
            </div>
        </a>
    </div>
@endforeach

<style>
    .category-card-custom {
        position: relative;
        height: 280px;
        border-radius: 15px;
        overflow: hidden;
        display: block;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .category-card-custom img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }
    .category-card-custom:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
    }
    .category-card-custom:hover img {
        transform: scale(1.1);
    }
    .category-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 35%, rgba(0,0,0,0) 100%);
        display: flex;
        align-items: flex-end;
        padding: 25px;
    }
    .category-card-title {
        color: #fff;
        margin: 0;
        font-weight: 800;
        font-size: 1.25rem;
        letter-spacing: -0.5px;
    }
</style>

