@extends($activeTemplate . 'layouts.' . $layout)
@section('content')
    <div class="text-end mb-3">
        <a href="{{ route('influencer.ticket.open') }}" class="btn btn--sm btn--base outline"> <i class="fas fa-plus"></i>
            @lang('New Ticket')</a>
    </div>
    <div class="row gy-4">
        <div class="dashboard-table">
            <table class="table--responsive--xxl table">
                <thead>
                    <tr>
                        <th>@lang('Subject')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Priority')</th>
                        <th>@lang('Last Reply')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($supports as $support)
                        <tr>
                            <td> <a href="{{ route('influencer.ticket.view', $support->ticket) }}" class="fw-bold">
                                    [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                            <td>
                                @php echo $support->statusBadge; @endphp
                            </td>
                            <td>
                                @if ($support->priority == Status::PRIORITY_LOW)
                                    <span class="badge badge--dark">@lang('Low')</span>
                                @elseif($support->priority == Status::PRIORITY_MEDIUM)
                                    <span class="badge  badge--warning">@lang('Medium')</span>
                                @elseif($support->priority == Status::PRIORITY_HIGH)
                                    <span class="badge badge--danger">@lang('High')</span>
                                @endif
                            </td>
                            <td>{{ diffForHumans($support->last_reply) }} </td>

                            <td>
                                <a href="{{ route('influencer.ticket.view', $support->ticket) }}"
                                   class="btn btn--base btn--xsm">
                                    <i class="las la-lg la-desktop"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center not-found">
                                <div>
                                    <i class="las la-2x la-list"></i>
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
    @if ($supports->hasPages())
        <div class="mt-4">
            {{ paginateLinks($supports) }}
        </div>
    @endif
@endsection
