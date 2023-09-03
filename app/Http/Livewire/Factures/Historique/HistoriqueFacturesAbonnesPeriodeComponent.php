<?php

namespace App\Http\Livewire\Factures\Historique;

use App\Models\Abonnement;
use App\Models\Consultation;
use App\Models\DemandeConsultation;
use App\Models\DemandeSpeciale;
use App\Models\MedicationService;
use App\Models\Nursing;
use App\Models\Sejour;
use App\Models\Taux;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HistoriqueFacturesAbonnesPeriodeComponent extends Component
{
    public $abonnements,$keySearch='',$abonnement_data;
    public $valeur_taux;
    public $searchDateFrom,$searchDateTo;
    public $searchDate,$page_number=50;
    public $demande;

    public $consultation;
    public $currentDate;
    public  $sejours;
    private $demandes,$speciales;
    public $numToEdit,$dateToEdit;
    public $abonnementData,$mois=[];
    public $types=['Hospitalisé','Ambulants'];
    public $type_data;
    public $demande_id,$itemMedication;
    public $mtLetter="Aucun",$entete="RELEVE DES DES FACTURES ";
    public $isFinish=false;
    public $consultation_id_edit,$cons_id,$sejour_id;
    public $itemLaboId,$itemRadioId,$itemProduct,$itemIdEcho,
            $itemIdSejour,$itemIdAutres,$itemIdNursing;

    public $newQtLabo,$newQtRadio,$newQtProduct,
            $newQtEcho,$newQtsejour,$newQtAutres,$newQtNursing,$newNameNursing,$nweQtMedication;
    protected $listeners=['facturePeriodeToDeleteListener'=>'destroyFacture'];


    public function show($id){
        $this->demande=DemandeConsultation::select('demande_consultations.*',
            'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom','patient_abonnes.Sexe')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
            ->where('demande_consultations.id',$id)
            ->first();
        //dd($this->demande);

        $this->numToEdit=$this->demande->numero;
        $date = date_create($this->demande->created_at);
        $this->dateToEdit=date_format($date, 'Y-m-d H:i:s');
    }

    public function hospitaliser($id){
        dd($id);
    }

    public function editNumAndDate(){
        $this->demande->numero=$this->numToEdit;
        $this->demande->created_at=$this->dateToEdit;
        $this->demande->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Info bein mis à jour"]);
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
        'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom','patient_abonnes.Sexe')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
        ->where('demande_consultations.id',$id)
        ->first();
    }

    //Marquer la consultation payée
    public function makePaiedCons($id){
        $this->demande->is_valided=true;
        $this->demande->update();
        $this->refresh($id);
        $this->consultation_id_edit=0;
        $this->dispatchBrowserEvent('data-added',['message'=>"Cosultation marquée payée"]);
    }
    public function cancelPaiedCons($id){
        $this->demande->is_valided=false;
        $this->demande->update();
        $this->refresh($id);
        $this->dispatchBrowserEvent('data-added',['message'=>"Cosultation marquée non payée"]);
    }

//Recuperer l'id du type de la consultation
    public function getConsid($id){
        $this->consultation_id_edit=$id;
    }

    public function changeCons($id){
        $this->demande->consultation_id=$this->cons_id;
        $this->demande->update();
        $this->refresh($id);
        $this->consultation_id_edit=0;
        $this->dispatchBrowserEvent('data-added',['message'=>"Cosultation mise à jour"]);
    }
///----------EXAMEN LABO---------
    //Recuperer le id d'un élement des examens labo
    public function getItemIdLabo($id){
        $labo = DB::table('demande_consultation_examen_labo')->where('id',$id)->first();
        $this->itemLaboId=$labo->id;
        $this->newQtLabo=$labo->qty;
    }

