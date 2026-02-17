@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-body py-2">
            @if ($user->kyc_data)
                <ul class="list-group list-group-flush">
                    @foreach ($user->kyc_data as $val)
                        @continue(!$val->value)
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2 px-0">
                            {{ __($val->name) }}
                            <span>
                                @if ($val->type == 'checkbox')
                                    {{ implode(',', $val->value) }}
                                @elseif($val->type == 'file')
                                    <a href="{{ route('user.download.attachment', encrypt(getFilePath('verify') . '/' . $val->value)) }}" class="text--base"><i class="fa-regular fa-file"></i> @lang('Attachment') </a>
                                @else
                                    <p class="mb-0">{{ __($val->value) }}</p>
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <h5 class="text-center">@lang('KYC data not found')</h5>
            @endif
        </div>
    </div>
@endsection
