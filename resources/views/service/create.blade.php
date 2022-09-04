@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="container pt-5">
                <div class="card ">
                    <div class="card-header">
                        <h2><strong>Add Service</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('services.store') }}" class="" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            {!!Form::input()->setName('name')->setValue()->setLabel('Service Name')->setPlaceholder('Service Name')->render()!!}
                                        </div>

                                        <div class="col-md-4">
                                            {!!Form::input()->setName('crafting_price')->setValue()->setLabel('Crafting Cost')->setPlaceholder('Crafting Cost')->render()!!}
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mt-0 mt-md-4 pt-0 pt-md-2">
                                                @include('input.checkbox', [
                                                    'name' => 'is_assian',
                                                    'checked' => false,
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="">
                                        <div class="row align-items-end">
                                            <div class="col-md-12">
                                                <div class="col"><label for="">Image</label></div>
                                                <div class="row" id="coba">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>





                            <div class="repeater form-group border p-2 rounded">
                                <label class="form-inline">Measurement's</label>

                                <div data-repeater-list="measurement" class="row">

                                    @forelse (old('measurement',[]) as $measurement)
                                        <div data-repeater-item class="col-md-4">
                                            {!!Form::input()->setName('name')->setValue($measurement['name']??'')->setLabel('Measurement Name')->setPlaceholder('Measurement Name')
                                            ->setEnableLabel(false)
                                            ->appendWrapperClass('d-flex flex-row border p-2 rounded mb-0')
                                            ->appendInputClass('d-flex w-auto flex-grow-1  only-bottom-border')
                                            ->setError('measurement.' . $loop->index . '.name')
                                            ->setAppend(
                                                '<a data-repeater-delete class="btn btn-sm ml-2">
                                                    <i class="fa fa-trash text-red"></i>
                                                </a>'
                                            )
                                                ->render()!!}
                                        </div>
                                    @empty
                                        <div data-repeater-item class="col-md-4">
                                            {!!Form::input()->setName('name')->setValue('')->setLabel('Measurement Name')->setPlaceholder('Measurement Name')
                                            ->setEnableLabel(false)
                                            ->appendWrapperClass('d-flex flex-row border p-2 rounded mb-0')
                                            ->appendInputClass('d-flex w-auto flex-grow-1  only-bottom-border')
                                            ->setError('')
                                            ->setAppend(
                                                '<a data-repeater-delete class="btn btn-sm ml-2">
                                                    <i class="fa fa-trash text-red"></i>
                                                </a>'
                                            )
                                                ->render()!!}
                                        </div>
                                    @endforelse

                                </div>
                                <a href="#" data-repeater-create class="btn btn-outline-success btn-sm mt-2" type="">Add</a>
                            </div>


                            <div class="repeater-nested form-group border p-2 rounded">
                                <label class="form-inline">Designs's</label>
                                <div data-repeater-list="design" class="row">

                                    @forelse (old('design',[]) as $design)
                                        <div data-repeater-item class="col-md-12 ">
                                            <div class="p-2 border  rounded mb-2">



                                                {!!Form::input()->setName('name')->setValue( $design['name']??'')->setPlaceholder('Design Name')
                                                    ->setEnableLabel(false)
                                                    ->appendWrapperClass('form-group d-flex flex-row mb-0')
                                                    ->appendInputClass('d-flex w-auto flex-grow-1  only-bottom-border')
                                                    ->setError('design.' . $loop->index . '.name')
                                                    ->setAppend(
                                                        '<a data-repeater-delete class="btn btn-sm">
                                                            <i class="fa fa-trash text-red"></i>
                                                        </a>'
                                                    )
                                                ->render()!!}

                                                <div class="inner-repeater mb-2 mt-2">
                                                    <div data-repeater-list="style" class="row">
                                                        @forelse ( $design['style']??[] as $style)
                                                            <div data-repeater-item class="col-md-4">
                                                                {!!Form::input()->setName('name')->setValue($style['name']??'')->setPlaceholder('Style Name')
                                                                    ->setEnableLabel(false)
                                                                    ->appendWrapperClass('d-flex flex-row border p-2 rounded')
                                                                    ->appendInputClass('d-flex w-auto flex-grow-1  only-bottom-border')
                                                                    ->setError('design.' . $loop->parent->index . '.style.'.($loop->index).'.name')
                                                                    ->setAppend(
                                                                        '<a data-repeater-delete class="btn btn-sm ">
                                                                            <i class="fa fa-trash text-red"></i>
                                                                        </a>'
                                                                    )
                                                                ->render()!!}
                                                            </div>
                                                        @empty
                                                            <div data-repeater-item class="col-md-4">
                                                                {!!Form::input()->setName('name')->setValue('')->setPlaceholder('Style Name')
                                                                    ->setEnableLabel(false)
                                                                    ->appendWrapperClass('d-flex flex-row border p-2 rounded')
                                                                    ->appendInputClass('d-flex w-auto flex-grow-1  only-bottom-border')
                                                                    ->setError('')
                                                                    ->setAppend(
                                                                        '<a data-repeater-delete class="btn btn-sm ">
                                                                            <i class="fa fa-trash text-red"></i>
                                                                        </a>'
                                                                    )
                                                                ->render()!!}
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

                                                {!!Form::input()->setName('name')->setValue('')->setPlaceholder('Design Name')
                                                    ->setEnableLabel(false)
                                                    ->appendWrapperClass('d-flex flex-row')
                                                    ->appendInputClass('d-flex w-auto flex-grow-1  only-bottom-border')
                                                    ->setError('')
                                                    ->setAppend(
                                                        '<a data-repeater-delete class="btn btn-sm">
                                                            <i class="fa fa-trash text-red"></i>
                                                        </a>'
                                                    )
                                                ->render()!!}

                                                <div class="inner-repeater mb-2 mt-2">
                                                    <div data-repeater-list="style" class="row">
                                                        <div data-repeater-item class="col-md-4">
                                                            {!!Form::input()->setName('name')->setValue('')->setPlaceholder('Style Name')
                                                                    ->setEnableLabel(false)
                                                                    ->appendWrapperClass('d-flex flex-row border p-2 rounded')
                                                                    ->appendInputClass('d-flex w-auto flex-grow-1  only-bottom-border')
                                                                    ->setError('')
                                                                    ->setAppend(
                                                                        '<a data-repeater-delete class="btn btn-sm">
                                                                            <i class="fa fa-trash text-red"></i>
                                                                        </a>'
                                                                    )
                                                                ->render()!!}
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
                                <a href="#" data-repeater-create class="btn btn-outline-success btn-sm" type="">Add
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
