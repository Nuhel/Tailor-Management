<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\BankAccount;
use Livewire\Component;

class OrderPayments extends Component
{

    public $transactionTypes;
    public $transactionType;

    public $banks;
    public $accounts;
    public $bank;

    public function mount(){
        $this->transactionTypes = ["Cash Payment","General Bank","Mobile Bank"];
        $this->banks = collect();
        $this->accounts = collect();
    }
    public function render()
    {
        return view('livewire.order-payments');
    }

    public function updatedTransactionType($bank){
        $this->banks = Bank::where('type',$bank)->get();
        $this->accounts = collect();
    }

    public function updatedBank($bank){
        $this->accounts = BankAccount::where('bank_id',$bank)->get();
    }
}
