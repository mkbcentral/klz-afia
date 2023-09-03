<?php

namespace App\Http\Livewire\Factures\Facturation;

use App\Models\Autre;
use App\Models\ConsInfo;
use App\Models\DemandeConsultation;
use App\Models\Echographie;
use App\Models\ExamenLabo;
use App\Models\ExamenRx;
use App\Models\MedicationService;
use App\Models\MedPatern;
use App\Models\Nursing;
use App\Models\Product;
use App\Models\Rate;
use App\Models\Sejour;
use Livewire\Component;

use function Symfony\Component\String\b;

class CreateFactureComponent extends Component
{
    public $facture,$facture_data;

    public $labos;
    public $radios;
    public $echos;
    public $sejours;
    public $products;
    public $autres;
    public $paterns;
    public $infos;


    public $itemLabo=[];
    public $itemRadio=[];
    public $itemEcho=[];
    public $itemAutre=[];
    public $itemPatern=[];
    //Enregiter

    public $sejour_id,$day_number;
    public $name_nursing="NURSING",$price_nursing=0,$qty_nursing=0;

    public $orderProducts=[];

    public function makeRate(){
        $rate=Rate::where('is_active',true)->first();
        $this->facture_data->rate_id=$rate->id;
        $this->facture_data->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Taux bien fixé"]);
    }
    public function addLaboDtail()
    {
        if($this->itemLabo==null){
            $this->dispatchBrowserEvent('data-added-faild',['message'=>"Aucun examen selectionné"]);
        }else{
            $this->facture_data->examenLabos()->attach($this->itemLabo);
            $this->dispatchBrowserEvent('data-added',['message'=>"Examens labo bien facturé(s)"]);

        }

    }
    public function addPatern()
    {
        if($this->itemPatern==null){
            $this->dispatchBrowserEvent('data-added-faild',['message'=>"Aucun examen selectionné"]);
        }else{
            $this->facture_data->paterns()->attach($this->itemPatern);
            $this->dispatchBrowserEvent('data-added',['message'=>"Examens labo bien facturé(s)"]);

        }

    }

    public function addInfo()
    {
        $this->validate(['infos'=>'required']);
        $info=new ConsInfo();
        $info->content=$this->infos;
        $info->demande_consultation_id =$this->facture_data->id;
        $info->save();
        $this->dispatchBrowserEvent('data-added',['message'=>"Examens labo bien facturé(s)"]);

    }
    public function addRadioDtail()
    {
        if($this->itemRadio==null){
            $this->dispatchBrowserEvent('data-added-faild',['message'=>"Aucun examen selectionné"]);
        }else{
            $this->facture_data->examenRadios()->attach($this->itemRadio);
            $this->dispatchBrowserEvent('data-added',['message'=>"Examens radio bien facturé(s)"]);

        }

    }

    public function addechoDtail(){
        if($this->itemEcho==null){
            $this->dispatchBrowserEvent('data-added-faild',['message'=>"Aucun examen selectionné"]);
        }else{
            $this->facture_data->echographies()->attach($this->itemEcho);
            $this->dispatchBrowserEvent('data-added',['message'=>"Examens echographie bien facturé(s)"]);

        }
    }

    public function addSejour(){
        $this->validate([
            'sejour_id'=>'required|numeric',
            'day_number'=>'required|numeric'
        ]);
        $this->facture_data->sejours()->attach($this->sejour_id,['qty'=>$this->day_number]);
        $this->dispatchBrowserEvent('data-added',['message'=>"Sejour bien facturé(s)"]);

    }

    public function addProductToOrder(){
        $this->orderProducts[]=['produit_pharma_id'=>'','qty'=>0,'posology'=>''];
    }

    public function removeOrderProduct($index){
        unset($this->orderProducts[$index]);
        array_values($this->orderProducts);
    }

