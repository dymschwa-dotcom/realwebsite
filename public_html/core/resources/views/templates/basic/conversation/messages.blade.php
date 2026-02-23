@php
    if (auth()->id()) {
        $currentUser = 'brand';
    } elseif (authInfluencerId()) {
        $currentUser = 'influencer';
    } else {
        $currentUser = 'admin';
    }
@endphp
@foreach ($conversationMessage->reverse() as $message)
    @php
        $isOutgoing = ($message->sender == $currentUser);
        if ($message->sender == 'brand') {
            $avatar = getImage(getFilePath('brand') . '/' . @$message->user->image, null, true);
            $senderName = @$message->user->fullname;
        } elseif ($message->sender == 'influencer') {
            $avatar = getImage(getFilePath('influencer') . '/' . @$message->influencer->image, null, true);
            $senderName = @$message->influencer->fullname;
        } else {
            $avatar = getImage(null, null, true);
            $senderName = 'Admin';
        }
    @endphp

    <li id="msg-{{ $message->id }}" class="{{ $isOutgoing ? 'outgoing__msg' : 'incoming__msg' }} d-flex gap-2 mb-3">
        @if (!$isOutgoing)
            <div class="flex-shrink-0">
                <img src="{{ $avatar }}" class="rounded-circle border" style="width: 35px; height: 35px; object-fit: cover;" title="{{ $senderName }}">
            </div>
        @endif
            <div class="msg__item">
                <div class="post__creator">
                    <div class="post__creator-content">

                    {{-- Campaign Context Label --}}
                    <div class="mb-2 d-flex align-items-center gap-1 border-bottom pb-1" style="opacity: 0.8;">
                        <i class="las la-bullhorn text--base" style="font-size: 0.75rem;"></i>
                        <span class="fw-bold text-uppercase text-muted" style="font-size: 0.6rem; letter-spacing: 0.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px;">
                            {{ __($message->participant->campaign->title) }}
                        </span>
                    </div>
                    
                        {{-- SENDER NAME (ADMIN) --}}
                    @if ($message->sender == 'admin')
                            <span class="comment-date text--danger d-block mb-1 fw-bold small">@lang('Admin')</span>
                        @endif

                    @if ($message->is_deliverable)
                            <div class="deliverable-badge mb-2">
                            @if ($message->approval_status == 0)
                                <span class="badge bg--warning"><i class="las la-clock"></i> @lang($isOutgoing ? 'Pending Deliverable' : 'Review Required')</span>
                            @elseif ($message->approval_status == 1)
                                    <span class="badge bg--success"><i class="las la-check-circle"></i> @lang('Approved')</span>
                            @elseif ($message->approval_status == 2)
                                    <span class="badge bg--danger"><i class="las la-exclamation-triangle"></i> @lang('Revision Requested')</span>
                                     @if($message->rejection_reason)
                                    <div class="small mt-1 text-white bg-danger bg-opacity-50 p-1 rounded" style="word-break: break-word;">
                                        <strong>@lang('Reason'):</strong> {{ $message->rejection_reason }}
                                    </div>
                                @endif
                                @endif
                            </div>
                        @endif

                    @if ($message->message)
                        <p class="mb-1">
                            @if($message->is_deliverable)
                            {!! preg_replace('!(http|ftp|scp)(s)?:\/\/[a-zA-Z0-9.?%=&_/:-]+!', '<a href="$0" target="_blank" class="text--base fw-bold">$0</a>', __($message->message)) !!}
                        @else
                            {{ __($message->message) }}</p>
                    @endif
                </p>
            @endif

                    @if ($message->attachments)
                        <div class="attachments-wrapper border-top pt-2 mt-2">
                            @foreach (json_decode($message->attachments) as $attachment)
                                @php
                                    $originalName = explode('_', $attachment, 2)[1] ?? $attachment;
                                    $extension = pathinfo($attachment, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                @endphp
                                <div class="attachment-item mb-2">
                                    <a class="text--base d-flex align-items-center gap-2 text-decoration-none" href="{{ route('attachment.download', [$attachment, $message->id, 'campaign']) }}">
                                        <i class="las la-{{ $isImage ? 'image' : 'file-alt' }} fs-5"></i>
                                        <span class="text-break small">{{ $originalName }}</span>
                                    </a>
                                </div>
@endforeach
                        </div>
                    @endif
                    <span class="comment-date text--secondary d-block mt-1" style="font-size: 0.7rem;">{{ diffForHumans($message->created_at) }}</span>
                </div>
            </div>
        </div>
                                    
        @if ($isOutgoing)
            <div class="flex-shrink-0">
                <img src="{{ $avatar }}" class="rounded-circle border" style="width: 35px; height: 35px; object-fit: cover;" title="{{ $senderName }}">
            </div>
        @endif
    </li>
@endforeach

