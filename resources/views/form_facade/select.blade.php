<div>
    <div class="{{$wrapperClass}}">
        @if ($enableLabel)
            <label class="{{$labelClass}}">{{ $label }}</label>
        @endif

        <select  {{ $id? "id=".($id) ."": ""  }} class="{{$inputClass}} @error($error) is-invalid @enderror" name="{{$name}}" {!!$attributes!!}>
            <option value="">{{$placeholder}}</option>
            @foreach ($options as $option)
                @php
                    $values = $optionBuilder($option);
                    if(!is_array($values) || count($values)<2){
                        throw new \ErrorException('Option Builder Should Return An Array With Two Value');
                    }
                @endphp
                <option value="{{ $values[0] }}" {{ (($selected === null)?old($name): $selected) == $values[0]?"selected":""}}>{{ $values[1] }} {{$selected}}</option>
            @endforeach
        </select>
        {!! $append??"" !!}

    </div>
    @include('components.errors.validation-error',['error'=>$error])
</div>
