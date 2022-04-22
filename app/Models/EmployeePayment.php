<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePayment extends Transaction
{
    use HasFactory;

    protected $table = "transactions";


    public function newQuery()
    {

        $query = parent::newQuery();

        $query->whereTransactionableType('App\Models\OrderService');

        return $query;
    }
    public function orderService()
    {
        return $this->belongsTo(OrderService::class, 'transactionable_id');
    }
}

//->whereTransactionableType('App\Models\Employee')
