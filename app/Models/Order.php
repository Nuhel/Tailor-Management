<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
