<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function measurements(){
        return $this->hasMany(ServiceMeasurement::class);
    }

    public function designs(){
        return $this->hasMany(ServiceDesign::class);
    }
}
