<?php

namespace App\Http\Livewire;

use App\Models\DemandeConsultation;
use App\Models\FactureAbulant;
use App\Models\Taux;
use Carbon\Carbon;
use Livewire\Component;

class DashboardPharmaComponent extends Component
{
    public $mois=[],$monthName,$currentMonth,$dataChart;
    public $factureOcc=0,$factureAbonnes=0,$factureAbonnesHosp=0,
                $priveHospitalises,$factureAmbulant,$categories,$montant;

    public function getAbonnes(){
        $taux=Taux::find(1);
        $valeur_taux=$taux->valeur;
        $total_general=0;
        $total_product=0;

        $demandes=DemandeConsultation::select('demande_consultations.*',
        'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom','patient_abonnes.Sexe')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
        ->whereMonth('demande_consultations.created_at',$this->currentMonth)
        ->get();
        $mt_cons=0;
        //dd($demandes->count());
        foreach ($demandes as $demande) {
            foreach ($demande->products as $product) {
                $total_product+=$product->price*$product->pivot->qty;
            }
            $total_general=+$total_product;
        }

        return $total_general;
    }
    public function getByMonth(){
        $this->currentMonth=$this->monthName;
       $this->getAbonnes();
       $this->getAbonnesHospitalise();
       $this->getHospitalisePRive();
       $this->getAmbulants();

    }

    public function getAbonnesHospitalise(){
        $taux=Taux::find(1);
        $valeur_taux=$taux->valeur;
        $total_general=0;
        $total_product=0;
        $total_medication=0;

        $demandes=DemandeConsultation::select('demande_consultations.*',
        'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom','patient_abonnes.Sexe')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
        ->where('demande_consultations.is_inteneted',true)
        ->whereMonth('demande_consultations.created_at',$this->currentMonth)
        ->get();
        foreach ($demandes as $demande) {
            foreach ($demande->products as $product) {
                $total_product+=$product->price*$product->pivot->qty;
            }
            if ($demande->medications->isEmpty()) {
                # code...
            } else {
                foreach ($demande->medications as $medication) {
                    $total_medication+=$medication->product->price * $medication->qty;
                }
            }
            $total_general=+$total_product+$total_medication;
        }

        return $total_general;
    }

    public function getHospitalisePRive(){
        $taux=Taux::find(1);
        $valeur_taux=$taux->valeur;
        $total_general=0;
        $total_product=0;

        $demandes=DemandeConsultation::select('demande_consultations.*',
        'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom','patient_prives.Sexe')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
        ->where('demande_consultations.is_inteneted',true)
        ->whereYear('demande_consultations.created_at',date('Y'))
        ->whereMonth('demande_consultations.created_at',$this->currentMonth)
        ->get();
        foreach ($demandes as $demande) {
            foreach ($demande->products as $product) {
                $total_product+=$product->price*$product->pivot->qty;
            }
            $total_general=+$total_product;
        }

        return $total_general;
    }

    public function getAmbulants(){
        $taux=Taux::find(1);
        $valeur_taux=$taux->valeur;
        $total_general=0;
        $total_product=0;

        $demandes=FactureAbulant::whereMonth('created_at',$this->currentMonth)->get();
        foreach ($demandes as $demande) {
            foreach ($demande->products as $product) {
                $total_product+=$product->price*$product->pivot->qty;
            }
            $total_general=+$total_product;
        }

        return $total_general;
    }

    public function mount(){
        $this->currentMonth=Carbon::now();
        foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }


    }
    public function render()
    {
        $this->factureAbonnes=$this->getAbonnes();
        $this->factureAbonnesHosp=$this->getAbonnesHospitalise();
        $this->priveHospitalises=$this->getHospitalisePRive();;
        $this->factureAmbulant=$this->getAmbulants();

        $this->categories=['init','ABONNES','PRIVES HOSP','AMBULANTS'];
        $this->montant=[0,$this->factureAbonnes,$this->priveHospitalises,$this->factureAmbulant];

        return view('livewire.dashboard-pharma-component');
    }
}
