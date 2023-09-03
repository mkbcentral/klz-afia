<?php

namespace App\Http\Livewire\Rapport;

use App\Models\Consultation;
use App\Models\DemandeConsultation;
use App\Models\DemandeSpeciale;
use App\Models\Taux;
use Livewire\Component;
use Livewire\WithPagination;

class PrivePharmaComponent extends Component
{
    use WithPagination;
    public $keySearch='',$searchDate,$page_number=50;
    public $demande;
    public $valeur_taux;
    public $mois=[];
    public $currentDate;
    public $types=['Hospitalisé','Ambulants'];
    public $type_data;
    public  $sejours;


    public function mount(){
        $taux=Taux::find(1);
        $this->valeur_taux=$taux->valeur;
        $this->currentDate=date('m');
        $this->consultations=Consultation::all();
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
            ->where('patient_prives.Nom','Like','%'.$this->keySearch.'%')
            ->orderBy('demande_consultations.created_at','ASC')
            ->get();
        $specials=DemandeSpeciale::whereMonth('created_at',$this->currentDate)
            ->where('name','Like','%'.$this->keySearch.'%')
            ->where('type','Privé')
            ->orderBy('numero','ASC')
            ->get();
        return view('livewire.rapport.prive-pharma-component',
            [
                'factures'=>$data,
                'specials'=>$specials,
            ]
        );
    }
}
