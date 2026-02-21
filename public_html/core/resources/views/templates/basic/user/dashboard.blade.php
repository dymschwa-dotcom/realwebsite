@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="notice"></div>
            @php
                $kyc = getContent('brand_kyc.content', true);
            @endphp

            @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
                <div class="alert alert--danger mb-4" role="alert">
                    <div class="alert__icon"><i class="fas fa-file-signature"></i></div>
                    <p class="alert__message">
                        <span class="fw-bold">@lang('KYC Documents Rejected')</span><br>
                        <small>
                            <i>{{ __(@$kyc->data_values->reject) }}
                                <a class="link-color" data-bs-toggle="modal" data-bs-target="#kycRejectionReason"
                                   href="javascript::void(0)">@lang('Click here')</a> @lang('to show the reason').

                                <a class="link-color" href="{{ route('user.kyc.form') }}">@lang('Click Here')</a>
                                @lang('to Re-submit Documents'). <br>
                                <a class="link-color" href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a>
                            </i>
                        </small>
                    </p>
                </div>
            @elseif (auth()->user()->kv == Status::KYC_UNVERIFIED)
                <div class="alert alert--info mb-4" role="alert">
                    <div class="alert__icon"><i class="fas fa-file-signature"></i></div>
                    <p class="alert__message">
                        <span class="fw-bold">@lang('KYC Verification Required')</span><br>
                        <small>
                            <i>{{ __(@$kyc->data_values->required) }}
                                <a class="link-color" href="{{ route('user.kyc.form') }}">@lang('Click here')</a>
                                @lang('to submit KYC information').
                            </i>
                        </small>
                    </p>
                </div>
            @elseif(auth()->user()->kv == Status::KYC_PENDING)
                <div class="alert alert--warning mb-4" role="alert">
                    <div class="alert__icon"><i class="fas fa-user-check"></i></div>
                    <p class="alert__message">
                        <span class="fw-bold">@lang('KYC Verification Pending')</span><br>
                        <small>
                            <i>{{ __(@$kyc->data_values->pending) }} <a class="link-color"
                                   href="{{ route('user.kyc.data') }}">@lang('Click here')</a>
                                @lang('to see your submitted information')
                            </i>
                        </small>
                    </p>
                </div>
            @endif
        </div>
    </div>

    <div class="row gy-4">
        <div class="col-xl-4 col-lg-6 col-sm-6">
            <div class="dashboard-card">
                <div class="dashboard-card__content">
                    <p class="dashboard-card__title">@lang('Balance')</p>
                    <h4 class="dashboard-card__amount">{{ showAmount(auth()->user()->balance) }}</h4>
                </div>
                <a href="{{ route('user.campaign.approved') }}" class="dashboard-card__icon card--primary">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <path fill="" fill-rule="evenodd" d="M12.893 2.875c-.414-.118-.876-.125-2.093-.125H4a1.25 1.25 0 1 0 0 2.5h11.5l-.18-.24c-.73-.973-1.013-1.339-1.355-1.599a3.25 3.25 0 0 0-1.072-.536zm4.482 2.375-.855-1.14-.068-.09c-.639-.852-1.05-1.401-1.58-1.804a4.75 4.75 0 0 0-1.568-.783c-.64-.183-1.326-.183-2.39-.183H4A2.75 2.75 0 0 0 1.25 4v13.232c0 .813 0 1.469.043 2 .045.546.14 1.026.366 1.47a3.75 3.75 0 0 0 1.639 1.64c.444.226.924.32 1.47.365.531.043 1.187.043 2 .043h10.464c.813 0 1.469 0 2-.043.546-.045 1.026-.14 1.47-.366a3.75 3.75 0 0 0 1.64-1.638c.226-.445.32-.925.365-1.471.043-.531.043-1.187.043-2v-6.464c0-.813 0-1.469-.043-2-.045-.546-.14-1.026-.366-1.47a3.75 3.75 0 0 0-1.639-1.64c-.444-.226-.924-.32-1.47-.365-.5-.04-1.11-.043-1.857-.043zM4 6.75c-.45 0-.875-.108-1.25-.3V17.2c0 .853 0 1.447.038 1.91.037.453.107.714.207.912.216.423.56.767.984.983.197.1.458.17.912.207.462.037 1.057.038 1.909.038h10.4c.853 0 1.447 0 1.91-.038.453-.037.714-.107.911-.207a2.25 2.25 0 0 0 .984-.983c.1-.198.17-.459.207-.913.029-.357.036-.794.037-1.367a3.75 3.75 0 0 1 0-7.484 18.388 18.388 0 0 0-.037-1.367c-.038-.454-.107-.715-.207-.912a2.25 2.25 0 0 0-.984-.984c-.197-.1-.458-.17-.912-.207-.462-.037-1.057-.038-1.909-.038zm17.25 5.014a2.25 2.25 0 0 0 0 4.472zm-11.2-.364a.75.75 0 0 1 1.05.15l1.5 2c.2.267.2.633 0 .9l-1.5 2a.75.75 0 1 1-1.2-.9l.6-.8H7a.75.75 0 0 1 0-1.5h3.5l-.6-.8a.75.75 0 0 1 .15-1.05z" clip-rule="evenodd" opacity="1" data-original="" class=""></path>
                        </g>
                    </svg>
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-sm-6">
            <div class="dashboard-card">
                <div class="dashboard-card__content">
                    <p class="dashboard-card__title">@lang('Total spending')</p>
                    <h4 class="dashboard-card__amount">{{ showAmount($data['total_spending']) }}</h4>
                </div>
                <div class="dashboard-card__icon card--warning">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 24" fill="none">
                        <path
                              d="M21.333 4H3.33301C3.06779 4 2.81344 4.10536 2.6259 4.29289C2.43836 4.48043 2.33301 4.73478 2.33301 5V19C2.33301 19.2652 2.43836 19.5196 2.6259 19.7071C2.81344 19.8946 3.06779 20 3.33301 20H21.333C21.5982 20 21.8526 19.8946 22.0401 19.7071C22.2277 19.5196 22.333 19.2652 22.333 19V5C22.333 4.73478 22.2277 4.48043 22.0401 4.29289C21.8526 4.10536 21.5982 4 21.333 4ZM20.333 15C19.5374 15 18.7743 15.3161 18.2117 15.8787C17.6491 16.4413 17.333 17.2044 17.333 18H7.33301C7.33301 17.2044 7.01694 16.4413 6.45433 15.8787C5.89172 15.3161 5.12866 15 4.33301 15V9C5.12866 9 5.89172 8.68393 6.45433 8.12132C7.01694 7.55871 7.33301 6.79565 7.33301 6H17.333C17.333 6.79565 17.6491 7.55871 18.2117 8.12132C18.7743 8.68393 19.5374 9 20.333 9V15Z">
                        </path>
                        <path
                              d="M12.333 8C10.127 8 8.33301 9.794 8.33301 12C8.33301 14.206 10.127 16 12.333 16C14.539 16 16.333 14.206 16.333 12C16.333 9.794 14.539 8 12.333 8ZM12.333 14C11.23 14 10.333 13.103 10.333 12C10.333 10.897 11.23 10 12.333 10C13.436 10 14.333 10.897 14.333 12C14.333 13.103 13.436 14 12.333 14Z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12">
            <div class="dashboard-card">
                <div class="dashboard-card__content">
                    <p class="dashboard-card__title">@lang('Total hired')</p>
                    <h4 class="dashboard-card__amount">{{ getAmount($data['total_participant']) }}</h4>
                </div>
                <div class="dashboard-card__icon card--base">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 24" fill="none">
                        <path
                              d="M8.66699 12.052C10.662 12.052 12.167 10.547 12.167 8.552C12.167 6.557 10.662 5.052 8.66699 5.052C6.67199 5.052 5.16699 6.557 5.16699 8.552C5.16699 10.547 6.67199 12.052 8.66699 12.052ZM9.66699 13H7.66699C4.90999 13 2.66699 15.243 2.66699 18V19H14.667V18C14.667 15.243 12.424 13 9.66699 13ZM19.031 2.636L17.617 4.05C18.938 5.373 19.667 7.131 19.667 9C19.667 10.869 18.938 12.627 17.617 13.95L19.031 15.364C20.731 13.663 21.667 11.403 21.667 9C21.667 6.597 20.731 4.337 19.031 2.636Z">
                        </path>
                        <path
                              d="M16.2021 5.464L14.7881 6.88C15.3551 7.445 15.6671 8.198 15.6671 9C15.6671 9.802 15.3551 10.555 14.7881 11.12L16.2021 12.536C17.1461 11.592 17.6671 10.337 17.6671 9C17.6671 7.663 17.1461 6.408 16.2021 5.464Z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4 mt-1">
        <div class="col-lg-6">
            <div class="campaign-status">
    <h4 class="campaign-status__title">
        @lang('Hiring & Work Progress')
    </h4>
    
    {{-- Pending Requests --}}
    <div class="campaign-status__item">
        <div class="campaign-status__item-left">
            <span class="icon card--warning">
                <i class="fas fa-user-clock"></i>
            </span>
            <span class="content">@lang('Pending Requests')</span>
        </div>
        <div class="campaign-status__item-right">
            <span>{{ $data['jobs_pending'] }}</span>
        </div>
    </div>

    {{-- Ongoing Jobs --}}
    <div class="campaign-status__item">
        <div class="campaign-status__item-left">
            <span class="icon card--primary">
                <i class="fas fa-spinner fa-spin"></i>
            </span>
            <span class="content">@lang('Ongoing Jobs')</span>
        </div>
        <div class="campaign-status__item-right">
            <span>{{ $data['jobs_ongoing'] }}</span>
        </div>
    </div>

    {{-- Awaiting Review (Delivered) --}}
    <div class="campaign-status__item">
        <div class="campaign-status__item-left">
            <span class="icon card--info">
                <i class="fas fa-file-import"></i>
            </span>
            <span class="content">@lang('Awaiting Review')</span>
        </div>
        <div class="campaign-status__item-right">
            <span>{{ $data['jobs_delivered'] }}</span>
        </div>
    </div>

    {{-- Completed --}}
    <div class="campaign-status__item">
        <div class="campaign-status__item-left">
            <span class="icon card--success">
                <i class="fas fa-check-double"></i>
            </span>
            <span class="content">@lang('Completed Jobs')</span>
        </div>
        <div class="campaign-status__item-right">
            <span>{{ $data['jobs_completed'] }}</span>
        </div>
    </div>
