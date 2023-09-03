<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Fiche extends Model
{
    use HasFactory;

    protected $fillable=['id','numero','type','source'];

    public function patientAbonne(){
        return $this->hasOne(PatientAbonne::class);
    }
    public function patientPersonnel(){
        return $this->hasOne(PatientAyantDroit::class);
    }

    public function patientPrive(){
        return $this->hasOne(PatientPrive::class);
    }

    public function demandes(){
        return $this->hasMany(Fiche::class);
    }



}
