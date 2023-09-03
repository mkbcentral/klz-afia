<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDayCons extends Model
{
    use HasFactory;

    public function day(){
        return $this->belongsTo(ConsommationWeek::class);
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function getOrder($id){
        $orders=ProductDayOder::where('product_day_con_id',$id)->get();
        return $orders;
    }
}
