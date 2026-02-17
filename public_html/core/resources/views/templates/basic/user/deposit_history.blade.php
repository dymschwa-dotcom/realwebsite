@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashbaord-table-header d-flex justify-content-end mb-3">
        <form class="search-form active">
            <input class="form--control" name="search" type="search" value="{{ request()->search }}" placeholder="@lang('Search by transactions')">
            <button class="search-form__btn" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="row gy-4">
        <div class="dashboard-table">
            <table class="table--responsive--xxl table">
                <thead>
                    <tr>
                        <th>@lang('Gateway | TRX')</th>
                        <th>@lang('Initiated')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Conversion')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Details')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deposits as $deposit)
                        <tr>
                            <td>
                                <div>
                                    <span class="fw-bold">
                                        <span class="text--base">
                                            @if ($deposit->method_code < 5000)
                                                {{ __(@$deposit->gateway->name) }}
                                            @else
                                                @lang('Google Pay')
                                            @endif
                                        </span>
                                    </span>
                                    <br>
                                    <small> {{ $deposit->trx }} </small>
                                </div>
                            </td>

                            <td>
                                <div>
                                    {{ showDateTime($deposit->created_at) }}<br>{{ diffForHumans($deposit->created_at) }}
                                </div>
                            </td>
                            <td>
                                <div>
                                    {{ showAmount($deposit->amount) }} + <span class="text--danger" data-bs-toggle="tooltip" title="@lang('Processing Charge')">{{ showAmount($deposit->charge) }} </span>
                                    <br>
                                    <strong data-bs-toggle="tooltip" title="@lang('Amount with charge')">
                                        {{ showAmount($deposit->amount + $deposit->charge) }}
                                    </strong>
                                </div>
                            </td>
                            <td>
                                <div>
                                    {{ showAmount(1) }} = {{ showAmount($deposit->rate, currencyFormat: false) }} {{ __($deposit->method_currency) }}
                                    <br>
                                    <strong>{{ showAmount($deposit->final_amount, currencyFormat: false) }} {{ __($deposit->method_currency) }}</strong>
                                </div>
                            </td>
                            <td>
                                @php echo $deposit->statusBadge @endphp
                            </td>
                            @php
                                $details = [];
                                if ($deposit->method_code >= 1000 && $deposit->method_code <= 5000) {
                                    foreach (@$deposit->detail ?? [] as $key => $info) {
                                        $details[] = $info;
                                        if ($info->type == 'file') {
                                            $details[$key]->value = route('user.download.attachment', encrypt(getFilePath('verify') . '/' . $info->value));
                                        }
                                    }
                                }
                            @endphp

                            <td>
                                @if ($deposit->method_code >= 1000 && $deposit->method_code <= 5000)
                                    <a class="btn btn--base btn--xsm detailBtn" data-info="{{ json_encode($details) }}" href="javascript:void(0)" @if ($deposit->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif>
                                        <i class="las la-desktop"></i>
                                    </a>
                                @else
                                    <button class="btn btn--success btn--xsm" data-bs-toggle="tooltip" type="button" title="@lang('Automatically processed')">
                                        <i class="las la-check"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center not-found" colspan="100%">
                                <div>
                                    <i class="las la-2x la-frown"></i>
                                    <br>
                                    {{ __($emptyMessage) }}
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($deposits->hasPages())
        <div class="mt-4">
            {{ paginateLinks($deposits) }}
        </div>
    @endif

    {{-- APPROVE MODAL --}}
    <div class="modal fade" id="detailModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush userData mb-2">
                    </ul>
                    <div class="feedback"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');

                var userData = $(this).data('info');
                var html = '';
                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                        } else {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>${element.name}</span>
                                <span"><a href="${element.value}" class="text--base"><i class="fa-regular fa-file"></i> @lang('Attachment')</a></span>
                            </li>`;
                        }
                    });
                }

                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);


                modal.modal('show');
            });

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title], [data-title], [data-bs-title]'))
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

        })(jQuery);
    </script>
@endpush
