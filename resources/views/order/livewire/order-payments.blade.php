

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <small>Transaction Type</small>
            <select wire:model="bankType" name="bank_type" id="" class="form-control form-control-sm">
                @foreach ($bankTypes as $bankType)
                    <option value="{{$bankType}}">{{$bankType}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <small>Select Bank</small>
            <select wire:model="bankId" name="bank_id" id="" class="form-control form-control-sm">
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
            <select name="account_id" id="" class="form-control form-control-sm" >
                <option value="">Select Account</option>
                @foreach ($accounts as $account)
                    <option value="{{$account->id}}" {{$accountId == $account->id?"selected":""}}>{{$account->number}} {{strlen($account->card)?"(Card: ".$account->card.")":""}}</option>
                @endforeach
            </select>
            @error('account_id')
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
    </div>
</div>


