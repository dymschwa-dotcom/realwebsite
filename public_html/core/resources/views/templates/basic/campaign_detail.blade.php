@extends($activeTemplate . 'layouts.frontend')
@section('content')
<section class="campaign-details py-120">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-8">
                {{-- Campaign Information Card --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h4 class="mb-3 text--danger">@lang('Campaign Details')</h4>
                        <div class="text-muted">@php echo $campaign->description @endphp</div>
                        <hr class="my-4">
                        <h4 class="mb-3 text--danger">@lang('Requirements')</h4>
                        <div class="p-3 bg-light rounded border border-danger border-opacity-25">
                            <p class="text-dark fw-bold mb-0" style="white-space: pre-line;">{{ __($campaign->content_requirements) }}</p>
                        </div>
                    </div>
                </div>

                {{-- SHARED WORKSPACE MODULE (Appears when status is Active or Completed) --}}
                @if($campaign->status == 1 || $campaign->status == 2)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="m-0 text--success"><i class="las la-folder-open"></i> @lang('Campaign Workspace')</h5>
                        @if($campaign->status == 2)
                            <span class="badge badge--dark">@lang('Completed')</span>
                        @else
                            <span class="badge badge--success">@lang('Active Contract')</span>
                        @endif
                    </div>
                    
                    <div class="card-body p-4">
                        @if(auth()->guard('influencer')->check() && $campaign->status == 1)
                        <div class="upload-box mb-4 p-3 bg-light rounded border">
                            <h6 class="mb-3">@lang('Upload Deliverables')</h6>
                            <form action="{{ route('campaign.file.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="conversation_id" value="{{ $campaign->conversation_id }}">
                                <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-5">
                                        <label class="form-label small">@lang('Select File')</label>
                                        <input type="file" name="attachment" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small">@lang('Note (Optional)')</label>
                                        <input type="text" name="message" class="form-control" placeholder="@lang('Add a note...')">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn--base w-100 d-flex align-items-center justify-content-center" style="height: 46px;">
                                            <i class="las la-cloud-upload-alt me-2"></i> <span>@lang('Upload')</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table--light style--two">
                                <thead>
                                    <tr>
                                        <th>@lang('Date')</th>
                                        <th>@lang('File Name')</th>
                                        <th>@lang('Status')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                        $files = App\Models\Message::whereNotNull('attachment')
                                                ->where(function($q) use ($campaign) {
                                                    $q->where('campaign_id', $campaign->id)
                                                      ->orWhere('conversation_id', $campaign->conversation_id);
                                                })
                                                ->latest()
                                                ->get(); 
                                    @endphp
                                    @forelse($files as $file)
                                    <tr>
                                        <td>{{ showDateTime($file->created_at, 'd M, Y') }}</td>
                                        <td>
                                            <a href="{{ route('campaign.file.download', $file->attachment) }}" class="text--base fw-bold">
                                                <i class="las la-file-download"></i> {{ $file->original_filename ?? __('Download File') }}
                                            </a>
                                            @if($file->message)
                                                <br><small class="text-muted">@lang('Note'): {{ $file->message }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($file->status == 'approved')
                                                <span class="badge badge--success">@lang('Approved')</span>
                                            @elseif($file->status == 'revision_requested')
                                                <span class="badge badge--warning">@lang('Revision Requested')</span>
                                            @else
                                                <span class="badge badge--primary">@lang('Pending Review')</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($isOwner) && $isOwner && $file->status != 'approved' && $campaign->status == 1)
                                                <div class="button--group">
                                                    <button class="btn btn-sm btn--success statusBtn" data-id="{{ $file->id }}" data-status="approved">
                                                        <i class="las la-check"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn--warning statusBtn" data-id="{{ $file->id }}" data-status="revision_requested">
                                                        <i class="las la-sync"></i>
                                                    </button>
                                                </div>
                                            @elseif($file->status == 'approved')
                                                <span class="text--success small"><i class="las la-check-double"></i> @lang('Finalized')</span>
                                            @else
                                                <span class="text-muted small">@lang('Awaiting Review')</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="100%" class="text-center p-4">@lang('No files uploaded yet.')</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm text-center p-4 sticky-sidebar">
                    <span class="text-muted small fw-bold">@lang('TOTAL BUDGET')</span>
                    <h2 class="text-success mb-4">{{ $general->cur_sym }}{{ showAmount($campaign->budget) }}</h2>
                    
                    {{-- 1. Influencer Proposal View --}}
                    @if(auth()->guard('influencer')->check())
                        @php
                            $alreadyApplied = App\Models\Participant::where('campaign_id', $campaign->id)
                                ->where('influencer_id', auth()->guard('influencer')->id())
                                ->first();
                        @endphp

                        @if(!$alreadyApplied)
                            <div class="proposal-form text-start">
                                <h6 class="mb-3">@lang('Send Proposal')</h6>
                                
                                {{-- RELEVANT PART CHANGED: Points to the new unique POST route from web.php --}}
                                <form action="{{ route('influencer.campaign.proposal.final.submit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                                    
                                    <div class="form-group mb-3 text-start">
                                        <label class="small fw-bold">@lang('Proposal Message')</label>
                                        <textarea name="message" class="form-control" rows="4" required placeholder="@lang('Why should the brand hire you?')"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn--primary w-100">@lang('Send Proposal')</button>
                                </form>
                            </div>
                        @else
                            <div class="alert alert-info border-0 mb-0">
                                <p class="small mb-2">@lang('Your proposal has been submitted.')</p>
                                <a href="{{ route('influencer.conversation.view', $alreadyApplied->conversation_id ?? 0) }}" class="btn btn--sm btn--dark w-100">
                                    <i class="las la-comments"></i> @lang('Open Workspace')
                                </a>
                            </div>
                        @endif

                    {{-- 2. Brand Owner Dashboard View --}}
                    @elseif(isset($isOwner) && $isOwner)
                        @if($campaign->status == 0)
                            <div class="brand-actions">
                                <button class="btn btn--success w-100 mb-2 proposalBtn" data-status="approved">@lang('Accept Proposal')</button>
                                <button class="btn btn--danger w-100 proposalBtn" data-status="rejected">@lang('Decline')</button>
                            </div>
                        @elseif($campaign->status == 1)
                            <button class="btn btn--primary w-100 completeJobBtn">
                                <i class="las la-check-circle"></i> @lang('Mark Job Completed')
                            </button>
                        @elseif($campaign->status == 2)
                            <div class="alert alert-success border-0 mb-3 text-center">
                                <i class="las la-certificate"></i> @lang('Job Completed')
                            </div>
                            @php
                                $participant = App\Models\Participant::where('campaign_id', $campaign->id)->first();
                                $review = App\Models\Review::where('campaign_id', $campaign->id)
                                            ->where('influencer_id', $campaign->influencer_id)
                                            ->first();
                            @endphp
                            @if(!$review)
                                <button class="btn btn--base w-100 reviewBtn" data-id="{{ $participant->id ?? '' }}">
                                    <i class="las la-star"></i> @lang('Rate Influencer')
                                </button>
                            @else
                                <div class="rating text--warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="la{{ $i <= $review->star ? 's' : 'r' }} la-star"></i>
                                    @endfor
                                </div>
                                <p class="small fst-italic mt-2">"{{ $review->review }}"</p>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MODALS SECTION --}}
