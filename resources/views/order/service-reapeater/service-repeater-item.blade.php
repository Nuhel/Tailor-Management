<div data-repeater-item class="repeater-item border rounded p-2 position-relative ">
    @php

        $serviceObject = $services->where('id', Arr::get($oldService, 'service_id', 0))->first();
        $designs = $serviceObject != null ? $serviceObject->designs : collect([]);

        $edit = true;
        if (count(Arr::get($oldService, 'measurements', [])) > 0) {
            $edit = false;
        }

        if (!$edit) {
            $oldmeasurements = collect(Arr::get($oldService, 'measurements', []));
            $oldDesigns = collect(Arr::get($oldService, 'designs', []));
            $selectedDesignIds = $oldDesigns->pluck('style_id');
        } else {
            $oldmeasurements = collect(Arr::get($oldService, 'serviceMeasurements', []));
            $oldDesigns = collect(Arr::get($oldService, 'serviceDesigns', []));
            $selectedDesignIds = $oldDesigns->pluck('service_design_style_id');
        }
        $baseErrorName = 'services.' . $serviceIndex;
    @endphp


    <div class="row">
        <div class="col-sm-12 col-md">
            <div class="form-group position-relative">
                <small>Select Service</small>
                <select name="service_id"
                    class="form-control form-control-sm service_id @error($baseErrorName . '.service_id') is-invalid @enderror"
                    data-index='0'>
                    <option value="" selected>Select Service</option>
                    @foreach ($services as $service)
                        <option data-crafting_price="{{ $service->crafting_price }}" value="{{ $service->id }}"
                            {{ Arr::get($oldService, 'service_id', 0) == $service->id ? 'selected' : '' }}>{{ $service->name }}
                        </option>
                    @endforeach
                </select>
                @error($baseErrorName . '.service_id')
                    <span class="text-danger error validation-error d-block mb-2 invalid-feedback"
                        role="alert">{{ $message }}</span>
                @enderror
                @php
                    $imageService = $services->where('id',Arr::get($oldService, 'service_id', 0))->first();
                    $imageUrl = $imageService?$imageService->image:null;
                @endphp
                <div class="position-absolute top-50 end-0 pe-2 text-secondary view-icon d-none  {{ $imageUrl?'d-block':"" }}" data-image="{{$imageUrl?($imageUrl):""}}">
                    <i class="fa fa-eye" aria-hidden="true"></i>

                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md">
            <div class="form-group">
                <small>Quantity</small>
                <input name="quantity"
                    class="form-control form-control-sm quantity @error($baseErrorName . '.quantity') is-invalid @enderror"
                    type="number" value="{{ Arr::get($oldService, 'quantity', '') }}" />
                @error($baseErrorName . '.quantity')
                    <span class="text-danger error validation-error d-block mb-2 invalid-feedback"
                        role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md">
            <div class="form-group">
                <small>Price</small>
                <input name="price"
                    class="form-control form-control-sm price @error($baseErrorName . '.price') is-invalid @enderror"
                    type="number" value="{{ Arr::get($oldService, 'price', '') }}" />
                @error($baseErrorName . '.price')
                    <span class="text-danger error validation-error d-block mb-2 invalid-feedback"
                        role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md">
            <div class="form-group">
                <small>Crafting Price</small>
                <input name="crafting_price"
                    class="form-control form-control-sm crafting_price @error($baseErrorName . '.crafting_price') is-invalid @enderror"
                    type="number" value="{{ Arr::get($oldService, 'crafting_price', '') }}" />
                @error($baseErrorName . '.crafting_price')
                    <span class="text-danger error validation-error d-block mb-2 invalid-feedback"
                        role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-sm-12 col-md">
            <small>Craftsman</small>
            {!! Form::select()->setName('employee_id')->setEnableLabel(false)->setPlaceholder('Select Craftsman')->setValue(Arr::get($oldService, 'employee_id', ''))->setOptions($employees)->setError('services.' . $serviceIndex . '.employee_id')->setOptionBuilder(function ($value) {
                    return [$value->id, $value->name];
                }) !!}
        </div>

        <div class="col-sm-12 col-md">
            <div class="form-group">
                <small>Deadline</small>
                <input name="deadline"
                    class="form-control form-control-sm  @error($baseErrorName . '.deadline') is-invalid @enderror"
                    type="date" value="{{ Arr::get($oldService, 'deadline', '') }}" />
                @error($baseErrorName . '.deadline')
                    <span class="text-danger error validation-error d-block mb-2 invalid-feedback"
                        role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>

    </div>

    <a class="btn btn-link  measurement-show-btn px-0" data-toggle="collapse" href="#" role="button"
        aria-expanded="false" aria-controls="collapseExample">
        Measurements & Design <i class="fa fa-caret-up"></i>
    </a>


    <div class="collapse show">
        <div class="row inner-repeater">
            <div class="col-md-6">
                <div class="border-bottom mb-2">
                    <span>Measurements</span>
                </div>
                <div class="">
                    <div class="measurement-inputs">
                        @if ($oldmeasurements)
                            <table class='table table-sm table-borderless'>
                                @foreach ($oldmeasurements as $measurement)
                                    @php

                                        $size = $measurement['size'];
                                        $measurement = $edit ? $measurement->measurement : $measurement;
                                        $errorName = 'services.' . $serviceIndex . '.measurements.' . $loop->index . '.size';
                                    @endphp
                                    <tr class="">
                                        <td class='w-5'><small>{{ $measurement['name'] }}</small></td>
                                        <td>
                                            <input type="text"
                                                name="services[{{ $serviceIndex }}][measurements][{{ $loop->index }}][size]"
                                                class="form-control form-control-sm @error($errorName) is-invalid @enderror"
                                                placeholder="Size" value="{{ $size }}" />
                                            @error($errorName)
                                                <span
                                                    class="text-danger error validation-error d-block mb-2 invalid-feedback"
                                                    role="alert">{{ $message }}</span>
                                            @enderror

                                            <input type="hidden"
                                                name="services[{{ $serviceIndex }}][measurements][{{ $loop->index }}][id]"
                                                value="{{ $measurement['id'] }}" />
                                            <input type="hidden"
                                                name="services[{{ $serviceIndex }}][measurements][{{ $loop->index }}][name]"
                                                value="{{ $measurement['name'] }}" />
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
                    <div class="row ">

                        <div class="col-12">
                            <div class="design-inputs">
                                @if ($oldDesigns)
                                    <table class='table table-sm table-borderless'>
                                        @foreach ($designs as $design)
                                            @php
                                                $errorName = 'services.' . $serviceIndex . '.designs.' . $loop->index . '.style_id';
                                            @endphp
                                            <tr>

                                                <td class='w-5'><small>{{ $design->name }}</small></td>
                                                <td>
                                                    <input type="hidden" value="{{ $design->id }}"
                                                        name="services[{{ $serviceIndex }}][designs][{{ $loop->index }}][id]" />
                                                    <select
                                                        class="form-control form-control-sm @error($errorName) is-invalid @enderror"
                                                        name="services[{{ $serviceIndex }}][designs][{{ $loop->index }}][style_id]">
                                                        <option value="">Select {{ $design->name }}</option>
                                                        @foreach ($design->styles as $style)
                                                            <option value="{{ $style->id }}"
                                                                {{ $selectedDesignIds->contains($style->id) ? 'selected' : '' }}>
                                                                {{ $style->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error($errorName)
                                                        <span
                                                            class="text-danger error validation-error d-block mb-2 invalid-feedback"
                                                            role="alert">{{ $message }}</span>
                                                    @enderror
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <a data-repeater-delete class="btn btn-danger btn-sm position-absolute service-remove-button">
        <i class="fa fa-trash "></i>
    </a>


    <div id="preview-modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <img src="" alt="">
            </div>
        </div>
    </div>

</div>

