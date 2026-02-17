@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-body">
            <div class="invite-alert__heading">
                <h6 class="text-muted"><span class="text--info"><i class="las la-info-circle"></i></span> @lang('You can invite any influencer to your campaign. For this, you need to search for an influencer username. You can visit the list of influencers you can visit their profile and send an invitation request to the influencer of your choice.')
                </h6>
            </div>
            <div class="campaign__info mb-3">
                <h6 class="mb-0">@lang('Campaign Title')</h6>
                <span>{{ __($campaign->title) }}</span>
            </div>
            <form action="{{ route('user.campaign.send.invite', $campaign->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form--label">@lang('Select Influencer')</label>
                    <select name="influencer_id[]" id="influencer-list" class="form--control select2" multiple></select>
                </div>
                <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $("#influencer-list").select2({
                placeholder: 'Influencer Username...',
                allowClear: true,
                ajax: {
                    url: "{{ route('user.campaign.influencer.username') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                }
            });
        })(jQuery);
    </script>
@endpush
