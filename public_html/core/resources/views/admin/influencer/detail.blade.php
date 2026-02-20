@extends('admin.layouts.app')

@section('panel')
    <div class="row gy-3">
        <div class="col-xxl-4 col-xl-5 col-lg-12">
            <div class="card influencer-card">
                <div class="card-body">
                    <div class="influencer__profile">
                        <div class="influencer__profile-thumb">
                            <img src="{{ getImage(getFilePath('influencer') . '/' . $influencer->image, getFileThumb('influencer')) }}"
                                 alt="@lang('image')">
                        </div>
                        <div class="influencer__profile-info">
                            <h4>{{ __($influencer->fullname) }}</h4>
                            <p>{{ __($influencer->country_name) }}</p>
                            <ul class="social-links style-two d-flex flex-wrap">
                                @foreach ($influencer->socialLink as $social)
                                    <li>
                                        <a href="{{ $social->social_link }}" target="_blank">@php echo $social->platform->icon @endphp <span
                                                  class="follower">{{ getFollowerCount($social->followers) }}</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="influencer__more-information">
                        <ul>
                            <li>
                                <span>@lang('Mobile Number')</span>
                                <span>{{ $influencer->dial_code }}{{ $influencer->mobile }}</span>
                            </li>
                            <li>
                                <span>@lang('Email')</span>
                                <span>{{ $influencer->email }}</span>
                            </li>
                            <li>
                                <span>@lang('Joined')</span>
                                <span>{{ showDateTime($influencer->created_at) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-8 col-xl-7 col-lg-12">
            <div class="row gy-3">
                <div class="col-xl-6 col-sm-6">
                    <x-widget style="2" link="{{ route('admin.report.transaction', $influencer->id) }}" title="Balance"
                              icon="las la-money-bill-wave-alt" value="{{ showAmount($influencer->balance) }}" color="indigo"
                              type="2" />
                </div>

                <div class="col-xl-6 col-sm-6">
                    <x-widget style="2" link="{{ route('admin.withdraw.data.all', $influencer->id) }}"
                              title="Withdrawals" icon="la la-bank" value="{{ showAmount($totalWithdrawals) }}" color="success"
                              type="2" />
                </div>

                <div class="col-xl-6 col-sm-6">
                    <x-widget style="2" link="{{ route('admin.report.transaction', $influencer->id) }}"
                              title="Transactions" icon="las la-exchange-alt" value="{{ $totalTransaction }}" color="17"
                              type="2" />
                </div>
                <div class="col-xl-6 col-sm-6">
                    <x-widget value="{{ $campaign['pendingTicket'] }}" title="Pending Ticket" style="2"
                              link="{{ route('admin.influencers.ticket.pending') }}?search={{ $influencer->username }}"
                              icon="las la-ticket-alt" color="warning" />
                </div>
                <div class="col-xl-6 col-sm-6">
                    <x-widget value="{{ $campaign['total'] }}" title="Applied Campaign" style="2"
                              link="{{ route('admin.participant.campaign.all') }}?search={{ $influencer->username }}"
                              icon="las la-list" color="primary" />
                </div>
                <div class="col-xl-6 col-sm-6">
                    <x-widget value="{{ $campaign['completed'] }}" title="Completed Campaign" style="2"
                              link="{{ route('admin.participant.campaign.completed') }}?search={{ $influencer->username }}"
                              icon="las la-check-circle" color="success" />
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4 mt-1">
        <h5>@lang('Campaign Applied Information')</h5>

        <div class="col-xl-4 col-sm-6">
            <x-widget value="{{ $campaign['pending'] }}" title="Pending" style="2" link="{{ route('admin.participant.campaign.pending') }}?search={{ $influencer->username }}" icon="las la-spinner" color="warning" />
        </div>
        <div class="col-xl-4 col-sm-6">
            <x-widget value="{{ $campaign['accepted'] }}" title="Accepted" style="2" link="{{ route('admin.participant.campaign.accepted') }}?search={{ $influencer->username }}" icon="las la-tasks" color="info" />
        </div>
        <div class="col-xl-4 col-sm-6">
            <x-widget value="{{ $campaign['delivered'] }}" title="Delivered" style="2" link="{{ route('admin.participant.campaign.delivered') }}?search={{ $influencer->username }}" icon="las la-check-square" color="indigo" />
        </div>

        <div class="col-xl-4 col-sm-6">
            <x-widget value="{{ $campaign['reported'] }}" title="Reported" style="2" link="{{ route('admin.participant.campaign.reported') }}?search={{ $influencer->username }}" icon="las la-hammer" color="dark" />
        </div>
        <div class="col-xl-4 col-sm-6">
            <x-widget value="{{ $campaign['canceled'] }}" title="Canceled" style="2" link="{{ route('admin.participant.campaign.canceled') }}?search={{ $influencer->username }}" icon="las la-times" color="danger" />
        </div>
        <div class="col-xl-4 col-sm-6">
            <x-widget value="{{ $campaign['rejected'] }}" title="Rejected Campaign" style="2" link="{{ route('admin.participant.campaign.rejected') }}?search={{ $influencer->username }}" icon="las la-times-circle" color="red" />
        </div>

    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="row gy-4">



            </div>

            <div class="d-flex flex-wrap gap-3 mt-4">
                <div class="flex-fill">
                    <button data-bs-toggle="modal" data-bs-target="#addSubModal"
                            class="btn btn--success btn--shadow w-100 btn-lg bal-btn" data-act="add">
                        <i class="las la-plus-circle"></i> @lang('Balance')
                    </button>
                </div>

                <div class="flex-fill">
                    <button data-bs-toggle="modal" data-bs-target="#addSubModal"
                            class="btn btn--danger btn--shadow w-100 btn-lg bal-btn" data-act="sub">
                        <i class="las la-minus-circle"></i> @lang('Balance')
                    </button>
                </div>

                <div class="flex-fill">
                    <a href="{{ route('admin.report.login.history') }}?search={{ $influencer->username }}"
                       class="btn btn--primary btn--shadow w-100 btn-lg">
                        <i class="las la-list-alt"></i>@lang('Logins')
                    </a>
                </div>

                <div class="flex-fill">
                    <a href="{{ route('admin.influencer.notification.log', $influencer->id) }}"
                       class="btn btn--secondary btn--shadow w-100 btn-lg">
                        <i class="las la-bell"></i>@lang('Notifications')
                    </a>
                </div>

                @if ($influencer->kyc_data)
                    <div class="flex-fill">
                        <a href="{{ route('admin.influencer.kyc.details', $influencer->id) }}" target="_blank"
                           class="btn btn--dark btn--shadow w-100 btn-lg">
                            <i class="las la-user-check"></i>@lang('KYC Data')
                        </a>
                    </div>
                @endif

                <div class="flex-fill">
                    @if ($influencer->status == Status::USER_ACTIVE)
                        <button type="button" class="btn btn--warning btn--shadow w-100 btn-lg userStatus"
                                data-bs-toggle="modal" data-bs-target="#userStatusModal">
                            <i class="las la-ban"></i>@lang('Ban Influencer')
                        </button>
                    @else
                        <button type="button" class="btn btn--success btn--shadow w-100 btn-lg userStatus"
                                data-bs-toggle="modal" data-bs-target="#userStatusModal">
                            <i class="las la-undo"></i>@lang('Unban Influencer')
                        </button>
                    @endif
                </div>
            </div>


            <div class="card mt-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('Information of') {{ $influencer->fullname }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.influencer.update', [$influencer->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('First Name')</label>
                                    <input class="form-control" type="text" name="firstname" required
                                           value="{{ $influencer->firstname }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Last Name')</label>
                                    <input class="form-control" type="text" name="lastname" required
                                           value="{{ $influencer->lastname }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email')</label>
                                    <input class="form-control" type="email" name="email"
                                           value="{{ $influencer->email }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number')</label>
                                    <div class="input-group ">
                                        <span class="input-group-text mobile-code">+{{ $influencer->dial_code }}</span>
                                        <input type="number" name="mobile" value="{{ $influencer->mobile }}"
                                               id="mobile" class="form-control checkUser" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label>@lang('Address')</label>
                                    <input class="form-control" type="text" name="address"
                                           value="{{ @$influencer->address }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('City')</label>
                                    <input class="form-control" type="text" name="city"
                                           value="{{ @$influencer->city }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('State')</label>
                                    <input class="form-control" type="text" name="state"
                                           value="{{ @$influencer->state }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Zip/Postal')</label>
                                    <input class="form-control" type="text" name="zip"
                                           value="{{ @$influencer->zip }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Country') <span class="text--danger">*</span></label>
                                    <select name="country" class="form-control select2">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}"
                                                    value="{{ $key }}" @selected($influencer->country_code == $key)>
                                                {{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Engagement')</label>
                                    <input class="form-control" type="text" name="engagement" value="{{ $influencer->engagement }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Avg Views')</label>
                                    <input class="form-control" type="text" name="avg_views" value="{{ $influencer->avg_views }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Primary Gender')</label>
                                    <input class="form-control" type="text" name="primary_gender" value="{{ $influencer->primary_gender }}">
                                </div>
                            </div>


                            <div class="col-xl-3 col-md-6 col-12">
                                <div class="form-group">
                                    <label>@lang('Email Verification')</label>
                                    <input type="checkbox" data-width="100%" data-onstyle="-success"
                                           data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')"
                                           data-off="@lang('Unverified')" name="ev"
                                           @if ($influencer->ev) checked @endif>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 col-12">
                                <div class="form-group">
                                    <label>@lang('Mobile Verification')</label>
                                    <input type="checkbox" data-width="100%" data-onstyle="-success"
                                           data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')"
                                           data-off="@lang('Unverified')" name="sv"
                                           @if ($influencer->sv) checked @endif>
                                </div>
                            </div>
                            <div class="col-xl-3 col-12">
                                <div class="form-group">
                                    <label>@lang('2FA Verification') </label>
                                    <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success"
                                           data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')"
                                           data-off="@lang('Disable')" name="ts"
                                           @if ($influencer->ts) checked @endif>
                                </div>
                            </div>
                            <div class="col-xl-3 col-12">
                                <div class="form-group">
                                    <label>@lang('KYC') </label>
                                    <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success"
                                           data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')"
                                           data-off="@lang('Unverified')" name="kv"
                                           @if ($influencer->kv == Status::KYC_VERIFIED) checked @endif>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{-- Add Sub Balance MODAL --}}
    <div id="addSubModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Balance')</span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.influencer.add.sub.balance', $influencer->id) }}"
                      class="balanceAddSub disableSubmission" method="POST">
                    @csrf
                    <input type="hidden" name="act">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <input type="number" step="any" name="amount" class="form-control"
                                       placeholder="@lang('Please provide positive amount')" required>
                                <div class="input-group-text">{{ __(gs('cur_text')) }}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Remark')</label>
                            <textarea class="form-control" placeholder="@lang('Remark')" name="remark" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="userStatusModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if ($influencer->status == Status::INFLUENCER_ACTIVE)
                            @lang('Ban Influencer')
                        @else
                            @lang('Unban Influencer')
                        @endif
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.influencer.status', $influencer->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($influencer->status == Status::INFLUENCER_ACTIVE)
                            <h6 class="mb-2">@lang('If you ban this influencer he/she won\'t able to access his/her dashboard.')</h6>
                            <div class="form-group">
                                <label>@lang('Reason')</label>
                                <textarea class="form-control" name="reason" rows="4" required></textarea>
                            </div>
                        @else
                            <p><span>@lang('Ban reason was'):</span></p>
                            <p>{{ $influencer->ban_reason }}</p>
                            <h4 class="text-center mt-3">@lang('Are you sure to unban this influencer?')</h4>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if ($influencer->status == Status::INFLUENCER_ACTIVE)
                            <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                        @else
                            <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                            <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.influencer.login', $influencer->id) }}" target="_blank"
       class="btn btn-sm btn-outline--primary"><i class="las la-sign-in-alt"></i>@lang('Login as Influencer')</a>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict"


            $('.bal-btn').on('click', function() {

                $('.balanceAddSub')[0].reset();

                var act = $(this).data('act');
                $('#addSubModal').find('input[name=act]').val(act);
                if (act == 'add') {
                    $('.type').text('Add');
                } else {
                    $('.type').text('Subtract');
                }
            });

            let mobileElement = $('.mobile-code');
            $('select[name=country]').on('change', function() {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });

        })(jQuery);
    </script>
