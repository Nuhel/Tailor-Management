<div data-repeater-item  class="repeater-item border rounded p-2 mb-5 position-relative ">
    @php
        $serviceObject = $services->where('id',Arr::get($oldService,'id',0))->first();
        $designs =  $serviceObject!=null? $serviceObject->designs:collect([]);
        $selectedDesignIds = collect(Arr::get($oldService,'designs',[]))->pluck('id');
        //$design->dump();
    @endphp
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <small >Select Service</small>
                <select name="id" class="form-control form-control-sm service_id" data-index='0'>
                    <option value="" selected>Select Service</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" {{Arr::get($oldService,'id',0)==$service->id?"selected":""}}>{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <small >Quantity</small>
                <input name="quantity" class="form-control form-control-sm" type="number" value="{{Arr::get($oldService,'quantity','')}}"/>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <small >Price</small>
                <input name="price" class="form-control form-control-sm" type="number" value="{{Arr::get($oldService,'price','')}}"/>
            </div>
        </div>
    </div>

    <a class="btn btn-link  measurement-show-btn px-0" data-toggle="collapse" href="#" role="button" aria-expanded="false" aria-controls="collapseExample">
        Measurements & Design <i class="fa fa-caret-up"></i>
    </a>


    <div class="collapse show">
        <div class="row inner-repeater">
            <div class="col-md-6">
                <div class="border-bottom mb-2">
                    <span>Measurements</span>
                </div>
                <div class="">
                    <div id="measurement-inputs" class="measurement-inputs">
                        @if (Arr::get($oldService,'measurements',null))
                            <table class='table table-sm table-borderless'>
                                @foreach ( Arr::get($oldService,'measurements',[]) as $measurement )
                                <tr class="">
                                    <td><small>{{$measurement['name']}}</small></td>
                                    <td>
                                        <input type="text" name="services[{{$serviceIndex}}][measurements][{{$loop->index}}][size]"
                                        class="form-control form-control-sm "
                                        placeholder="Size" value="{{$measurement['size']}}" />

                                        <input type="hidden" name="services[{{$serviceIndex}}][measurements][{{$loop->index}}][id]" value="{{$measurement['id']}}" />
                                        <input type="hidden" name="services[{{$serviceIndex}}][measurements][{{$loop->index}}][name]" value="{{$measurement['name']}}" />
                                    </td>

                                </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="border-bottom mb-2">
                    <span>Design</span>
                </div>
                <div class="">
                    <div id="design-inputs" class="row design-inputs">
                        @if (Arr::get($oldService,'designs',null))
                            <table class='table table-sm table-borderless'>
                                @foreach ( $designs as $design )
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <small >{{$design->name}}</small>
                                            <select class="form-control form-control-sm" name="services[{{$serviceIndex}}][designs][{{$loop->index}}][id]">
                                                @foreach ($design->styles as $style)
                                                    <option value="{{$style->id}}" {{$selectedDesignIds->contains($style->id)?"selected":""}}>{{$style->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <a data-repeater-delete class="btn btn-danger btn-sm position-absolute service-remove-button">
        <i class="fa fa-trash "></i>
    </a>


</div>
