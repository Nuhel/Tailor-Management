

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <small>Transaction Type</small>
            <select wire:model="transactionType" name="transactionType" id="" class="form-control form-control-sm">
                @foreach ($transactionTypes as $transactionType)
                    <option value="{{$transactionType}}">{{$transactionType}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <small>Select Bank</small>
            <select wire:model="bank" name="bank" id="" class="form-control form-control-sm">
                <option value="">Select Bank</option>
                @foreach ($banks as $bank)
                    <option value="{{$bank->id}}">{{$bank->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <small>Select Account</small>
            <select name="" id="" class="form-control form-control-sm">
                @foreach ($accounts as $account)
                    <option value="">{{$account->number}} {{strlen($account->card)?"(Card: ".$account->card.")":""}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>


