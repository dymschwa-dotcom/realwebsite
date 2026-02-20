@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashbaord-table-header d-flex justify-content-end mb-3">
        <form class="search-form">
            <input class="form--control" name="search" type="search" value="{{ request()->search }}" placeholder="@lang('Search..')">
            <button class="search-form__btn" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="row gy-4">
        <div class="dashboard-table">
            <table class="table--responsive--xxl table">
                <thead>
                    <tr>
                        <th>@lang('Participant Number')</th>
                        <th>@lang('Influencer')</th>
                        <th>@lang('Rating')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td>
                                <a class="text--base" href="{{ route('user.participant.detail', @$review->participant_id) }}">{{ @$review->participant->participant_number }}</a>
                            </td>
                            <td>
                                <a class="text--base fw-bold" href="{{ route('influencer.profile', [slug($review->influencer->username), $review->influencer_id]) }}" target="_blank">
                                    <span>@</span>{{ __(@$review->influencer->username) }}
                                </a>
                            </td>

                            <td>
                                <div class="d-flex justify-content-center">
                                    <ul class="rating-list">
                                        @php
                                            echo showRatings($review->star);
                                        @endphp
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-end flex-wrap gap-1">
                                    <a class="btn btn--sm btn--warning outline" href="{{ route('user.review.form', [$review->participant_id, $review->id]) }}">
                                        <i class="las la-edit"></i> @lang('Edit')
                                    </a>
                                    <button class="btn btn--sm btn--danger confirmationBtn outline" data-action="{{ route('user.review.remove', $review->id) }}" data-question="@lang('Are you sure to remove this review?')" data-btn_class="btn btn--base btn--md">
                                        <i class="las la-trash"></i> @lang('Delete')
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center not-found" colspan="100%">
                                <div>
                                    <i class="lar la-2x la-star"></i>
                                    <br>
                                    @lang('No review yet!')
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($reviews->hasPages())
        <div class="mt-4">
            {{ paginateLinks($reviews) }}
        </div>
    @endif

    <x-confirmation-modal custom='true' />
@endsection
