@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                <div class="card mt-5">
                    <div class="card-header">
                        <h2><strong>Update Service</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('services.update', ['service' => $service->id]) }}" enctype="multipart/form-data"
                            class="">
                            @csrf
                            @method('put')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {!! Form::input()->setName('name')->setValue(old('name', $service->name))->setLabel('Service Name')->setPlaceholder('Service Name')->render() !!}
                                        </div>

                                        <div class="col-md-6">
                                            {!! Form::input()->setName('crafting_price')->setValue(old('crafting_price', $service->crafting_price))->setLabel('Crafting Cost')->setPlaceholder('Crafting Cost')->render() !!}
                                        </div>



                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-{{ $service->image ? '6' : '12' }}">
                                            <div class="col"><label for="">Select Image <small
                                                        class="text-danger">(Will delete
                                                        old)</small></label></div>
                                            <div class="row" id="coba">
                                            </div>
                                        </div>

                                        @if ($service->image)
                                            <div class="col-6 d-flex align-items-center flex-column justify-content-end">
                                                <div>
                                                    @include('input.checkbox', [
                                                        'name' => 'delete_old',
                                                        'checked' => old('delete_old') == 1,
                                                    ])
                                                </div>
                                                <img src="{{ URL::to($service->image) }}" alt=""
                                                    class="mg-fluid img-thumbnail" style="height: 150px !important">
                                            </div>
                                        @endif


                                    </div>
                                </div>
                            </div>




                            <div class="repeater form-group border p-2 rounded">
                                <label class="form-inline">Measurement's</label>

                                <div data-repeater-list="measurement" class="row">

                                    @forelse (old('measurement',$service->measurements??[])  as $measurement)
                                        <div data-repeater-item class="col-md-4">


                                            {!! Form::input()->setName('name')->setValue($measurement['name'] ?? '')->setPlaceholder('Measurement Name')->setEnableLabel(false)->appendWrapperClass('d-flex flex-row border p-2 rounded mb-0')->appendInputClass('d-flex w-auto flex-grow-1  only-bottom-border')->setError('measurement.' . $loop->index . '.name')->setAppend(
                                                    '<a data-repeater-delete class="btn btn-sm ml-2">
                                                                                                                                            <i class="fa fa-trash text-red"></i>
                                                                                                                                        </a>',
                                                )->render() !!}
                                            <input type="hidden" name="id" value="{{ $measurement['id'] }}" />
                                        </div>
                                    @empty
                                        <div data-repeater-item class="col-md-4">

                                            {!! Form::input()->setName('name')->setValue('')->setPlaceholder('Measurement Name')->setEnableLabel(false)->appendWrapperClass('d-flex flex-row border p-2 rounded mb-0')->appendInputClass('d-flex w-auto flex-grow-1  only-bottom-border')->setError('')->setAppend(
                                                    '<a data-repeater-delete class="btn btn-sm ml-2">
                                                                                                                                            <i class="fa fa-trash text-red"></i>
                                                                                                                                        </a>',
                                                )->render() !!}
                                            <input type="hidden" name="id" value="0" />
                                        </div>
                                    @endforelse

                                </div>
                                <a href="#" data-repeater-create class="btn btn-outline-success btn-sm mt-2"
                                    type="">Add</a>
                            </div>


                            <div class="repeater-nested form-group border p-2 rounded">
                                <label class="form-inline">Designs's</label>
                                <div data-repeater-list="design" class="row">

                                    @forelse (old('design',$service->designs??[])  as $design)
                                        <div data-repeater-item class="col-md-12 ">
                                            <div class="p-2 border  rounded mb-2">

                                                {!! Form::input()->setName('name')->setValue($design['name'] ?? '')->setPlaceholder('Design Name')->setEnableLabel(false)->appendWrapperClass('form-group d-flex flex-row mb-0')->appendInputClass('d-flex w-auto flex-grow-1  only-bottom-border')->setError('design.' . $loop->index . '.name')->setAppend(
                                                        '<a data-repeater-delete class="btn btn-sm">
                                                                                                                                                            <i class="fa fa-trash text-red"></i>
                                                                                                                                                        </a>',
                                                    )->render() !!}
                                                <input type="hidden" name="id" value="{{ $design['id'] }}" />

                                                <div class="inner-repeater mb-2 mt-2">
                                                    <div data-repeater-list="style" class="row">
                                                        @forelse ($design['style']??$design->styles??[] as $style)
                                                            <div data-repeater-item class="col-md-4">

                                                                {!! Form::input()->setName('name')->setValue($style['name'] ?? '')->setPlaceholder('Style Name')->setEnableLabel(false)->appendWrapperClass('d-flex flex-row border p-2 rounded')->appendInputClass('d-flex w-auto flex-grow-1 only-bottom-border')->setError('design.' . $loop->parent->index . '.style.' . $loop->index . '.name')->setAppend(
                                                                        '<a data-repeater-delete class="btn btn-sm ">
                                                                                                                                                                                                            <i class="fa fa-trash text-red"></i>
                                                                                                                                                                                                        </a>',
                                                                    )->render() !!}
                                                                <input type="hidden" name="id"
                                                                    value="{{ $style['id'] }}" />
                                                            </div>
                                                        @empty
                                                            <div data-repeater-item class="col-md-4">

                                                                {!! Form::input()->setName('name')->setValue('')->setPlaceholder('Style Name')->setEnableLabel(false)->appendWrapperClass('d-flex flex-row border p-2 rounded')->appendInputClass('d-flex w-auto flex-grow-1 only-bottom-border')->setError('')->setAppend(
                                                                        '<a data-repeater-delete class="btn btn-sm ">
                                                                                                                                                                                                            <i class="fa fa-trash text-red"></i>
                                                                                                                                                                                                        </a>',
                                                                    )->render() !!}
                                                                <input type="hidden" name="id" value="0" />
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                    <a data-repeater-create class="btn btn-outline-success btn-sm mt-2">
                                                        Add Style
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div data-repeater-item class="col-md-12 ">
                                            <div class="p-2 border  rounded mb-2">

                                                {!! Form::input()->setName('name')->setValue('')->setPlaceholder('Design Name')->setEnableLabel(false)->appendWrapperClass('d-flex flex-row')->appendInputClass('d-flex w-auto flex-grow-1  only-bottom-border')->setError('')->setAppend(
                                                        '<a data-repeater-delete class="btn btn-sm">
                                                                                                                                                            <i class="fa fa-trash text-red"></i>
                                                                                                                                                        </a>',
                                                    )->render() !!}

                                                <div class="inner-repeater mb-2 mt-2">
                                                    <div data-repeater-list="style" class="row">
                                                        <div data-repeater-item class="col-md-4">
                                                            {!! Form::input()->setName('name')->setValue('')->setPlaceholder('Style Name')->setEnableLabel(false)->appendWrapperClass('d-flex flex-row border p-2 rounded')->appendInputClass('d-flex w-auto flex-grow-1  only-bottom-border')->setError('')->setAppend(
                                                                    '<a data-repeater-delete class="btn btn-sm">
                                                                                                                                                                                                    <i class="fa fa-trash text-red"></i>
                                                                                                                                                                                                </a>',
                                                                )->render() !!}
                                                        </div>
                                                    </div>
                                                    <a data-repeater-create class="btn btn-outline-success btn-sm">
                                                        Add Style
                                                    </a>
                                                </div>
                                            </div>


                                        </div>
                                    @endforelse

                                </div>
                                <a href="#" data-repeater-create class="btn btn-outline-success btn-sm"
                                    type="">Add
                                    Design</a>
                            </div>



                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success mt-3" name="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/repeater.js') }}"></script>
    <script src="{{ asset('js/picker.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'image',
                rowHeight: '150px',
                groupClassName: 'col',
                maxCount: '1',
            });
            $('.repeater-nested').repeater({
                initEmpty: false,
                show: function() {
                    $(this).find('.validation-error:not(.validation-error-space)').remove();

                    //Forcing repeater to append only one input
                    var row = $(this).find('.inner-repeater > .row')[0];
                    var inputs = $(this).find('.inner-repeater > .row > .col-md-4')[0];
                    $(row).html(inputs);
                    $(this).slideDown();
                },
                repeaters: [{
                    selector: '.inner-repeater',
                    isFirstItemUndeletable: true,
                    show: function() {
                        $(this).find('.validation-error:not(.validation-error-space)').remove();
                        $(this).slideDown();
                    },
                }],

                isFirstItemUndeletable: true
            })

            $('.repeater').repeater({
                initEmpty: false,
                show: function() {
                    $(this).find('div > .validation-error:not(.validation-error-space)').remove();
                    $(this).slideDown();
                },

                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                },

                ready: function(setIndexes) {
                    //$dragAndDrop.on('drop', setIndexes);
                },

                isFirstItemUndeletable: true
            })
        });
    </script>
@endsection
