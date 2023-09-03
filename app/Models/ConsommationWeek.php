<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsommationWeek extends Model
{
    use HasFactory;

    public function consommation(){
        return $this->belongsTo(ConsommationProduct::class);
    }

    public function products(){
        return $this->hasMany(ProductDayCons::class);
    }
}
