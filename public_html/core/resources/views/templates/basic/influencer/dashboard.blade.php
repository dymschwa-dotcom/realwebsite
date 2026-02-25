@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="notice"></div>
            @if (!$influencer->stripe_onboarded || !$influencer->address || !$influencer->tax_number)
                <div class="alert alert--danger" role="alert">
                    <div class="alert__icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <p class="alert__message">
                        <span class="fw-bold">@lang('Payouts Paused - Action Required')</span><br>
                        <small>
                            @lang('Your profile is live and you can apply for campaigns, but you cannot withdraw funds until you complete the following:')
                            <ul class="mt-2 mb-0 ms-3">
                                @if(!$influencer->stripe_onboarded)
                                    <li><a href="{{ route('influencer.payment.index') }}" class="link-color fw-bold">@lang('Connect Stripe Express')</a> - @lang('Required to receive instant, automated payments.')</li>
                                @endif
                                @if(!$influencer->address || !$influencer->tax_number)
                                    <li><a href="{{ route('influencer.profile.setting') }}" class="link-color fw-bold">@lang('Update Profile Details')</a> - @lang('Required for New Zealand tax compliance (Address, Tax ID & GST Status).')</li>
                                @endif
                            </ul>
                        </small>
                    </p>
                </div>
            @endif
            @php
                $kyc = getContent('influencer_kyc.content', true);
            @endphp
            @if ($influencer->kv == Status::KYC_UNVERIFIED && $influencer->kyc_rejection_reason)
                <div class="alert alert--danger" role="alert">
                    <div class="alert__icon"><i class="fas fa-file-signature"></i></div>
                    <p class="alert__message">
                        <span class="fw-bold">@lang('KYC Documents Rejected')</span><br>
                        <small>
                            <i>{{ __(@$kyc->data_values->reject) }}
                                <a class="link-color" data-bs-toggle="modal" data-bs-target="#kycRejectionReason"
                                   href="javascript::void(0)">@lang('Click here')</a> @lang('to show the reason').

                                <a class="link-color" href="{{ route('influencer.kyc.form') }}">@lang('Click Here')</a>
                                @lang('to Re-submit Documents'). <br>
                                <a class="link-color" href="{{ route('influencer.kyc.data') }}">@lang('See KYC Data')</a>
                            </i>
                        </small>
                    </p>
                    
                </div>
            @elseif ($influencer->kv == Status::KYC_UNVERIFIED)
                <div class="alert alert--info" role="alert">
                    <div class="alert__icon"><i class="fas fa-file-signature"></i></div>
                    <p class="alert__message">
                        <span class="fw-bold">@lang('KYC Verification Required')</span><br>
                        <small>
                            <i>{{ __(@$kyc->data_values->required) }}
                                <a class="link-color" href="{{ route('influencer.kyc.form') }}">@lang('Click here')</a>
                                @lang('to submit KYC information').
                            </i>
                        </small>
                    </p>
                </div>
            @elseif($influencer->kv == Status::KYC_PENDING)
                <div class="alert alert--warning" role="alert">
                    <div class="alert__icon"><i class="fas fa-user-check"></i></div>
                    <p class="alert__message">
                        <span class="fw-bold">@lang('KYC Verification Pending')</span><br>
                        <small>
                            <i>{{ __(@$kyc->data_values->pending) }} <a class="link-color"
                                   href="{{ route('influencer.kyc.data') }}">@lang('Click here')</a>
                                @lang('to see your submitted information')
                            </i>
                        </small>
                    </p>
                </div>
            @endif
        </div>
    </div>


    <div class="row gy-4 justify-content-center">
        <div class="col-lg-6 col-md-6">
            <div class="dashboard-card__two">
                <div class="dashboard-card__two-header primary">
                    <div class="title">
                        <h6>@lang('Completed campaigns')</h6>
                    </div>
                    <div class="icon">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_181_44592)">
                                <path
                                      d="M8.0763 7.25993L8.1713 7.34293L16.6573 15.8279C16.7685 15.939 16.852 16.0748 16.9009 16.2242C16.9498 16.3736 16.9628 16.5325 16.9389 16.6878C16.9149 16.8432 16.8546 16.9907 16.763 17.1185C16.6713 17.2462 16.5508 17.3505 16.4113 17.4229L16.2953 17.4729L5.9103 21.2999C3.9583 22.0199 2.0573 20.1849 2.6503 18.2359L2.7003 18.0899L6.5263 7.70493C6.57688 7.56737 6.65708 7.4426 6.76123 7.33947C6.86538 7.23634 6.99093 7.15736 7.12898 7.10813C7.26704 7.0589 7.41423 7.04062 7.56013 7.05458C7.70604 7.06855 7.84709 7.11441 7.9733 7.18893L8.0763 7.25993ZM17.1073 11.6039C18.0183 11.6519 19.2673 11.8439 20.3533 12.4959C20.5735 12.6265 20.7352 12.8364 20.8052 13.0826C20.8752 13.3288 20.8481 13.5925 20.7296 13.8193C20.6111 14.0461 20.41 14.2189 20.168 14.302C19.9259 14.3851 19.6612 14.3722 19.4283 14.2659L19.3243 14.2109C18.6423 13.8009 17.7703 13.6409 17.0023 13.6009C16.6859 13.5826 16.3686 13.584 16.0523 13.6049L15.7363 13.6359C15.4754 13.6696 15.2118 13.5991 15.0025 13.4398C14.7933 13.2805 14.6552 13.0451 14.6182 12.7847C14.5813 12.5243 14.6484 12.2598 14.8051 12.0485C14.9618 11.8372 15.1954 11.6962 15.4553 11.6559C16.003 11.5852 16.5562 11.5674 17.1073 11.6029M19.1323 8.81693C19.3871 8.81747 19.6321 8.91524 19.8172 9.09029C20.0024 9.26534 20.1137 9.50446 20.1285 9.75883C20.1433 10.0132 20.0605 10.2636 19.8969 10.459C19.7333 10.6543 19.5013 10.7798 19.2483 10.8099L19.1323 10.8169H18.4243C18.1695 10.8164 17.9245 10.7186 17.7394 10.5436C17.5542 10.3685 17.4429 10.1294 17.4281 9.87504C17.4133 9.62068 17.4961 9.37025 17.6597 9.17491C17.8233 8.97956 18.0553 8.85402 18.3083 8.82393L18.4243 8.81693H19.1323ZM15.9503 8.04993C16.1225 8.22213 16.2259 8.45123 16.2412 8.69425C16.2565 8.93728 16.1826 9.17753 16.0333 9.36993L15.9503 9.46393L14.8893 10.5249C14.7093 10.7043 14.4679 10.8084 14.2139 10.8162C13.96 10.8239 13.7126 10.7347 13.522 10.5667C13.3315 10.3987 13.212 10.1644 13.1879 9.91146C13.1638 9.65854 13.2369 9.40593 13.3923 9.20493L13.4753 9.11093L14.5353 8.05093C14.6282 7.95796 14.7385 7.8842 14.8599 7.83387C14.9813 7.78355 15.1114 7.75765 15.2428 7.75765C15.3742 7.75765 15.5043 7.78355 15.6257 7.83387C15.7471 7.8842 15.8574 7.95696 15.9503 8.04993ZM13.3633 2.78493C13.8113 4.13093 13.5713 5.60493 13.2913 6.63493C13.123 7.27708 12.8919 7.90109 12.6013 8.49793C12.4829 8.7353 12.275 8.91591 12.0234 9.00002C11.7719 9.08413 11.4972 9.06485 11.2598 8.94643C11.0224 8.82801 10.8418 8.62015 10.7577 8.36857C10.6736 8.11699 10.6929 7.8423 10.8113 7.60493C11.0493 7.12993 11.2213 6.61993 11.3613 6.10893C11.5883 5.27693 11.7023 4.37393 11.5273 3.63393L11.4663 3.41793C11.4227 3.29287 11.4044 3.1604 11.4124 3.02821C11.4205 2.89602 11.4547 2.76674 11.5131 2.64787C11.5715 2.52901 11.6529 2.42293 11.7527 2.3358C11.8524 2.24866 11.9685 2.1822 12.0941 2.14028C12.2197 2.09836 12.3524 2.08182 12.4845 2.0916C12.6166 2.10138 12.7454 2.13731 12.8635 2.19728C12.9815 2.25725 13.0865 2.34008 13.1723 2.44096C13.2581 2.54184 13.323 2.65876 13.3633 2.78493ZM18.7783 5.22293C18.9658 5.41046 19.0711 5.66477 19.0711 5.92993C19.0711 6.1951 18.9658 6.44941 18.7783 6.63693L18.0713 7.34393C17.9791 7.43944 17.8687 7.51563 17.7467 7.56804C17.6247 7.62044 17.4935 7.64803 17.3607 7.64918C17.2279 7.65034 17.0962 7.62504 16.9733 7.57476C16.8504 7.52447 16.7388 7.45022 16.6449 7.35633C16.551 7.26244 16.4768 7.15078 16.4265 7.02789C16.3762 6.90499 16.3509 6.77331 16.352 6.64053C16.3532 6.50775 16.3808 6.37653 16.4332 6.25453C16.4856 6.13253 16.5618 6.02218 16.6573 5.92993L17.3643 5.22293C17.5518 5.03546 17.8061 4.93015 18.0713 4.93015C18.3365 4.93015 18.5908 5.03546 18.7783 5.22293Z" />
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="dashboard-card__two-content">
                    <h4 class="mb-0">{{ getAmount($completedCampaign) }}</h4>
                </div>
            </div>
        </div>
    
        <div class="col-lg-6 col-md-6">
            <div class="dashboard-card__two">
                <div class="dashboard-card__two-header danger">
                    <div class="title">
                        <h6>@lang('Total withdraw')</h6>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                </div>
                <div class="dashboard-card__two-content">
                    <h4 class="mb-0">{{ showAmount($totalWithdraws) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4 mt-1">
        <div class="col-lg-7">
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
                                              d="M21.1781 9.6375C20.8219 9.27188 20.4562 8.8875 20.3156 8.55938C20.175 8.23125 20.1844 7.74375 20.175 7.24688C20.1656 6.3375 20.1469 5.29688 19.425 4.575C18.7031 3.85312 17.6625 3.83437 16.7531 3.825C16.2562 3.81562 15.75 3.80625 15.4406 3.68437C15.1312 3.5625 14.7281 3.17813 14.3625 2.82188C13.7156 2.20313 12.975 1.5 12 1.5C11.025 1.5 10.2844 2.20313 9.6375 2.82188C9.27188 3.17813 8.8875 3.54375 8.55938 3.68437C8.23125 3.825 7.74375 3.81562 7.24688 3.825C6.3375 3.83437 5.29688 3.85312 4.575 4.575C3.85312 5.29688 3.83437 6.3375 3.825 7.24688C3.81562 7.74375 3.80625 8.25 3.68437 8.55938C3.5625 8.86875 3.17813 9.27188 2.82188 9.6375C2.20313 10.2844 1.5 11.025 1.5 12C1.5 12.975 2.20313 13.7156 2.82188 14.3625C3.17813 14.7281 3.54375 15.1125 3.68437 15.4406C3.825 15.7687 3.81562 16.2562 3.825 16.7531C3.83437 17.6625 3.85312 18.7031 4.575 19.425C5.29688 20.1469 6.3375 20.1656 7.24688 20.175C7.74375 20.1844 8.25 20.1938 8.55938 20.3156C8.86875 20.4375 9.27188 20.8219 9.6375 21.1781C10.2844 21.7969 11.025 22.5 12 22.5C12.975 22.5 13.7156 21.7969 14.3625 21.1781C14.7281 20.8219 15.1125 20.4562 15.4406 20.3156C15.7687 20.175 16.2562 20.1844 16.7531 20.175C17.6625 20.1656 18.7031 20.1469 19.425 19.425C20.1469 18.7031 20.1656 17.6625 20.175 16.7531C20.1844 16.2562 20.1938 15.75 20.3156 15.4406C20.4375 15.1312 20.8219 14.7281 21.1781 14.3625C21.7969 13.7156 22.5 12.975 22.5 12C22.5 11.025 21.7969 10.2844 21.1781 9.6375ZM16.6406 10.2938L11.1469 15.5438C11.0048 15.6774 10.8169 15.7512 10.6219 15.75C10.4298 15.7507 10.2449 15.6768 10.1063 15.5438L7.35938 12.9188C7.28319 12.8523 7.22123 12.7711 7.17722 12.6801C7.1332 12.589 7.10805 12.49 7.10328 12.389C7.0985 12.2881 7.11419 12.1871 7.14941 12.0924C7.18463 11.9976 7.23865 11.9109 7.30822 11.8375C7.37779 11.7642 7.46148 11.7056 7.55426 11.6654C7.64703 11.6252 7.74697 11.6042 7.84808 11.6036C7.94919 11.603 8.04937 11.6229 8.14261 11.662C8.23584 11.7011 8.32021 11.7587 8.39062 11.8312L10.6219 13.9594L15.6094 9.20625C15.7552 9.07902 15.9446 9.01309 16.1379 9.02223C16.3312 9.03138 16.5135 9.1149 16.6467 9.25533C16.7798 9.39576 16.8535 9.58222 16.8524 9.77575C16.8513 9.96928 16.7754 10.1549 16.6406 10.2938Z" />
                                    </svg></span>
                                <p> {{ __($activity->title) }} </p>
                            </li>

                        @empty
                            <li>@lang('No activity found')</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="refferal-card">
                <div class="refferal-card-header">
                    <h6 class="title mb-0 text--danger">@lang('Referral link')</h6>
                </div>
                <div class="refferal-card-content">
                    <div class="qr-code text--base mb-3">
                        <div class="qr-code-copy-form" data-copy="true">
                            @php
                                $referralLink = route('influencer.register') . '?reference=' . $influencer->referral_code;
                            @endphp
                            <input id="qr-code-text" type="text" value="{{ $referralLink }}" readonly="">
                            <button class="text-copy-btn copy-btn text-white" data-bs-toggle="tooltip"
                                    data-bs-original-title="Copy to clipboard" type="button"><i
                                   class="fas fa-copy copyBtn"></i>
                            </button>
                        </div>
                    </div>
                    <p>@lang('Total referred:') {{ @$influencer->all_referrals_count ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    @if ($influencer->kv == Status::KYC_UNVERIFIED && $influencer->kyc_rejection_reason)
        <div class="modal fade" id="kycRejectionReason">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('KYC Document Rejection Reason')</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ $influencer->kyc_rejection_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection


@push('script')
    <script>
        (function($) {
            "use strict";
            $('.copyBtn').on('click', function(e) {
                var linkElement = $('#qr-code-text');
                var link = linkElement.val();
                var temp = $("<input>");
                $("body").append(temp);
                temp.val(link).select();
                document.execCommand("copy");
                temp.remove();
                linkElement.css({
                    'background-color': "#{{ gs('base_color') }}",
                    'color': '#fff'
                });
                linkElement.blur();
            });
        })(jQuery)
    </script>
@endpush

