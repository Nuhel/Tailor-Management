<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderService extends Model
{
    use HasFactory;
    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function serviceMeasurements(){
        return $this->hasMany(OrderServicMeasurement::class);
    }

    public function serviceDesigns(){
        return $this->hasMany(OrderServicDesign::class);
    }

    public function payments(){
        return $this->morphMany(Transaction::class,'transactionable')->expense();
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
                    ->on('transactions.transactionable_id', '=', 'order_services.id')
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
                `order_services`.`id` = `transactions`.`transactionable_id`
                AND `transactionable_type` = 'App\\\Models\\\OrderService') AS `paid`
        ");
    }
}
