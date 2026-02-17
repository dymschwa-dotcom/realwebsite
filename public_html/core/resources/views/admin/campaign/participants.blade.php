@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('Participant No')</th>
                                    <th>@lang('Influencer')</th>
                                    <th>@lang('Budget')</th>
                                    <th>@lang('Applied_at')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($participants as $participant)
                                    <tr>
                                       
                                        <td>{{ $participant->participant_number }}</td>
                                        <td>
                                            <span class="fw-bold">{{ $participant->influencer->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.influencer.detail', $participant->influencer_id) }}"><span>@</span>{{ $participant->influencer->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            {{ showAmount(@$participant->campaign->budget) }} 
                                        </td>
                                        <td>{{ showDateTime($participant->created_at) }}</td>
                                        <td>
                                            @php
                                                echo $participant->statusBadge;
                                            @endphp
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.campaign.conversation', $participant->id) }}">
                                                    <i class="la la-sms"></i> @lang('Chat')
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

@push('breadcrumb-plugins')
    <select class="form-control select2" data-minimum-results-for-search="-1" name="status">
        <option value="">@lang('All')</option>
        <option value="pending" @selected(request()->status == 'pending')>@lang('Pending')</option>
        <option value="accepted" @selected(request()->status == 'accepted')>@lang('Accepted')</option>
        <option value="delivered" @selected(request()->status == 'delivered')>@lang('Delivered')</option>
        <option value="completed" @selected(request()->status == 'completed')>@lang('Completed')</option>
        <option value="reported" @selected(request()->status == 'reported')>@lang('Reported')</option>
        <option value="canceled" @selected(request()->status == 'canceled')>@lang('canceled')</option>
        <option value="rejected" @selected(request()->status == 'rejected')>@lang('Rejected')</option>
    </select>
    <x-search-form placeholder="influencer or participant no" />
    <x-back route="{{ route('admin.campaign.index') }}" />
@endpush
@push('style')
    <style>
        .form-control {
            width: unset;
        }

        .badge--secondary {
            border-radius: 999px;
            padding: 2px 15px;
            position: relative;
            border-radius: 999px;
            -webkit-border-radius: 999px;
            -moz-border-radius: 999px;
            -ms-border-radius: 999px;
            -o-border-radius: 999px;
        }

        .badge--secondary {
            background-color: rgb(134, 142, 150, 0.1);
            border: 1px solid #868e96;
            color: #868e96;
        }
        .select2-container{
            min-width: 120px;
        }
    </style>
@endpush
@push('script')
    <script>
        $('[name=status]').on('change', function(e) {
            window.location.href = `{{ route('admin.campaign.participants', $campaign->id) }}?status=${$(this).val()}`;
        });
    </script>
@endpush