</div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="custom--card h-100">
                <div class="card-body">
                    <h4 class="campaign-status__title">
                        @lang('Recent Activities')
                    </h4>
                    <ul class="recent-activices">
                        @forelse ($activities as $activity)
                            <li class="recent-activices__item">
                                <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="none">
                                        <path
                                              d="M21.1781 9.6375C20.8219 9.27188 20.4562 8.8875 20.3156 8.55938C20.175 8.23125 20.1844 7.74375 20.175 7.24688C20.1656 6.3375 20.1469 5.29688 19.425 4.575C18.7031 3.85312 17.6625 3.83437 16.7531 3.825C16.2562 3.81562 15.75 3.80625 15.4406 3.68437C15.1312 3.5625 14.7281 3.17813 14.3625 2.82188C13.7156 2.20313 12.975 1.5 12 1.5C11.025 1.5 10.2844 2.20313 9.6375 2.82188C9.27188 3.17813 8.8875 3.54375 8.55938 3.68437C8.23125 3.825 7.74375 3.81562 7.24688 3.825C6.3375 3.83437 5.29688 3.85312 4.575 4.575C3.85312 5.29688 3.83437 6.3375 3.825 7.24688C3.81562 7.74375 3.80625 8.25 3.68437 8.55938C3.5625 8.86875 3.17813 9.27188 2.82188 9.6375C2.20313 10.2844 1.5 11.025 1.5 12C1.5 12.975 2.20313 13.7156 2.82188 14.3625C3.17813 14.7281 3.54375 15.1125 3.68437 15.4406C3.825 15.7687 3.81562 16.2562 3.825 16.7531C3.83437 17.6625 3.85312 18.7031 4.575 19.425C5.29688 20.1469 6.3375 20.1656 7.24688 20.175C7.74375 20.1844 8.25 20.1938 8.55938 20.3156C8.86875 20.4375 9.27188 20.8219 9.6375 21.1781C10.2844 21.7969 11.025 22.5 12 22.5C12.975 22.5 13.7156 21.7969 14.3625 21.1781C14.7281 20.8219 15.1125 20.4562 15.4406 20.3156C15.7687 20.175 16.2562 20.1844 16.7531 20.175C17.6625 20.1656 18.7031 20.1469 19.425 19.425C20.1469 18.7031 20.1656 17.6625 20.175 16.7531C20.1844 16.2562 20.1938 15.75 20.3156 15.4406C20.4375 15.1312 20.8219 14.7281 21.1781 14.3625C21.7969 13.7156 22.5 12.975 22.5 12C22.5 11.025 21.7969 10.2844 21.1781 9.6375ZM16.6406 10.2938L11.1469 15.5438C11.0048 15.6774 10.8169 15.7512 10.6219 15.75C10.4298 15.7507 10.2449 15.6768 10.1063 15.5438L7.35938 12.9188C7.28319 12.8523 7.22123 12.7711 7.17722 12.6801C7.1332 12.589 7.10805 12.49 7.10328 12.389C7.0985 12.2881 7.11419 12.1871 7.14941 12.0924C7.18463 11.9976 7.23865 11.9109 7.30822 11.8375C7.37779 11.7642 7.46148 11.7056 7.55426 11.6654C7.64703 11.6252 7.74697 11.6042 7.84808 11.6036C7.94919 11.603 8.04937 11.6229 8.14261 11.662C8.23584 11.7011 8.32021 11.7587 8.39062 11.8312L10.6219 13.9594L15.6094 9.20625C15.7552 9.07902 15.9446 9.01309 16.1379 9.02223C16.3312 9.03138 16.5135 9.1149 16.6467 9.25533C16.7798 9.39576 16.8535 9.58222 16.8524 9.77575C16.8513 9.96928 16.7754 10.1549 16.6406 10.2938Z">
                                        </path>
                                    </svg></span>
                                <p>{{ __($activity->title) }}</p>
                            </li>
                        @empty
                            <li>@lang('No activity found')</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
        <div class="modal fade" id="kycRejectionReason">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('KYC Document Rejection Reason')</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ auth()->user()->kyc_rejection_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