//Cahnger la quantité de l'examen lao
    public function changeQtLabo($id,$id_dmd){
        $labo = DB::table('demande_consultation_examen_labo')
              ->where('id', $id)
              ->update(['qty' => $this->newQtLabo]);
        $this->dispatchBrowserEvent('data-added',['message'=>"Quantité labo bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemLaboId=0;
    }
//Retirer l'examen labo
    public function deleteLabo($id,$id_dmd){
        DB::table('demande_consultation_examen_labo')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Examen labo retiré !"]);
    }


//E----------XAMEN RADIO -----------

    public function getItemIdRadio($id){
        $labo = DB::table('demande_consultation_examen_rx')->where('id',$id)->first();
        $this->itemRadioId=$labo->id;
        $this->newQtRadio=$labo->qty;
    }

//Cahnger la quantité de l'examen labp
    public function changeQtRadio($id,$id_dmd){
        $labo = DB::table('demande_consultation_examen_rx')
            ->where('id', $id)
            ->update(['qty' => $this->newQtRadio]);
        $this->dispatchBrowserEvent('data-added',['message'=>"Quantité radio bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemRadioId=0;
    }
//Retirer l'examen labo
    public function deleteRadio($id,$id_dmd){
        DB::table('demande_consultation_examen_rx')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Examen radio retiré !"]);
    }

//-----------PRODUIT DE LA PHARMACIE
    public function getItemIdProduct($id){
        $prod = DB::table('demande_consultation_product')->where('id',$id)->first();
        $this->itemProduct=$prod->id;
        $this->newQtProduct=$prod->qty;
    }

    public function getItemMedication($id){
        $medication = MedicationService::find($id);
        $this->itemMedication=$medication->id;
        $this->nweQtMedication=$medication->qty;
    }

//Cahnger la quantité de l'examen labp
    public function changeQtProduc($id,$id_dmd){
        $labo = DB::table('demande_consultation_product')
            ->where('id', $id)
            ->update(['qty' => $this->newQtProduct]);
        $this->dispatchBrowserEvent('data-added',['message'=>"Quantité produit bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemProduct=0;
    }

    public function changeQtMedication($id,$id_dmd){
        $medication = MedicationService::find($id);
        $medication->qty=$this->nweQtMedication;
        $medication->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Quantité produit bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemMedication=0;
    }
//Retirer l'examen labo
    public function deleteProduct($id,$id_dmd){
        DB::table('demande_consultation_product')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Produit retiré !"]);
    }

    public function deleteMedicatio($id,$id_dmd){
        $medication = MedicationService::find($id);
        $medication->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Produit retiré !"]);
    }
//-----------ECHOGRAPHIE------------
    public function getItemIdEcho($id){
        $labo = DB::table('demande_consultation_echographie')->where('id',$id)->first();
        $this->itemIdEcho=$labo->id;
        $this->newQtEcho=$labo->qty;
    }

    //Cahnger la quantité de l'examen labp
    public function changeQtEcho($id,$id_dmd){
        $labo = DB::table('demande_consultation_echographie')
            ->where('id', $id)
            ->update(['qty' => $this->newQtEcho]);
        $this->dispatchBrowserEvent('data-added',['message'=>"Quantité echo bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemIdEcho=0;
    }
    //Retirer l'examen labo
    public function deleteEcho($id,$id_dmd){
        DB::table('demande_consultation_echographie')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Echo bien retiré !"]);
    }
//-----------SEJOUR ------------------
    public function getItemIdSejour($id){
        $sejour = DB::table('demande_consultation_sejour')->where('id',$id)->first();
        $this->itemIdSejour=$sejour->id;
        $this->newQtsejour=$sejour->qty;
    }
    //Cahnger la quantité de l'examen labp
    public function changeQtSejour($id,$id_dmd){
        if ($this->sejour_id==null) {
            $labo = DB::table('demande_consultation_sejour')
            ->where('id', $id)
            ->update([
                'qty' => $this->newQtsejour
            ]);
        } else {
            $labo = DB::table('demande_consultation_sejour')
            ->where('id', $id)
            ->update([
                'qty' => $this->newQtsejour,
                'sejour_id' => $this->sejour_id
            ]);
        }


        $this->dispatchBrowserEvent('data-added',['message'=>"Quantité sejour bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemIdSejour=0;
    }
    //Retirer l'examen labo
    public function deleteSejour($id,$id_dmd){
        DB::table('demande_consultation_sejour')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Sejour bien retiré !"]);
    }

//-----------AUTRES -----------------
    public function getItemIdAutres($id){
        $autres = DB::table('autre_demande_consultation')->where('id',$id)->first();
        $this->itemIdAutres=$autres->id;
        $this->newQtAutres=$autres->qty;
    }
    //Cahnger la quantité d'autres details
    public function changeQtAutres($id,$id_dmd){
        $labo = DB::table('autre_demande_consultation')
            ->where('id', $id)
            ->update([
                'qty' => $this->newQtAutres
            ]);

        $this->dispatchBrowserEvent('data-added',['message'=>"Autres bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemIdAutres=0;
    }
    //Retirer d'autres
    public function deleteAutres($id,$id_dmd){
        DB::table('autre_demande_consultation')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Autres bien retiré !"]);
    }
//----------- NURSING -----------------
    public function getItemIdNursing($id){
        $nursing = DB::table('nursings')->where('id',$id)->first();
        $this->itemIdNursing=$nursing->id;
        $this->newQtNursing=$nursing->qty;
        $this->newNameNursing=$nursing->name;

    }
    //Cahnger la quantité d'autres details
    public function changeQtNursing($id,$id_dmd){
        $nursing = DB::table('nursings')
            ->where('id', $id)
            ->update([
                'qty' => $this->newQtNursing,
                'name'=>$this->newNameNursing
            ]);
        $this->dispatchBrowserEvent('data-added',['message'=>"Info bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemIdNursing=0;
    }
    //Retirer d'Nursing
    public function deleteNursing($id,$id_dmd){
        DB::table('nursings')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Info bien retiré !"]);
    }
//----------- FIN -----------------

    public function shuwDeleteDialog($id){
        $this->demande_id=$id;
        $this->dispatchBrowserEvent('show-delete-confirmation-facture-periode');
    }

    public function destroyFacture(){
        $facture=DemandeConsultation::find($this->demande_id);
        $facture->examenLabos()->detach();
        $facture->examenRadios()->detach();
        $facture->echographies()->detach();
        $facture->products()->detach();
        $facture->sejours()->detach();
        $facture->autres ()->detach();

        $nursings=Nursing::where('demande_consultation_id',$this->demande_id)->get();
        if ($nursings !=null) {
           foreach ($nursings  as $nursing) {
              $nursing->delete();
           }
        }
        $facture->delete();
        $this->dispatchBrowserEvent('facture-deleted',['message'=>"Facture bien ajouté !"]);
    }

    public function marquerFini($id){
        $this->demande->is_valided=true;
        $this->demande->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Facture marqué finie !"]);
        $this->refresh($id);
    }
    public function annulerMarquerFini($id){
        $this->demande->is_valided=false;
        $this->demande->update();
        $this->dispatchBrowserEvent('data-deleted',['message'=>"Facture marqué finie !"]);
        $this->refresh($id);
    }


    public function mount(){
        $this->abonnements=Abonnement::all();
        $taux=Taux::find(1);
        $this->valeur_taux=2300;
        $this->consultation=Consultation::all();
        $this->sejours=Sejour::all();
    }
    public function render()
    {
        $factures=DemandeConsultation::select('demande_consultations.*',
        'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
        ->where('patient_abonnes.Nom','Like','%'.$this->keySearch.'%')
        ->where('patient_abonnes.abonnement_id',$this->abonnement_data)
        ->whereBetween('demande_consultations.created_at',[$this->searchDateFrom,$this->searchDateTo])
        ->whereYear('demande_consultations.created_at',date('Y'))

        ->orderBy('demande_consultations.numero','ASC')
        ->get();


        $abn=Abonnement::find($this->abonnement_data);
       if ($abn) {
        $speciales=DemandeSpeciale::whereBetween('date_venue',[$this->searchDateFrom,$this->searchDateTo])
        ->where('type',$abn->name)
        ->get();
       } else {
          $speciales=null;
       }


        //dd($speciales);
        return view('livewire.factures.historique.historique-factures-abonnes-periode-component',
            [
                'factures'=>$factures,
                'fac_speciales'=>$speciales
            ]
        );
    }
}
