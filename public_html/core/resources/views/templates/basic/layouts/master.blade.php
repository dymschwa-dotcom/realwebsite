@extends($activeTemplate . 'layouts.app')

@section('panel')
    @include('Template::partials.header')

    <div class="dashboard py-120 section-bg-two">
        <div class="container-fluid @if(isset($fullWidth)) px-0 @else px-lg-5 @endif">
            <div class="row">
                @if(!isset($fullWidth))
                <div class="col-xl-3 col-lg-4 d-none d-lg-block">
                    @if (auth()->guard('influencer')->check())
                        @include($activeTemplate . 'partials.influencer_sidebar')
                    @else
                        @include($activeTemplate . 'partials.brand_sidebar')
                    @endif
                </div>
                @endif
                <div class="@if(isset($fullWidth)) col-12 @else col-xl-9 col-lg-8 @endif">
                    <div class="dashboard-body @if(isset($fullWidth)) px-0 @endif">
                        <div class="dashboard-body__bar d-lg-none d-block">
                            <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
                        </div>

                        @stack('tab-nav')

                        @yield('content')

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('Template::partials.footer')
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            var inputElements = $('[type=text],[type=password],select,textarea');
            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input:not([type=checkbox]):not([type=hidden]), select, textarea'), function(i, element) {

                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }

            });


            $('.showFilterBtn').on('click', function() {
                $('.responsive-filter-card').slideToggle();
            });


            Array.from(document.querySelectorAll('table')).forEach(table => {
                let heading = table.querySelectorAll('thead tr th');
                Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                    Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                        colum.setAttribute('data-label', heading[i].innerText)
                    });
                });
            });


            let disableSubmission = false;
            $('.disableSubmission').on('submit', function(e) {
                if (disableSubmission) {
                    e.preventDefault()
                } else {
                    disableSubmission = true;
                }
            });
        })(jQuery);
    </script>
@endpush
