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
                                    <th>@lang('Title')</th>
                                    <th>@lang('Brand')</th>
                                    @if (request()->routeIs('admin.campaign.approved') || request()->routeIs('admin.campaign.index'))
                                        <th>@lang('Participate')</th>
                                    @endif
                                    <th>@lang('Budget')</th>
                                    <th>@lang('Created At')</th>
                                    @if (request()->routeIs('admin.campaign.index'))
                                        <th>@lang('Status')</th>
                                    @endif
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($campaigns as $campaign)
                                    <tr>
                                        <td>{{ __(strLimit($campaign->title, 50)) }}</td>
                                        <td>
                                            <span class="fw-bold">{{ __(@$campaign->user->fullname) }}</span>
                                            <br>
                                            <span class="small">
                                                <a
                                                    href="{{ route('admin.users.detail', $campaign->user_id) }}"><span>@</span>{{ @$campaign->user->username }}</a>
                                            </span>
                                        </td>
                                        @if (request()->routeIs('admin.campaign.approved') || request()->routeIs('admin.campaign.index'))
                                            <td>
                                                <a href="{{ route('admin.campaign.participants', $campaign->id) }}">
                                                    {{ getAmount($campaign->participants_count) }}
                                                </a>
                                            </td>
                                        @endif
                                        <td>{{ showAmount($campaign->budget) }} </td>
                                        <td>{{ showDateTime($campaign->updated_at) }}</td>
                                        @if (request()->routeIs('admin.campaign.index'))
                                            <td>
                                                @php
                                                    echo $campaign->statusBadge;
                                                @endphp
                                            </td>
                                        @endif
                                        <td>
                                            <div class="button--group">
                                                <a class="btn btn-sm btn-outline--primary"
                                                    href="{{ route('admin.campaign.detail', $campaign->id) }}">
                                                    <i class="la la-desktop"></i> @lang('Detail')
                                                </a>
                                                @if (request()->routeIs('admin.campaign.approved') || request()->routeIs('admin.campaign.index'))
                                                    <a class="btn btn-sm btn-outline--info"
                                                        href="{{ route('admin.campaign.participants', $campaign->id) }}">
                                                        <i class="la la-users"></i> @lang('Participants')
                                                    </a>
                                                @endif
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
                @if ($campaigns->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($campaigns) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Title or Brand" />
@endpush
