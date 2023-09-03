<?php

namespace App\Http\Livewire\Pharmacie\Facturation;

use App\Models\FactureAbulant;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FacturationAmbulantComponent extends Component
{

    protected $listeners=['deleteFacturePharmaListener'=>'destroy'];

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
          $facture_pharma=FactureAbulant::create(
              [
                'numero'=>'PS-'.date('d').'.'.date('m').'.'.date('y').'-'.rand(10,1000).'-ABL',
                'name'=>$this->name,
                'user_id'=> Auth::user()->id            ]
          );
          $this->dispatchBrowserEvent('data-added',['message'=>"Facture bien bien étabie"]);
        } catch (\Illuminate\Database\QueryException $ex) {
              $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function edit($id){
        $this->facture_pharma_to_edit=FactureAbulant::find($id);
        $this->name=$this->facture_pharma_to_edit->name;
        $this->dateFact=$this->facture_pharma_to_edit->created_at;
    }

    public function update(){
        try {
            $this->facture_pharma_to_edit->name=$this->name;
            $this->facture_pharma_to_edit->created_at=$this->dateFact;
            $this->facture_pharma_to_edit->update();
            $this->dispatchBrowserEvent('data-updated',['message'=>"Facture bien bien mise à jour"]);
          } catch (\Illuminate\Database\QueryException $ex) {
                $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
          }

    }

    public $orderProducts=[];

    public function show($id){
        $this->facture_pharma=FactureAbulant::find($id);
    }

    public function showOrder($id){
        $this->facture_pharma_orders=FactureAbulant::find($id);
    }
    public function showDialog(){
        $this->dispatchBrowserEvent('show-add-facture_pharma-confirmation');
    }

    public function refresh($id){
        $this->facture_pharma_orders=FactureAbulant::find($id);
        $this->facture_pharma_id_to_edit=0;

    }

    public function showDeletefacturePharma1Dialog($id){
        $this->facture_pharma_id=$id;
        $this->dispatchBrowserEvent('show-delete-facture_pharma-confirmation');
    }

    public function destroy(){
        $this->facture_pharma_id;
        $facture_pharma=FactureAbulant::find($this->facture_pharma_id);
        $facture_pharma->products()->detach();
        $facture_pharma->delete();
        $this->dispatchBrowserEvent('facture_pharma-deleted',['message'=>"Facture ambulant  bein retiré !"]);
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
                $this->dispatchBrowserEvent('data-add-faild',['message'=>"Veillez remplir tout les champs"]);
            }else{
                $this->facture_pharma->products()->attach($orders['product_id'],['qty'=>$orders['qty']]);
                $this->dispatchBrowserEvent('data-added',['message'=>"produit bien facturé(s)"]);
            }

        }
    }



    public function activeEditfacturePharma($id){
        $order=DB::table('facture_abulant_product')->where('id',$id)->first();
        $this->facture_pharma_id_to_edit=$order->id;
        $this->qtToEdit=$order->qty;
    }

    public function updateOrder($id,$id_facture_pharma){
        $labo = DB::table('facture_abulant_product')
        ->where('id', $id)
        ->update([
            'qty' => $this->qtToEdit,
        ]);

        $this->dispatchBrowserEvent('data-added',['message'=>"Liste bien mise à jour!"]);
        $this->refresh($id_facture_pharma);
        $this->facture_pharma_id_to_edit=0;
    }

    public function deleteOrder($id,$id_facture_pharma){
        DB::table('facture_abulant_product')->where('id',$id)->delete();
        $this->dispatchBrowserEvent('data-added',['message'=>"Liste bien retiré !"]);
        $this->refresh($id_facture_pharma);
        $this->facture_pharma_id_to_edit=0;
    }

    public function validateOrder($id){
        $facture_pharma=FactureAbulant::find($id);
        $facture_pharma->isValided=true;
        $facture_pharma->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Bon entrées bien validé !"]);
        $this->refresh($id);
    }

    public function unValidateOrder($id){
        $facture_pharma=FactureAbulant::find($id);
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
        return view('livewire.pharmacie.facturation.facturation-ambulant-component',[
            'factures'=>FactureAbulant::orderBy('created_at','DESC')
                ->whereDate('created_at',$this->currentDate)
                ->get()
        ]);
    }
}
