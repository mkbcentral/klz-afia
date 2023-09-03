<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsommationProduct extends Model
{
    use HasFactory;

    protected $fillable=[
        'week','service_id','code','user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function service(){
        return $this->belongsTo(Service::class,'service_id');
    }

    public function getProductsWeek($id){
        $orders=ProductDayOder::select('product_day_oders.*',
            'consommation_products.id')
            ->join('product_day_cons','product_day_oders.product_day_con_id','=','product_day_cons.id')
            ->join('consommation_weeks','product_day_cons.consommation_week_id','=','consommation_weeks.id')
            ->join('consommation_products','consommation_weeks.consommation_product_id','=','consommation_products.id')
            ->where('consommation_products.id',$id)
            ->get();

        return $orders->count();
    }
}
