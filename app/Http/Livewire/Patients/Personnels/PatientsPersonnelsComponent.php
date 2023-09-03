<?php

namespace App\Http\Livewire\Patients\Personnels;

use App\Models\Consultation;
use App\Models\DemandeConsultation;
use App\Models\Fiche;
use App\Models\PatientAyantDroit;
use App\Models\Service;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PatientsPersonnelsComponent extends Component
{
    use WithPagination;

    protected $listeners=['patientPersonnelDeletedListener'=>'destroy'];

    public $nom,$postnom,$prenom,$date_venu,$sexe,$dateNaissance,$telephone="(+243)",$type_agent,
            $autreTelephone="(+243)",$commune,$quartier="Inconnue",$avenue="Incoonnue",
            $numero="0",$serviceId,$demande_id;

    public $keySearch='',$page_number=20;
    public $services;
    public $patient_data,$patient_data_to_edit,$patient_data_personnel_to_update_deep;
    public $fiche_to_update;
    public $id_patient_to_delete=null,$consultations;

    protected $rules=[
        "nom"=>"required",
        "postnom"=>"required",
        "prenom"=>"required|nullable",
        "sexe"=>"required",
        "dateNaissance"=>"date",
        "sexe"=>"required",
        "telephone"=>"nullable",
        "autreTelephone"=>"nullable",
        "commune"=>"min:5|nullable",
        "quartier"=>"min:3",
        "avenue"=>"min:3|nullable",
        "numero"=>"numeric|nullable",
        "type_agent"=>"required",
        'date_venu'=>"date"
    ];

    public function genarateFicheNumber(){
        if(Auth::user()->is_to=="Ville") {
            $myDate=new DateTime();
            $fiche=Fiche::where('source',Auth::user()->is_to);
            $number=sprintf('%05d',$fiche->count()+1);
            return "$number+1/".$myDate->format('Y')."/AG-V";
        } else {
            $myDate=new DateTime();
            $fiche=Fiche::where('source',Auth::user()->is_to);
            $number=sprintf('%05d',$fiche->count()+1);
            return "$number/".$myDate->format('Y');
        }
    }

    public function generateFactureNumber()
    {
        if (Auth::user()->is_to=="Golf") {
            $demande=DemandeConsultation::select('demande_consultations.*')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->whereMonth('demande_consultations.created_at',date('m'))
            ->where('fiches.type','Personnel')
            ->where('demande_consultations.source',Auth::user()->is_to)
            ->get();

            $date = Carbon::now()->locale('fr_FR.utf8');
            $mois= $date->monthName;
            $number=sprintf('%03d',$demande->count()+1);
            $num_fact=$number."/".substr(strtoupper($mois),0,5)."/G-SHUKRA-PRSNL";
            return $num_fact;
        } else {
            $demande=DemandeConsultation::select('demande_consultations.*')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->whereMonth('demande_consultations.created_at',date('m'))
            ->where('fiches.type','Personnel')
            ->where('demande_consultations.source',Auth::user()->is_to)
            ->get();

            $date = Carbon::now()->locale('fr_FR.utf8');
            $mois= $date->monthName;
            $number=sprintf('%03d',+1+1);
            $num_fact=$number."/".substr(strtoupper($mois),0,5)."/V-SHUKRA--PRSNL";
            return $num_fact;
        }
    }

    public function store(){
        $this->validate();
        try {
            $patient_check=PatientAyantDroit::where('Nom',$this->nom)
                    ->where('Postnom',$this->postnom)
                    ->where('DateNaissance',$this->dateNaissance)
                    ->first();
            if ($patient_check) {
            $this->dispatchBrowserEvent('patient-faild-added',['message'=>'Ce patient est déjà enregistré !']);
            } else {
            $fiche=Fiche::create([
            'numero'=>$this->genarateFicheNumber(),
            'type'=>"Personnel",
            'source'=>Auth::user()->is_to
            ]);

            $patient=PatientAyantDroit::create(
            [
                'Nom'=>$this->nom,
                'Postnom'=>$this->postnom,
                'Prenom'=>$this->prenom,
                'Sexe'=>$this->sexe,
                'DateNaissance'=>$this->dateNaissance,
                'Telephone'=>$this->telephone,
                'AutreTelephone'=>$this->autreTelephone,
                'Commune'=>$this->commune,
                'Quartier'=>$this->quartier,
                'Avenue'=>$this->avenue,
                'Numero'=>$this->numero,
                'service_id'=>$this->serviceId,
                'Type'=>$this->type_agent,
                'fiche_id'=>$fiche->id,
                'date_venu'=>$this->date_venu,
                'created_by'=>Auth::user()->id
            ]
            );
            DemandeConsultation::create([
                'numero'=>$this->generateFactureNumber(),
                'fiche_id'=>$fiche->id,
                'consultation_id'=>$this->demande_id,
                'created_by'=>Auth::user()->id,
                'source'=>Auth::user()->is_to
            ]);
            $this->dispatchBrowserEvent('data-added',['message'=>"Patient ajouté avec succès ! !"]);
            }

        } catch (\Illuminate\Database\QueryException $ex) {
            //$fiche->delete();
            if ($ex->getCode()=="22007") {
                session()->flash('error_msg',"Vérifier le format de la date SVP!");
            }
            if ($ex->getCode()=="23000") {
                session()->flash('error_msg',$ex->getMessage());
            }if ($ex->getCode()=="42S22") {
                session()->flash('error_msg',$ex->getMessage());
            }
        }
    }

    public function show($id){
        $p=PatientAyantDroit::find($id);
        $this->patient_data=$p;
    }

    public function demanderCons(){
        try {
            $demande=DemandeConsultation::whereDate('created_at',Carbon::now())
                ->where('fiche_id',$this->patient_data->fiche->id)
                ->where('source',Auth::user()->is_to)
                ->first();
            if ($this->demande_id==null) {
                session()->flash('problem',"Veuillez choisir le type de la demande SVP! !");
            } else {
                if ($demande) {
                    $this->dispatchBrowserEvent('data-add-faild',['message'=>"Ce patient a déjà une demande pour aujourd'hui !"]);
                } else {
                    DemandeConsultation::create([
                    'numero'=>$this->generateFactureNumber(),
                    'fiche_id'=>$this->patient_data->fiche->id,
                    'consultation_id'=>$this->demande_id,
                    'created_by'=>Auth::user()->id,
                    'source'=>Auth::user()->is_to
                    ]);
                    $this->dispatchBrowserEvent('data-added',['message'=>'Demande de consultation validée avec succès ! !']);
                }
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                $this->dispatchBrowserEvent('cons-faild-valided-exp',['message'=>"Le numero de la facture ".$this->patient_data->fiche->numero." existe dejà !"]);
            }
        }
    }


    public function edit($id){

        $p=PatientAyantDroit::find($id);
        $this->patient_data_to_edit=$p;

        $this->nom=$this->patient_data_to_edit->Nom;
        $this->postnom=$this->patient_data_to_edit->Postnom;
        $this->prenom=$this->patient_data_to_edit->Prenom;
        $this->sexe=$this->patient_data_to_edit->Sexe;
        $this->dateNaissance=$this->patient_data_to_edit->DateNaissance;
        $this->telephone=$this->patient_data_to_edit->Telephone;
        $this->autre_tel=$this->patient_data_to_edit->AutreTelephone;
        $this->commune=$this->patient_data_to_edit->Commune;
        $this->quartier=$this->patient_data_to_edit->Quartier;
        $this->avenue=$this->patient_data_to_edit->Avenue;
        $this->numero=$this->patient_data_to_edit->Numero;
        $this->serviceId=$this->patient_data_to_edit->service_id;
        $this->type_agent=$this->patient_data_to_edit->Type;
    }

    public function update()
    {
        try {
            $this->patient_data_to_edit->Nom=$this->nom;
            $this->patient_data_to_edit->Postnom=$this->postnom;
            $this->patient_data_to_edit->Prenom=$this->prenom;
            $this->patient_data_to_edit->Sexe=$this->sexe;
            $this->patient_data_to_edit->DateNaissance=$this->dateNaissance;
            $this->patient_data_to_edit->Telephone=$this->telephone;
            $this->patient_data_to_edit->AutreTelephone=$this->autreTelephone;
            $this->patient_data_to_edit->Commune= $this->commune;
            $this->patient_data_to_edit->Quartier=$this->quartier;
            $this->patient_data_to_edit->Avenue=$this->avenue;
            $this->patient_data_to_edit->Numero=$this->numero;
            $this->patient_data_to_edit->Type=$this->type_agent;
            $this->patient_data_to_edit->service_id=$this->serviceId;
            $this->patient_data_to_edit->update();
            $this->dispatchBrowserEvent('data-updated',['message'=>"Patient bien mis à jour !"]);

        } catch (\Illuminate\Database\QueryException $ex) {
            if ($ex->getCode()=="22007") {
                session()->flash('error_msg',"Vérifier le format de la date SVP!");
            }
            if ($ex->getCode()=="23000") {
                session()->flash('error_msg',$ex->getMessage());
            }
        }
    }

    public function showDestroy($id){
        $this->id_patient_to_delete=$id;
        $this->dispatchBrowserEvent('show-delete-patient-personnel');
    }

    public function destroy(){


        $patient_abonne=PatientAyantDroit::find($this->id_patient_to_delete);
        $fiche=Fiche::find($patient_abonne->fiche_id);
        $demande=DemandeConsultation::where('fiche_id',$fiche->id)->get();
        if ($demande !=null) {
            foreach ($demande as $dmd) {
                $dmd->delete();
            }
        }
        if ($patient_abonne != null) {
            $patient_abonne->delete();
        }
        if ($fiche != null) {
            $fiche->delete();
        }
        $this->dispatchBrowserEvent('data-deleted',['message'=>"Patient retiré du système !"]);
        //session()->flash('message','Patient retiré du système !');

    }

    public function getData($id){
        $p=PatientAyantDroit::find($id);
        $this->fiche_to_update=$p->fiche->numero;
        $this->patient_data_personnel_to_update_deep=$p;
    }
    public function updateFicheNumber(){
        try {
            $fiche=Fiche::find($this->patient_data_personnel_to_update_deep->fiche_id);
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
    public function mount(){
        $this->services=Service::all();
        $this->consultations=Consultation::all();
    }
    public function render()
    {
        return view('livewire.patients.personnels.patients-personnels-component',[
            'personnels'=>PatientAyantDroit::where('Nom','LIKE','%'.$this->keySearch.'%')
            ->orderBy('patient_ayant_droits.created_at','DESC')
            ->join('fiches','patient_ayant_droits.fiche_id','=','fiches.id')
            ->select('patient_ayant_droits.*')
            ->where('fiches.source',Auth::user()->is_to)
            ->get()
        ]);
    }
}
