<div class="modal fade" tabindex="-1" role="dialog" id="take-payment-modal">
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
                <form method="POST" id="take-payment-form">
                    <input type="hidden" name="id">
                    <div class="form-group" id="amount">
                        <label class="form-inline">Amount</label>
                        <input type="text" name="amount" class="form-control form-control-sm" placeholder="Enter Amount">
                    </div>

                    <div class="form-group" id="date">
                        <label class="form-inline">Payment Date</label>
                        <input type="date" name="date" class="form-control form-control-sm" >
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

        var modalView =  $('#take-payment-modal');
        modalView.on('hidden.bs.modal', function (e) {
            $(this).find('.error').remove();
            $(this).find(`input`).val('');
            $(this).find(`input`).removeClass('is-invalid');
        })

        modalView.on('show.bs.modal', function (e) {
            var target = $(e.relatedTarget);
            var id = target.data('id');
            $(this).find(`input[name='id']`).val(id);
        })

        $('#take-payment-form').on('submit', function(event){
            event.preventDefault();
            var baseUrl = "{{URL::to('/orders/')}}";
            var id = $("input[name='id']").val();
            var url = baseUrl+'/'+id+'/take-payment'
            var bodyFormData = new FormData();
            bodyFormData.append('_token', '{{ csrf_token() }}');
            bodyFormData.append('amount', $("input[name='amount']").val());
            bodyFormData.append('date', $("input[name='date']").val());
            axios({
                method: "post",
                url: url,
                data: bodyFormData,
                })
                .then(function (response) {
                    modalView.modal('hide')
                    var dataTable = $('#{{$datatableId}}').dataTable();
                    dataTable.api().ajax.reload();
                })
                .catch(function (error) {

                    $.each(error.response.data, function(index,val){
                        console.log(index);
                        $('#'+index).append(`
                            <span class='text-danger error validation-error invalid-feedback' role="alert">`+val[0]+`</span>
                        `)
                        $('#'+index).find('input').addClass('is-invalid');
                    })
                });
        })
  </script>
  @endpush
