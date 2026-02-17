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
                                    <th>@lang('Campaign')</th>
                                    <th>@lang('Participant No')</th>
                                    <th>@lang('Influencer')</th>
                                    <th>@lang('Budget')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Participated At')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($participants as $participant)
                                    <tr>
                                        <td>
                                            <a
                                                href="{{ route('admin.campaign.detail', $participant->campaign_id) }}">{{ __(strLimit($participant->campaign->title, 40)) }}</a>

                                        </td>
                                        <td>{{ $participant->participant_number }}</td>
                                        <td>
                                            <span class="fw-bold">{{ $participant->influencer->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a
                                                    href="{{ route('admin.influencer.detail', $participant->influencer_id) }}"><span>@</span>{{ $participant->influencer->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            {{ showAmount(@$participant->campaign->budget) }}
                                        </td>
                                        <td>
                                            @php
                                                echo $participant->statusBadge;
                                            @endphp
                                        </td>
                                        <td>{{ showDateTime($participant->created_at) }}</td>
                                        <td>
                                            <div class="button--group">
                                                <a class="btn btn-sm btn-outline--primary"
                                                    href="{{ route('admin.campaign.conversation', $participant->id) }}">
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
    <x-search-form placeholder="influencer or participant no" />
@endpush
