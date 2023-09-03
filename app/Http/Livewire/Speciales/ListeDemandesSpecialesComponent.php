<?php

namespace App\Http\Livewire\Speciales;

use App\Models\Abonnement;
use App\Models\DemandeSpeciale;
use App\Models\NursingSpecial;
use App\Models\Sejour;
use App\Models\Taux;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ListeDemandesSpecialesComponent extends Component
{
    use WithPagination;
    public $keySearch='',$searchDate,$page_number=50;
    public $demande;
    public $valeur_taux;
    public $mois=[];
    public $currentDate=0;
    public $types=['Hospitalisé','Ambulants'];
    public $type_data;
    public  $sejours;
    public $demandes,$demande_to_edit;
    public $numToEdit,$dateToEdit;
    public $demande_id;
    public $consultations,$itemMedicationPv,$name_patient;

    public $consultation_id_edit,$cons_id,$sejour_id;
    public $itemLaboId,$itemRadioId,$itemProduct,$itemIdEcho,
            $itemIdSejour,$itemIdAutres,$itemIdNursing,$itemActeID;
    public $id_dmd,$myType="Aucune";

    public $newQtLabo,$newQtRadio,$newQtProduct,$newQtEcho,
            $newQtsejour,$newQtAutres,$newQtActe;
    protected $listeners=['factureSpecialToDeleteListener'=>'destroy'];

    public $isReduction=false,$mt_reduction;

    public $name,$type,$date_venue,$abonnements;
    public $currentYear=0;
    public $years=['2021','2022','2023','2024'];


    public function mount(){
        foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }

        $this->abonnements=Abonnement::orderBy('id','desc')->get();
        $this->sejours=Sejour::all();

        $taux=Taux::find(1);
        $this->valeur_taux=$taux->valeur;
        $this->currentDate=date('m');
        $this->currentYear=date('Y');

    }

    public function shuwDeleteDialogSpecial($id){
        $this->id_dmd=$id;
        $this->dispatchBrowserEvent('show-delete-spaciaql');
    }

    public function internate($id){
        $demande=DemandeSpeciale::find($id);
        if ($demande->is_inteneted==true) {
           $demande->is_inteneted=false;
           $demande->update();
           $this->dispatchBrowserEvent('data-added',['message'=>'Hospitalisation annulée !']);
        } else {
            $demande->is_inteneted=true;
            $demande->update();
            $this->dispatchBrowserEvent('data-added',['message'=>'Malade hospitalisé !']);
        }
    }

    public function destroy(){
        $demande=DemandeSpeciale::find($this->id_dmd);
        $demande->actes()->detach();
        $demande->examenLabos()->detach();
        $demande->examenRadios()->detach();
        $demande->echographies()->detach();
        $demande->sejours()->detach();
        $demande->products()->detach();
        $demande->autres()->detach();
        $nursings=NursingSpecial::where('demande_speciale_id',$this->demande_id)->get();
        if ($nursings !=null) {
           foreach ($nursings  as $nursing) {
              $nursing->delete();
           }
        }
        $demande->delete();

        $this->dispatchBrowserEvent('special-deleted');
    }

    public function generateFactureNumber()
    {
        $demande=DemandeSpeciale::whereMonth('created_at',Carbon::now())
        ->whereYear('created_at',$this->currentYear)
        ->get();
        if (Auth::user()->is_to=="Golf") {
            $date = Carbon::now()->locale('fr_FR.utf8');
            $mois= $date->monthName;
            $number=sprintf('%03d',$demande->count()+1);
            $num_fact=$number."/".substr(strtoupper($mois),0,5);
            return $num_fact;
        } else {
            $date = Carbon::now()->locale('fr_FR.utf8');
            $mois= $date->monthName;
            $number=sprintf('%03d',$demande->count()+1);
            $num_fact=$number."/".substr(strtoupper($mois),0,5);
            return $num_fact;
        }
    }
    public function store(){
        $this->validate([
            'name'=>'required|string',
            'type'=>'required|string',
            'date_venue'=>'required|string'
        ]);
        $demande=DemandeSpeciale::create([
            'numero'=>$this->generateFactureNumber(),
            'name'=>$this->name,
            'type'=>$this->type,
            'date_venue'=>$this->date_venue,
                'created_by'=>Auth::user()->id
        ]);
        $this->dispatchBrowserEvent('data-added',['message'=>'Demande bien ajouté']);
    }

    public function show($id){
        $this->demande=DemandeSpeciale::where('demande_speciales.id',$id)
            ->first();
        $this->numToEdit=$this->demande->numero;
        $this->name_patient=$this->demande->name;
        $date = date_create($this->demande->created_at);
        $this->dateToEdit=date_format($date, 'Y-m-d H:i:s');
        if ($this->demande->rate !=null) {
            $this->valeur_taux=$this->demande->rate->reate;
        }else{
            $this->valeur_taux=2000;
        }
    }


    public function editNumAndDate(){
        $this->demande->numero=$this->numToEdit;
        $this->demande->created_at=$this->dateToEdit;
        $this->demande->date_venue=$this->dateToEdit;
        $this->demande->name=$this->name_patient;
        $this->demande->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Info bein mis à jour"]);
    }

    public function getByDate(){
        $this->currentDate=$this->searchDate;
    }


    public function getCurrentDate(){

        $this->currentDate=date('Y-m-d');
    }

    //Rafrechir le modal et toules données
    public function refresh($id){
        $this->demande=DemandeSpeciale::where('demande_speciales.id',$id)
        ->first();
    }
    //ATCES

    //----------EXAMEN LABO---------
    //Recuperer le id d'un élement des examens labo
    public function getItemIdActe($id){
        $acte = DB::table('acte_medical_demande_speciale')->where('id',$id)->first();
        $this->itemActeID=$acte->id;
        $this->newQtActe=$acte->qty;
    }

