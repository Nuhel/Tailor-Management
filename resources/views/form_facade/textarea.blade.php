<div>
    <div class="{{$wrapperClass}}">
        @if ($enableLabel)
            <label class="{{$labelClass}}">{{ $label }}</label>
        @endif
        <textarea
            class="{{$inputClass}}"
            {{ $id? "id=".($id) ."": ""  }}
            name="{{$name}}">{{($value === null)?old($name): $value}}</textarea>
            {!! $append??"" !!}

    </div>
    @include('components.errors.validation-error',['error'=>$error])
</div>
