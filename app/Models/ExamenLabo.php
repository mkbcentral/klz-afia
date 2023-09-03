<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenLabo extends Model
{
    use HasFactory;

    public function demandes(){
        return $this->belongsToMany(DemandeConsultation::class);
    }

    public function getResult($id,$dmdId){
        $result=LaboResult::where('demande_consultation_id',$dmdId)
                            ->where('examen_labo_id',$id)
                            ->first();
        if ($result==null) {
            return "Aucun";
        } else {
            return $result->name;
        }

    }
}
