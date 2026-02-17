@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="categories py-120">
        <div class="container">
            <div class="categories-wrapper">
                <div class="row gy-4 justify-content-center">
                    @include($activeTemplate . 'partials.filtered_category')
                </div>
            </div>
            {{ paginateLinks($categories) }}
        </div>
    </div>
    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
