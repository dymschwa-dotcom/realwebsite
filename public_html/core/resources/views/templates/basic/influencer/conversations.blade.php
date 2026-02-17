@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="dashboard-section pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card custom--card">
                    <div class="card-body p-0">
                        <div class="table-responsive--md">
                            <table class="table custom--table">
                                <thead>
                                    <tr>
                                        <th>@lang('Brand')</th>
                                        <th>@lang('Last Message')</th>
                                        <th>@lang('Time')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($conversations as $conv)
                                    <tr>
                                        <td>
                                            <div class="user-info">
                                                <span class="fw-bold">{{ __(@$conv->user->fullname) }}</span>
                                                <br>
                                                <small class="text-muted">@<span>{{ @$conv->user->username }}</span></small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="small">
                                                {{ strLimit(@$conv->lastMessage->message, 50) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ diffForHumans(@$conv->updated_at) }}
                                        </td>
                                        <td>
                                            <a href="{{ route('influencer.chat.view', $conv->id) }}" class="btn btn--outline-base btn--sm">
                                                <i class="las la-envelope"></i> @lang('View Chat')
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="100%" class="text-center p-5">
                                            <div class="empty-state">
                                                <i class="las la-comments la-3x"></i>
                                                <p>@lang('No conversations found yet.')</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @if($conversations->hasPages())
                    <div class="mt-4">
                        {{ paginateLinks($conversations) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection