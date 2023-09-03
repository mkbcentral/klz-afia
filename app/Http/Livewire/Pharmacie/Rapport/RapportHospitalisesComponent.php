<?php

namespace App\Http\Livewire\Pharmacie\Rapport;

use App\Models\DemandeConsultation;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class RapportHospitalisesComponent extends Component
{
    use WithPagination;
    public $keySearch='',$searchDate,$currentDate,$data;
    public function getByDate(){
        $this->currentDate=$this->searchDate;
        //dd($this->currentDate);
    }

    public function getCurrentDate(){
        $this->currentDate=Carbon::now();
    }

    public function mount(){

    }
    public function render()
    {
        return view('livewire.pharmacie.rapport.rapport-hospitalises-component',[
            'rapports'=>DemandeConsultation::select('demande_consultations.*',
            'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
            ->where('demande_consultations.is_inteneted',true)
            ->whereDate('demande_consultations.created_at',$this->currentDate)
            ->get()
        ]);
    }
}
