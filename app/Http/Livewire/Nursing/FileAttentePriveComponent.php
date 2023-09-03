<?php

namespace App\Http\Livewire\Nursing;

use App\Models\DemandeConsultation;
use App\Models\LaboResult;
use App\Models\SigneDemande;
use Carbon\Carbon;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

class FileAttentePriveComponent extends Component
{
    public $keySearch='',$searchDate,$currentDate;
    public $poids,$temperature,$taille,$tension;
    public $demade_select,$idLaboSelect, $result,$result_edit;


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
        $this->currentDate=Carbon::now();
    }
    public function render()
    {
        $data=DemandeConsultation::select('demande_consultations.*',
        'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
        ->whereDate('demande_consultations.created_at',$this->currentDate)
        ->where('patient_prives.Nom','Like','%'.$this->keySearch.'%')
        ->orderBy('demande_consultations.created_at','ASC')
        ->get();
        return view('livewire.nursing.file-attente-prive-component',[
            'demandes'=>$data
        ]);
    }
}
