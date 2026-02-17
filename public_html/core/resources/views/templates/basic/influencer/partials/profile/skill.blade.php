<div class="card custom--card influencer-skill mt-4">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        <h6 class="card-title mb-0">@lang('Skills')</h6>
        <button class="btn btn--base outline btn--sm editSkillbtn">
            <i class="la la-edit"></i>@lang('Edit')
        </button>
    </div>
    <div class="card-body">
        @if (!blank($influencer->skills))
            <div class="d-flex gap-2 flex-wrap">
                @foreach (@$influencer->skills ?? [] as $skill)
                    <span class="badge badge--base">{{ __(@$skill) }}</span>
                @endforeach
            </div>
        @else
            <div class="global-item noSkill">
                <p class="text">
                    @lang('No skill added yet')
                </p>
            </div>
        @endif
    </div>
</div>

<div class="card custom--card skill-edit d-none mt-5">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        <h6 class="card-title">@lang('Skills')</h6>
        <button class="btn btn--base outline btn--sm d-flex skillBtn">
            <i class="la la-plus"></i> @lang('Add New')
        </button>
    </div>
    <div class="card-body">
        <form action="{{ route('influencer.skill') }}" method="POST">
            @csrf
            <div id="skillContainer">
                @forelse ($influencer->skills??[] as $skill)
                    <div class="mb-3">
                        <div class="add-skill input-group">
                            <input class="form-control form--control" name="skills[]" type="text" value="{{ $skill }}" required />
                            <button class="input-group-text text--danger remove-btn" type="button"><i class="las la-times"></i></button>
                        </div>
                    </div>
                @empty
                    <div class="mb-3">
                        <div class="add-skill input-group">
                            <input class="form-control form--control" name="skills[]" type="text" placeholder="@lang('Enter your skill')" required />
                            <button class="input-group-text text--danger remove-btn" type="button"><i class="las la-times"></i></button>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="mt-3 text-end">
                <button class="btn btn--black btn--md cancelSkillBtn" type="button">@lang('Cancel')</button>
                <button class="btn btn--base btn--md">@lang('Submit')</button>
            </div>
        </form>
    </div>
</div>

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.skillBtn').on('click', function() {
                $('.noSkill').addClass('d-none');
                $("#skillContainer").append(`
                    <div class="add-skill form-group">
                        <div class="input-group">
                            <input type="text" class="form-control form--control" name="skills[]" placeholder="@lang('Enter your skill')" required>
                            <button class="input-group-text text--danger remove-btn" type="button"><i class="las la-times"></i></button>
                        </div>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                $(this).closest('.add-skill').remove();
                if ($("#skillContainer").children().length == 0) {
                    $('.noSkill').removeClass('d-none');
                }
            });
            $('.editSkillbtn').on('click', function() {
                $('.skill-edit').removeClass('d-none');
                $('.influencer-skill').addClass('d-none');
            });
            $('.cancelSkillBtn').on('click', function() {
                $('.skill-edit').addClass('d-none');
                $('.influencer-skill').removeClass('d-none');
            });



        })(jQuery)
    </script>
@endpush
