@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-4">
        <div class="col-md-6">
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="text-start m-0">@lang('Brand Information')</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Fullname')</span>
                            <span>{{ __(@$participant->campaign->user->fullname) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Username')</span>
                            <span>{{ @$participant->campaign->user->username }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Email')</span>
                            <span>{{ @$participant->campaign->user->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Phone')</span>
                            <span>{{ @$participant->campaign->user->mobile }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Country')</span>
                            <span>{{ __(@$participant->campaign->user->country_name) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="text-start m-0">@lang('Campaign Information')</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Title')</span>
                            <span>{{ __(@$participant->campaign->title) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Participant Number')</span>
                            <span>{{ @$participant->participant_number }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Influencing for')</span>
                            <span>{{ @$participant->campaign->user->brand_name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Status')</span>
                            <span>@php echo $participant->statusBadge @endphp</span>
                        </li>
                    </ul>
                </div>
            </div>
            @if ($participant->status == Status::PARTICIPATE_REQUEST_ACCEPTED)
                <div class="card custom--card mt-4">
                    <div class="card-header">
                        <h5 class="m-0">@lang('Take Action')</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center gap-3">
                            <button class="btn btn--danger outline btn--md confirmationBtn"
                                    data-question="@lang('Are you sure to cancel this campaign job')?"
                                    data-action="{{ route('influencer.campaign.cancel', $participant->id) }}" type="button">
                                <i class="las la-times-circle"></i> @lang('Cancel')
                            </button>
                            <button class="btn btn--info outline btn--md confirmationBtn" data-question="@lang('If you complete campaign work, you need to ensure delivery of this work, which means you need to keep proof and documents of the work. The brand can report this work without proper proof. So check everything before clicking the yes button.')"
                                    data-action="{{ route('influencer.campaign.deliver', $participant->id) }}" type="button"><i
                                   class="las la-check-circle"></i> @lang('Deliver')</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <x-confirmation-modal custom="true" />
@endsection


@push('tab-nav')
    <div class="tab-wrapper">
        <ul class="custom--tab nav template-tabs">
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link active">@lang('Campaign Detail')</button>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('influencer.campaign.view', @$participant->id) }}"
                   class="nav-link">@lang('About Campaign')</a>
            </li>
            <li class="outline-background"></li>
        </ul>
    </div>
@endpush
