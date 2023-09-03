<?php

namespace App\Http\Livewire\Hospitalisation;

use App\Models\DemandeConsultation;
use App\Models\MedicationSurveillance;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HospitalisationAbonnesDetailsComponent extends Component
{
    public $facture,$facture_date;
    public $keySearch='',$isClicked=false;
    public $idProdSelect,$qty,$time_data;
    public $productId,$dateToSearch,$currentDate;



    public function getByDay(){
        $this->currentDate=$this->dateToSearch;;
    }
    public function activeWriter($id){
        $this->idProdSelect=$id;
    }

    public function validedData(){
        $this->idProdSelect=0;
        $info=new MedicationSurveillance();
        $info->qty=$this->qty;
        $info->time_add=$this->time_data;
        $info->product_id=$this->productId;
        $info->demande_consultation_id =$this->facture;
        $info->user_id=Auth::user()->id;
        $info->save();
        $this->dispatchBrowserEvent('data-added',['message'=>"Info bien ajoutée !"]);
    }

    public function show($id){
        $productInfos=Product::find($id);
        $this->productId=$productInfos->id;
    }

    public function delete($id){
        $info=MedicationSurveillance::find($id);
        $info->delete();
        $this->dispatchBrowserEvent('data-deleted',['message'=>"Info bien retiré !"]);
    }

    public function mount(){
        $this->facture_data=DemandeConsultation::select('demande_consultations.*',
        'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
        ->where('demande_consultations.id',$this->facture)
        ->first();
        $this->currentDate=Carbon::now();

    }
    public function render()
    {
        $products= Product::orderBy('name','ASC')
                ->where('name','Like','%'.$this->keySearch.'%')
                ->where('is_depreciated',false)
                ->paginate(15);
        $infos=MedicationSurveillance::where('demande_consultation_id',$this->facture)
                                        ->whereDate('created_at',$this->currentDate)
                                        ->get();
        return view('livewire.hospitalisation.hospitalisation-abonnes-details-component',[
            'products'=>$products,
            'infos'=>$infos
        ]);
    }
}
