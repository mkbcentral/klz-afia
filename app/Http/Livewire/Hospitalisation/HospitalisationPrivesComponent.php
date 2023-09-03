<?php

namespace App\Http\Livewire\Hospitalisation;

use App\Models\DemandeConsultation;
use App\Models\Product;
use Livewire\Component;

class HospitalisationPrivesComponent extends Component
{
    public $keySearch='',$searchDate,$currentDate,$mois;
    public $products;

    public function mount(){
         $this->currentDate=date('m');
         foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }
    }

    public function render()
    {
        $data= DemandeConsultation::select('demande_consultations.*',
        'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
        ->whereMonth('demande_consultations.created_at',$this->currentDate)
        ->orderBy('demande_consultations.created_at','ASC')
        ->where('demande_consultations.is_inteneted',true)
        ->get();

        return view('livewire.hospitalisation.hospitalisation-prives-component',[
            'factures'=>$data,
            ''
        ]);
    }
}
