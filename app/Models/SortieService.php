<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SortieService extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function service(){
        return $this->belongsTo(Service::class,'service_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot(['id','qty']);
    }

    public function getToatl($id){
        $total=0;

        $oserie=$this->find($id);
        foreach ($oserie->products as $product) {
            $total+=$product->price*$product->pivot->qty;
        }
        return $total;
    }
}
