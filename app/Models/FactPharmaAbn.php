<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactPharmaAbn extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function demande(){
        return $this->belongsTo(DemandeConsultation::class,'demande_consultation_id');
    }


    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot(['id','qty']);
    }


    public function getTotal($id){
        $facture=FactPharmaAbn::find($id);

        $mt=0;
        if ($facture==null) {
           return $mt;
        } else {
            foreach ($facture->products as $product) {
                $mt+=$product->quantity*$product->price;
            }
            return $mt;
        }


    }
}
