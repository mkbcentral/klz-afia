<?php

namespace App\Http\Livewire\Patients\Abonnes;

use App\Models\Abonnement;
use App\Models\AnotherDemande;
use App\Models\Consultation;
use App\Models\DemandeConsultation;
use App\Models\Fiche;
use App\Models\PatientAbonne;
use App\Models\Rate;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PatientsAbonnesComponent extends Component
{

    use WithPagination;

    protected $listeners=['patientDeletedListener'=>'destroy'];

    public $nom,$postnom,$prenom,$sexe,$date_naisssance,$telephone='(+243)',$autre_tel='(+243)',
            $commune,$quartier='Aucun',$avenue='Aucune',$numero=0,$matricule,
            $date_venue,$type,$demande_id,$abonnement_id;

    public $abonnements,$consultations;
    public $keySearch='',$page_number=250;
    public $patient_data,$patient_data_to_edit,$patient_data_abonne_to_update_deep;
    public $fiche_to_update,$abonnement_id_to_change;
    public $id_patient_to_delete=null;


    protected $rules = [
        "nom"=>"required",
        "postnom"=>"required",
        "prenom"=>"nullable|string",
        "sexe"=>"required",
        "date_naisssance"=>"date",
        "telephone"=>"nullable",
        "autre_tel"=>"nullable",
        "commune"=>"required",
        "quartier"=>"min:3",
        "avenue"=>"min:3|",
        "numero"=>"numeric",
        "type"=>"required",
        "date_venue"=>"date",
        "abonnement_id"=>"numeric"
    ];

    public function updatingkeySearch(){
        $this->resetPage();
    }

    public function generateFicheNumber(){
        if(Auth::user()->is_to=="Ville") {
            $myDate=new DateTime();
            $fiche=Fiche::where('source',Auth::user()->is_to);
            $number=sprintf('%05d',$fiche->count()+1);
            return "$number/".$myDate->format('Y')."/AB-V";
        } else {
            $myDate=new DateTime();
            $fiche=Fiche::where('source',Auth::user()->is_to);
            $number=sprintf('%05d',$fiche->count()+1);
            return "$number/".$myDate->format('Y');
        }
    }

    public function generateFactureNumber($abonnement_name)
    {
        $demande=DemandeConsultation::select('demande_consultations.*')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
        ->join('abonnements','patient_abonnes.abonnement_id','=','abonnements.id')
        ->whereMonth('demande_consultations.created_at',date('m'))
        ->where('abonnements.name',$abonnement_name)
        ->whereYear('demande_consultations.created_at',date('Y'))
        ->where('fiches.type','Abonne')
        ->get();

        $date = Carbon::now()->locale('fr_FR.utf8');
        $mois= $date->monthName;
        $number=sprintf('%03d',$demande->count()+1);
        $num_fact=$number."/".substr(strtoupper($mois),0,5)."/".$abonnement_name;
        return $num_fact;
    }

    public function store()
    {
        $this->validate();
        try {
            $patient_check=PatientAbonne::where('Nom',$this->nom)
                    ->where('Postnom',$this->postnom)
                    ->where('DateNaissance',$this->date_naisssance)
                    ->first();
            if ($patient_check) {
            $this->dispatchBrowserEvent('data-add-faild',['message'=>'Ce patient est déjà enregistré !']);
            } else {
                $fiche=Fiche::create([
                    'numero'=>$this->generateFicheNumber(),
                    'type'=>"Abonné",
                    'source'=>Auth::user()->is_to
                ]);
                $patient=PatientAbonne::create(
                    [
                        'Nom'=>$this->nom,
                        'Postnom'=>$this->postnom,
                        'Prenom'=>$this->prenom,
                        'Sexe'=>$this->sexe,
                        'DateNaissance'=>$this->date_naisssance,
                        'Telephone'=>$this->telephone,
                        'AutreTelephone'=>$this->autre_tel,
                        'Commune'=>$this->commune,
                        'Quartier'=>$this->quartier,
                        'Avenue'=>$this->avenue,
                        'Numero'=>$this->numero,
                        'Type'=>$this->type,
                        'Matricule'=>$this->matricule,
                        'abonnement_id'=>$this->abonnement_id,
                        'fiche_id'=>$fiche->id,
                        'date_venu'=>$this->date_venue,
                        'created_by'=>Auth::user()->id
                    ]
                );
                $abonnement=Abonnement::find($this->abonnement_id);

               if ($this->date_venue==date('d-m-Y')) {
                $dmd=DemandeConsultation::create([
                    'numero'=>$this->generateFactureNumber($abonnement->name),
                    'fiche_id'=>$fiche->id,
                    'consultation_id'=>$this->demande_id,
                    'created_by'=>Auth::user()->id,
                    'source'=>Auth::user()->is_to
                ]);
                $rate=Rate::where('is_active',true)->first();
                $dmd->rate_id=$rate->id;
                $dmd->update();
               } else {
                $dmd=DemandeConsultation::create([
                    'numero'=>$this->generateFactureNumber($abonnement->name),
                    'fiche_id'=>$fiche->id,
                    'consultation_id'=>$this->demande_id,
                    'created_by'=>Auth::user()->id,
                    'source'=>Auth::user()->is_to,
                    'created_at'=>$this->date_venue
                ]);
                $rate=Rate::where('is_active',true)->first();
                $dmd->rate_id=$rate->id;
                $dmd->update();
               }

                $this->dispatchBrowserEvent('data-added',['message'=>"Patient ajouté avec succès ! !"]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            $fiche->delete();
            if ($ex->getCode()=="22007") {
                session()->flash('error_msg',"Vérifier le format de la date SVP!");
            }
            if ($ex->getCode()=="23000") {
                session()->flash('error_msg',$ex->getMessage());
            }
        }
    }

    public function show($id){
        $p=PatientAbonne::find($id);
        $this->patient_data=$p;
    }

    public function demanderCons(){
        try {

            if ($this->demande_id==null) {
                session()->flash('problem',"Veuillez choisir le type de la demande SVP! !");
            } else {
                $demande=DemandeConsultation::whereMonth('created_at',Carbon::now())
                ->whereYear('created_at',date('Y'))
                ->where('fiche_id',$this->patient_data->fiche->id)
                ->where('source',Auth::user()->is_to)
                ->first();
              if ($demande) {
                    AnotherDemande::create([
                        'demande_consultation_id'=>$demande->id
                    ]);
                    $this->dispatchBrowserEvent('data-added',['message'=>'Ce malade était déjà au courant de ce mois, sa demande sera archivée, Merci  !']);
              } else {
                $dmd=DemandeConsultation::create([
                    'numero'=>$this->generateFactureNumber($this->patient_data->abonnement->name),
                    'fiche_id'=>$this->patient_data->fiche->id,
                    'consultation_id'=>$this->demande_id,
                    'created_by'=>Auth::user()->id,
                    'source'=>Auth::user()->is_to
                    ]);
                    $rate=Rate::where('is_active',true)->first();
                    $dmd->rate_id=$rate->id;
                    $dmd->update();
                    $this->dispatchBrowserEvent('data-added',['message'=>'Demande de consultation validée avec succès ! !']);
              }

            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                $this->dispatchBrowserEvent('data-deleted',['message'=>"Le numero de la facture ".$this->patient_data->fiche->numero." existe dejà !"]);
            }
        }




    }

    public function edit($id){
        $p=PatientAbonne::find($id);
        $this->patient_data_to_edit=$p;

        $this->nom=$this->patient_data_to_edit->Nom;
        $this->postnom=$this->patient_data_to_edit->Postnom;
        $this->prenom=$this->patient_data_to_edit->Prenom;
        $this->sexe=$this->patient_data_to_edit->Sexe;
        $this->date_naisssance=$this->patient_data_to_edit->DateNaissance;
        $this->telephone=$this->patient_data_to_edit->Telephone;
        $this->autre_tel=$this->patient_data_to_edit->AutreTelephone;
        $this->commune=$this->patient_data_to_edit->Commune;
        $this->quartier=$this->patient_data_to_edit->Quartier;
        $this->avenue=$this->patient_data_to_edit->Avenue;
        $this->numero=$this->patient_data_to_edit->Numero;
        $this->type=$this->patient_data_to_edit->Type;
        $this->matricule=$this->patient_data_to_edit->Matricule;
    }

    public function update(){
        $this->patient_data_to_edit->Nom=$this->nom;
        $this->patient_data_to_edit->Postnom=$this->postnom;
        $this->patient_data_to_edit->Prenom=$this->prenom;
        $this->patient_data_to_edit->Sexe=$this->sexe;
        $this->patient_data_to_edit->DateNaissance=$this->date_naisssance;
        $this->patient_data_to_edit->Telephone=$this->telephone;
        $this->patient_data_to_edit->AutreTelephone=$this->autre_tel;
        $this->patient_data_to_edit->Commune= $this->commune;
        $this->patient_data_to_edit->Quartier=$this->quartier;
        $this->patient_data_to_edit->Avenue=$this->avenue;
        $this->patient_data_to_edit->Numero=$this->numero;
        $this->patient_data_to_edit->Type=$this->type;
        $this->patient_data_to_edit->Matricule=$this->matricule;

        $this->patient_data_to_edit->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Patient bien mis à jour !"]);
    }

    public function showDestroy($id){
        $this->id_patient_to_delete=$id;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function destroy(){
        $patient_abonne=PatientAbonne::find($this->id_patient_to_delete);
        $fiche=Fiche::find($patient_abonne->fiche_id);
        $demande=DemandeConsultation::where('fiche_id',$fiche->id)->first();
        if ($demande !=null) {
            $demande->delete();
        }
        if ($patient_abonne != null) {
            $patient_abonne->delete();
        }
        if ($fiche != null) {
            $fiche->delete();
        }
        $this->dispatchBrowserEvent('data-deleted',['message'=>"Patient retiré du système !"]);
    }

    public function getData($id){
        $p=PatientAbonne::find($id);
        $this->fiche_to_update=$p->fiche->numero;
        $this->patient_data_abonne_to_update_deep=$p;
    }

    public function updateFicheNumber(){
        try {
            $fiche=Fiche::find($this->patient_data_abonne_to_update_deep->fiche_id);
            $fiche->numero=$this->fiche_to_update;
            $fiche->update();
            $this->dispatchBrowserEvent('data-updated',['message'=>"Numero mis à jour !"]);
        } catch (\Illuminate\Database\QueryException $ex) {
            if ($ex->getCode()=="22007") {
                session()->flash('error_msg',"Vérifier le format de la date SVP!");
            }
            if ($ex->getCode()=="23000") {
                session()->flash('error_msg',$ex->getMessage());
            }
        }
    }

    public function updateSociety(){
        try {
            $this->patient_data_abonne_to_update_deep->abonnement_id=$this->abonnement_id_to_change;
        $this->patient_data_abonne_to_update_deep->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Societé bien mise à jour ! !"]);
        } catch (\Illuminate\Database\QueryException $ex) {
            if ($ex->getCode()=="22007") {
                session()->flash('error_msg',"Vérifier le format de la date SVP!");
            }
            if ($ex->getCode()=="23000") {
                session()->flash('error_msg',$ex->getMessage());
            }
        }

    }

    public function mount (){
        $this->abonnements=Abonnement::all();
        $this->consultations=Consultation::all();
    }

    public function render()
    {
        return view('livewire.patients.abonnes.patients-abonnes-component',[
            'patients'=>PatientAbonne::where('Nom','Like','%'.$this->keySearch.'%')
                ->orderBy('patient_abonnes.created_at','DESC')
                ->join('fiches','patient_abonnes.fiche_id','=','fiches.id')
                ->where('fiches.source',Auth::user()->is_to)
                ->select('patient_abonnes.*')
                ->get()
        ]);
    }
}
