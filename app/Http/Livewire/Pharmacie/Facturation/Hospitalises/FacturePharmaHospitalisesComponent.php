<?php

namespace App\Http\Livewire\Pharmacie\Facturation\Hospitalises;

use App\Models\DemandeConsultation;
use App\Models\MedicationService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class FacturePharmaHospitalisesComponent extends Component
{
    use WithPagination;
    public $keySearch='',$searchDate,$page_number=50;
    public $demande;
    public $currentDate;
    public $demandes;
    public $numToEdit,$dateToEdit;
    public $itemProduct;
    public $newQtProduct,$itemMedicationPv;
    public $mois=[];

    public function getItemMedication($id){
        $medication = MedicationService::find($id);
        $this->itemMedicationPv=$medication->id;
        $this->nweQtMedication=$medication->qty;
    }

    public function changeQtMedication($id,$id_dmd){
        $medication = MedicationService::find($id);
        $medication->qty=$this->nweQtMedication;
        $medication->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Quantité produit bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemMedicationPv=0;
    }

    public function show($id){
        $this->demande=DemandeConsultation::select('demande_consultations.*',
            'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom','patient_prives.Sexe')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
            ->where('demande_consultations.id',$id)
            ->first();

            $this->numToEdit=$this->demande->numero;
            $date = date_create($this->demande->created_at);
            $this->dateToEdit=date_format($date, 'Y-m-d H:i:s');
    }

    public function getByDate(){
        $this->currentDate=$this->searchDate;
    }

    public function getCurrentDate(){
        $this->currentDate=date('Y-m-d');
    }

    //Rafrechir le modal et toules données
    public function refresh($id){
        $this->demande=DemandeConsultation::select('demande_consultations.*',
        'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom','patient_prives.Sexe')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
        ->where('demande_consultations.id',$id)
        ->first();
    }

//-----------PRODUIT DE LA PHARMACIE
    public function getItemIdProduct($id){
        $labo = DB::table('demande_consultation_product')->where('id',$id)->first();
        $this->itemProduct=$labo->id;
        $this->newQtProduct=$labo->qty;
    }

    //Cahnger la quantité de l'examen labp
    public function changeQtProduc($id,$id_dmd){
        $labo = DB::table('demande_consultation_product')
            ->where('id', $id)
            ->update(['qty' => $this->newQtProduct]);
        $this->dispatchBrowserEvent('datails-added',['message'=>"Quantité produit bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemProduct=0;
    }
    //Retirer l'examen labo
    public function deleteProduct($id,$id_dmd){
        DB::table('demande_consultation_product')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('datails-added',['message'=>"Produit retiré !"]);
    }

    public function mount(){

        foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }

        $this->currentDate=date('m');

    }

    public function render()
    {
        return view('livewire.pharmacie.facturation.hospitalises.facture-pharma-hospitalises-component',[
            'factures'=>
            DemandeConsultation::select('demande_consultations.*',
            'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
            ->whereMonth('demande_consultations.created_at',$this->currentDate)
            ->where('patient_prives.Nom','Like','%'.$this->keySearch.'%')
            ->where('demande_consultations.is_inteneted',true)
            ->orderBy('demande_consultations.created_at','ASC')
            ->get()
        ]);
    }
}
