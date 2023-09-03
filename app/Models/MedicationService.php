<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicationService extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function demande(){
        return $this->belongsTo(DemandeConsultation::class,'demande_consultation_id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function getProduct($id){
        $product=Product::find($id);
        if ($product) {
            return $product->name;
        }
    }


}
