<?php

namespace App\Http\Livewire\Rapport;

use App\Models\Abonnement;
use App\Models\DemandeConsultation;
use App\Models\Taux;
use Livewire\Component;

class RapportVentesAbonnesComponent extends Component
{
    public $keySearch='',$searchDate,$page_number=300,$mois,$abonnements,$abonnementData,$types=[];

    public function mount(){
        setlocale(LC_TIME, "fr_FR");
        $this->currentDate=date('m');
        foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }

        $this->abonnements=Abonnement::all();
        $taux=Taux::find(1);
        $this->valeur_taux=$taux->valeur;

    }

    public function render()
    {
        $data=DemandeConsultation::select('demande_consultations.*',
            'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
            ->whereMonth('demande_consultations.created_at',$this->currentDate)
            ->where('patient_abonnes.Nom','Like','%'.$this->keySearch.'%')
            ->where('patient_abonnes.abonnement_id',$this->abonnementData)
            ->orderBy('demande_consultations.numero','ASC')
            ->get();
        return view('livewire.rapport.rapport-ventes-abonnes-component',[
            'factures'=>$data,
        ]);
    }
}
