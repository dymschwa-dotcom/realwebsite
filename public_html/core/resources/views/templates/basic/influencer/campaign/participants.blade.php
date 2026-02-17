@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card custom--card">
            <div class="card-body p-0">
                <div class="table-responsive--sm">
                    <table class="table table--light">
                        <thead>
                            <tr>
                                <th>@lang('Influencer')</th>
                                <th>@lang('Joined At')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Using the correct variable $participants passed from the controller --}}
                            @forelse($participants as $participant)
                                <tr>
                                    <td>
                                        <div class="user">
                                            <div class="thumb me-2">
                                                <img src="{{ getImage(getFilePath('influencerProfile').'/'.$participant->influencer->image, getFileSize('influencerProfile')) }}" alt="@lang('image')">
                                            </div>
                                            <span class="name">{{ $participant->influencer->firstname }} {{ $participant->influencer->lastname }}</span>
                                        </div>
                                    </td>
                                    <td>{{ showDateTime($participant->created_at) }}</td>
                                    <td>
                                        @php echo $participant->statusBadge; @endphp
                                    </td>
                                    <td>
                                        <div class="button--group">
                                            {{-- Link to public profile --}}
                                            <a href="{{ route('influencer.profile', [slug($participant->influencer->username), $participant->influencer->id]) }}" class="btn btn--sm btn-outline--primary">
                                                <i class="las la-desktop"></i> @lang('Profile')
                                            </a>
                                            
                                            {{-- Option to initiate/view chat --}}
                                            <a href="{{ route('user.conversation.view', $participant->campaign->conversation_id ?? 0) }}" class="btn btn--sm btn-outline--info">
                                                <i class="las la-sms"></i> @lang('Chat')
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($participants->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($participants) }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection