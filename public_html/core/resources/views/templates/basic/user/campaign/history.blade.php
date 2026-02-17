@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="brand-dashboard-header d-flex justify-content-end align-items-center flex-wrap gap-3 mb-4">
        <div class="brand-dashboard-header__right">
            <a href="{{ route('user.campaign.create') }}" class="btn btn--base outline btn--sm" type="button"><i class="las la-bullhorn"></i> @lang('Create Campaign')</a>
        </div>
    </div>
    <div class="dashbaord-table-header">
        <div class="brand-short-inner">
            <select name="campaign_status" class="form-control form--control select2" data-minimum-results-for-search="-1">
                <option value="index" data-action="{{ route('user.campaign.index') }}" @selected(request()->routeIs('user.campaign.index'))>@lang('All Campaigns')</option>
                <option value="pending" data-action="{{ route('user.campaign.pending') }}" @selected(request()->routeIs('user.campaign.pending'))>@lang('Pending Campaigns')</option>
                <option value="approved" data-action="{{ route('user.campaign.approved') }}" @selected(request()->routeIs('user.campaign.approved'))>@lang('Approved Campaigns')</option>
                <option value="rejected" data-action="{{ route('user.campaign.rejected') }}" @selected(request()->routeIs('user.campaign.rejected'))>@lang('Rejected Campaigns')</option>
                <option value="incompleted" data-action="{{ route('user.campaign.incompleted') }}" @selected(request()->routeIs('user.campaign.incompleted'))>@lang('Incompleted Campaigns')</option>
            </select>
        </div>
        <div class="dashbaord-table-header-right d-flex flex-wrap gap-3">
            <form class="search-form">
                <input class="form--control" name="search" type="search" value="{{ request()->search }}" placeholder="@lang('Search...')">
                <button class="search-form__btn" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="row gy-4">
        <div class="dashboard-table">
            <table class="table--responsive--xxl table">
                <thead>
                    <tr>
                        <th>@lang('Title')</th>
                        <th>@lang('Type')</th>
                        <th>@lang('Participants')</th>
                        <th>@lang('Requered Influencer')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                        <tr>
                            <td><span>{{ __(strLimit($campaign->title, 30)) }}</span></td>
                            <td>{{ __(ucfirst($campaign->campaign_type)) }}</td>
                            <td><span>{{ getAmount(@$campaign->participants_count) }}</span></td>
                            <td><span>{{ getAmount(@$campaign->influencer_requirements->required_influencer) }}</span></td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-1">
                                    @php
                                        echo $campaign->statusBadge;
                                    @endphp
                                    @if ($campaign->status == Status::CAMPAIGN_REJECTED)
                                        <span class="reject-alert text--danger" data-reject_reason="{{ $campaign->reason }}"><i class="las la-info-circle"></i></span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="dropdown table-action">
                                    <span id="dropdownMenuLink" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                        <i class="las la-ellipsis-v"></i>
                                    </span>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li>
                                            @if ($campaign->status == Status::CAMPAIGN_INCOMPLETE)
                                                <a class="dropdown-item" href="{{ route('user.campaign.create', [$campaign->campaign_step, $campaign->slug]) }}">
                                                    <i class="las la-edit"></i> @lang('Complete Now')
                                                </a>
                                            @elseif($campaign->status == Status::CAMPAIGN_PENDING)
                                                <a class="dropdown-item" href="{{ route('user.campaign.create', [0, $campaign->slug, 'edit']) }}">
                                                    <i class="las la-edit"></i> @lang('Edit')
                                                </a>
                                            @endif
                                        </li>
                                        @if ($campaign->status != Status::CAMPAIGN_INCOMPLETE)
                                            <li>
                                                <a class="dropdown-item" href="{{ route('user.campaign.view', $campaign->id) }}">
                                                    <i class="las la-eye"></i> @lang('View')
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item position-relative" href="{{ route('user.participant.list', $campaign->id) }}">
                                                    <i class="las la-users"></i> @lang('Participants')
                                                    @if ($campaign->participants_count_pending)
                                                        <div class="participant-pending-alert">{{ $campaign->participants_count_pending }}</div>
                                                    @endif
                                                </a>
                                            </li>
                                        @endif

                                        @if ($campaign->campaign_type == 'invite' && $campaign->status == Status::CAMPAIGN_APPROVED)
                                            <li>
                                                <a class="dropdown-item" href="{{ route('user.campaign.invite.form', $campaign->id) }}">
                                                    <i class="las la-gift"></i> @lang('Invite')
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center not-found" colspan="100%">
                                <div>
                                    <i class="las la-2x la-bullhorn"></i>
                                    <br>
                                    <span>@lang('No campaign found yet!')</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
        })(jQuery);
    </script>
@endpush