    public function addProduct(){
        foreach ($this->orderProducts as $orders) {
            if($orders['product_id']==""){
                $this->dispatchBrowserEvent('data-added-faild',['message'=>"Veillez remplir tout les champs"]);
            }else{
                $prod=Product::find($orders['product_id']);
                $this->facture_data->products()->attach($orders['product_id'],['qty'=>$orders['qty'],'posology'=>$orders['posology']]);
                $this->facture_data->is_livred=true;
                $this->facture_data->update();
                $this->dispatchBrowserEvent('data-added',['message'=>"produit bien facturé(s)"]);
                /*
                if($orders['qty'] >$prod->quantity+$prod->getEntrees($prod->id)-$prod->getSortieService($prod->id)-$prod->getSortieDemande($prod->id)-$prod->getSortieAmbulant($prod->id)){
                    $this->dispatchBrowserEvent('data-added-faild',['message'=>"Quantité en stock insuffisant !"]);
                }else{
                    $this->facture_data->products()->attach($orders['product_id'],['qty'=>$orders['qty'],'posology'=>$orders['posology']]);
                    $this->facture_data->is_livred=true;
                    $this->facture_data->update();
                    $this->dispatchBrowserEvent('data-added',['message'=>"produit bien facturé(s)"]);

                }
                */
            }

        }
    }

    public function addMEication(){
        foreach ($this->orderProducts as $orders) {
            if($orders['product_id']==""){
                $this->dispatchBrowserEvent('data-added-faild',['message'=>"Veillez remplir tout les champs"]);
            }else{
                $medication=MedicationService::create(
                    [
                        'demande_consultation_id'=>$this->facture_data->id,
                        'product_id'=>$orders['product_id'],
                        'qty'=>$orders['qty'],
                        'posology'=>$orders['posology'],

                    ]
                );

                if ($medication) {
                        $this->dispatchBrowserEvent('data-added',['message'=>"produit bien facturé(s)"]);
                }
            }

        }
    }

    public function addautreDtail(){
        if($this->itemAutre==null){
            $this->dispatchBrowserEvent('data-added-faild',['message'=>"Aucun élément selectionné"]);
        }else{
            $this->facture_data->autres()->attach($this->itemAutre);
            $this->dispatchBrowserEvent('data-added',['message'=>"Auutre details bien facturé(s)"]);

        }
    }

    public function addNursing(){
        $this->validate([
            'name_nursing'=>'required',
            'price_nursing'=>'required|numeric',
            'qty_nursing'=>'required|numeric'
        ]);

        $nursing=Nursing::create(
            [
                'name'=>$this->name_nursing,
                'price'=>$this->price_nursing,
                'qty'=>$this->qty_nursing,
                'demande_consultation_id'=>$this->facture_data->id
            ]
        );
        $this->dispatchBrowserEvent('data-added',['message'=>"Nursing et autres details bien facturé(s)"]);
        $this->emitTo('component-to-refresh', 'refreshComponent');
    }

    public function retour(){
        back();
    }

    public function mount(){
        $this->labos=ExamenLabo::where('is_changed',false)->orderBy('name','ASC')->get();
        $this->radios=ExamenRx::where('is_changed',false)->orderBy('name','ASC')->get();
        $this->echos=Echographie::where('is_changed',false)->orderBy('name','ASC')->get();
        $this->paterns=MedPatern::all();
        $this->sejours=Sejour::where('is_changed',false)->orderBy('name','ASC')->get();
        $this->products=Product::orderBy('name','ASC')
                            ->where('is_depreciated',false)
                            ->get();
        $this->autres=Autre::where('is_changed',false)->orderBy('name','ASC')->get();

        $this->facture_data=DemandeConsultation::select('demande_consultations.*',
        'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
        ->where('demande_consultations.id',$this->facture)
        ->first();


        $this->orderProducts=[
            [
                'product_id'=>'','qty'=>'0','posology'=>"Aucune"
            ]
        ];
    }
    public function render()
    {
        return view('livewire.factures.facturation.create-facture-component');
    }
}
