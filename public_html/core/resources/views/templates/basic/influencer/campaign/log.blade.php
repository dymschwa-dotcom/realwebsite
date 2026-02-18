@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="d-flex align-items-center justify-content-end flex-wrap pb-3 gap-3">
        <div class="campaign-participant-status">
            <select class="form--control select2" data-minimum-results-for-search="-1" name="status">
                <option value="all">@lang('All')</option>
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

    <div class="dashbaord-table-header">
        <div class="custom--tab nav template-tabs p-0 m-0">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" type="button">@lang('Campaigns')</button>
            </li>
            <li class="nav-item" role="presentation">
                {{-- Pointing to the campaign.all route for influencers to find more work --}}
                <a class="nav-link" href="{{ route('campaign.all') }}">@lang('Find Campaigns')</a>
            </li>
            <li class="outline-background"></li>
        </div>
        <div class="dashbaord-table-header-right d-flex flex-wrap gap-3">
            <form class="search-form active">
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
                        <th>@lang('Campaign Title')</th>
                        <th>@lang('Brand')</th>
                        <th>@lang('Budget')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Changed from $participates to $campaigns to match your Controller --}}
                    @forelse($campaigns as $campaign)
                        <tr>
                            <td>
                                <strong>{{ __($campaign->title) }}</strong>
                            </td>
                            <td>
                                {{-- Accessing the brand name through the user relationship --}}
                                <span>{{ @$campaign->user->brand_name ?? @$campaign->user->fullname }}</span>
                            </td>
                            <td>
                                @if ($campaign->budget > 0)
                                    <span>{{ showAmount($campaign->budget) }}</span>
                                @else
                                    <span class="badge badge--info">@lang('Gift Based')</span>
                                @endif
                            </td>
                            <td>
                                @php echo $campaign->statusBadge; @endphp
                            </td>
                            <td>
                                <div class="dropdown table-action">
                                    <span class="btn btn--sm btn--outline-base" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="las la-ellipsis-v"></i> @lang('Action')
                                    </span>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('influencer.campaign.view', $campaign->id) }}">
                                                <i class="las la-desktop"></i> @lang('Details')
                                            </a>
                                        </li>
                                        {{-- Link to the chat thread --}}
                                        @if($campaign->conversation_id)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('influencer.conversation.view', $campaign->conversation_id) }}">
                                                <i class="las la-sms"></i> @lang('Chat with Brand')
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
                                <div class="py-4">
                                    <i class="las la-2x la-bullhorn text--base"></i>
                                    <br>
                                    @lang('No campaigns found in your log.')
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

    <x-confirmation-modal custom=true />
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('select[name=status]').on('change', function() {
                var status = $(this).val();
                window.location.href = `{{ route('influencer.campaign.log') }}?status=${status}`;
            });

            $('.select2').select2();
        })(jQuery);
    </script>
@endpush