@endpush


@push('style')
    <style>
        .influencer-card .card-body {
            padding: 30px 25px;
        }

        .influencer__profile {
            display: flex;
            margin-bottom: 30px;
            border-bottom: 1px solid #dddddd94;
            padding-bottom: 30px;
        }

        .influencer__profile-thumb {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 1px solid #dddddd94;
        }

        .influencer__profile-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .influencer__profile-info {
            width: calc(100% - 90px);
            padding-left: 30px;
        }

        .influencer__profile-info h4 {
            font-weight: 500;
            margin-bottom: 10px;
        }

        .influencer__profile-info p {
            margin-bottom: 5px;
        }

        .influencer__more-information ul li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .influencer__more-information ul li:last-child {
            margin-bottom: 0px;
        }

        .influencer__more-information ul li span:first-child {
            color: #34495e;

        }

        .social-links.style-two li {
            margin-right: 22px;
            text-align: center;
        }

        .social-links.style-two li:last-child {
            margin-right: 0px;
        }

        .social-links.style-two li .follower {
            color: hsl(var(--heading-color));
            font-weight: 700;
        }

        .social-links.style-two li a {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            gap: 8px;
        }

        .social-links.style-two li a i {
            font-size: 18px !important;
            padding: 4px 0px;
        }

        .social-links [class*="facebook"] {
            color: #1877f2 !important;
            font-size: 18px;
        }

        .social-links [class*="youtube"] {
            color: #ff0000 !important;
            font-size: 18px;
        }

        .social-links [class*="instagram"] {
            font-size: 18px;
            background: -webkit-linear-gradient(#eee, #333);
            background-clip: text !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent;
            background: radial-gradient(circle at 30% 107%,
                    #fdf497 0%,
                    #fdf497 5%,
                    #fd5949 45%,
                    #d6249f 60%,
                    #285aeb 90%);
            background: linear-gradient(222.35deg,
                    #d300c5 -24.77%,
                    #f00679 41.3%,
                    #ff7a00 111.8%);
            background: -webkit-linear-gradient(222.35deg,
                    #d300c5 -24.77%,
                    #f00679 41.3%,
                    #ff7a00 111.8%);
        }

        .social-links.style-two li .follower {
            color: #222;
            font-weight: 700;
        }
    </style>
@endpush
