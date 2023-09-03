<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientPrive extends Model
{
    use HasFactory;

    protected $fillable=[
        'id',
        'Nom',
        'Postnom',
        'Prenom',
        'Sexe',
        'DateNaissance',
        'Telephone',
        'AutreTelephone',
        'Commune',
        'Quartier',
        'Avenue',
        'Numero',
        'fiche_id',
        'created_by',
        'date_venu',
    ];

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
}
