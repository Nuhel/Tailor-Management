<div class="service-repeater card">
    <div data-repeater-list="services" class="card-body">
        <div class="row">
            <div class="col-12">
                <label class="form-inline">Services's</label>
            </div>
        </div>
        @forelse ($oldServices as $service)
            @include('order.service-reapeater.service-repeater-item', ['services' => $services,'oldService' => $service,'serviceIndex' => $loop->index])
        @empty
            @include('order.service-reapeater.service-repeater-item', ['services' => $services,'oldService' => [], 'serviceIndex' => 0])
        @endforelse

    </div>
    <div class="card-body pt-0">
        <button href="" data-repeater-create class="btn btn-outline-success btn-sm" type="button">Add
            Service</button>
    </div>
</div>

@push('inner-script')

<script src="{{ asset('js/repeater.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.service-repeater').repeater({
                repeaters: [{
                    selector: '.inner-repeater'
                }],
                initEmpty: false,
                show: function() {
                    var newService = $(this);
                    cleanUpNewService(newService)
                    newService.slideDown()
                    newService.addClass('mt-5')
                    manageNewServiceSelectBox(newService)
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

        function cleanUpNewService(newService){
            newService.find('.measurement-inputs').html('');
            newService.find('.design-inputs').html('');
            newService.find('span.error').remove();
        }

        function manageNewServiceSelectBox(newService){
            var selectBox = $(newService.find('.service_id')[0]);
            selectBox.data('index',$('.service_id').length-1);
            $('html, body').animate({
                scrollTop: selectBox.offset().top
            }, 2000);
            selectBox.focus();
        }
    </script>

    <script>
        const json = '{!! html_entity_decode($json) !!} ';
        const obj = JSON.parse(json);

        $(document).on('change', '.service_id', function($event) {
            var id = $(this).val();
            var row = $($(this).parents('.row')[0]);
            var option = $($(this).find(":selected"));
            var craftingPrice = option.data('crafting_price')??"";
            row.find('.crafting_price').val(craftingPrice);
            var repeaterItem = $(row.parents('.repeater-item')[0]);
            var measurementInput = $(repeaterItem.find('.measurement-inputs')[0]);
            var designInput = $(repeaterItem.find('.design-inputs')[0]);

            if (id != null && id!="") {
                var serviceIndex = $(this).data('index');
                var service = obj[id];
                if (service != undefined && service != null) {
                    var measurements = service['measurements'];
                    var measurementinputs = "<table class='table table-sm table-borderless'>";
                    $.each(measurements, function(index,value){
                        measurementinputs+=`
                            <tr class="">
                                <td class='w-5'><small>`+value['name']+`</small></td>
                                <td>
                                    <input type="text" name="services[`+serviceIndex+`][measurements][`+index+`][size]"
                                    class="form-control form-control-sm "
                                    placeholder="Size" value="" />

                                    <input type="hidden" name="services[`+serviceIndex+`][measurements][`+index+`][id]" value="`+value['id']+`" />
                                    <input type="hidden" name="services[`+serviceIndex+`][measurements][`+index+`][name]" value="`+value['name']+`" />
                                </td>
                            </tr>
                        `
                    });
                    measurementinputs+='</table>'
                    measurementInput.html(measurementinputs);

                    var designs = service['designs'];
                    var designInputs = "<table class='table table-sm table-borderless'>";

                    $.each(designs, function(index,value){

                        var styles = value['styles'];
                        var options = `
                            <option value=''>Select `+value['name']+`</option>
                        `;
                        $.each(styles, function(index,value){
                            options+='<option value="'+value['id']+'">'+value['name']+'</option>'
                        });

                        designInputs+=`
                            <tr class="">
                                <td class='w-5'><small >`+value['name']+`</small></td>
                                <td>
                                    <input type="hidden" value="`+value['id']+`" name="services[`+serviceIndex+`][designs][`+index+`][id]"/>
                                    <select class="form-control form-control-sm" name="services[`+serviceIndex+`][designs][`+index+`][style_id]">`
                                        +options+
                                    `</select>
                                </td>
                            </tr>
                        `
                    });
                    designInputs+='</table>'
                    designInput.html(designInputs);
                }

            }else{
                measurementInput.empty();
                designInput.empty();
            }

        });

        //$('.service_id').trigger('change');


        $(document).on('click', '.measurement-show-btn', function(){
            var collapseableButton = $(this);
            var collapseable = $(collapseableButton.parent('.repeater-item').find('.collapse')[0]);

            if(collapseable.hasClass('show')){
                collapseableButton.find('i').attr('class','fa fa-caret-down');
                collapseable.collapse('hide');
            }else{
                collapseableButton.find('i').attr('class','fa fa-caret-up');
                collapseable.collapse('show');
            }
        });

    </script>
@endpush
