<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureAbulant extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot(['id','qty']);
    }

    public function getTotal($id){
        $total=0;
        $facture=FactureAbulant::find($id);
        foreach ($facture->products as $product) {
            $total+=$product->price*$product->pivot->qty;
        }

        return $total;
    }
}
