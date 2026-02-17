<li class="outgoing__msg">
    <div class="msg__item">
        <div class="post__creator">
            <div class="post__creator-content">
                @if ($message->message)
                    <p>{{ __($message->message) }}</p>
                    <span class="comment-date text--secondary">{{ diffForHumans($message->created_at) }}</span>
                @endif
                @if ($message->attachments)
                    <div>
                        @foreach (json_decode($message->attachments) as $key => $attachment)
                            <p class="m-1">
                                <a class="me-2 text--base" href="{{ route('attachment.download', [$attachment, $message->id, 'campaign']) }}"><i class="fa fa-file text--base"></i>
                                    @lang('Attachment') {{ ++$key }}
                                </a>
                            </p>
                        @endforeach
                        <span class="comment-date text--secondary">{{ diffForHumans($message->created_at) }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</li>
