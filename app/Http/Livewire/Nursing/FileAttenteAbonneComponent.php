<?php

namespace App\Http\Livewire\Nursing;

use App\Models\Abonnement;
use App\Models\DemandeConsultation;
use App\Models\LaboResult;
use App\Models\SigneDemande;
use Carbon\Carbon;
use Livewire\Component;

class FileAttenteAbonneComponent extends Component
{
    public $keySearch='',$searchDate,$currentDate;
    public $poids,$temperature,$taille,$tension;
    public $abonnements,$abonnement_data;
    public $demade_select_abn,$idLaboSelect, $result,$result_edit;

    public function getInfos($id){
        $this->demade_select_abn=DemandeConsultation::select('demande_consultations.*',
        'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
        ->where('demande_consultations.id',$id)
        ->first();
    }

    public function activeWriter($id){
        $this->idLaboSelect=$id;
    }

    public function saveResult($id){
        $result=new LaboResult();
        $result->name=$this->result;
        $result->demande_consultation_id =$this->demade_select_abn->id;
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

    public function addSigneVitauxAbn(){
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
            'demande_consultation_id'=>$this->demade_select_abn_abn->id
        ]);
        $this->dispatchBrowserEvent('data-added',['message'=>"Info bien ajoutées !"]);
    }


    public function mount(){
        $this->currentDate=Carbon::now();
        $this->abonnements=Abonnement::all();
    }
    public function render()
    {
        $data=DemandeConsultation::select('demande_consultations.*',
            'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
            ->whereMonth('demande_consultations.created_at',$this->currentDate)
            ->where('patient_abonnes.Nom','Like','%'.$this->keySearch.'%')
            ->where('patient_abonnes.abonnement_id',$this->abonnement_data)
            ->orderBy('demande_consultations.created_at','DESC')
            ->where('demande_consultations.source','Golf')
             ->get();
        return view('livewire.nursing.file-attente-abonne-component',['demandes'=>$data]);
    }
}
