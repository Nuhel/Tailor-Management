<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{
    use HasFactory;
    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function serviceMeasurements(){
        return $this->hasMany(OrderServicMeasurement::class);
    }

    public function serviceDesigns(){
        return $this->hasMany(OrderServicDesign::class);
    }
}
