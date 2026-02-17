@extends($activeTemplate . 'layouts.' . $layout)
@section('content')
    <div class="card custom--card">
        <div class="card-header card-header-bg d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="m-0">
                @php echo $myTicket->statusBadge; @endphp
                [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
            </h6>
            @if ($myTicket->status != Status::TICKET_CLOSE && $myTicket->influencer)
                <button class="btn btn--danger close-button btn--sm confirmationBtn" data-question="@lang('Are you sure to close this ticket?')" data-action="{{ route('influencer.ticket.close', $myTicket->id) }}" type="button"><i class="fas fa-lg fa-times-circle"></i>
                </button>
            @endif
        </div>
        <div class="card-body">
            <form class="disableSubmission" method="post" action="{{ route('influencer.ticket.reply', $myTicket->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-between">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea class="form-control form--control" name="message" rows="4" required>{{ old('message') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <button class="btn btn-dark btn--sm addAttachment my-2" type="button"> <i class="fas fa-plus"></i> @lang('Add Attachment') </button>
                        <p class="mb-2"><small class="text--info">@lang('Max 5 files can be uploaded | Maximum upload size is ' . convertToReadableSize(ini_get('upload_max_filesize')) . ' | Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')</small></p>
                        <div class="row fileUploadsContainer">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn--sm btn--base w-100 my-2" type="submit"><i class="la la-fw la-lg la-reply"></i> @lang('Reply')
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <h5 class="mb-1 mt-4">@lang('Previous Replies')</h5>
    <div class="list support-list">
        @foreach ($messages as $message)
            @if ($message->admin_id == 0)
                <div class="support-card mb-3">
                    <div class="support-card__head">
                        <h6 class="support-card__title">
                            {{ $message->ticket->name }}
                        </h6>
                        <span class="support-card__date">
                            <code class="xsm-text text-muted"><i class="lar la-clock"></i>
                                {{ showDateTime($message->created_at, 'dS F Y @ H:i') }}</code>
                        </span>
                    </div>
                    <div class="support-card__body">
                        <p class="support-card__body-text m-0">
                            {{ $message->message }}
                        </p>

                        @if ($message->attachments->count() > 0)
                            <ul class="list list--row support-card__lis d-flex gap-3 mt-2">
                                @foreach ($message->attachments as $k => $image)
                                    <li>
                                        <a class="support-card__file" href="{{ route('influencer.ticket.download', encrypt($image->id)) }}">
                                            <span class="support-card__file-icon">
                                                <i class="lar la-file-alt"></i>
                                            </span>
                                            <span class="support-card__file-text">
                                                @lang('Attachment') {{ ++$k }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @else
                <div class="support-card mb-3">
                    <div class="support-card__head">
                        <h6 class="support-card__title">
                            {{ $message->admin->name }}
                        </h6>
                        <span class="support-card__date">
                            <code class="xsm-text text-muted"><i class="lar la-clock"></i>
                                {{ showDateTime($message->created_at, 'dS F Y @ H:i') }}</code>
                        </span>

                    </div>
                    <div class="support-card__body">
                        <p class="support-card__body-text m-0">
                            {{ $message->message }}
                        </p>

                        @if ($message->attachments->count() > 0)
                            <ul class="list list--row support-card__list gap-3 d-flex justify-content-center justify-content-md-start flex-wrap mt-2">
                                @foreach ($message->attachments as $k => $image)
                                    <li>
                                        <a class="support-card__file" href="{{ route('influencer.ticket.download', encrypt($image->id)) }}">
                                            <span class="support-card__file-icon">
                                                <i class="lar la-file-alt"></i>
                                            </span>
                                            <span class="support-card__file-text">
                                                @lang('Attachment') {{ ++$k }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <x-confirmation-modal custom="true" />
@endsection
@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }

        .reply-bg {
            background-color: #ffd96729
        }

        .empty-message img {
            width: 120px;
            margin-bottom: 15px;
        }
    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addAttachment').on('click', function() {
                fileAdded++;
                if (fileAdded == 5) {
                    $(this).attr('disabled', true)
                }
                $(".fileUploadsContainer").append(`
                    <div class="col-lg-6 col-md-12 removeFileInput">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="file" name="attachments[]" class="form-control form--control" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx" required>
                                <button type="button" class="input-group-text removeFile bg--danger border--danger"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                `)
            });
            $(document).on('click', '.removeFile', function() {
                $('.addAttachment').removeAttr('disabled', true)
                fileAdded--;
                $(this).closest('.removeFileInput').remove();
            });
        })(jQuery);
    </script>
@endpush
