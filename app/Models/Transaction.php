<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mehradsadeghi\FilterQueryString\FilterQueryString;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;

    protected $casts = [
        'transaction_date' => 'datetime:Y-m-d',
    ];
    protected $filters = ['sort','like','transactionable_id','transactionable_type', 'from_date','to_date','amount'];


    public function from_date($query, $value) {
        try{
            return $query->whereDate('transaction_date', '>=', Carbon::parse($value));
        }catch(\Exception $e){
            return $query;
        }
    }

    public function to_date($query, $value) {
        try{
            return $query->whereDate('transaction_date', '<=', Carbon::parse($value));
        }catch(\Exception $e){
            return $query;
        }
    }


    public function scopeWithdrawal($query)
    {
        return $query->whereType('Credit')->where('transactionable_type','=','App\Models\Investor');
    }

    public function scopeExpense($query)
    {
        return $query->whereType('Credit');
    }

    public function scopeIncome($query)
    {
        return $query->whereType('Debit')->where('transactionable_type','!=','App\Models\Investor');
    }

    public function scopeInvestment($query)
    {
        return $query->whereTransactionableType('App\Models\Investor')->whereType('Debit');
    }

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function saveAsExpense(){
        $this->type = "Credit";
        return $this->save();
    }

    public function saveAsIncome(){
        $this->type = "Debit";
        return $this->save();
    }

    public function saveAsInvest(){
        return $this->saveAsIncome();
    }

    public function sourceable()
    {
        return $this->morphTo();
    }
}
