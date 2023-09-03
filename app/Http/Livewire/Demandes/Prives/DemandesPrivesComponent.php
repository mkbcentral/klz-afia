<?php

namespace App\Http\Livewire\Demandes\Prives;

use App\Models\Abonnement;
use App\Models\Consultation;
use App\Models\DemandeConsultation;
use App\Models\LaboResult;
use App\Models\MedicationService;
use App\Models\Sejour;
use App\Models\SigneDemande;
use App\Models\signeVito;
use App\Models\Taux;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DemandesPrivesComponent extends Component
{
    use WithPagination;
    public $keySearch='',$searchDate,$page_number=200;
    public $demande;
    public $valeur_taux;
    public $mois=[];
    public $currentDate;
    public $types=['Hospitalisé','Ambulants'];
    public $type_data;
    public  $sejours;
    public $demandes,$demande_to_edit;
    public $numToEdit,$dateToEdit;
    public $demande_id;
    public $consultations,$itemMedicationPv;
    public $consultation_id_edit,$cons_id,$sejour_id;
    public $itemLaboId,$itemRadioId,$itemProduct,$itemIdEcho,
            $itemIdSejour,$itemIdAutres,$itemIdNursing;
    public $newQtLabo,$newQtRadio,$newQtProduct,$newQtEcho,
            $newQtsejour,$newQtAutres,$newQtNursing,$nweQtMedication;
    public $poids,$temperature,$taille,$tension;
    public $demade_select,$idLaboSelect, $result,$result_edit;
    protected $listeners=['factureAbnToDeleteListener'=>'destroyFactureAbn'];
    public $currentYear;
    public $years=['2021','2022','2023','2024'];

    public $defaultDate;

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

    public function edit($id){
        $this->demande_to_edit=DemandeConsultation::select('demande_consultations.*',
            'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom','patient_prives.Sexe')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
            ->where('demande_consultations.id',$id)
            ->first();

            $this->numToEdit=$this->demande_to_edit->numero;
            $date = date_create($this->demande_to_edit->created_at);
            $this->dateToEdit=date_format($date, 'Y-m-d H:i:s');
    }

    public function editNumAndDatePv(){
        $this->demande_to_edit->numero=$this->numToEdit;
        $this->demande_to_edit->created_at=$this->dateToEdit;
        $this->demande_to_edit->update();
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
        'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom','patient_prives.Sexe')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
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

    //Cahnger la quantité de l'examen labp
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
        $labo = DB::table('demande_consultation_product')->where('id',$id)->first();
        $this->itemProduct=$labo->id;
        $this->newQtProduct=$labo->qty;
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
    //Retirer l'examen labo
    public function deleteProduct($id,$id_dmd){
        DB::table('demande_consultation_product')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Produit retiré !"]);
    }

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

    }
    //Cahnger la quantité d'autres details
    public function changeQtNursing($id,$id_dmd){
        $nursing = DB::table('nursings')
            ->where('id', $id)
            ->update([
                'qty' => $this->newQtNursing
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


    public function getInfos($id){
        $this->demade_select=DemandeConsultation::select('demande_consultations.*',
        'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
        ->where('demande_consultations.id',$id)
        ->first();
        $this->idLaboSelect=$this->demade_select->id;
    }

    public function activeWriter($id){
        $this->idLaboSelect=$id;
    }

    public function saveResult($id){
        $result=new LaboResult();
        $result->name=$this->result;
        $result->demande_consultation_id =$this->demade_select->id;
        $result->examen_labo_id =$id;
        $result->save();
        $this->dispatchBrowserEvent('data-added',['message'=>"Info bien ajoutées !"]);
        $this->idLaboSelect=0;

    }

    public function editResult($id){
        $this->idLaboSelect=$id;
        $result=LaboResult::where('examen_labo_id',$id)
                            ->first();
        $this->result=$result->name;
        $this->idLaboSelect=$id;
        $this->result_edit=$result;
    }

    public function updateResult(){
        $this->result_edit->name=$this->result;
        $this->result_edit->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Info bien mise à jour !"]);
        $this->idLaboSelect=0;

    }

    public function addSigneVitaux(){
        $this->validate([
            'poids'=>'required',
            'temperature'=>'required',
            'taille'=>'required',
            'tension'=>'required',
        ]);

        SigneDemande::create([
            'poids'=>$this->poids,
            'temperature'=>$this->temperature,
            'taille'=>$this->taille,
            'tension'=>$this->tension,
            'demande_consultation_id'=>$this->demade_select->id
        ]);
        $this->dispatchBrowserEvent('data-added',['message'=>"Info bien ajoutées !"]);
    }

    public function mount(){
        $taux=Taux::find(1);
        $this->valeur_taux=$taux->valeur;
        $this->currentDate=date('m');
        $this->currentYear=date('Y');
        $this->societes=Abonnement::all();
        $this->consultations=Consultation::all();
        $this->currentDate=date('m');
        $this->sejours=Sejour::all();
        foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }

    }

    public function hospitaliser($id){
        $demande=DemandeConsultation::find($id);
        $demande->is_inteneted=true;
        $demande->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Patient hopitalisé !"]);
    }
    public function unhospitaliser($id){
        $demande=DemandeConsultation::find($id);
        $demande->is_inteneted=false;
        $demande->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Hospitalisation annulée !"]);
    }
    public function completed($id){
        $demande=DemandeConsultation::find($id);
        $demande->is_completed=true;
        $demande->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Patient marqué completé !"]);
    }
    public function render()
    {
        $data=DemandeConsultation::select('demande_consultations.*',
        'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
        ->whereMonth('demande_consultations.created_at',$this->currentDate)
        ->where('patient_prives.Nom','Like','%'.$this->keySearch.'%')
        ->orderBy('demande_consultations.created_at','ASC')
        ->whereYear('demande_consultations.created_at',$this->currentYear)
        ->paginate($this->page_number);

    if ($this->type_data=="Tous") {
        $data=DemandeConsultation::select('demande_consultations.*',
        'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
        ->whereYear('demande_consultations.created_at',date('Y'))
        ->whereMonth('demande_consultations.created_at',$this->currentDate)
        ->where('patient_prives.Nom','Like','%'.$this->keySearch.'%')
        ->whereYear('demande_consultations.created_at',$this->currentYear)
        ->orderBy('demande_consultations.created_at','ASC')
        ->paginate($this->page_number);
    }
    elseif($this->type_data=="Hospitalisé") {
        $data= DemandeConsultation::select('demande_consultations.*',
        'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
        ->whereMonth('demande_consultations.created_at',$this->currentDate)
        ->where('patient_prives.Nom','Like','%'.$this->keySearch.'%')
        ->orderBy('demande_consultations.created_at','ASC')
        ->where('demande_consultations.is_inteneted',true)
        ->whereYear('demande_consultations.created_at',$this->currentYear)
        ->paginate($this->page_number);
    }
    elseif($this->type_data=="Ambulants") {
        $data= DemandeConsultation::select('demande_consultations.*',
        'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
        ->whereMonth('demande_consultations.created_at',$this->currentDate)
        ->where('patient_prives.Nom','Like','%'.$this->keySearch.'%')
        ->orderBy('demande_consultations.created_at','ASC')
        ->whereYear('demande_consultations.created_at',$this->currentYear)
        ->where('demande_consultations.is_inteneted',false)
        ->paginate($this->page_number);
    }
        return view('livewire.demandes.prives.demandes-prives-component',['factures'=>$data]);
    }
}
