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
                                <th>@lang('Influencer')</th>
                                <th>@lang('Email-Mobile')</th>
                                <th>@lang('Country')</th>
                                <th>@lang('Joined At')</th>
                                <th>@lang('Balance')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($influencers as $user)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{$user->fullname}}</span>
                                    <br>
                                    <span class="small">
                                    <a href="{{ route('admin.influencer.detail', $user->id) }}"><span>@</span>{{ $user->username }}</a>
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
    <a href="{{ route('admin.influencer.detail', $user->id) }}" class="btn btn-sm btn-outline--primary">
        <i class="las la-desktop"></i> @lang('Details')
    </a>
    
    @if($user->status == 1)
        <button class="btn btn-sm btn-outline--warning confirmationBtn" data-action="{{ route('admin.influencer.status', $user->id) }}" data-question="@lang('Are you sure to ban this influencer?')">
            <i class="las la-user-alt-slash"></i> @lang('Ban')
        </button>
    @else
        <button class="btn btn-sm btn-outline--success confirmationBtn" data-action="{{ route('admin.influencer.status', $user->id) }}" data-question="@lang('Are you sure to unban this influencer?')">
            <i class="las la-user-check"></i> @lang('Unban')
        </button>
    @endif

    @if (request()->routeIs('admin.influencer.kyc.pending'))
    <a href="{{ route('admin.influencer.kyc.details', $user->id) }}" target="_blank" class="btn btn-sm btn-outline--dark">
        <i class="las la-user-check"></i>@lang('KYC Data')
    </a>
    @endif

    <form action="{{ route('admin.influencer.delete', $user->id) }}" method="POST" onsubmit="return confirm('WARNING: Permanent deletion. Continue?')" class="d-inline">
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
                @if ($influencers->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($influencers) }}
                </div>
                @endif
            </div>
        </div>


    </div>
    
@endsection

<x-confirmation-modal />

@push('breadcrumb-plugins')
    <x-search-form placeholder="Username / Email" />
@endpush

@push('script')
<script>
    (function($){
        "use strict";
        $('.confirmationBtn').on('click', function () {
            var modal = $('#confirmationModal');
            let data = $(this).data();
            
            // 1. Clean up any previous boxes
            modal.find('.reason-field').remove(); 

            // 2. Set basic modal info
            modal.find('.question').text(`${data.question}`);
            modal.find('form').attr('action', data.action);
            
            // 3. Force the reason box to appear if the question contains "ban"
            // This is more reliable than checking CSS classes
            var questionText = data.question.toLowerCase();
            if(questionText.includes('ban')){
                let html = `
                    <div class="form-group reason-field">
                        <label class="fw-bold mt-3">@lang('Reason for Ban')</label>
                        <textarea name="reason" class="form-control" rows="4" required></textarea>
                    </div>`;
                modal.find('.modal-body').append(html);
            }
            
            modal.modal('show');
        });
    })(jQuery);
</script>    
@endpush
