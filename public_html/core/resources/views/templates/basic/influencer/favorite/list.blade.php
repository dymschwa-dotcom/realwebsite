@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-body">
            <div class="dashbaord-table-header">
                <h5 class="card-header__title text-dark mb-0"> {{ __($pageTitle) }} </h5>

                <div class="dashbaord-table-header-right d-flex flex-wrap gap-3">
                    <form class="search-form">
                        <input class="form--control" name="search" type="search" value="{{ request()->search }}" placeholder="@lang('Search..')">
                        <button class="search-form__btn" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="row gy-4">
                <div class="dashboard-table">
                    <table class="table--responsive--xxl table">
                        <thead>
                            <tr>
                                <th>@lang('Image')</th>
                                <th>@lang('Influencer')</th>
                                <th>@lang('Rating')</th>
                                <th>@lang('Joined At')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($favorites as $favorite)
                                <tr>
                                    <td>
                                        <div class="favorite-thumb">
                                            <img src="{{ getImage(getFilePath('influencer') . '/thumb_' . @$favorite->influencer->image, getFileThumb('influencer')) }}" alt="@lang('image')">
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text--base">
                                            <a href="{{ route('influencer.profile', slug(@$favorite->influencer->username)) }}">{{ __(@$favorite->influencer->username) }}
                                            </a>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <ul class="rating-list">
                                                @php
                                                    echo showRatings(@$favorite->influencer->rating);
                                                @endphp
                                            </ul>
                                            ({{ getAmount(@$favorite->influencer->reviews_count) }})
                                        </div>
                                    </td>
                                    <td>
                                        <span>{{ showDateTime(@$favorite->influencer->created_at) }}</span><br>
                                        <span>{{ diffForHumans(@$favorite->influencer->created_at) }}</span>
                                    </td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <span class="" id="dropdownMenuLink" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                                <i class="las la-ellipsis-v"></i>
                                            </span>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('influencer.profile', slug($favorite->influencer->username)) }}" target="_blank">
                                                        <i class="las la-external-link-alt"></i> @lang('Profile')
                                                    </a>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item confirmationBtn" data-action="{{ route('user.favorite.remove', $favorite->id) }}" data-question="Are you sure to remove this influencer?" data-btn_class="btn btn--base btn--md" type="button">
                                                        <i class="la la-times"></i> @lang('Remove')
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="justify-content-center text-center" colspan="100%">
                                        <i class="lar la-4x la-heart"></i>
                                        <br>
                                        @lang('No favorite influencer yet')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($favorites->hasPages())
            <div class="mt-4">
                {{ paginateLinks($favorites) }}
            </div>
        @endif
        <x-confirmation-modal btn="btn--base" btnType="btn--md" />
    @endsection
