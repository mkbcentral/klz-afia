<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reduction extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function demande(){
        return $this->belongsTo(DemandeConsultation::class,'demande_consultation_id');
    }

}
