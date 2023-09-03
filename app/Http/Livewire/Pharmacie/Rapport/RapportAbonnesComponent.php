<?php

namespace App\Http\Livewire\Pharmacie\Rapport;

use App\Models\Abonnement;
use App\Models\FactPharmaAbn;
use Carbon\Carbon;
use Livewire\Component;

class RapportAbonnesComponent extends Component
{

    public $data;
    public $searchDate,$currentDate;
    public $abonnements,$abonnement_id,$mois=[];



    public function getByDate(){
        $this->currentDate=$this->searchDate;
    }

    public function getCurrentDate(){
        $this->currentDate=Carbon::now();
    }


    public function mount(){
       $this->currentDate=date('m');
        foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }
        $this->abonnements=Abonnement::all();
    }

    public function render()
    {
        return view('livewire.pharmacie.rapport.rapport-abonnes-component',[
            'rapports'=>FactPharmaAbn::select('demande_consultations.*','fact_pharma_abns.*',
            'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom')
            ->join('demande_consultations','fact_pharma_abns.demande_consultation_id','=','demande_consultations.id')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
            ->whereMonth('demande_consultations.created_at',$this->currentDate)
            ->where('patient_abonnes.abonnement_id',$this->abonnement_id)
            ->get()
        ]);
    }
}
