@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-4">
        {{-- Brand Information Card --}}
        <div class="col-md-6">
            <div class="card custom--card h-100">
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
                            <span class="fw-bold">@lang('Brand Name')</span>
                            <span>{{ @$participant->campaign->user->brand_name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Email')</span>
                            <span>{{ @$participant->campaign->user->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Country')</span>
                            <span>{{ __(@$participant->campaign->user->country_name) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Campaign Information Card --}}
        <div class="col-md-6">
            <div class="card custom--card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="text-start m-0">@lang('My Contract Details')</h5>
                    <a href="{{ route('influencer.conversation.view', $participant->conversation_id ?? 0) }}" class="btn btn--base btn--sm">
                        <i class="las la-comments"></i> @lang('Go to Chat')
                    </a>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Campaign Title')</span>
                            <span>{{ __(@$participant->campaign->title) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('My ID Number')</span>
                            <span>{{ @$participant->participant_number }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Status')</span>
                            <span>@php echo $participant->statusBadge @endphp</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
                            <span class="fw-bold">@lang('Full Brief')</span>
                            <a href="{{ route('user.campaign.detail', [slug(@$participant->campaign->title), @$participant->campaign->id]) }}" target="_blank" class="text--base">
                                <i class="las la-external-link-alt"></i> @lang('View Public Page')
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Action Section: Only visible when active --}}
        @if ($participant->status == Status::PARTICIPATE_REQUEST_ACCEPTED)
            <div class="col-12">
                <div class="card custom--card mt-2">
                    <div class="card-header bg--dark">
                        <h5 class="m-0 text-white">@lang('Required Actions')</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center flex-wrap gap-3">
                            <button class="btn btn--danger outline btn--md confirmationBtn"
                                    data-question="@lang('Are you sure you want to cancel this job? This may affect your reputation score.')"
                                    data-action="{{ route('influencer.campaign.cancel', $participant->id) }}" type="button">
                                <i class="las la-times-circle"></i> @lang('Cancel Job')
                            </button>
                            
                            <button class="btn btn--info outline btn--md confirmationBtn" 
                                    data-question="@lang('Confirm work delivery? Make sure you have shared all deliverables in the chat workspace first.')"
                                    data-action="{{ route('influencer.campaign.deliver', $participant->id) }}" type="button">
                                <i class="las la-check-circle"></i> @lang('Submit Final Delivery')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <x-confirmation-modal custom="true" />
@endsection

@push('tab-nav')
    <div class="tab-wrapper">
        <ul class="custom--tab nav template-tabs">
            <li class="nav-item">
                <button type="button" class="nav-link active">@lang('Participant Info')</button>
            </li>
            <li class="nav-item">
                <a href="{{ route('influencer.campaign.view', @$participant->id) }}" class="nav-link">@lang('About Campaign')</a>
            </li>
            <li class="outline-background"></li>
        </ul>
    </div>
@endpush