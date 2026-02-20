@extends($activeTemplate . 'layouts.app')

@section('panel')
    @include('Template::partials.header')

    @yield('content')

    @include('Template::partials.footer')

    @include('Template::partials.cookie')
@endsection


@push('script')
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
