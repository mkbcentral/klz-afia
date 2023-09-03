<?php

namespace App\Http\Livewire\Hospitalisation;

use App\Models\Abonnement;
use App\Models\DemandeConsultation;
use Livewire\Component;

class HospitalisationAbonnesComponent extends Component
{
    public $keySearch='',$searchDate,$currentDate;
    public $products;
    public $abonnements,$abonnement_data,$mois=[];

    public function mount(){
         $this->currentDate=date('m');
         foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }
        $this->currentDate=date('m');
        $this->abonnements=Abonnement::all();
    }
    public function render()
    {
        $data= DemandeConsultation::select('demande_consultations.*',
        'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
        ->whereMonth('demande_consultations.created_at',$this->currentDate)
        ->where('patient_abonnes.Nom','Like','%'.$this->keySearch.'%')
        ->where('patient_abonnes.abonnement_id',$this->abonnement_data)
        ->where('demande_consultations.is_inteneted',true)
        ->orderBy('demande_consultations.created_at','DESC')
        ->where('demande_consultations.source','Golf')
         ->get();
        return view('livewire.hospitalisation.hospitalisation-abonnes-component',[
            'factures'=>$data
        ]);
    }
}
