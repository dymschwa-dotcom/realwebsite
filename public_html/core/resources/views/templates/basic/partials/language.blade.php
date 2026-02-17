@if (gs('multi_language'))
    @php
        $currentLang = App\Models\Language::where('code', session()->get('lang'))->first();
        $language = App\Models\Language::where('code', '!=', session()->get('lang'))->get();
    @endphp
    <div class="header-login__item language-box">
        <div class="custom--dropdown">
            <div class="custom--dropdown__selected dropdown-list__item">
                <div class="thumb">
                    <img src="{{ getImage(getFilePath('language') . '/' . $currentLang->image, getFileSize('language')) }}" alt="@lang('image')">
                    <span class="text"> {{ strtoupper($currentLang->code) }} </span>
                </div>
            </div>
            <ul class="dropdown-list">
                @foreach ($language as $lang)
                    <li class="dropdown-list__item" data-value="en">
                        <a class="thumb" href="{{ route('lang', $lang->code) }}">
                            <img src="{{ getImage(getFilePath('language') . '/' . $lang->image, getFileSize('language')) }}" alt="@lang('image')">
                            <span class="text"> {{ strtoupper($lang->code) }} </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@push('style')
    <style>
        
    </style>
@endpush