<div id="reviewModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Leave a Review')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="reviewForm" action="{{ route('user.review.store') }}" method="POST">
                @csrf
                <input type="hidden" name="participant_id">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label">@lang('Rating')</label>
                        <select name="star" class="form-control" required>
                            <option value="5">@lang('5 Stars - Excellent')</option>
                            <option value="4">@lang('4 Stars - Good')</option>
                            <option value="3">@lang('3 Stars - Average')</option>
                            <option value="2">@lang('2 Stars - Poor')</option>
                            <option value="1">@lang('1 Star - Terrible')</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Your Feedback')</label>
                        <textarea name="review" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--base w-100">@lang('Submit Review')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="revisionModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Reason for Revision')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="revisionForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="message_id">
                    <div class="form-group">
                        <textarea name="reason" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--base w-100">@lang('Submit Request')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        "use strict";

        $('.proposalBtn').on('click', function() {
            let status = $(this).data('status');
            if(confirm("@lang('Update proposal status to ')" + status + "?")) {
                $.post("{{ route('campaign.proposal.update') }}", {
                    _token: "{{ csrf_token() }}",
                    id: "{{ $campaign->id }}",
                    status: status
                }, function(res) {
                    location.reload();
                });
            }
        });

        $('.reviewBtn').on('click', function() {
            let modal = $('#reviewModal');
            modal.find('input[name="participant_id"]').val($(this).data('id'));
            modal.modal('show');
        });

        $('.statusBtn').on('click', function() {
            let id = $(this).data('id');
            let status = $(this).data('status');
            if(status == 'approved'){
                if(confirm("@lang('Approve this work submission?')")) {
                    $.post("{{ route('campaign.file.status') }}", {
                        _token: "{{ csrf_token() }}", 
                        message_id: id, 
                        status: 'approved'
                    }, function() { 
                        location.reload(); 
                    });
                }
            } else {
                let modal = $('#revisionModal');
                modal.find('input[name="message_id"]').val(id);
                modal.modal('show');
            }
        });

        $('.completeJobBtn').on('click', function() {
            if(confirm("@lang('Finalize campaign and release funds?')")) {
                $.post("{{ route('user.campaign.complete') }}", {
                    _token: "{{ csrf_token() }}", 
                    campaign_id: "{{ $campaign->id }}"
                }, function(res) {
                    location.reload();
                });
            }
        });
    });
</script>
@endpush