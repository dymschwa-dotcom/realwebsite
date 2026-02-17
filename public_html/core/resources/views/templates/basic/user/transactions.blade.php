@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="show-filter mb-3 text-end">
        <button class="btn btn--base showFilterBtn btn-sm" type="button"><i class="las la-filter"></i>
            @lang('Filter')</button>
    </div>
    <div class="card custom--card responsive-filter-card mb-4">
        <div class="card-body">
            <form>
                <div class="d-flex flex-wrap gap-2">
                    <div class="flex-grow-1">
                        <label class="form-label">@lang('Transaction Number')</label>
                        <input class="form-control form--control" name="search" type="search"
                               value="{{ request()->search }}">
                    </div>
                    <div class="flex-grow-1 select2-parent">
                        <label class="form-label d-block">@lang('Type')</label>
                        <select class="form-select form--control select2" name="trx_type"
                                data-minimum-results-for-search="-1">
                            <option value="">@lang('All')</option>
                            <option value="+" @selected(request()->trx_type == '+')>@lang('Plus')</option>
                            <option value="-" @selected(request()->trx_type == '-')>@lang('Minus')</option>
                        </select>
                    </div>
                    <div class="flex-grow-1 select2-parent">
                        <label class="form-label d-block">@lang('Remark')</label>
                        <select class="form-select form--control select2" name="remark"
                                data-minimum-results-for-search="-1">
                            <option value="">@lang('All')</option>
                            @foreach ($remarks as $remark)
                                <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>
                                    {{ __(keyToTitle($remark->remark)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-grow-1 align-self-end">
                        <button class="btn btn--base w-100"><i class="las la-filter"></i> @lang('Filter')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="dashboard-table">
        <table class="table--responsive--xxl table">
            <thead>
                <tr>
                    <th>@lang('Trx')</th>
                    <th>@lang('Transacted')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Post Balance')</th>
                    <th>@lang('Detail')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                    <tr>
                        <td>
                            <strong>{{ $trx->trx }}</strong>
                        </td>

                        <td>
                            {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                        </td>

                        <td>
                            <span
                                  class="fw-bold @if ($trx->trx_type == '+') text--success @else text--danger @endif">
                                {{ $trx->trx_type }} {{ showAmount($trx->amount) }}
                            </span>
                        </td>

                        <td>
                            {{ showAmount($trx->post_balance) }}
                        </td>

                        <td>{{ __($trx->details) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center not-found" colspan="100%">
                            <div>
                                <i class="las la-2x la-list"></i>
                                <br>
                                {{ __($emptyMessage) }}
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($transactions->hasPages())
        <div class="mt-4">
            {{ paginateLinks($transactions) }}
        </div>
    @endif
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.select2').each(function(index, element) {
                $(element).select2();
            });

        })(jQuery);
    </script>
@endpush
