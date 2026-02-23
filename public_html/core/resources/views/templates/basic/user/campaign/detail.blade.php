@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-4">
        {{-- Unified Brief Partial --}}
        <div class="col-12">
            @php $campaign = $applicant->campaign; @endphp
            @include($activeTemplate . 'partials.campaign_brief')
        </div>

        <div class="col-md-6">
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="m-0">@lang('Influencer Information')</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Fullname')</span>
                            <span>{{ __(@$applicant->influencer->fullname) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Country')</span>
                            <span>{{ __(@$applicant->influencer->country_name) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('GST Registered')</span>
                            <span>{{ @$applicant->influencer_is_gst_registered ? __('Yes') : __('No') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">

                            <span class="fw-bold">@lang('Job Completed')</span>
                            <span>{{ getAmount(@$applicant->influencer->job_completed_count) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Job Running')</span>
                            <span>{{ getAmount(@$applicant->influencer->job_running_count) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card custom--card">
                                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <h5 class="m-0">@lang('Campaign Information')</h5>
                        <a class="btn btn--base outline btn--xsm" href="{{ route('user.participant.conversation.inbox', $applicant->id) }}"><i class="las la-arrow-left"></i> @lang('Go Back')</a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Title')</span>
                            <span>{{ __(@$applicant->campaign->title) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Applicant Number')</span>
                            <span>{{ @$applicant->participant_number }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Influencing for')</span>
                            <span>{{ @$applicant->campaign->user->brand_name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Status')</span>
                            <span>@php echo $applicant->statusBadge @endphp</span>
                        </li>
                        @if ($applicant->status == Status::CAMPAIGN_JOB_REPORTED)
                            <li class="list-group-item d-flex justify-content-center align-items-center flex-wrap px-0">
                                <span class="text--danger fw-bold">@lang('This job was reported. Admin will handle this. if your report reason is true you will get back your invested money otherwise this job will be completed. ')</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

                                    @if ($applicant->status == Status::CAMPAIGN_JOB_DELIVERED || $applicant->status == Status::PARTICIPATE_REQUEST_ACCEPTED)
                <div class="card custom--card mt-4">
                    <div class="card-header border-bottom-0 pb-0">
                        <h5 class="m-0">@lang('Take Action')</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center gap-3">
                            @if ($applicant->status == Status::CAMPAIGN_JOB_DELIVERED)
                                <button class="btn btn--success outline btn--md confirmationBtn" data-question="@lang('Are you sure to complete this campaign job')?" data-action="{{ route('user.participant.completed', $applicant->id) }}" type="button"><i class="las la-check-circle"></i> @lang('Complete')</button>
                                <button class="btn btn--black outline btn--md report-btn" type="button"><i class="las la-gavel"></i> @lang('Report')</button>
                            @endif
                            
                            @if ($applicant->status == Status::PARTICIPATE_REQUEST_ACCEPTED)
                                <div class="text-center w-100">
                                    <p class="fs-14 text-muted mb-3">@lang('Job in progress. Escrow is locked.')</p>
                                    <button class="btn btn--black outline btn--sm report-btn" type="button"><i class="las la-gavel"></i> @lang('Report Issue')</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="modal fade" id="reportModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Report on Campaign Job')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="mt-2">@lang('Reason for Report')</label>
                            <textarea class="form-control form--control" name="report_reason" rows="5" required>{{ old('report_reason') }}</textarea>
                        </div>
                        <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-confirmation-modal custom="true" />
@endsection
@push('script')
    <script>
        (function($) {
            "use strict";
            $('.report-btn').on('click', function() {
                var modal = $('#reportModal');
                modal.find('form').attr('action', `{{ route('user.participant.reported', $applicant->id) }}`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
