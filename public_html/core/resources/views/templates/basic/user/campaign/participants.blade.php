@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashbaord-table-header">
        <div class="dashboard-hiring__menu">
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
        <div class="dashbaord-table-header-right d-flex flex-wrap gap-3">
            <form class="search-form">
                <input class="form--control" name="search" type="search" value="{{ request()->search }}" placeholder="@lang('Search..')">
                <button class="search-form__btn" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>

    <div class="row gy-4">
        <div class="dashboard-table">
            <table class="table--responsive--xxl table">
                <thead>
                    <tr>
                        <th>@lang('Participant No')</th>
                        <th>@lang('Influencer')</th>
                        <th>@lang('Budget')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participants as $participant)
                        <tr>
                            <td><span>{{ $participant->participant_number }}</span></td>
                                                        <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ getImage(getFilePath('influencer') . '/' . $participant->influencer->image, getFileSize('influencer')) }}"
                                        alt="@lang('image')" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                    <div>
                                        <span class="d-block fw-bold">{{ $participant->influencer->fullname }}</span>
                                        <a href="{{ route('influencer.profile', @$participant->influencer->username) }}" target="_blank" class="small text--base">
                                            @ {{ $participant->influencer->username }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if (@$participant->budget > 0)
                                    <span>{{ showAmount(@$participant->budget) }}</span>
                                @else
                                    <span>@lang('Gift')</span>
                                @endif
                            </td>
                            <td>
                                @php echo $participant->statusBadge; @endphp
                            </td>
                            <td>
                                <div class="dropdown table-action">
                                    <span id="dropdownMenuLink{{ $participant->id }}" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                        <i class="las la-ellipsis-v"></i>
                                    </span>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink{{ $participant->id }}">
                                        @if ($participant->status == Status::PARTICIPATE_REQUEST_PENDING)
                                            <li>
                                                <button class="dropdown-item confirmationBtn" data-action="{{ route('user.participant.accept', $participant->id) }}" data-question="@lang('Are you sure to accept this participant in your campaign')?" type="button">
                                                    <i class="las la-check-circle"></i> @lang('Accept')
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item confirmationBtn" data-action="{{ route('user.participant.reject', $participant->id) }}" data-question="@lang('Are you sure to reject this participant in your campaign')?" type="button">
                                                    <i class="las la-times-circle"></i> @lang('Reject')
                                                </button>
                                            </li>
                                        @elseif($participant->status == Status::PARTICIPATE_INQUIRY || $participant->status == Status::PARTICIPATE_PROPOSAL)
                                            <li>
                                                <a class="dropdown-item" href="{{ route('user.participant.conversation.inbox', $participant->id) }}">
                                                    <i class="las la-sms"></i> @lang('Chat')
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a class="dropdown-item" href="{{ route('user.participant.detail', @$participant->id) }}">
                                                    <i class="las la-desktop"></i> @lang('Detail')
                                                </a>
                                            </li>
                                            @if (!in_array($participant->status, [Status::PARTICIPATE_REQUEST_REJECTED, Status::CAMPAIGN_JOB_CANCELED, Status::CAMPAIGN_JOB_COMPLETED]))
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('user.participant.conversation.inbox', $participant->id) }}">
                                                        <i class="las la-sms"></i> @lang('Chat')
                                                    </a>
                                                </li>
                                            @endif
                                            @if ($participant->status == Status::CAMPAIGN_JOB_COMPLETED && !$participant->review_count)
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('user.review.form', $participant->id) }}">
                                                        <i class="lar la-star"></i> @lang('Review')
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center not-found" colspan="100%">
                                <div>
                                    <i class="la la-2x la-frown"></i>
                                    <br>
                                    {{ __($emptyMessage) }}
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($participants->hasPages())
        <div class="mt-4">
            {{ paginateLinks($participants) }}
        </div>
    @endif
    <x-confirmation-modal custom='true' />
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('[name=status]').on('change', function(e) {
                var status = $(this).val();
                window.location.href = `{{ route('user.participant.list', @$campaign->id) }}?status=${status}`;
            });

            $('.select2').each(function(index, element) {
                $(element).select2();
            });
        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        .selection {
            min-width: 120px;
        }
    </style>
@endpush