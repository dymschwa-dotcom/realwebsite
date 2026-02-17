@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-header">
            <h5 class="mb-0">{{ __($pageTitle) }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('user.review.add', [@$participant->id, @$participant->review->id]) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form--label">@lang('Influencer Name')</label>
                            <input class="form--control" type="text" value="{{ __(@$participant->influencer->fullname) }}" readonly required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form--label">@lang('Participant Number')</label>
                            <input class="form--control" type="text" value="{{ __(@$participant->participant_number) }}" readonly required>
                        </div>
                    </div>
                </div>
                <div class="form-group rating">
                    <label class="form--label">@lang('Rating'): <span class="text--danger">*</span></label>
                    <div class="rating-form-group">
                        <label class="star-label">
                            <input name="star" type="radio" value="1" @checked(@$participant->review->star == 1) />
                            <span class="icon"><i class="las la-star"></i></span>
                        </label>
                        <label class="star-label">
                            <input name="star" type="radio" value="2" @checked(@$participant->review->star == 2) />
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                        </label>
                        <label class="star-label">
                            <input name="star" type="radio" value="3" @checked(@$participant->review->star == 3) />
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                        </label>
                        <label class="star-label">
                            <input name="star" type="radio" value="4" @checked(@$participant->review->star == 4) />
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                        </label>
                        <label class="star-label">
                            <input name="star" type="radio" value="5" @checked(@$participant->review->star == 5) />
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                            <span class="icon"><i class="las la-star"></i></span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form--label">@lang('Review')</label>
                    <textarea class="form--control" name="review" placeholder="@lang('Write here')..." required>{{ old('review', @$participant->review->review) }}</textarea>
                </div>
                <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
            </form>
        </div>
    </div>
@endsection
