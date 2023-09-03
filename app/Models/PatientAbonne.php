<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientAbonne extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function getAge($id){
        $patient=$this->find($id);
        $annee=(new DateTime($patient->DateNaissance))->format('Y');
        $age=date('Y')-$annee;
        if ($age>0) {
            return $age;
        } else {
            return "Inconnu";
        }


    }
    public function fiche(){
        return $this->belongsTo(Fiche::class,'fiche_id');
    }

    public function abonnement(){
        return $this->belongsTo(Abonnement::class,'abonnement_id');
    }
}
