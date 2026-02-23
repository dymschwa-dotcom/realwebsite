@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="d-flex align-items-center justify-content-end flex-wrap pb-3 gap-3">
        <div class="campaign-participant-status">
                        <select class="form--control select2" data-minimum-results-for-search="-1" name="status">
                <option value="all">@lang('All')</option>
                <option value="inquiry" @selected(request()->status == 'inquiry')>@lang('Inquiry')</option>
                <option value="proposal" @selected(request()->status == 'proposal')>@lang('Proposal')</option>
                <option value="pending" @selected(request()->status == 'pending')>@lang('Pending')</option>
                <option value="accepted" @selected(request()->status == 'accepted')>@lang('Accepted')</option>
                <option value="delivered" @selected(request()->status == 'delivered')>@lang('Delivered')</option>
                <option value="completed" @selected(request()->status == 'completed')>@lang('Completed')</option>
                <option value="refunded" @selected(request()->status == 'refunded')>@lang('Refunded')</option>
                <option value="cancelled" @selected(request()->status == 'cancelled')>@lang('Cancelled')</option>
                <option value="reported" @selected(request()->status == 'reported')>@lang('Reported')</option>
                <option value="rejected" @selected(request()->status == 'rejected')>@lang('Rejected')</option>
            </select>
        </div>
    </div>
<!--
    <div class="dashbaord-table-header">
        <div class="custom--tab nav template-tabs p-0 m-0">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" type="button">@lang('Campaigns')</button>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="{{ route('influencer.campaign.invite') }}">@lang('Invite Campaigns')</a>
            </li>
            <li class="outline-background"></li>
        </div> 
        <div class="dashbaord-table-header-right d-flex flex-wrap gap-3">
            <form class="search-form active">
                <input class="form--control" name="search" type="search" value="{{ request()->search }}" placeholder="@lang('Search...')">
                <button class="search-form__btn" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div> -->
    <!-- SECTION 1: CAMPAIGNS (General Casting Calls) -->
    @if($generalCampaigns->count() > 0)
    <h5 class="mb-3">@lang('Campaigns')</h5>
    <div class="card custom--card mb-5">
        <div class="card-body p-0">
            <div class="table-responsive--md table-responsive">
                <table class="table custom--table">
                    <thead>
                        <tr>
                            <th>@lang('Title')</th>
                            <th>@lang('Brand')</th>
                            <th>@lang('Budget')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($generalCampaigns as $p)
                        <tr>
                            <td>
                                <span class="fw-bold">{{ __($p->campaign->title) }}</span>
                            </td>
                            <td>
                                <span>{{ @$p->campaign->user->brand_name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span>{{ showAmount($p->budget) }}</span>
                            </td>
                            <td>
                                @php echo $p->statusBadge; @endphp
                            </td>
                            <td>
                                <a href="{{ route('influencer.campaign.detail', $p->id) }}" class="btn btn--sm btn--base outline" data-bs-toggle="tooltip" title="@lang('View Detail')">
                                    <i class="las la-desktop"></i>
                                </a>
                                <a href="{{ route('influencer.campaign.conversation.inbox', $p->id) }}" class="btn btn--sm btn--info outline" data-bs-toggle="tooltip" title="@lang('Chat')">
                                    <i class="las la-comments"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- SECTION 2: DIRECT RELATIONSHIPS -->
    <h5 class="mb-3">@lang('My Brands')</h5>
    <div class="accordion custom--accordion" id="brandAccordion">
        @forelse($directWorkstreams as $brandId => $jobs)
            @php 
                $brand = $jobs->first()->campaign->user; 
            @endphp

            <div class="accordion-item crm-card shadow-sm mb-3 border-0">
                <div class="accordion-header" id="heading{{ $brandId }}">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-6 d-flex align-items-center gap-3">
                                <button class="accordion-button collapsed p-0 bg-transparent border-0 shadow-none w-auto" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $brandId }}" aria-expanded="false" aria-controls="collapse{{ $brandId }}">
                                </button>
                                <img src="{{ getImage(getFilePath('brand') . '/' . $brand->image, null, true) }}" 
                                     class="rounded-circle shadow-sm border" style="width: 50px; height: 50px; object-fit: cover;">
                                <div>
                                    <h6 class="m-0">{{ $brand->brand_name ?? $brand->username }}</h6>
                                    <span class="text-muted small">@lang('Brand')</span>
                                </div>
        </div>
                            <div class="col-md-6 text-end d-flex justify-content-end align-items-center gap-3">
                                <a href="{{ route('influencer.campaign.conversation.inbox', $jobs->first()->id) }}" 
                                   class="btn btn--base px-4">
                                    <i class="las la-comments"></i> @lang('Open Workspace')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="collapse{{ $brandId }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $brandId }}" data-bs-parent="#brandAccordion">
                    <div class="accordion-body pt-0 px-4 pb-4">
                        <hr class="mt-0">
                        <div class="table-responsive">
                            <table class="table table-sm custom--table">
                                <thead>
                                    <tr>
                                        <th>@lang('Project Title')</th>
                                        <th>@lang('Budget')</th>
                                        <th>@lang('Status')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobs as $job)
                                    <tr>
                                        <td>{{ strLimit($job->campaign->title, 40) }}</td>
                                        <td>{{ showAmount($job->budget) }}</td>
                                        <td>@php echo $job->statusBadge; @endphp</td>
                                        <td>
                                            <a href="{{ route('influencer.campaign.conversation.inbox', $job->id) }}" class="btn btn--sm btn--base outline" data-bs-toggle="tooltip" title="@lang('View Workspace')">
                                                <i class="las la-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <p class="text-muted">@lang('No active relationships yet.')</p>
            </div>
        @endforelse
    </div>

    @if ($participates->hasPages())
        <div class="mt-4">
            {{ paginateLinks($participates) }}
        </div>
    @endif

    <x-confirmation-modal custom=true />
@endsection
@push('script')
    <script>
        (function($) {
            "use strict";
            $('[name=status]').on('change', function(e) {
                var status = $(this).val();
                window.location.href = `{{ route('influencer.campaign.log') }}?status=${status}`;
            });

            $('.select2').each(function(index, element) {
                $(element).select2();
            });

        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .select2-container--default .select2-selection--single {
            min-width: 140px !important;
        }
    </style>
@endpush

