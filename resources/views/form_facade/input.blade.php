<div>
    <div class="{{$wrapperClass}}">
        @if ($enableLabel)
            <label class="{{$labelClass}}">{{ $label }}</label>
        @endif

        <input
            class="{{$inputClass}} @error($error) is-invalid @enderror"
            {{ $id? "id=".($id) ."": ""  }}
            name="{{$name}}"
            type="{{$type}}"
            placeholder="{{$placeholder}}"
            value= "{{($value === null)?old($name): $value}}"
        />
        {!! $append??"" !!}

    </div>
    @include('components.errors.validation-error',['error'=>$error])

</div>
