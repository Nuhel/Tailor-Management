@if(!$errors->has($error))
    <span class="text-danger error validation-error validation-error-space d-block">&nbsp;</span>
@endif

@error($error)
    <small class="text-danger error validation-error d-block mb-2">{{$message}}</small>
@enderror