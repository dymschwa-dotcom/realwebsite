@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="card b-radius--10 overflow-hidden shadow-sm">
    <div class="card-body p-0">
        <div class="row g-0" style="min-height: 700px;">
            {{-- Left Side: Sidebar --}}
            <div class="col-xl-4 col-lg-5 border-end d-none d-lg-block">
                <div class="chat-sidebar">
                    <div class="p-3 border-bottom bg-light">
                        <h5 class="m-0 fw-bold">@lang('Messages')</h5>
                    </div>
                    <div class="conversation-list overflow-auto" style="max-height: 650px;">
                        @foreach($conversations as $conv)
                            <a href="{{ route('influencer.conversation.view', $conv->id) }}" 
                               class="d-flex align-items-center p-3 border-bottom decoration-none chat-item {{ $conversation->id == $conv->id ? 'bg-selected' : '' }}">
                                <div class="avatar-wrapper">
                                    <img src="{{ getImage(getFilePath('userProfile') . '/' . $conv->user->image, getFileSize('userProfile')) }}" 
                                         class="rounded-circle border" style="width: 45px; height: 45px; object-fit: cover;">
                                </div>
                                <div class="ms-3 overflow-hidden">
                                    <h6 class="text-dark fw-bold mb-0 text-truncate">{{ __($conv->user->fullname) }}</h6>
                                    <p class="text-muted small mb-0 text-truncate">{{ Str::limit($conv->lastMessage->message ?? '', 30) }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right Side: Chat Window --}}
            <div class="col-xl-8 col-lg-7 d-flex flex-column">
                <div class="p-3 border-bottom d-flex align-items-center justify-content-between bg-white sticky-top">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('influencer.conversation.index') }}" class="btn btn-sm btn-light d-lg-none me-2">
                            <i class="las la-angle-left"></i>
                        </a>
                        <img src="{{ getImage(getFilePath('userProfile') . '/' . $conversation->user->image, getFileSize('userProfile')) }}" 
                             class="rounded-circle border" style="width: 40px; height: 40px; object-fit: cover;">
                        <div class="ms-3">
                            <h6 class="m-0 fw-bold">{{ __($conversation->user->fullname) }}</h6>
                            <small class="text-success">@lang('Brand')</small>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-sm btn--primary px-3" data-bs-toggle="modal" data-bs-target="#inviteCampaignModal">
                        <i class="las la-file-invoice-dollar"></i> @lang('Send Custom Package')
                    </button>
                </div>

                {{-- Messages Area --}}
                <div class="chat-box p-4 flex-grow-1 overflow-auto bg-light" id="message-container" style="max-height: 550px;">
                    <div id="message-list">
                        @foreach($conversation->messages as $message)
                            @include($activeTemplate . 'partials.message_bubble', ['message' => $message])
                        @endforeach
                    </div>
                    <input type="hidden" id="last-message-id" value="{{ $conversation->messages->last() ? $conversation->messages->last()->id : 0 }}">
                </div>

                {{-- Action Bar --}}
                <div class="p-3 border-top bg-white">
                    <div class="d-flex gap-2 align-items-center">
                        <button type="button" 
                                class="btn btn--primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#attachmentModal" 
                                style="width: 45px; height: 45px;">
                            <i class="las la-paperclip fs-4 text-white"></i>
                        </button>

                        <form id="chat-form" class="d-flex gap-2 flex-grow-1">
                            @csrf
                            <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                            <input type="hidden" name="campaign_id" value="{{ $conversation->campaign_id ?? 0 }}">
                            <input type="text" id="chat-input" name="message" class="form-control rounded-pill px-4" 
                                   placeholder="@lang('Type your message...')" required autocomplete="off">
                            <button type="submit" class="btn btn--primary rounded-circle shadow-sm d-flex align-items-center justify-content-center" 
                                    style="width: 45px; height: 45px;">
                                <i class="las la-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL 1: Send Attachment --}}
