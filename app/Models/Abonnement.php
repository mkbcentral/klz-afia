<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Abonnement extends Model
{
    use HasFactory;

    protected $guarded=[];


    public function getData($mois,$abonnement){
        $total_product=0;
        $total_medication=0;

        $demandes=DemandeConsultation::select('demande_consultations.*','patient_abonnes.*')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
        ->whereMonth('demande_consultations.created_at',$mois)
        ->where('patient_abonnes.abonnement_id',$abonnement)
        ->get();
        $mt=0;
        if ($demandes->isEmpty()) {
            return 0;
        } else {
            foreach ($demandes as $key => $demande) {
                foreach ($demande->products as $product) {
                    $total_product+=($product->price*$product->pivot->qty);
                }
                foreach ($demande->medications as $medication) {
                    $total_medication+=$medication->product->price * $medication->qty;
                }
                $mt=+$total_product+$total_medication;
            }
        }

        return $mt;

    }

    public function getCount($mois,$abonnement){
        $total_product=0;
        $total_medication=0;

        $demandes=DemandeConsultation::select('demande_consultations.*','patient_abonnes.*')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
        ->whereMonth('demande_consultations.created_at',$mois)
        ->where('patient_abonnes.abonnement_id',$abonnement)
        ->get();

        //dd($demande);

        return $demandes->count();
    }

    public function patientAbonnes(){
        return $this->hasMany(PatientAbonne::class);
    }
}
