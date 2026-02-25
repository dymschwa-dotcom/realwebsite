@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashbaord-table-header d-flex justify-content-end">
        <form class="search-form active">
            <input class="form--control" name="search" type="search" value="{{ request()->search }}"
                   placeholder="@lang('Search...')">
            <button class="search-form__btn" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="row gy-4">
        <div class="dashboard-table">
            <table class="table--responsive--xxl table">
                <thead>
                    <tr>
                        <th>@lang('Participant Number')</th>
                        <th>@lang('Brand')</th>
                        <th>@lang('Rating')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td>
                                <a class="text--base"
                                   href="{{ route('influencer.campaign.detail', @$review->participant_id) }}">{{ @$review->participant->participant_number }}</a>
                            </td>
                            <td>
                                <span><span>@</span>{{ __(@$review->user->username) }}</span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-end">
                                    <ul class="rating-list">
                                        @php
                                            echo showRatings($review->star);
                                        @endphp
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center not-found" colspan="100%">
                                <div>
                                    <i class="lar la-2x la-star"></i>
                                    <br>
                                    @lang('No reviews yet')
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

    <x-confirmation-modal custom=true />
@endsection
