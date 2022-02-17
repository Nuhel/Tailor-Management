<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderServicDesign extends Model
{
    use HasFactory;

    public function design(){
        return $this->belongsTo(ServiceDesign::class,'service_design_id');
    }
    public function style(){
        return $this->belongsTo(ServiceDesignStyle::class,'service_design_style_id');
    }
}
