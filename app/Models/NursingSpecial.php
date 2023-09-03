<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NursingSpecial extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function demande(){
        return $this->belongsTo(DemandeSpeciale::class,'demande_speciale_id');
    }
}
