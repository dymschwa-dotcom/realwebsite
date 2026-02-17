@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Brand')</th>
                                <th>@lang('Email-Mobile')</th>
                                <th>@lang('Country')</th>
                                <th>@lang('Joined At')</th>
                                <th>@lang('Balance')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
@forelse($users as $user)
<tr>
    <td>
        <span class="fw-bold">{{$user->fullname}}</span>
        <br>
        <span class="small">
            <a href="{{ route('admin.users.detail', $user->id) }}"><span>@</span>{{ $user->username }}</a>
        </span>
    </td>

    <td>
        {{ $user->email }}<br>{{ $user->mobileNumber }}
    </td>
    <td>
        <span class="fw-bold" title="{{ @$user->country_name }}">{{ $user->country_code }}</span>
    </td>

    <td>
        {{ showDateTime($user->created_at) }} <br> {{ diffForHumans($user->created_at) }}
    </td>

    <td>
        <span class="fw-bold">
            {{ showAmount($user->balance) }}
        </span>
    </td>

    <td>
        <div class="button--group">
            <a href="{{ route('admin.users.detail', $user->id) }}" class="btn btn-sm btn-outline--primary">
                <i class="las la-desktop"></i> @lang('Details')
            </a>

            @if (request()->routeIs('admin.users.kyc.pending'))
            <a href="{{ route('admin.users.kyc.details', $user->id) }}" target="_blank" class="btn btn-sm btn-outline--dark">
                <i class="las la-user-check"></i> @lang('KYC Data')
            </a>
            @endif

            @if($user->status == 1)
                <button class="btn btn-sm btn-outline--warning confirmationBtn" 
                    data-action="{{ route('admin.users.status', $user->id) }}" 
                    data-question="@lang('Are you sure to ban this brand?')">
                    <i class="las la-user-alt-slash"></i> @lang('Ban')
                </button>
            @else
                <button class="btn btn-sm btn-outline--success confirmationBtn" 
                    data-action="{{ route('admin.users.status', $user->id) }}" 
                    data-question="@lang('Are you sure to unban this brand?')">
                    <i class="las la-user-check"></i> @lang('Unban')
                </button>
            @endif

            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('EXTREME WARNING: This will permanently delete this brand and all their data. Continue?')" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline--danger">
                    <i class="las la-trash-alt"></i> @lang('Delete')
                </button>
            </form>
        </div>
    </td>
</tr>
@empty
    <tr>
        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
    </tr>
@endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($users->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($users) }}
                </div>
                @endif
            </div>
        </div>


    </div>
@endsection



@push('breadcrumb-plugins')
    <x-search-form placeholder="Username / Email" />
@endpush

<x-confirmation-modal />

@push('script')
<script>
    (function($) {
        "use strict";
        // Using $(document).on handles buttons even if they are inside an AJAX-loaded table
        $(document).on('click', '.confirmationBtn', function() {
            var modal = $('#confirmationModal');
            let data = $(this).data();
            
            // 1. Clear any old reason fields so they don't stack up
            modal.find('.reason-field').remove();

            // 2. Set the modal question and form action
            modal.find('.question').text(`${data.question}`);
            modal.find('form').attr('action', data.action);

            // 3. Check if the button is for banning
            var questionText = data.question.toLowerCase();
            if (questionText.includes('ban')) {
                let html = `
                    <div class="form-group reason-field">
                        <hr>
                        <label class="fw-bold mt-2">@lang('Reason for Ban')</label>
                        <textarea name="reason" class="form-control" rows="4" placeholder="@lang('Why is this account being banned?')" required></textarea>
                    </div>`;
                modal.find('.modal-body').append(html);
            }

            // 4. Show the modal
            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush
