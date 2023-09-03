<?php

namespace App\Http\Livewire\Pharmacie\Facturation\Abonnes;

use App\Models\Abonnement;
use App\Models\DemandeConsultation;
use App\Models\MedicationService;
use App\Models\Taux;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class FacturePharmaAbonnesComponent extends Component
{
    use WithPagination;
    public $keySearch='',$searchDate,$page_number=50;
    public $demande;
    public $valeur_taux;
    public $consultation;
    public $currentDate;
    public  $sejours;
    private $demandes;
    public $numToEdit,$dateToEdit;
    public $abonnements,$mois=[];
    public $abonnementData;

    public $consultation_id_edit,$cons_id,$sejour_id;
    public $itemLaboId,$itemRadioId,$itemProduct,$itemIdEcho,
            $itemIdSejour,$itemIdAutres,$itemIdNursing,$itemMedication;

    public $newQtLabo,$newQtRadio,$newQtProduct,
            $newQtEcho,$newQtsejour,$newQtAutres,$newQtNursing,$newNameNursing;

            public $currentYear;
            public $years=['2021','2022','2023','2024'];


    public function getByDate(){
        $this->currentDate=$this->searchDate;

    }

    public function getCurrentDate(){
        $this->currentDate=date('Y-m-d');
    }

    public function show($id){
        $this->demande=DemandeConsultation::select('demande_consultations.*',
            'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom','patient_abonnes.Sexe')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
            ->where('demande_consultations.id',$id)
            ->first();
    }

    public function livred($id){
        $demande=DemandeConsultation::where('demande_consultations.id',$id)
                ->first();
        $demande->is_livred=true;
        $demande->update();
        $this->dispatchBrowserEvent('datails-added',['message'=>"Demande bien validée !"]);
    }

    public function unlivred($id){
        $demande=DemandeConsultation::where('demande_consultations.id',$id)
            ->first();
        $demande->is_livred=false;
        $demande->update();
        $this->dispatchBrowserEvent('datails-added',['message'=>"Demande bien validée !"]);
    }


    public function getItemIdProduct($id){
        $labo = DB::table('demande_consultation_product')->where('id',$id)->first();
        $this->itemProduct=$labo->id;
        $this->newQtProduct=$labo->qty;
    }

    public function changeQtProduc($id,$id_dmd){
        $labo = DB::table('demande_consultation_product')
            ->where('id', $id)
            ->update(['qty' => $this->newQtProduct]);
        $this->dispatchBrowserEvent('datails-added',['message'=>"Quantité produit bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemProduct=0;
    }
    public function deleteProduct($id,$id_dmd){
        DB::table('demande_consultation_product')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('datails-added',['message'=>"Produit retiré !"]);
    }

     //Rafrechir le modal et toules données
     public function refresh($id){
        $this->demande=DemandeConsultation::select('demande_consultations.*',
        'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom','patient_abonnes.Sexe')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
        ->where('demande_consultations.id',$id)
        ->first();
    }

    public function changeQtMedication($id,$id_dmd){
        $medication = MedicationService::find($id);
        $medication->qty=$this->nweQtMedication;
        $medication->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Quantité produit bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemMedication=0;
    }

    public function deleteMedicatio($id,$id_dmd){
        $medication = MedicationService::find($id);
        $medication->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Produit retiré !"]);
    }


    public function mount(){
        $taux=Taux::find(1);
        $this->valeur_taux=$taux->valeur;
        $this->currentDate=Carbon::now();
        $this->abonnements=Abonnement::all();
        $this->currentYear=date('Y');

        $this->currentDate=date('m');
        foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }
    }

    public function render()
    {
        return view('livewire.pharmacie.facturation.abonnes.facture-pharma-abonnes-component',[
            'factures'=>
                DemandeConsultation::select('demande_consultations.*',
                'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom')
                ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
                ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
                ->whereMonth('demande_consultations.created_at',$this->currentDate)
                ->where('patient_abonnes.abonnement_id',$this->abonnementData)
                ->orderBy('demande_consultations.created_at','DESC')
                ->where('patient_abonnes.Nom','Like','%'.$this->keySearch.'%')
                ->whereYear('demande_consultations.created_at',$this->currentYear)
                ->get()
        ]);
    }
}
