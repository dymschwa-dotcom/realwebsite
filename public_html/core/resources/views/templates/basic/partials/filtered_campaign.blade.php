@forelse ($campaigns as $campaign)
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xsm-6">
        <div class="campaign style-two">
            <div class="campaign__thumb">
                {{-- FIX: Updated route name and changed parameters to just the slug --}}
                <a href="{{ route('user.campaign.detail', $campaign->slug) }}">
                    <img src="{{ getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign')) }}" alt="image">
                </a>
            </div>
            <div class="campaign__content">
                <div class="campaign__content-viewer align-items-center justify-content-between flex-wrap gap-1">
                    <span class="fs-12"> <span class="date"><i class="far fa-clock"></i></span>
                        {{ diffForHumans($campaign->end_date) }} </span>
                    <span class="viewer-user">
                        <i class="las la-user"></i>
                        {{ getAmount(@$campaign->participants_count) }}
                    </span>
                </div>
                <h6 class="campaign__title">
                    {{-- FIX: Updated route name and changed parameters to just the slug --}}
                    <a href="{{ route('user.campaign.detail', $campaign->slug) }}">
                        {{ __(strLimit(@$campaign->title, 30)) }} 
                    </a>
                </h6>
                <div class="campaign__cate d-flex justify-content-between flex-wrap gap-3">
                    <span class="campaign__cate-amount"> {{ showAmount(@$campaign->budget) }} </span>
                    <ul class="text-list style-category">
                        <li class="text-list__item">
                            <span class="text-list__link text--dark">
                                {{ __($campaign->payment_type == 'paid' ? 'Paid' : 'Free') }}
                            </span>
                        </li>
                    </ul>
                </div>
                
                {{-- Category List --}}
                <div class="campaign__cate d-flex justify-content-between flex-wrap gap-3">
                    <ul class="text-list style-category">
                        @foreach ($campaign->categories->take(3) as $category)
                            <li class="text-list__item">
                                <a class="text-list__link" href="{{ route('campaign.all') }}?category[]={{ $category->slug }}">{{ __(@$category->name) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Gender & Platform Info --}}
                <div class="campaign__info align-items-center justify-content-between flex-wrap gap-2">
                    <div class="campaign__user">
                        {{-- Note: Accessing gender from the JSON object we fixed in the Model --}}
                        @foreach (@$campaign->influencer_requirements->gender ?? [] as $gender)
                            <span>
                                @if ($gender == 'male')
                                    <i class="las la-mars"></i> {{ __(ucfirst($gender)) }}
                                @elseif($gender == 'female')
                                    <i class="las la-venus"></i> {{ __(ucfirst($gender)) }}
                                @else
                                    <i class="las la-genderless"></i> {{ __(ucfirst($gender)) }}
                                @endif
                            </span>
                        @endforeach
                    </div>
                    <ul class="social-links d-flex flex-wrap gap-2">
                        @foreach ($campaign->platforms as $platform)
                            <li><a href="javascript:void(0)"> @php echo $platform->icon @endphp </a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-xl-12">
        <div class="empty-data text-center">
            <div class="empty-image">
                <img src="{{ asset($activeTemplateTrue . 'images/empty.png') }}" alt="img">
            </div>
            <p>@lang('No campaigns available')</p>
        </div>
    </div>
@endforelse