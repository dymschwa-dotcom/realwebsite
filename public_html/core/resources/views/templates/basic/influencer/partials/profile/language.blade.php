<div class="card custom--card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap border-none">
        <h6 class="card-title mb-0">@lang('Language')</h6>
        <button class="btn btn--base btn--sm languageBtn outline">
            <i class="la la-plus"></i>@lang('Add New')
        </button>
    </div>
    <div class="card-body">
        @if (!blank($influencer->languages))
            @foreach (@$influencer->languages ?? [] as $key => $profiencies)
                <div class="education-content">
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <h6 class="mb-0">{{ __($key) }}</h6>
                        <button class="btn btn--danger btn--sm confirmationBtn outline"
                            data-action="{{ route('influencer.language.remove', $key) }}"
                            data-question="@lang('Are you sure to removed this language?')" type="button">
                            <i class="las la-trash"></i> @lang('Delete')
                        </button>
                    </div>
                    <div class="d-flex mt-1 flex-wrap gap-2">
                        @foreach ($profiencies as $key => $profiency)
                            <span><span class="fw-bold">{{ keyToTitle($key) }}</span>: {{ $profiency }}</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="global-item">
                <p class="text">
                    @lang('No language added yet')
                </p>
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="languageModal" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add Language')</h5>
                <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <form id="languageForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form--label">@lang('Name')</label>
                        <select class="form--control select2" name="language" required>
                            <option value="">@lang('Select One')</option>
                            @foreach ($languageData as $lang)
                                <option value="{{ $lang }}">{{ __($lang) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="from-group mb-4">
                        <label class="form--label">@lang('Listening') <span class="text--danger">*</span> </label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="custom--check">
                                <label class="custom--check-label" for="basic-listening"></label>
                                <div class="d-flex gap-2">
                                    <div class="form--check d-inline-block">
                                        <input class="form-check-input" id="basic-listening" name="listening"
                                            type="radio" value="Basic">
                                    </div>
                                    <span class="title">@lang('Basic')</span>
                                </div>
                            </div>
                            <div class="custom--check">
                                <label class="custom--check-label" for="medium-listening"></label>
                                <div class="d-flex gap-2">
                                    <div class="form--check d-inline-block">
                                        <input class="form-check-input" id="medium-listening" name="listening"
                                            type="radio" value="Medium">
                                    </div>
                                    <span class="title">@lang('Medium')</span>
                                </div>
                            </div>
                            <div class="custom--check">
                                <label class="custom--check-label" for="fluent-listening"></label>
                                <div class="d-flex gap-2">
                                    <div class="form--check d-inline-block">
                                        <input class="form-check-input" id="fluent-listening" name="listening"
                                            type="radio" value="Fluent">
                                    </div>
                                    <span class="title">@lang('Fluent')</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="from-group mb-4">
                        <label class="form--label">@lang('Speaking') <span class="text--danger">*</span> </label>

                        <div class="d-flex flex-wrap gap-3">
                            <div class="custom--check">
                                <label class="custom--check-label" for="basic-speaking"></label>
                                <div class="d-flex gap-2">
                                    <div class="form--check d-inline-block">
                                        <input class="form-check-input" id="basic-speaking" name="speaking"
                                            type="radio" value="Basic">
                                    </div>
                                    <span class="title">@lang('Basic')</span>
                                </div>
                            </div>
                            <div class="custom--check">
                                <label class="custom--check-label" for="medium-speaking"></label>
                                <div class="d-flex gap-2">
                                    <div class="form--check d-inline-block">
                                        <input class="form-check-input" id="medium-speaking" name="speaking"
                                            type="radio" value="Medium">
                                    </div>
                                    <span class="title">@lang('Medium')</span>
                                </div>
                            </div>
                            <div class="custom--check">
                                <label class="custom--check-label" for="fluent-speaking"></label>
                                <div class="d-flex gap-2">
                                    <div class="form--check d-inline-block">
                                        <input class="form-check-input" id="fluent-speaking" name="speaking"
                                            type="radio" value="Fluent">
                                    </div>
                                    <span class="title">@lang('Fluent')</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="from-group">
                        <label class="form--label">@lang('Writing') <span class="text--danger">*</span> </label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="custom--check">
                                <label class="custom--check-label" for="basic-writing"></label>
                                <div class="d-flex gap-2">
                                    <div class="form--check d-inline-block">
                                        <input class="form-check-input" id="basic-writing" name="writing"
                                            type="radio" value="Basic">
                                    </div>
                                    <span class="title">@lang('Basic')</span>
                                </div>
                            </div>
                            <div class="custom--check">
                                <label class="custom--check-label" for="medium-writing"></label>
                                <div class="d-flex gap-2">
                                    <div class="form--check d-inline-block">
                                        <input class="form-check-input" id="medium-writing" name="writing"
                                            type="radio" value="Medium">
                                    </div>
                                    <span class="title">@lang('Medium')</span>
                                </div>
                            </div>
                            <div class="custom--check">
                                <label class="custom--check-label" for="fluent-writing"></label>
                                <div class="d-flex gap-2">
                                    <div class="form--check d-inline-block">
                                        <input class="form-check-input" id="fluent-writing" name="writing"
                                            type="radio" value="Fluent">
                                    </div>
                                    <span class="title">@lang('Fluent')</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn--base w-100">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.select2').each(function(index, element) {
                $(element).select2({
                    dropdownParent: $('#languageModal')
                });
            });

            $('.languageBtn').on('click', function() {
                var modal = $('#languageModal');
                modal.find('form').attr('action', `{{ route('influencer.language.add') }}`);
                modal.modal('show')
            });

            $("#languageForm").on('submit', function(e) {
                if ($("[name='speaking']:checked").length === 0 || $("[name='listening']:checked").length ===
                    0 || $("[name='writing']:checked").length === 0) {
                    e.preventDefault();
                }
            });
        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        .select2-container {
            z-index: 1055 !important;
        }
    </style>
@endpush
