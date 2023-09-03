<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientAyantDroit extends Model
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

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function fiche(){
        return $this->belongsTo(Fiche::class,'fiche_id');
    }
}
