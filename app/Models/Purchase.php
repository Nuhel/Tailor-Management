<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;


    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function products(){
        return $this->hasMany(PurchaseProduct::class);
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

        return $query->leftJoinSub(

            $transactionQuery,'transactions',
            function($join){
                return $join
                    ->on('transactions.transactionable_id', '=', 'purchases.id')
                    //->where('total_paid', '>',"sales.net_payable")
                    ;
            }
        );
    }

    public function scopePaidRaw($query){
        return $query->selectRaw("
        (
            SELECT
                SUM(amount) AS paid
            FROM
                `transactions`
            WHERE
                `purchases`.`id` = `transactions`.`transactionable_id`
                AND `transactionable_type` = 'App\\\Models\\\purchase') AS `paid`
        ");
    }
}
