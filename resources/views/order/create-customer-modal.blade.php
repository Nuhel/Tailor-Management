<div class="modal" tabindex="-1" role="dialog" id="create-customer-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Customer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="c">
                <form method="POST" action="{{route('customers.store')}}" id="customer-create-form">
                    <div class="form-group" id="name">
                        <label class="form-inline">Customer Name</label>
                        <input type="text" name="name" id="empName" class="form-control" placeholder="Enter Customer Name">
                    </div>
                    <div class="form-group" id="mobile">
                        <label class="form-inline">Customer Mobile</label>
                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter Customer Mobile">
                    </div>

                    <div class="form-group" id="address">
                        <label class="form-inline">Customer Address</label>
                        <textarea name="address" id="address" class="form-control" placeholder="Enter Employee Address"></textarea>
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

        var modalView =  $('#create-customer-modal');
        modalView.on('hidden.bs.modal', function (e) {
            $(this).find('.error').remove();
            $(this).find("input").val('')
            $(this).find("textarea").val('')
        })

        $('#customer-create-form').on('submit', function(event){
            event.preventDefault();

            var url = $(this).attr('action');
            var bodyFormData = new FormData();
            bodyFormData.append('_token', '{{ csrf_token() }}');
            bodyFormData.append('name', $("input[name='name']").val());
            bodyFormData.append('mobile', $("input[name='mobile']").val());
            bodyFormData.append('address', $("textarea[name='address']").val());
            axios({
                method: "post",
                url: url,
                data: bodyFormData,
                })
                .then(function (response) {
                    var name = response.data.name;
                    var mobile = response.data.mobile;
                    var id = response.data.id;
                    var option = `<option value="`+id+`"> `+name+` (`+mobile+`)</option>`;
                    $('#customer_id').append(option);
                    $('#customer_id').val(id).trigger('change');
                    modalView.modal('hide');
                })
                .catch(function (error) {

                    $.each(error.response.data, function(index,val){
                        $('#'+index).append(`
                            <span class='error text-danger'>`+val[0]+`</span>
                        `)

                    })
                });
        })
  </script>
  @endpush