//Cahnger la quantité de l'examen lao
    public function changeQtActe($id,$id_dmd){
        $acte = DB::table('acte_medical_demande_speciale')
              ->where('id', $id)
              ->update(['qty' => $this->newQtActe]);
        $this->dispatchBrowserEvent('data-added',['message'=>"Quantité acte bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemActeID=0;
    }
//Retirer l'examen acte
    public function deleteActe($id,$id_dmd){
        DB::table('acte_medical_demande_speciale')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Examen acte retiré !"]);
    }


///----------EXAMEN LABO---------
    //Recuperer le id d'un élement des examens labo
    public function getItemIdLabo($id){
        $labo = DB::table('demande_speciale_examen_labo')->where('id',$id)->first();
        $this->itemLaboId=$labo->id;
        $this->newQtLabo=$labo->qty;
    }

//Cahnger la quantité de l'examen lao
    public function changeQtLabo($id,$id_dmd){
        $labo = DB::table('demande_speciale_examen_labo')
              ->where('id', $id)
              ->update(['qty' => $this->newQtLabo]);
        $this->dispatchBrowserEvent('data-added',['message'=>"Quantité labo bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemLaboId=0;
    }
//Retirer l'examen labo
    public function deleteLabo($id,$id_dmd){
        DB::table('demande_speciale_examen_labo')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Examen labo retiré !"]);
    }

//E----------XAMEN RADIO -----------

    public function getItemIdRadio($id){
        $labo = DB::table('demande_speciale_examen_rx')->where('id',$id)->first();
        $this->itemRadioId=$labo->id;
        $this->newQtRadio=$labo->qty;
    }

//Cahnger la quantité de l'examen labp
    public function changeQtRadio($id,$id_dmd){
        $labo = DB::table('demande_speciale_examen_rx')
            ->where('id', $id)
            ->update(['qty' => $this->newQtRadio]);
        $this->dispatchBrowserEvent('data-added',['message'=>"Quantité radio bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemRadioId=0;
    }
//Retirer l'examen labo
    public function deleteRadio($id,$id_dmd){
        DB::table('demande_speciale_examen_rx')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Examen radio retiré !"]);
    }

//-----------PRODUIT DE LA PHARMACIE
    public function getItemIdProduct($id){
        $prod = DB::table('demande_speciale_product')->where('id',$id)->first();
        $this->itemProduct=$prod->id;
        $this->newQtProduct=$prod->qty;
    }



//Cahnger la quantité de l'examen labp
    public function changeQtProduc($id,$id_dmd){
        $labo = DB::table('demande_speciale_product')
            ->where('id', $id)
            ->update(['qty' => $this->newQtProduct]);
        $this->dispatchBrowserEvent('data-added',['message'=>"Quantité produit bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemProduct=0;
    }

    public function deleteProduct($id,$id_dmd){
        DB::table('demande_speciale_product')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Produit retiré !"]);
    }



    //Cahnger la quantité de l'examen labp
    public function getItemIdEcho($id){
        $labo = DB::table('demande_speciale_echographie')->where('id',$id)->first();
        $this->itemIdEcho=$labo->id;
        $this->newQtEcho=$labo->qty;
    }
    public function changeQtEcho($id,$id_dmd){
        $labo = DB::table('demande_speciale_echographie')
            ->where('id', $id)
            ->update(['qty' => $this->newQtEcho]);
        $this->dispatchBrowserEvent('data-added',['message'=>"Quantité echo bien changé !"]);
        $this->refresh($id_dmd);
        $this->itemIdEcho=0;
    }
    //Retirer l'examen labo
    public function deleteEcho($id,$id_dmd){
        DB::table('demande_speciale_echographie')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Echo bien retiré !"]);
    }
//-----------SEJOUR ------------------updat
    public function getItemIdSejour($id){
        $sejour = DB::table('demande_speciale_sejour')->where('id',$id)->first();
        $this->itemIdSejour=$sejour->id;
        $this->newQtsejour=$sejour->qty;
    }
    //Cahnger la quantité de l'examen labp
    public function changeQtSejour($id,$id_dmd){
        if ($this->sejour_id==null) {
            $labo = DB::table('demande_speciale_sejour')
            ->where('id', $id)
            ->update([
                'qty' => $this->newQtsejour
            ]);
        } else {
            $labo = DB::table('demande_speciale_sejour')
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
        DB::table('demande_speciale_sejour')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Sejour bien retiré !"]);
    }

//-----------AUTRES -----------------
    public function getItemIdAutres($id){
        $autres = DB::table('autre_demande_speciale')->where('id',$id)->first();
        $this->itemIdAutres=$autres->id;
        $this->newQtAutres=$autres->qty;
    }
    //Cahnger la quantité d'autres details
    public function changeQtAutres($id,$id_dmd){
        $labo = DB::table('autre_demande_speciale')
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
        DB::table('autre_demande_speciale')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Autres bien retiré !"]);
    }
//----------- NURSING -----------------
    public function getItemIdNursing($id){
        $nursing = DB::table('nursing_specials')->where('id',$id)->first();
        $this->itemIdNursing=$nursing->id;
        $this->newQtNursing=$nursing->qty;
        $this->newNameNursing=$nursing->name;

    }
    //Cahnger la quantité d'autres details
    public function changeQtNursing($id,$id_dmd){
        $nursing = DB::table('nursing_specials')
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
        DB::table('nursing_specials')->where('id',$id)->delete();
        $this->refresh($id_dmd);
        $this->dispatchBrowserEvent('data-added',['message'=>"Info bien retiré !"]);
    }
//----------- FIN -----------------

    public function shuwDeleteDialog($id){
        $this->demande_id=$id;
        $this->dispatchBrowserEvent('show-delete-confirmation-facture');
    }

    public function destroyFacture(){
        $facture=DemandeSpeciale::find($this->demande_id);
        $facture->examenLabos()->detach();
        $facture->examenRadios()->detach();
        $facture->echographies()->detach();
        $facture->products()->detach();
        $facture->sejours()->detach();
        $facture->autres ()->detach();

        $nursings=NursingSpecial::where('demande_consultation_id',$this->demande_id)->get();
        if ($nursings !=null) {
           foreach ($nursings  as $nursing) {
              $nursing->delete();
           }
        }
        $facture->delete();
        $this->dispatchBrowserEvent('facture-deleted',['message'=>"Facture bien ajouté !"]);
    }
    public function render()
    {
        return view('livewire.speciales.liste-demandes-speciales-component',[
            'factures'=>DemandeSpeciale::whereMonth('created_at',$this->currentDate)
                        ->where('name','Like','%'.$this->keySearch.'%')
                        ->where('type',$this->myType)
                        ->whereYear('created_at',$this->currentYear)
                        ->orderBy('numero','ASC')
                        ->get()
        ]);
    }
}
