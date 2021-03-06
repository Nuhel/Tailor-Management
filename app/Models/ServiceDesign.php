<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDesign extends Model
{
    use HasFactory;

    public function styles(){
        return $this->hasMany(ServiceDesignStyle::class);
    }
}
