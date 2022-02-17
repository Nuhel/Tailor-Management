<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderServicMeasurement extends Model
{
    use HasFactory;
    public function measurement(){
        return $this->belongsTo(ServiceMeasurement::class);
    }
}
