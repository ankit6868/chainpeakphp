@foreach($formData as $data)
    <div class="form-group">
        <label class="form-label">{{ __(keyToTitle($data->name)) }}</label>
        @if($data->type == 'text')
            <input type="text"
            class="form-control @if(!$class) form--control @endif"
            name="{{ $data->label }}"
            value="{{ old($data->label) }}"
            @if($data->is_required == 'required') required @endif
            >
        @elseif($data->type == 'textarea')
            <textarea
                class="form-control @if(!$class) form--control @endif"
                name="{{ $data->label }}"
                @if($data->is_required == 'required') required @endif
            >{{ old($data->label) }}</textarea>
        @elseif($data->type == 'select')
            <select
                class="form-control @if(!$class) form--control @endif"
                name="{{ $data->label }}"
                @if($data->is_required == 'required') required @endif
            >
                <option value="">@lang('Select One')</option>
                @foreach ($data->options as $item)
                    <option value="{{ $item }}" @selected($item == old($data->label))>{{ __($item) }}</option>
                @endforeach
            </select>
        @elseif($data->type == 'checkbox')
            @foreach($data->options as $option)
                <div class="@if($class) custom-check-group @else form-check @endif">
                    <input
                        class="form-check-input"
                        name="{{ $data->label }}[]"
                        type="checkbox"
                        value="{{ $option }}"
                        id="{{ $data->label }}_{{ titleToKey($option) }}"
                    >
                    <label class="form-check-label" for="{{ $data->label }}_{{ titleToKey($option) }}">{{ $option }}</label>
                </div>
            @endforeach
        @elseif($data->type == 'radio')
            @foreach($data->options as $option)
                <div class="@if($class) custom-check-group @else form-check @endif">
                    <input
                    class="form-check-input"
                    name="{{ $data->label }}"
                    type="radio"
                    value="{{ $option }}"
                    id="{{ $data->label }}_{{ titleToKey($option) }}"
                    @checked($option == old($data->label))
                    >
                    <label class="form-check-label" for="{{ $data->label }}_{{ titleToKey($option) }}">{{ $option }}</label>
                </div>
            @endforeach
        @elseif($data->type == 'file')
            @if ($class)
                <div class="custom-file-wrapper">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="{{ $data->label }}" id="customFile" accept="@foreach(explode(',',$data->extensions) as $ext) .{{ $ext }}, @endforeach" @if($data->is_required == 'required') required @endif>
                        <label class="custom-file-label" for="customFile">@lang('Choose file')</label>
                    </div>
                </div>
            @else
                <input
                type="file"
                class="form-control form--control"
                name="{{ $data->label }}"
                @if($data->is_required == 'required') required @endif
                accept="@foreach(explode(',',$data->extensions) as $ext) .{{ $ext }}, @endforeach"
                >
            @endif
            <pre class="text--base mt-1">@lang('Supported mimes'): {{ $data->extensions }}</pre>
        @endif
    </div>
@endforeach
