@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('Participant Number')</th>
                                    <th>@lang('Campaign')</th>
                                    <th>@lang('Reviewer')</th>
                                    <th>@lang('Influencer')</th>
                                    <th>@lang('Rating')</th>
                                    <th>@lang('Created At')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                    <tr>
                                        <td>
                                            <span>
                                                <a href="{{ route('admin.campaign.conversation', $review->participant_id) }}">{{ @$review->participant->participant_number }}</a>
                                            </span>
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.campaign.detail', @$review->participant->campaign_id) }}">{{ __(strLimit(@$review->participant->campaign->title, 30)) }}</a>
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.users.detail', $review->user_id) }}">
                                                <span>@</span>{{ @$review->user->username }}
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.influencer.detail', $review->influencer_id) }}">
                                                <span>@</span>{{ @$review->influencer->username }}
                                            </a>
                                        </td>

                                        <td>
                                            <span>{{ $review->star }} @lang('star')</span>
                                        </td>

                                        <td>
                                            <span>{{ showDateTime($review->created_at) }} <br> {{ diffForHumans($review->created_at) }}</span>
                                        </td>

                                        <td>
                                            <div class="button--group">
                                                <button class="btn btn-sm btn-outline--info viewBtn" data-review="{{ $review->review }}" type="button">
                                                    <i class="las la-comment"></i> @lang('View')
                                                </button>
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.reviews.remove', $review->id) }}" data-question="@lang('Are you sure remove this review?')" data-btn_class="btn btn--primary">
                                                    <i class="las la-trash"></i> @lang('Delete')
                                                </button>
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
                @if ($reviews->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($reviews) }}
                    </div>
                @endif
            </div>
        </div>

    </div>

    <div class="modal fade" id="viewModal" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Review')</h4>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close"><i class="las la-times"></i></button>
                </div>
                <div class="modal-body">
                    <p class="modal-detail"></p>
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form />
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.viewBtn').on('click', function() {
                var modal = $('#viewModal');
                modal.find('.modal-detail').text($(this).data('review'));
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
