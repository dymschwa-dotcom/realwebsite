@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="card b-radius--10 overflow-hidden shadow-sm">
    <div class="card-body p-0">
        <div class="row g-0" style="min-height: 700px;">
            {{-- Left Side: Sidebar --}}
            <div class="col-xl-4 col-lg-5 border-end d-none d-lg-block">
                <div class="chat-sidebar">
                    <div class="p-3 border-bottom bg-light">
                        <h5 class="m-0 fw-bold">@lang('Workspaces')</h5>
                    </div>
                    <div class="conversation-list overflow-auto" style="max-height: 650px;">
                        @foreach($conversations as $conv)
                            <a href="{{ route('workspace.view', $conv->id) }}" 
                               class="d-flex align-items-center p-3 border-bottom decoration-none chat-item {{ $conversation->id == $conv->id ? 'bg-selected' : '' }}">
                                <div class="avatar-wrapper">
                                    @if($isInfluencer)
                                        <img src="{{ getImage(getFilePath('brand') . '/' . $conv->user->image, getFileSize('brand')) }}" class="rounded-circle border" style="width: 45px; height: 45px; object-fit: cover;">
                                    @else
                                        <img src="{{ getImage(getFilePath('influencer') . '/' . $conv->influencer->image, getFileSize('influencer')) }}" class="rounded-circle border" style="width: 45px; height: 45px; object-fit: cover;">
                                    @endif
                                </div>
                                <div class="ms-3 overflow-hidden">
                                    <h6 class="text-dark fw-bold mb-0 text-truncate">
                                        {{ $isInfluencer ? __($conv->user->fullname) : __($conv->influencer->fullname) }}
                                    </h6>
                                    <p class="text-muted small mb-0 text-truncate">{{ Str::limit($conv->lastMessage->message ?? '', 30) }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right Side: Workspace Window --}}
            <div class="col-xl-8 col-lg-7 d-flex flex-column">
                <div class="p-3 border-bottom d-flex align-items-center justify-content-between bg-white sticky-top">
                    <div class="d-flex align-items-center">
                        <a href="{{ $isInfluencer ? route('influencer.conversation.index') : route('user.conversation.index') }}" class="btn btn-sm btn-light d-lg-none me-2">
                            <i class="las la-angle-left"></i>
                        </a>
                        @if($isInfluencer)
                            <img src="{{ getImage(getFilePath('brand') . '/' . $conversation->user->image, getFileSize('brand')) }}" class="rounded-circle border" style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                            <img src="{{ getImage(getFilePath('influencer') . '/' . $conversation->influencer->image, getFileSize('influencer')) }}" class="rounded-circle border" style="width: 40px; height: 40px; object-fit: cover;">
                        @endif
                        <div class="ms-3">
                            <h6 class="m-0 fw-bold">{{ $isInfluencer ? __($conversation->user->fullname) : __($conversation->influencer->fullname) }}</h6>
                            <small class="{{ $isInfluencer ? 'text-success' : 'text-primary' }}">
                                {{ $isInfluencer ? trans('Brand') : trans('Influencer') }}
                            </small>
                        </div>
                    </div>
                    
                    @if($isInfluencer)
                        <a href="{{ route('influencer.campaign.create.wizard') }}?conversation_id={{ $conversation->id }}" class="btn btn-sm btn--primary px-3">
                            <i class="las la-file-invoice-dollar"></i> @lang('Send Proposal')
                        </a>
                    @else
                        @if($conversation->campaign_id)
                            <a href="{{ route('user.campaign.view', $conversation->campaign_id) }}" class="btn btn-sm btn-outline--primary">
                                <i class="las la-info-circle"></i> @lang('Campaign Brief')
                            </a>
                        @endif
                    @endif
                </div>

                {{-- Messages Area --}}
                <div class="chat-box p-4 flex-grow-1 overflow-auto bg-light" id="message-container" style="max-height: 550px;">
                    <div id="message-list">
                        @php
                            use App\Models\Campaign;
                            use App\Constants\Status;

                            $activeCampaignId = Campaign::where('conversation_id', $conversation->id)
                                ->where('status', Status::CAMPAIGN_APPROVED)
                                ->orderBy('id', 'desc')
                                ->first()?->id;
                            
                            $messages = $conversation->messages;
                            if($activeCampaignId){
                                // Filter messages to show ONLY those from the current active campaign
                                // OR system messages/proposals
                                $messages = $messages->filter(function($m) use ($activeCampaignId) {
                                    return $m->campaign_id == $activeCampaignId || $m->type == 'contract_proposal' || !$m->campaign_id;
                                });
                            }
                        @endphp
                        @foreach($messages as $message)
                            @include($activeTemplate . 'partials.message_bubble', ['message' => $message])
                        @endforeach
                    </div>
                    <input type="hidden" id="last-message-id" value="{{ $conversation->messages->last() ? $conversation->messages->last()->id : 0 }}">
                </div>

                {{-- Action Bar --}}
                <div class="p-3 border-top bg-white">
                    <div class="d-flex gap-2 align-items-center">
                        <button type="button" class="btn btn--primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" data-bs-toggle="modal" data-bs-target="#attachmentModal" style="width: 45px; height: 45px;">
                            <i class="las la-paperclip fs-4 text-white"></i>
                        </button>

                        <form id="workspace-chat-form" class="d-flex gap-2 flex-grow-1">
                            @csrf
                            <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
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

