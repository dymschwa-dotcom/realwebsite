@extends($activeTemplate . 'layouts.app')

@section('panel')
    <style>
        /* FIXED: Corrected the typo in the livewire loading selector */
        [livewire\:loading] { 
            display: none; 
        }
    </style>

    {{-- Alpine.js CDN --}}
    @push('style')
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @endpush

    @include('Template::partials.header')

    {{-- 
        FIXED: The breadcrumb is now hidden on the Home page 
        AND the Influencer Profile page for a cleaner look.
    --}}
    @if (!request()->routeIs('home') && !request()->routeIs('influencer.profile'))
        @include('Template::partials.breadcrumb')
    @endif

    {{-- Render page content --}}
    @yield('content')

    @include('Template::partials.footer')

    @include('Template::partials.cookie')
@endsection

@push('script')
    {{-- Livewire CDN Script --}}
    <script src="https://cdn.jsdelivr.net/gh/livewire/livewire@v2.x/dist/livewire.min.js"></script>
    
    <script>
        (function($) {
            "use strict";

            $('.select2').each(function(index, element) {
                $(element).select2();
            });

            $('.select2-basic').each(function(index, element) {
                $(element).select2({
                    dropdownParent: $(element).closest('.select2-parent')
                });
            });

            $(".select2-auto-tokenize").select2({
                tags: true,
                tokenSeparators: [","],
                width: "100%",
                closeOnSelect: false
            }).on('select2:select', function(e) {
                $(document).find('.select2-search__field').css('width', '0px')
            });

            $('input[name=code]').closest('.submit-form').find('.form-label').addClass('required');
        })(jQuery);
    </script>
@endpush