<div class="modal fade" id="attachmentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="attachment-upload-form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title">@lang('Send Attachment')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                    <input type="hidden" name="campaign_id" value="{{ $conversation->campaign_id ?? 0 }}">
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">@lang('Message')</label>
                        <textarea name="message" id="attachment-message" class="form-control" rows="3" placeholder="@lang('Add a description...')"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">@lang('File Attachment')</label>
                        <input type="file" name="attachment" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Cancel')</button>
                    <button type="submit" class="btn btn--primary px-4">@lang('Send')</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL 2: Custom Package Modal --}}
<div class="modal fade" id="inviteCampaignModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form id="proposal-form" action="{{ route('influencer.campaign.proposal.final.submit') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title">@lang('Send Custom Package Proposal')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {{-- Pull the raw number value from the conversation row --}}
                    <input type="hidden" name="campaign_id" value="{{ $conversation->campaign_id }}">
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">

                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">@lang('Package Title')</label>
                        {{-- Use the @ sign to suppress errors if campaign is null --}}
                        <input type="text" name="title" class="form-control" 
                               value="{{ @$conversation->campaign->title ? 'Proposal: ' . $conversation->campaign->title : 'Custom Proposal' }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">@lang('Proposal Details')</label>
                        <textarea name="message" class="form-control" rows="4" required placeholder="@lang('Describe your plan...')"></textarea>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label fw-bold">@lang('Proposed Price') ($)</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" name="budget" class="form-control" 
                                   value="{{ @$conversation->campaign->budget ?? '' }}" placeholder="0.00" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Cancel')</button>
                    <button type="submit" class="btn btn--primary px-4">@lang('Send Proposal')</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
    (function($){
        "use strict";
        const messageContainer = document.getElementById('message-container');
        const messageList = $('#message-list');
        const chatForm = $('#chat-form');
        const chatInput = $('#chat-input');
        const attachmentForm = $('#attachment-upload-form');
        const proposalForm = $('#proposal-form');

        const scrollToBottom = () => {
            messageContainer.scrollTop = messageContainer.scrollHeight;
        };

        scrollToBottom();

        // Standard Chat Submission
        chatForm.on('submit', function(e){
            e.preventDefault();
            let formData = $(this).serialize();
            chatInput.val(''); 

            $.post("{{ route('influencer.conversation.send') }}", formData, function(response){
                if(response.status == 'success'){
                    messageList.append(response.message_html);
                    scrollToBottom();
                    $('#last-message-id').val(response.last_id);
                }
            });
        });

        // Attachment Submission
        attachmentForm.on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "{{ route('influencer.conversation.send') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    if(response.status == 'success'){
                        $('#attachmentModal').modal('hide');
                        attachmentForm[0].reset();
                        messageList.append(response.message_html);
                        scrollToBottom();
                        $('#last-message-id').val(response.last_id);
                    }
                }
            });
        });

        // PROPOSAL FORM AJAX
        $(document).on('submit', '#proposal-form', function(e) {
            e.preventDefault(); // This stops the "Supported methods: POST" redirect error
            
            let form = $(this);
            let btn = form.find('button[type=submit]');
            let modalElement = document.getElementById('inviteCampaignModal');
            let modal = bootstrap.Modal.getInstance(modalElement);

            btn.prop('disabled', true);

            $.ajax({
                url: form.attr('action'),
                method: "POST",
                data: form.serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        modal.hide();
                        form[0].reset();
                        $('#message-list').append(response.message_html); 
                        
                        // Scroll chat to bottom
                        const container = document.getElementById('message-container');
                        container.scrollTop = container.scrollHeight;
                        
                        notify('success', response.message);
                    }
                    btn.prop('disabled', false);
                },
                error: function(xhr) {
                    btn.prop('disabled', false);
                    notify('error', 'Check your fields and try again.');
                }
            });
        });

    })(jQuery);
</script>
@endpush