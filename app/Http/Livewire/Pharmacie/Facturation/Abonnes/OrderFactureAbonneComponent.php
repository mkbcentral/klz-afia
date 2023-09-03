<?php

namespace App\Http\Livewire\Pharmacie\Facturation\Abonnes;

use App\Models\DemandeConsultation;
use App\Models\facture_dataConsultation;
use App\Models\FactPharmaAbn;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrderFactureAbonneComponent extends Component
{
    public $facture,$facture_data;

    protected $listeners=['factPharmAbonneOrderListener'=>'store','deleteOrderFactPharmaOrderListener'=>'destroy'];
    public $orderProducts=[];
    public $facture_orders;
    public $products;
    public $facture_id_to_edit,$qtToEdit,$priceToEdit;
    public $dmd;

    public function showDialog(){
        $this->dispatchBrowserEvent('show-add-order-abn-confirmation');
    }

    public function show($id){
        $this->facture_orders=FactPharmaAbn::find($id);
    }
    public function showOrder($id){
        $this->facture_orders=FactPharmaAbn::find($id);
    }
    public function store(){
        try {
            FactPharmaAbn::create(
                [
                    'code'=>'PS-'.date('d').'.'.date('m').'.'.date('y').'-'.rand(10,1000),
                    'demande_consultation_id'=>$this->facture_data->id,
                    'user_id'=> Auth::user()->id            ]
            );
            $this->refreshAll();
            $this->dispatchBrowserEvent('data-added',['message'=>"Facture bien étabie"]);
          } catch (\Illuminate\Database\QueryException $ex) {
                $this->dispatchBrowserEvent('data-added-faild',['message'=>"Echec de l'opération"]);
          }
    }

    public function addProductToOrder(){
        $this->orderProducts[]=['product_id'=>'','qty'=>0];
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
                $this->facture_data->products()->attach($orders['product_id'],['qty'=>$orders['qty']]);
                $this->facture_orders->products()->attach($orders['product_id'],['qty'=>$orders['qty']]);
                $this->facture_data->is_livred=true;
                $this->facture_data->update();
                $this->dispatchBrowserEvent('data-added',['message'=>"produit bien facturé(s)"]);
            }

        }
    }

    public function activeEditfacture($id){
        $order=DB::table('fact_pharma_abn_product')->where('id',$id)->first();
        $this->facture_id_to_edit=$order->id;
        $this->qtToEdit=$order->qty;
    }

    public function updateOrder($id,$id_facture){
        DB::table('fact_pharma_abn_product')
        ->where('id', $id)
        ->update([
            'qty' => $this->qtToEdit,
        ]);

        $this->dispatchBrowserEvent('data-added',['message'=>"Liste bien mise à jour!"]);
        $this->refresh($id_facture);
        $this->facture_id_to_edit=0;
    }


    public function deleteOrder($id,$id_facture){
        DB::table('fact_pharma_abn_product')->where('id',$id)->delete();
        $this->dispatchBrowserEvent('data-added',['message'=>"Produit bien retiré !"]);
        $this->refresh($id_facture);
        $this->facture_id_to_edit=0;
    }

    public function refresh($id){
        $this->facture_orders=FactPharmaAbn::find($id);
        $this->facture_id_to_edit=0;

    }

    public function showDeleteFactDialog($id){
        $this->dmd_id=$id;
        $this->dispatchBrowserEvent('show-delete-fact-pharma-abn-confirmation');
    }
    public function destroy(){
        $facture=FactPharmaAbn::find($this->dmd_id);
        $facture->products()->detach();
        $this->facture_data->products()->detach();
        $facture->delete();
        $this->dispatchBrowserEvent('data-added',['message'=>" Facture bein retiré !"]);
    }

    public function refreshAll(){
        $this->facture_data=DemandeConsultation::select('demande_consultations.*',
        'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom','patient_abonnes.Sexe')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
        ->where('demande_consultations.id',$this->facture)
        ->first();
    }

    public function mount(){
        $this->facture_data=DemandeConsultation::select('demande_consultations.*',
        'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom','patient_abonnes.Sexe')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
        ->where('demande_consultations.id',$this->facture)
        ->first();

        $this->products=Product::where('is_depreciated',false)->get();
        $this->orderProducts=[
            [
                'product_id'=>'','qty'=>'0','price'=>'0','posology'=>'Aucune'
            ]
        ];
        $this->facture_id_to_edit=0;

    }
    public function render()
    {
        return view('livewire.pharmacie.facturation.abonnes.order-facture-abonne-component',
            [
                'factures'=>FactPharmaAbn::where('demande_consultation_id',$this->facture)
                        ->orderBy('created_at','DESC')
                        ->get()
            ]

        );
    }
}
