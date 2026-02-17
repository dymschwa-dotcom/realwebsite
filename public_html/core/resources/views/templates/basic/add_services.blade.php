@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="pt-80 pb-80">
    <div class="container">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">@lang('Create Your Packages')</h2>
                    <p class="text-muted">@lang('You must add at least 3 packages to make your profile public.')</p>
                </div>

                <form action="{{ route('service.save') }}" method="POST">
                    @csrf
                    <div class="row">
                        
                        {{-- Package 1: Instagram Post --}}
                        <div class="col-12 mb-4">
                            <div class="p-4 border rounded-3 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold mb-0">@lang('Package #1')</h5>
                                    <span class="badge bg--pink text-white">@lang('Required')</span>
                                </div>
                                <div class="row gy-3">
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold">@lang('Package Title')</label>
                                        <input type="text" name="services[1][title]" class="form-control" placeholder="@lang('e.g. 1 x Instagram Post')" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">@lang('Price ($NZD)')</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0">{{ gs('cur_sym') }}</span>
                                            <input type="number" name="services[1][price]" class="form-control border-start-0 price-input" placeholder="0" step="1" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">@lang('Description')</label>
                                        <textarea name="services[1][description]" class="form-control" rows="2" placeholder="@lang('What will the brand get for this package?')" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Package 2: Instagram Reel --}}
                        <div class="col-12 mb-4">
                            <div class="p-4 border rounded-3 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold mb-0">@lang('Package #2')</h5>
                                    <span class="badge bg--pink text-white">@lang('Required')</span>
                                </div>
                                <div class="row gy-3">
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold">@lang('Package Title')</label>
                                        <input type="text" name="services[2][title]" class="form-control" placeholder="@lang('e.g. 1 x Instagram Reel')" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">@lang('Price ($NZD)')</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0">{{ gs('cur_sym') }}</span>
                                            <input type="number" name="services[2][price]" class="form-control border-start-0 price-input" placeholder="0" step="1" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">@lang('Description')</label>
                                        <textarea name="services[2][description]" class="form-control" rows="2" placeholder="@lang('What will the brand get for this package?')" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Package 3: Instagram Live --}}
                        <div class="col-12 mb-4">
                            <div class="p-4 border rounded-3 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold mb-0">@lang('Package #3')</h5>
                                    <span class="badge bg--pink text-white">@lang('Required')</span>
                                </div>
                                <div class="row gy-3">
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold">@lang('Package Title')</label>
                                        <input type="text" name="services[3][title]" class="form-control" placeholder="@lang('e.g. 1 x Instagram Live')" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">@lang('Price ($NZD)')</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0">{{ gs('cur_sym') }}</span>
                                            <input type="number" name="services[3][price]" class="form-control border-start-0 price-input" placeholder="0" step="1" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">@lang('Description')</label>
                                        <textarea name="services[3][description]" class="form-control" rows="2" placeholder="@lang('What will the brand get for this package?')" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn--pink px-5 py-3 rounded-pill fw-bold text-white shadow">
                            @lang('Save Packages & Go Live')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .btn--pink { background-color: #ff3366; border: none; transition: all 0.3s; }
    .btn--pink:hover { background-color: #e62e5c; transform: translateY(-2px); }
    .bg--pink { background-color: #ff3366 !important; }
    .form-control:focus { border-color: #ff3366; box-shadow: none; }
    .input-group-text { color: #ff3366; font-weight: bold; }
    
    /* Hide number input arrows for a cleaner '0' placeholder look */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    input[type=number] { -moz-appearance: textfield; }
</style>
@endpush

@push('script')
<script>
    (function($){
        "use strict";

        // STRICT PRICE VALIDATION
        // Block decimals, symbols, and commas in real-time
        $('.price-input').on('keydown input paste', function(e) {
            // Block the dot and comma keys
            if (e.key === '.' || e.key === ',') {
                e.preventDefault();
            }
            
            // Scrub non-numeric characters on paste or rapid typing
            let $this = $(this);
            setTimeout(function() {
                $this.val($this.val().replace(/[^0-9]/g, ''));
            }, 0);
        });

        // Ensure value is at least 0 and never empty on blur
        $('.price-input').on('blur', function() {
            let val = $(this).val();
            if(val === "" || parseInt(val) < 0) {
                $(this).val(0);
            }
        });

    })(jQuery);
</script>
@endpush