@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="brand-dashboard-header d-flex justify-content-end align-items-center flex-wrap gap-3 mb-4">
        <div class="brand-dashboard-header__right">
            <a href="{{ route('user.campaign.create') }}" class="btn btn--base outline btn--sm" type="button"><i class="las la-bullhorn"></i> @lang('Create Campaign')</a>
        </div>
    </div>
    
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
                            <th>@lang('Status')</th>
                            <th>@lang('Stats')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($generalCampaigns as $campaign)
                        <tr>
                            <td>
                                <span class="fw-bold">{{ __($campaign->title) }}</span>
                            </td>
                            <td>
                                @php echo $campaign->statusBadge; @endphp
                            </td>
                            <td>
                                <div class="small">
                                    <span class="text-warning" title="@lang('Pending')">
                                        <i class="las la-clock"></i> {{ $campaign->pending_count }}
                                    </span>
                                    <span class="text-success ms-2" title="@lang('Hired')">
                                        <i class="las la-check-circle"></i> {{ $campaign->hired_count }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('user.participant.list', $campaign->id) }}" class="btn btn--sm btn--base outline" data-bs-toggle="tooltip" title="@lang('Manage Participants')">
                                    <i class="las la-users"></i>
                                </a>
                                <a href="{{ route('user.campaign.view', $campaign->id) }}" class="btn btn--sm btn--info outline" data-bs-toggle="tooltip" title="@lang('View Details')">
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
    @endif

        <!-- SECTION 2: DIRECT RELATIONSHIPS (Shadow Campaigns) -->
    <h5 class="mb-3">@lang('My Influencers')</h5>
    <div class="accordion custom--accordion" id="influencerAccordion">
        @forelse($directWorkstreams as $influencerId => $jobs)
            @php 
                $influencer = $jobs->first()->influencer; 
                $pendingJobs = $jobs->where('status', Status::PARTICIPATE_PROPOSAL);
            @endphp

                        <div class="accordion-item crm-card shadow-sm mb-3 border-0">
                <div class="accordion-header" id="heading{{ $influencerId }}">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-6 d-flex align-items-center gap-3">
                                <button class="accordion-button collapsed p-0 bg-transparent border-0 shadow-none w-auto" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $influencerId }}" aria-expanded="false" aria-controls="collapse{{ $influencerId }}">
                                </button>
                                <img src="{{ getImage(getFilePath('influencer').'/'.$influencer->image, getFileSize('influencer')) }}" 
                                     class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                <div>
                                    <h6 class="m-0">{{ $influencer->firstname }}</h6>
                                    <span class="text-muted small">{{ '@'.$influencer->username }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 text-end d-flex justify-content-end align-items-center gap-3">
                                @if($pendingJobs->count() > 0)
                                    <span class="badge badge--danger" title="@lang('New Proposal')">
                                        <i class="las la-exclamation-circle"></i> {{ $pendingJobs->count() }}
                                    </span>
                                @endif
                                <a href="{{ route('user.participant.conversation.inbox', $jobs->first()->id) }}" 
                                   class="btn btn--base px-4">
                                    <i class="las la-comments"></i> @lang('Open Workspace')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="collapse{{ $influencerId }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $influencerId }}" data-bs-parent="#influencerAccordion">
                    <div class="accordion-body pt-0 px-4 pb-4">
                        <hr class="mt-0">
                        <div class="table-responsive">
                            <table class="table table-sm custom--table">
                                <thead>
                                    <tr>
                                        <th>@lang('Project Title')</th>
                                        <th>@lang('Price')</th>
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
                                            <a href="{{ route('user.participant.conversation.inbox', $job->id) }}" class="btn btn--sm btn--base outline" data-bs-toggle="tooltip" title="@lang('View Workspace')">
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

    @if ($campaigns->hasPages())
        <div class="mt-4">
            {{ paginateLinks($campaigns) }}
        </div>
    @endif

    <div class="modal fade" id="rejectReasonModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Reject Reason')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <p class="modal-detail"></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .reject-alert {
            cursor: pointer;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.select2').each(function(index, element) {
                $(element).select2();
            });

            $('.reject-alert').on('click', function() {
                var modal = $('#rejectReasonModal');
                modal.find('.modal-detail').text($(this).data('reject_reason'));
                modal.modal('show');
            });

                        $('[name=campaign_status]').on('change', function() {
                let url = $(this).find('option:selected').data('action');
                window.location.href = url;
            });

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
              return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        })(jQuery);
    </script>
@endpush
