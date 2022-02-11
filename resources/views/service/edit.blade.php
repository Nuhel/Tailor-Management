@extends('layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="container">
                <div class="card mt-5">
                    <div class="card-header">
                        <h2><strong>Insert Bank</strong></h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('services.update',['service'=>$service->id]) }}" class="">
                            @csrf
                            @method('put')
                            <div class="form-group ">
                                <label class="form-inline">Service Name</label>
                                <input type="text" name="name" id="empName" class="form-control"
                                    placeholder="Enter Service Name" value="{{ old('name',$service->name) }}">
                                @error('name')
                                <p class="text-danger mb-0 alert-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="repeater form-group border p-2 rounded">
                                <label class="form-inline">Measurement's</label>

                                <div data-repeater-list="measurement" class="row">

                                    @forelse ( old('measurement',$service->measurements??[])  as $measurement)
                                        <div data-repeater-item class="col-md-4">
                                            <div class="form-group d-flex flex-row border p-2 rounded mb-0">
                                                <input type="text" name="name"
                                                    class="form-control d-flex w-auto flex-grow-1  only-bottom-border "
                                                    placeholder="Measurement Name" value="{{ $measurement['name'] }}" />
                                                    <input type="hidden" name="id" value="{{ $measurement['id'] }}" />
                                                <a data-repeater-delete class="btn  ml-2">
                                                    <i class="fa fa-trash text-red"></i>
                                                </a>
                                            </div>
                                            @error('measurement.' . $loop->index . '.name')
                                                <p class="text-danger mb-0 alert-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @empty
                                        <div data-repeater-item class="col-md-4">
                                            <div class="form-group d-flex flex-row border p-2 rounded">
                                                <input type="text" name="name"
                                                    class="form-control d-flex w-auto flex-grow-1  only-bottom-border "
                                                    placeholder="Measurement Name" />
                                                    <input type="hidden" name="id" value="0" />
                                                <a data-repeater-delete class="btn  ml-2">
                                                    <i class="fa fa-trash text-red"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforelse

                                </div>
                                <a href="#" data-repeater-create class="btn btn-outline-success btn-sm mt-2" type="">Add</a>
                            </div>


                            <div class="repeater-nested form-group border p-2 rounded">
                                <label class="form-inline">Designs's</label>
                                <div data-repeater-list="design" class="row">

                                    @forelse (old('design',$service->designs??[])  as $design)
                                        <div data-repeater-item class="col-md-12 ">
                                            <div class="p-2 border  rounded mb-2">
                                                <div class="form-group d-flex flex-row mb-0">
                                                    <input type="text" name="name"
                                                        class="form-control d-flex w-auto flex-grow-1  only-bottom-border "
                                                        placeholder="Design Name" value="{{ $design['name'] }}" />
                                                        <input type="hidden" name="id" value="{{ $design['id'] }}" />
                                                    <a data-repeater-delete class="btn  ml-2">
                                                        <i class="fa fa-trash text-red"></i>
                                                    </a>

                                                </div>
                                                @error('design.' . $loop->index . '.name')
                                                    <p class="text-danger mb-0 alert-message">{{ $message }}</p>
                                                @enderror
                                                <div class="inner-repeater mb-2 mt-2">
                                                    <div data-repeater-list="style" class="row">
                                                        @forelse ( $design['style']??$design->styles??[] as $style)
                                                            <div data-repeater-item class="col-md-4">
                                                                <div class="form-group d-flex flex-row border rounded mb-0">
                                                                    <input type="text" name="name"
                                                                        class="form-control d-flex w-auto flex-grow-1  only-bottom-border "
                                                                        placeholder="Style Name"
                                                                        value="{{ $style['name'] }}" />
                                                                        <input type="hidden" name="id" value="{{ $style['id'] }}" />
                                                                    <a data-repeater-delete class="btn  ml-2">
                                                                        <i class="fa fa-trash text-red"></i>
                                                                    </a>
                                                                </div>
                                                                @error('design.' . $loop->parent->index . '.style.'.($loop->index).'.name')
                                                                    <p class="text-danger mb-0 alert-message">{{ $message }}</p>
                                                                @enderror
                                                            
                                                            </div>
                                                        @empty
                                                            <div data-repeater-item class="col-md-4">
                                                                <div class="form-group d-flex flex-row border rounded mb-0">
                                                                    <input type="text" name="name"
                                                                        class="form-control d-flex w-auto flex-grow-1  only-bottom-border "
                                                                        placeholder="Style Name" />
                                                                        <input type="hidden" name="id" value="0" />
                                                                    <a data-repeater-delete class="btn  ml-2">
                                                                        <i class="fa fa-trash text-red"></i>
                                                                    </a>
                                                                </div>
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
                                                <div class="form-group d-flex flex-row ">
                                                    <input type="text" name="name"
                                                        class="form-control d-flex w-auto flex-grow-1  only-bottom-border "
                                                        placeholder="Design Name" />
                                                        <input type="hidden" name="id" value="0" />
                                                        
                                                    <a data-repeater-delete class="btn  ml-2">
                                                        <i class="fa fa-trash text-red"></i>
                                                    </a>
                                                </div>

                                                <div class="inner-repeater mb-2 mt-2">
                                                    <div data-repeater-list="style" class="row">
                                                        <div data-repeater-item class="col-md-4">
                                                            <div class="form-group d-flex flex-row border p-2 rounded">
                                                                <input type="text" name="name"
                                                                    class="form-control d-flex w-auto flex-grow-1  only-bottom-border "
                                                                    placeholder="Style Name" />
                                                                <a data-repeater-delete class="btn  ml-2">
                                                                    <i class="fa fa-trash text-red"></i>
                                                                </a>
                                                            </div>
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
    <script>
        $(document).ready(function() {
            $('.repeater-nested').repeater({
                initEmpty: false,
                show: function() {
                    if ($(this).find('> div .alert-message').length) {
                        $(this).find('> div .alert-message').remove();
                    }

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
                        if ($(this).find('>  .alert-message').length) {
                            $(this).find('> .alert-message').remove();
                        }
                        $(this).slideDown();
                    },
                }],

                isFirstItemUndeletable: true
            })

            $('.repeater').repeater({
                initEmpty: false,
                show: function() {
                    if ($(this).find('> .alert-message').length) {
                        $(this).find('> .alert-message').remove();
                    }
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
