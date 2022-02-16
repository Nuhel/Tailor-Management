<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\BankAccount;
use Livewire\Component;
use Illuminate\Support\Arr;

class OrderPayments extends Component
{

    public $bankTypes;
    public $bankType;

    public $banks;
    public $bankId;

    public $accounts;
    public $accountId;

    public function mount($bankType, $bankId, $accountId){

        $this->bankType = $bankType;
        $this->bankTypes = collect(["Cash Payment","General Bank","Mobile Bank"]);

        $this->bankId = $bankId;
        $this->banks = ($bankType!= null && $this->bankTypes->contains($bankType) )? Bank::where('type',$bankType)->get(): collect();

        $this->accounts = ($bankId!=null)? BankAccount::where('bank_id',$bankId)->get():collect();
        $this->accountId = $accountId;
    }
    public function render()
    {
        return view('order.livewire.order-payments');
    }

    public function updatedBankType($bank){
        $this->banks = Bank::where('type',$bank)->get();
        $this->accounts = collect();
    }

    public function updatedBankId($bankId){
        $this->accounts = BankAccount::where('bank_id',$bankId)->get();
    }
}
