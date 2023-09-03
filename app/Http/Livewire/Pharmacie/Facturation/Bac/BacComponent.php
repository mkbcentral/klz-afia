<?php

namespace App\Http\Livewire\Pharmacie\Facturation\Bac;

use App\Models\FactureBacPharma;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BacComponent extends Component
{
    protected $listeners=['deleteFacturePharmaBacListener'=>'destroy'];

    public $name;
    public $facture_pharma_id;
    public $products;
    public $facture_pharma_orders;
    public $facture_pharma;
    public $facture_pharma_to_edit;
    public $facture_pharma_id_to_edit,$qtToEdit,$dateFact;
    public $keySearch,$currentDate;

    public function getByDate(){
        $this->currentDate=$this->keySearch;
    }


    public function store(){
        $this->validate(['name'=>'required']);
        try {
          $facture_pharma=FactureBacPharma::create(
              [
                'numero'=>'PS-'.date('d').'.'.date('m').'.'.date('y').'-'.rand(10,1000).'-ABL',
                'name'=>$this->name,
                'user_id'=> Auth::user()->id            ]
          );
          $this->dispatchBrowserEvent('data-added',['message'=>"Facture bien bien étabie"]);
        } catch (\Illuminate\Database\QueryException $ex) {
              $this->dispatchBrowserEvent('data-added-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function edit($id){
        $this->facture_pharma_to_edit=FactureBacPharma::find($id);
        $this->name=$this->facture_pharma_to_edit->name;
        $this->dateFact=$this->facture_pharma_to_edit->created_at;
    }

    public function update(){
        try {
            $this->facture_pharma_to_edit->name=$this->name;
            $this->facture_pharma_to_edit->created_at=$this->dateFact;
            $this->facture_pharma_to_edit->update();
            $this->dispatchBrowserEvent('data-added',['message'=>"Facture bien bien mise à jour"]);
          } catch (\Illuminate\Database\QueryException $ex) {
                $this->dispatchBrowserEvent('data-added-faild',['message'=>$ex->getMessage()]);
          }

    }

    public $orderProducts=[];

    public function show($id){
        $this->facture_pharma=FactureBacPharma::find($id);
    }

    public function showOrder($id){
        $this->facture_pharma_orders=FactureBacPharma::find($id);
    }
    public function showDialog(){
        $this->dispatchBrowserEvent('show-add-facture_pharma-bac-confirmation');
    }

    public function refresh($id){
        $this->facture_pharma_orders=FactureBacPharma::find($id);
        $this->facture_pharma_id_to_edit=0;

    }

    public function showDeletefacturePharmaBacDialog($id){
        $this->facture_pharma_id=$id;
        $this->dispatchBrowserEvent('show-delete-facture-pharma-bac-confirmation');
    }

    public function destroy(){
        $this->facture_pharma_id;
        $facture_pharma=FactureBacPharma::find($this->facture_pharma_id);
        $facture_pharma->products()->detach();
        $facture_pharma->delete();
        $this->dispatchBrowserEvent('facture_pharma-deleted',['message'=>"Bon de sortie bein retiré !"]);
    }

    public function addProductToOrder(){
        $this->orderProducts[]=['product_id'=>'','qty'=>0];
    }

    public function removeOrderProduct($index){
        unset($this->orderProducts[$index]);
        array_values($this->orderProducts);
    }

    public function addProduct(){
        //dd($this->facture_pharma);
        foreach ($this->orderProducts as $orders) {
            if($orders['product_id']==""){
                $this->dispatchBrowserEvent('data-added-faild',['message'=>"Veillez remplir tout les champs"]);
            }else{
                $this->facture_pharma->products()->attach($orders['product_id'],['qty'=>$orders['qty']]);
                $this->dispatchBrowserEvent('data-added',['message'=>"produit bien facturé(s)"]);
            }

        }
    }



    public function activeEditfacturePharma($id){
        $order=DB::table('facture_bac_pharma_product')->where('id',$id)->first();
        $this->facture_pharma_id_to_edit=$order->id;
        $this->qtToEdit=$order->qty;
    }

    public function updateOrder($id,$id_facture_pharma){
        $labo = DB::table('facture_bac_pharma_product')
        ->where('id', $id)
        ->update([
            'qty' => $this->qtToEdit,
        ]);

        $this->dispatchBrowserEvent('data-added',['message'=>"Liste bien mise à jour!"]);
        $this->refresh($id_facture_pharma);
        $this->facture_pharma_id_to_edit=0;
    }

    public function deleteOrder($id,$id_facture_pharma){
        DB::table('facture_bac_pharma_product')->where('id',$id)->delete();
        $this->dispatchBrowserEvent('data-added',['message'=>"Liste bien retiré !"]);
        $this->refresh($id_facture_pharma);
        $this->facture_pharma_id_to_edit=0;
    }

    public function validateOrder($id){
        $facture_pharma=FactureBacPharma::find($id);
        $facture_pharma->isValided=true;
        $facture_pharma->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Bon entrées bien validé !"]);
        $this->refresh($id);
    }

    public function unValidateOrder($id){
        $facture_pharma=FactureBacPharma::find($id);
        $facture_pharma->isValided=false;
        $facture_pharma->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Validation annulée !"]);
        $this->refresh($id);
    }

    public function mount(){
        $this->products=Product::where('is_depreciated',false)->get();
        $this->orderProducts=[
            [
                'product_id'=>'','qty'=>'0'
            ]
        ];
        $this->facture_pharma_id_to_edit=0;
        $this->currentDate=Carbon::now();
    }
    public function render()
    {
        return view('livewire.pharmacie.facturation.bac.bac-component',[
            'factures'=>FactureBacPharma::orderBy('created_at','DESC')
            ->whereDate('created_at',$this->currentDate)
            ->get()
        ]);
    }
}
