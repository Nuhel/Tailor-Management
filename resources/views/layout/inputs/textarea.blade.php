
@php
    $attributes = $attributes??collect();
    if(is_array($attributes)){
        $attributes = collect($attributes);
    }

    $name = $attributes->get('name');

    if($name == null || Str::length($name)==0){
        throw new \ErrorException('Input Name is required');
    }

    $attributes2=$attributes;
@endphp

<div class="form-group">
    <label class="form-inline">{{ Str::of($attributes->get('label', $name))->ucfirst() }}</label>
    <textarea
        class="form-control form-control-sm"
        {{ ($attributes->get('id'))? "id=".($attributes->get('id')) ."": ""  }}
        name="{{$name}}">{{old($name, $attributes->get('value'))}}</textarea>
    @include('layout.errors.validation-error',['error'=>$attributes->get('error', $name)])
</div>
