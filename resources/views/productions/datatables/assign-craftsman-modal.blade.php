<div class="modal fade" tabindex="-1" role="dialog" id="asign-craftsman-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Take Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="c">
                <form method="POST" id="asign-craftsman-form">
                    <input type="hidden" name="id">
                    <div class="form-group" id="employee_id">
                        <label class="form-inline">Crafts Man</label>
                        <select name="employee_id" id="" class="form-control form-control-sm">
                            <option value="">Select CraftsMan</option>
                            @foreach ($craftMans as $craftsMan)
                                <option value="{{$craftsMan->id}}"> {{$craftsMan->name}}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-sm btn-success mr-3" name="submit">Submit</button>
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancle</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div>
  @push('inner-script')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>

            var datatableIds = {!!collect($tableIds)->toJson()!!};
            var modalView =  $('#asign-craftsman-modal');
            modalView.on('hidden.bs.modal', function (e) {
                $(this).find('.error').remove();
                $(this).find(`input`).val('');
                $(this).find(`select`).val('');
                $(this).find(`input`).removeClass('is-invalid');
            })

            modalView.on('show.bs.modal', function (e) {

                var target = $(e.relatedTarget);
                datatableId = $(target.parents('table')[1]).attr('id');
                var id = target.data('id');
                $(this).find(`input[name='id']`).val(id);
            })

            $('#asign-craftsman-form').on('submit', function(event){
                event.preventDefault();
                var baseUrl = "{{URL::to('/productions/sent-to-production/')}}";
                var id = $("input[name='id']").val();
                var url = baseUrl+'/'+id
                var bodyFormData = new FormData();
                bodyFormData.append('_token', '{{ csrf_token() }}');
                bodyFormData.append('employee_id', $("select[name='employee_id']").val());
                axios({
                    method: "post",
                    url: url,
                    data: bodyFormData,
                    })
                    .then(function (response) {

                        if(datatableIds != null){
                            $.each(datatableIds, function(index,datatableId){
                                var datatable = $('#'+datatableId).dataTable();
                                datatable.api().ajax.reload();
                            })

                        }
                        modalView.modal('hide')
                    })
                    .catch(function (error) {
                        console.log(error);
                        return;
                        $.each(error.response.data, function(index,val){

                            $('#'+index).append(`
                                <span class='text-danger error validation-error invalid-feedback' role="alert">`+val[0]+`</span>
                            `)
                            $('#'+index).find('input').addClass('is-invalid');
                            $('#'+index).find('select').addClass('is-invalid');

                        })
                    });
            })
    </script>
  @endpush
