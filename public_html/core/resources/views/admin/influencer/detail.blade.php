@extends('admin.layouts.app')

@section('panel')
    <div class="row gy-3">
        {{-- Left Side: Profile Summary --}}
        <div class="col-xxl-4 col-xl-5 col-lg-12">
            <div class="card influencer-card shadow-sm">
                <div class="card-body">
                    <div class="influencer__profile text-center">
                        <div class="influencer__profile-thumb mb-3">
                            <img src="{{ getImage(getFilePath('influencer') . '/' . $influencer->image, getFileThumb('influencer')) }}" 
                                 class="rounded-circle border" style="width: 120px; height: 120px; object-fit: cover;" alt="profile">
                        </div>
                        <div class="influencer__profile-info">
                            <h4 class="mb-1">
                                {{ $influencer->fullname }} 
                                @if($influencer->kv == 1)
                                    <i class="fas fa-check-circle text--pink" title="@lang('Verified')"></i>
                                @endif
                            </h4>
                            <p class="text-muted"><i class="las la-map-marker"></i> {{ __($influencer->country_name) }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="influencer__more-information">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="fw-bold">@lang('Username')</span>
                                <span>{{ $influencer->username }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="fw-bold">@lang('Balance')</span>
                                <span class="text--success">{{ showAmount($influencer->balance) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side: Quick Action Widgets --}}
        <div class="col-xxl-8 col-xl-7 col-lg-12">
            <div class="row gy-3">
                <div class="col-sm-6">
                    <div class="card bg--primary text-white shadow-sm">
                        <div class="card-body">
                            <h6>@lang('Total Withdrawals')</h6>
                            <h3>{{ showAmount($totalWithdrawals) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card bg--info text-white shadow-sm">
                        <div class="card-body">
                            <h6>@lang('Completed Campaigns')</h6>
                            <h3>{{ $campaign['completed'] }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-2">
                    <div class="d-flex flex-wrap gap-2">
                        <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--success flex-fill bal-btn" data-act="add"><i class="las la-plus-circle"></i> @lang('Add Balance')</button>
                        <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--danger flex-fill bal-btn" data-act="sub"><i class="las la-minus-circle"></i> @lang('Sub Balance')</button>
                        <a href="{{ route('admin.influencer.login', $influencer->id) }}" target="_blank" class="btn btn--primary flex-fill"><i class="las la-sign-in-alt"></i> @lang('Login as Influencer')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Update Form --}}
    <div class="card mt-4">
        <div class="card-header bg--dark text-white">
            <h5 class="card-title mb-0">@lang('Update Account Information')</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.influencer.update', [$influencer->id]) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>@lang('First Name')</label>
                        <input class="form-control" type="text" name="firstname" required value="{{ $influencer->firstname }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>@lang('Last Name')</label>
                        <input class="form-control" type="text" name="lastname" required value="{{ $influencer->lastname }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>@lang('Email')</label>
                        <input class="form-control" type="email" name="email" value="{{ $influencer->email }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>@lang('Mobile Number')</label>
                        <input class="form-control" type="text" name="mobile" value="{{ $influencer->mobile }}" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>@lang('Country')</label>
                        <select name="country" class="form-control" required>
                            @foreach($countries as $key => $country)
                                <option value="{{ $key }}" data-dial_code="{{ $country->dial_code }}" {{ $key == $influencer->country_code ? 'selected' : '' }}>
                                    {{ __($country->country) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12"><hr></div>

                    {{-- AUDIENCE INSIGHTS (Admin Only) --}}
                    <div class="col-12">
                        <h5 class="mb-3 text--primary">@lang('Audience Insights (Admin Only)')</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>@lang('Engagement Rate')</label>
                                <input class="form-control" type="text" name="engagement_rate" value="{{ $influencer->engagement_rate }}" placeholder="e.g. 4.5%">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>@lang('Average Reach')</label>
                                <input class="form-control" type="text" name="avg_reach" value="{{ $influencer->avg_reach }}" placeholder="e.g. 12.5k">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>@lang('Primary Gender')</label>
                                <input class="form-control" type="text" name="primary_gender" value="{{ $influencer->primary_gender }}" placeholder="e.g. Female / Mixed">
                            </div>
                        </div>
                    </div>

                    <div class="col-12"><hr></div>

                    {{-- VERIFICATION & STATUS SECTION --}}
                    <div class="col-md-3 mb-3">
                        <label>@lang('Email Verification')</label>
                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="ev" @checked($influencer->ev)>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>@lang('Mobile Verification')</label>
                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="sv" @checked($influencer->sv)>
                    </div>
                    
                    {{-- FIXED: Status toggle added to prevent auto-banning on update --}}
                    <div class="col-md-3 mb-3">
                        <label>@lang('Account Status')</label>
                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Banned')" name="status" @checked($influencer->status == Status::USER_ACTIVE)>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="text--pink fw-bold">@lang('Verify Account (Red Tick)')</label>
                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('ACTIVE RED TICK')" data-off="@lang('NO TICK')" name="kv" @checked($influencer->kv == 1)>
                    </div>

                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn--primary w-100 btn-lg">@lang('Save Changes')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Add/Sub Balance Modal --}}
    <div id="addSubModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> @lang('Balance')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.influencer.add.sub.balance', $influencer->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="act">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <input type="number" step="any" name="amount" class="form-control" required>
                                <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Remark')</label>
                            <textarea class="form-control" name="remark" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    (function($) {
        "use strict";
        $('.bal-btn').on('click', function() {
            var act = $(this).data('act');
            $('#addSubModal').find('input[name=act]').val(act);
            $('.type').text(act == 'add' ? 'Add' : 'Subtract');
        });
    })(jQuery);
</script>
@endpush