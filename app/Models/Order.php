<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function master(){
        return $this->belongsTo(Master::class);
    }

    public function services(){
        return $this->hasMany(OrderService::class);
    }

    public function products(){
        return $this->hasMany(OrderProduct::class);
    }

    public function payments(){
        return $this->morphMany(Transaction::class,'transactionable')->income();
    }


    public function scopePaid($query){
        $transactionQuery = DB::table('transactions')
                   ->select(
                       'transactionable_id',
                       //'transactionable_type',
                       DB::raw('COUNT(*) AS transactions'),
                       DB::raw('SUM(amount) AS paid'),
                    )
                   ->where('transactionable_type', "App\Models\\".class_basename($this))

                   ->groupBy('transactionable_id');

        return $query->joinSub(

            $transactionQuery,'transactions',
            function($join){
                return $join
                    ->on('transactions.transactionable_id', '=', 'orders.id')
                    //->where('total_paid', '>',"sales.net_payable")
                    ;
            }
        );
    }
}
