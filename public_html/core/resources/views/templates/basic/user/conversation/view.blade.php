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
                            <a href="{{ route('user.conversation.view', $conv->id) }}" 
                               class="d-flex align-items-center p-3 border-bottom decoration-none chat-item {{ $conversation->id == $conv->id ? 'bg-selected' : '' }}">
                                <div class="avatar-wrapper">
                                    <img src="{{ getImage(getFilePath('influencer') . '/' . $conv->influencer->image, getFileSize('influencer')) }}" 
                                         class="rounded-circle border" style="width: 45px; height: 45px; object-fit: cover;">
                                </div>
                                <div class="ms-3 overflow-hidden">
                                    <h6 class="text-dark fw-bold mb-0 text-truncate">{{ __($conv->influencer->fullname) }}</h6>
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
                        <a href="{{ route('user.conversation.index') }}" class="btn btn-sm btn-light d-lg-none me-2">
                            <i class="las la-angle-left"></i>
                        </a>
                        <img src="{{ getImage(getFilePath('influencer') . '/' . $conversation->influencer->image, getFileSize('influencer')) }}" 
                             class="rounded-circle border" style="width: 40px; height: 40px; object-fit: cover;">
                        <div class="ms-3">
                            <h6 class="m-0 fw-bold">{{ __($conversation->influencer->fullname) }}</h6>
                            <small class="text-primary">@lang('Influencer')</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn--primary px-3" data-bs-toggle="modal" data-bs-target="#inviteCampaignModal">
                        <i class="las la-plus"></i> @lang('Create Campaign')
                    </button>
                </div>

                {{-- Messages Area --}}
                <div class="chat-box p-4 flex-grow-1 overflow-auto bg-light" id="message-container" style="max-height: 550px;">
                    <div id="message-list">
                        @foreach($conversation->messages as $message)
                            @include('templates.basic.partials.message_bubble', ['message' => $message])
                        @endforeach
                    </div>
                    <input type="hidden" id="last-message-id" value="{{ $conversation->messages->last() ? $conversation->messages->last()->id : 0 }}">
                </div>

                {{-- Action Bar --}}
                <div class="p-3 border-top bg-white">
                    <div class="d-flex gap-2 align-items-center">
                        <button type="button" 
                                class="btn btn--primary rounded-circle d-flex align-items-center justify-content-center shadow-sm attachment-btn" 
                                data-bs-toggle="modal" 
                                data-bs-target="#attachmentModal" 
                                style="width: 45px; height: 45px;">
                            <i class="las la-paperclip fs-4 text-white"></i>
                        </button>

                        <form id="chat-form" class="d-flex gap-2 flex-grow-1">
                            @csrf
                            <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                            <input type="hidden" name="campaign_id" value="{{ $conversation->campaign_id ?? 0 }}">
                            <input type="text" id="chat-input" name="message" class="form-control rounded-pill px-4" placeholder="@lang('Type your message...')" required autocomplete="off">
                            <button type="submit" class="btn btn--primary rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="las la-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Attachment Modal --}}
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
                        <textarea name="message" class="form-control" rows="3" placeholder="@lang('Add a description...')"></textarea>
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

{{-- Create Campaign Modal --}}
<div class="modal fade" id="inviteCampaignModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('user.campaign.invite') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title"><i class="las la-bullhorn"></i> @lang('Invite Influencer')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="influencer_id" value="{{ $conversation->influencer_id }}">
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">@lang('Campaign Title')</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">@lang('Budget') ($)</label>
                            <input type="number" step="0.01" name="budget" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">@lang('Completion Date')</label>
                            <input type="date" name="end_date" class="form-control" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">@lang('Requirements')</label>
                            <textarea name="content_requirements" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Cancel')</button>
                    <button type="submit" class="btn btn--primary px-4">@lang('Send Invite')</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('style')
<style>
    .bg-selected { background-color: #f0f4ff; border-left: 4px solid #4634ff; }
    .chat-box { display: flex; flex-direction: column; scroll-behavior: smooth; }
    .bg--primary { background-color: #4634ff !important; }
    .btn--primary { background-color: #4634ff !important; border-color: #4634ff !important; color: #fff; }
    .chat-item { text-decoration: none !important; }
    #message-container::-webkit-scrollbar { width: 5px; }
    #message-container::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
</style>
@endpush

@push('script')
<script>
    (function($){
        "use strict";

        const messageContainer = document.getElementById('message-container');
        const messageList = $('#message-list');
        const chatForm = $('#chat-form');
        const chatInput = $('#chat-input');
        const attachmentForm = $('#attachment-upload-form');
        
        messageContainer.scrollTop = messageContainer.scrollHeight;

        // 1. AJAX Send Text Message
        chatForm.on('submit', function(e){
            e.preventDefault();
            let formData = $(this).serialize();
            chatInput.val(''); 

            $.post("{{ route('user.conversation.send') }}", formData, function(response){
                if(response.status == 'success'){
                    messageList.append(response.message_html);
                    $('#last-message-id').val(response.last_id); 
                    messageContainer.scrollTop = messageContainer.scrollHeight;
                }
            });
        });

        // 2. AJAX Send Attachment
        attachmentForm.on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            let submitBtn = $(this).find('button[type=submit]');
            submitBtn.prop('disabled', true).text("@lang('Uploading...')");

            $.ajax({
                url: "{{ route('user.conversation.send') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    if(response.status == 'success'){
                        $('#attachmentModal').modal('hide');
                        attachmentForm[0].reset();
                        messageList.append(response.message_html);
                        $('#last-message-id').val(response.last_id);
                        messageContainer.scrollTop = messageContainer.scrollHeight;
                    }
                },
                complete: function(){
                    submitBtn.prop('disabled', false).text("@lang('Send')");
                }
            });
        });

        // 3. Real-time Polling
        setInterval(function(){
            let lastId = $('#last-message-id').val();
            $.get("{{ route('user.conversation.getNewMessages', $conversation->id) }}", { last_id: lastId }, function(data){
                // Corrected condition: only append if there is actual HTML
                if(data.html && data.html.trim().length > 0){
                    messageList.append(data.html);
                    $('#last-message-id').val(data.last_id);
                    messageContainer.scrollTop = messageContainer.scrollHeight;
                }
            });
        }, 3000);

    })(jQuery);

    // 4. Global function for Campaign Status
    window.updateCampaignStatus = function(campaignId, status) {
        if (!confirm("@lang('Are you sure?')")) return;
        jQuery.ajax({
            url: "{{ route('user.campaign.status.update') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                campaign_id: campaignId,
                status: status
            },
            success: function(response) {
                if (response.status == 'success') {
                    notify('success', response.message);
                    location.reload();
                } else {
                    notify('error', response.message);
                }
            }
        });
    }

    // 5. Global function for Influencer Proposal (Contract) Status
    window.updateProposalStatus = function(participantId, status) {
        if (!confirm(`Are you sure you want to ${status} this proposal?`)) return;

        jQuery.ajax({
            url: "{{ route('user.campaign.proposal.update') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                participant_id: participantId,
                status: status
            },
            success: function(response) {
                if (response.status == 'success') {
                    notify('success', response.message);
                    
                    if (response.redirect_url) {
                        setTimeout(() => { window.location.href = response.redirect_url; }, 1000);
                    } else {
                        setTimeout(() => { location.reload(); }, 1000);
                    }
                } else {
                    notify('error', response.message);
                }
            },
            error: function() {
                notify('error', 'Something went wrong or insufficient balance.');
            }
        });
    }
</script>
@endpush