{{-- Modal: Send Attachment --}}
<div class="modal fade" id="attachmentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="attachment-form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Send File')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                    <div class="form-group mb-3">
                        <label>@lang('Message (Optional)')</label>
                        <textarea name="message" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label>@lang('Select File')</label>
                        <input type="file" name="attachment" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary w-100">@lang('Upload & Send')</button>
                </div>
            </div>
        </form>
    </div>
</div>

</div>

@endsection

@push('style')
<style>
    .bg-selected { background-color: #f8f9ff; border-left: 4px solid #4634ff; }
    .chat-box { scroll-behavior: smooth; }
    .btn--primary { background-color: #4634ff; border-color: #4634ff; color: #fff; }
</style>
@endpush

@push('script')
<script>
    (function($){
        "use strict";
        const container = document.getElementById('message-container');
        const list = $('#message-list');
        container.scrollTop = container.scrollHeight;

        // 1. Send Message
        $('#workspace-chat-form').on('submit', function(e){
            e.preventDefault();
            let data = $(this).serialize();
            $('#chat-input').val('');
            $.post("{{ route('workspace.send') }}", data, function(res){
                if(res.status == 'success'){
                    list.append(res.message_html);
                    container.scrollTop = container.scrollHeight;
                    $('#last-message-id').val(res.last_id);
                }
            });
        });

        // 2. Send Attachment
        $('#attachment-form').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "{{ route('workspace.send') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res){
                    if(res.status == 'success'){
                        $('#attachmentModal').modal('hide');
                        list.append(res.message_html);
                        container.scrollTop = container.scrollHeight;
                        $('#last-message-id').val(res.last_id);
                    }
                }
            });
        });

        // 3. Polling
        setInterval(function(){
            let lastId = $('#last-message-id').val();
            $.get("{{ route('workspace.getNewMessages', $conversation->id) }}", { last_id: lastId }, function(res){
                if(res.html){
                    list.append(res.html);
                    $('#last-message-id').val(res.last_id);
                    container.scrollTop = container.scrollHeight;
                }
            });
        }, 3000);

        // 5. Global Accept/Reject
        window.updateProposalStatus = function(id, status){
            if(!confirm(`Are you sure you want to ${status}?`)) return;
            $.post("{{ route('workspace.proposal.update') }}", {
                _token: "{{ csrf_token() }}",
                participant_id: id,
                status: status
            }, function(res){
                notify(res.status, res.message);
                if(res.status == 'success') location.reload();
            });
        }
    })(jQuery);
</script>
@endpush
