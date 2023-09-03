<?php

namespace App\Http\Livewire\Pharmacie\Entrees;

use App\Models\EntreeStock;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EntreesComponent extends Component
{
    protected $listeners=['entreeStockListener'=>'store','deleteEntreeListener'=>'destroy'];
    public $entree_id;
    public $products;
    public $entree_orders;
    public $entree;
    public $entree_id_to_edit,$qtToEdit,$priceToEdit;
    public $mois=[],$currentMonth;

    public $orderProducts=[];

    public function show($id){
        $this->entree=EntreeStock::find($id);
    }

    public function showOrder($id){
        $this->entree_orders=EntreeStock::find($id);
    }
    public function showDialog(){
        $this->dispatchBrowserEvent('show-add-entree-confirmation');
    }
    public function store(){
      try {
        $entree=EntreeStock::create(
            [
                'code'=>'PS-'.date('d').'.'.date('m').'.'.date('y').'-'.rand(10,1000),
                'user_id'=> Auth::user()->id            ]
        );
        $this->dispatchBrowserEvent('entree-added',['message'=>"Entre en stock bien étabie"]);
      } catch (\Illuminate\Database\QueryException $ex) {
            $this->dispatchBrowserEvent('data-added-faild',['message'=>"Echec de l'opération"]);
      }
    }

    public function refresh($id){
        $this->entree_orders=EntreeStock::find($id);
        $this->entree_id_to_edit=0;

    }

    public function showDeleteEntree1Dialog($id){
        $this->entree_id=$id;
        $this->dispatchBrowserEvent('show-delete-entree-confirmation');
    }

    public function destroy(){
        $this->entree_id;
        $entree=EntreeStock::find($this->entree_id);
        $entree->products()->detach();
        $entree->delete();
        $this->dispatchBrowserEvent('entree-deleted',['message'=>"Bon de sortie bein retiré !"]);
    }

    public function addProductToOrder(){
        $this->orderProducts[]=['product_id'=>'','qty'=>0,'price_to_by'=>0];
    }

    public function removeOrderProduct($index){
        unset($this->orderProducts[$index]);
        array_values($this->orderProducts);
    }

    public function getSalePrice($index){
        unset($this->orderProducts[$index]);
        array_values($this->orderProducts);
    }

    public function addProduct(){
        //dd($this->entree);
        foreach ($this->orderProducts as $orders) {
            if($orders['product_id']==""){
                $this->dispatchBrowserEvent('data-added-faild',['message'=>"Veillez remplir tout les champs"]);
            }else{
                $this->entree->products()->attach($orders['product_id'],['qty'=>$orders['qty'],'price_to_by'=>$orders['price_to_by']]);
                $this->dispatchBrowserEvent('data-added',['message'=>"produit bien facturé(s)"]);
            }

        }
    }



    public function activeEditEntree($id){
        $order=DB::table('entree_stock_product')->where('id',$id)->first();
        $this->entree_id_to_edit=$order->id;
        $this->qtToEdit=$order->qty;
        $this->priceToEdit=$order->price_to_by;
    }

    public function updateOrder($id,$id_entree){
        $labo = DB::table('entree_stock_product')
        ->where('id', $id)
        ->update([
            'qty' => $this->qtToEdit,
            'price_to_by' => $this->priceToEdit
        ]);

        $this->dispatchBrowserEvent('data-added',['message'=>"Liste bien mise à jour!"]);
        $this->refresh($id_entree);
        $this->entree_id_to_edit=0;
    }

    public function deleteOrder($id,$id_entree){
        DB::table('entree_stock_product')->where('id',$id)->delete();
        $this->dispatchBrowserEvent('data-added',['message'=>"Liste bien retiré !"]);
        $this->refresh($id_entree);
        $this->entree_id_to_edit=0;
    }

    public function validateOrder($id){
        $entree=EntreeStock::find($id);
        $entree->is_valided=true;
        $entree->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Bon entrées bien validé !"]);
        $this->refresh($id);
    }

    public function unValidateOrder($id){
        $entree=EntreeStock::find($id);
        $entree->is_valided=false;
        $entree->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Validation annulée !"]);
        $this->refresh($id);
    }

    public function mount(){
        $this->products=Product::where('is_depreciated',false)
        ->orderBy('name','ASC')
        ->get();
        $this->orderProducts=[
            [
                'product_id'=>'','qty'=>'0','price_to_by'=>'0'
            ]
        ];
        $this->entree_id_to_edit=0;
        $this->currentMonth=date('m');
        setlocale(LC_TIME, "fr_FR");
        foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }
    }
    public function render()
    {
        return view('livewire.pharmacie.entrees.entrees-component',[
            'entrees'=>EntreeStock::orderBy('created_at','DESC')
                                ->whereMonth('created_at',$this->currentMonth)
                                ->get()
        ]);
    }
}
