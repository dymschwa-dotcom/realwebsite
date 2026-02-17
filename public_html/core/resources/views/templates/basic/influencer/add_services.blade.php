@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="pt-80 pb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            @if($services->count() < 3)
                                <span class="badge bg-dark px-3 py-2 rounded-pill mb-3">@lang('Final Step')</span>
                                <h2 class="fw-bold">@lang('Create Your Content Packages')</h2>
                                <p class="text-muted">@lang('To complete your profile and go live, please add at least 3 packages.')</p>
                            @else
                                <span class="badge bg-dark px-3 py-2 rounded-pill mb-3">@lang('Manage Services')</span>
                                <h2 class="fw-bold">@lang('Update Your Packages')</h2>
                                <p class="text-muted">@lang('Modify your existing packages or add details below.')</p>
                            @endif
                        </div>

                        <form action="{{ route('influencer.services.save') }}" method="POST">
                            @csrf
                            <div class="row" id="package-container">
                                @php
                                    $countToShow = $services->count() < 3 ? 3 : $services->count();
                                @endphp

                                @for($i = 0; $i < $countToShow; $i++)
                                    @php $service = $services->get($i); @endphp
                                    <div class="col-12 mb-4 package-item">
                                        <div class="p-4 border rounded-4 {{ $service ? 'bg-white' : 'bg-light' }} shadow-none {{ $i < 3 ? 'core-package' : '' }}">
                                            @if($service)
                                                <input type="hidden" name="services[{{ $i }}][id]" value="{{ $service->id }}">
                                            @endif
                                            
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center item-number" style="width: 24px; height: 24px; font-size: 12px;">{{ $i + 1 }}</div>
                                                    <h5 class="fw-bold m-0">@lang('Package') #<span class="num">{{ $i + 1 }}</span></h5>
                                                    @if($i < 3)
                                                        <span class="badge badge--info border-0 fw-normal small">@lang('Required')</span>
                                                    @endif
                                                </div>
                                                
                                                @if($i >= 3 && $service)
                                                <a href="{{ route('influencer.services.delete', $service->id) }}" class="btn btn-sm btn--danger rounded-pill px-3 fw-bold text-white delete-btn-permanent">
                                                    <i class="las la-times"></i> @lang('Remove')
                                                </a>
                                                @endif
                                            </div>
                                            
                                            <div class="row gy-3">
                                                <div class="col-md-8">
                                                    <label class="form-label fw-bold small text-uppercase">@lang('Service Title')</label>
                                                    <input type="text" name="services[{{ $i }}][title]" class="form-control form-control-lg border-0 shadow-sm" value="{{ $service ? $service->title : '' }}" placeholder="e.g. 1x Instagram Post" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold small text-uppercase">@lang('Price ($)')</label>
                                                    <input type="number" name="services[{{ $i }}][price]" class="form-control form-control-lg border-0 shadow-sm" value="{{ $service ? getAmount($service->price) : '' }}" placeholder="0.00" step="0.01" required>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-bold small text-uppercase">@lang('Description')</label>
                                                    <textarea name="services[{{ $i }}][description]" class="form-control border-0 shadow-sm" rows="3" placeholder="What exactly will the brand receive?" required>{{ $service ? $service->description : '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            <div class="text-center mt-4 d-flex justify-content-center gap-3 flex-wrap">
                                {{-- Request: Add button made Red --}}
                                <button type="button" class="btn btn--danger px-4 py-3 rounded-pill fw-bold add-new-package shadow-sm">
                                    <i class="las la-plus"></i> @lang('Add Another Package')
                                </button>
                                <button type="submit" class="btn btn--pink px-5 py-3 rounded-pill fw-bold text-white shadow">
                                    @lang('Save Changes & Update Profile')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    body { background-color: #f8f9fa !important; }
    
    .btn--pink { 
        background-color: #ff3366; 
        border: none; 
        transition: all 0.3s ease;
    }
    .btn--pink:hover { 
        background-color: #e62e5c; 
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 51, 102, 0.3) !important;
    }
    
    .form-control:focus { 
        border-color: #ff3366; 
        box-shadow: 0 0 0 0.25 red !important;
    }
    .card { border-radius: 20px; }
    .bg-white { background-color: #ffffff !important; }

    .core-package {
        border: 1px solid #dee2e6 !important;
        border-left: 4px solid #ff3366 !important;
    }
    
    .badge--info {
        background-color: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
    }
</style>
@endpush

@push('script')
<script>
    (function($) {
        "use strict";

        let packageIndex = $('.package-item').length;

        $('.add-new-package').on('click', function() {
            let html = `
                <div class="col-12 mb-4 package-item">
                    <div class="p-4 border rounded-4 bg-light shadow-none">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center item-number" style="width: 24px; height: 24px; font-size: 12px;">${packageIndex + 1}</div>
                                <h5 class="fw-bold m-0">@lang('Package') #<span class="num">${packageIndex + 1}</span></h5>
                            </div>
                            <button type="button" class="btn btn-sm btn--danger remove-package-js rounded-pill px-3 fw-bold text-white">
                                <i class="las la-times"></i> @lang('Remove')
                            </button>
                        </div>
                        
                        <div class="row gy-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold small text-uppercase">@lang('Service Title')</label>
                                <input type="text" name="services[${packageIndex}][title]" class="form-control form-control-lg border-0 shadow-sm" placeholder="e.g. 1x TikTok Video" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-uppercase">@lang('Price ($)')</label>
                                <input type="number" name="services[${packageIndex}][price]" class="form-control form-control-lg border-0 shadow-sm" placeholder="0.00" step="0.01" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-uppercase">@lang('Description')</label>
                                <textarea name="services[${packageIndex}][description]" class="form-control border-0 shadow-sm" rows="3" placeholder="Description of this package" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#package-container').append(html);
            packageIndex++;
        });

        $(document).on('click', '.remove-package-js', function() {
            $(this).closest('.package-item').remove();
            $('.package-item').each(function(index) {
                $(this).find('.item-number').text(index + 1);
                $(this).find('.num').text(index + 1);
            });
            packageIndex = $('.package-item').length;
        });

    })(jQuery);
</script>
@endpush