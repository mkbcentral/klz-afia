<?php

namespace App\Http\Livewire\Stock;

use App\Models\AchatProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AchatComponent extends Component
{
    protected $listeners=['AchatProductListener'=>'store','deleteAchatListener'=>'destroy'];
    public $achat_id;
    public $products;
    public $achat_orders;
    public $achat;
    public $achat_id_to_edit,$qtToEdit,$priceToEdit;
    public $mois=[],$currentMonth;

    public $orderProducts=[];

    public function show($id){
        $this->achat=AchatProduct::find($id);
    }

    public function showOrder($id){
        $this->achat_orders=AchatProduct::find($id);
    }
    public function showDialog(){
        $this->dispatchBrowserEvent('show-add-achat');
    }
    public function store(){
      try {
        $achat=AchatProduct::create(
            [
                'code'=>'PS-'.date('d').'.'.date('m').'.'.date('y').'-'.rand(10,1000),
                'user_id'=> Auth::user()->id
             ]
        );
        $this->dispatchBrowserEvent('achat-added',['message'=>"Entre en stock bien étabie"]);
      } catch (\Illuminate\Database\QueryException $ex) {
            $this->dispatchBrowserEvent('data-added-faild',['message'=>"Echec de l'opération"]);
      }
    }

    public function refresh($id){
        $this->achat_orders=AchatProduct::find($id);
        $this->achat_id_to_edit=0;

    }

    public function showDeleteachatDialog($id){
        $this->achat_id=$id;
        $this->dispatchBrowserEvent('show-delete-achat');
    }

    public function destroy(){
        $this->achat_id;
        $achat=AchatProduct::find($this->achat_id);
        $achat->products()->detach();
        $achat->delete();
        $this->dispatchBrowserEvent('achat-deleted',['message'=>"Bon de sortie bein retiré !"]);
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
        foreach ($this->orderProducts as $orders) {
            if($orders['product_id']==""){
                $this->dispatchBrowserEvent('data-added-faild',['message'=>"Veillez remplir tout les champs"]);
            }else{
                $this->achat->products()->attach($orders['product_id'],['qty'=>$orders['qty'],'price_to_by'=>$orders['price_to_by']]);
                $this->dispatchBrowserEvent('data-added',['message'=>"produit bien facturé(s)"]);
            }

        }
    }



    public function activeEditAchat($id){
        $order=DB::table('achat_product_product')->where('id',$id)->first();
        $this->achat_id_to_edit=$order->id;
        $this->qtToEdit=$order->qty;
        $this->priceToEdit=$order->price_to_by;
    }

    public function updateOrder($id,$id_achat){
        $labo = DB::table('achat_product_product')
        ->where('id', $id)
        ->update([
            'qty' => $this->qtToEdit,
            'price_to_by' => $this->priceToEdit
        ]);

        $this->dispatchBrowserEvent('data-added',['message'=>"Liste bien mise à jour!"]);
        $this->refresh($id_achat);
        $this->achat_id_to_edit=0;
    }

    public function deleteOrder($id,$id_achat){
        DB::table('achat_product_product')->where('id',$id)->delete();
        $this->dispatchBrowserEvent('data-added',['message'=>"Liste bien retiré !"]);
        $this->refresh($id_achat);
        $this->achat_id_to_edit=0;
    }

    public function validateOrder($id){
        $achat=AchatProduct::find($id);
        $achat->is_valided=true;
        $achat->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Bon entrées bien validé !"]);
        $this->refresh($id);
    }

    public function unValidateOrder($id){
        $achat=AchatProduct::find($id);
        $achat->is_valided=false;
        $achat->update();
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
        $this->achat_id_to_edit=0;
        $this->currentMonth=date('m');
        setlocale(LC_TIME, "fr_FR");
        foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }
    }
    public function render()
    {
        return view('livewire.stock.achat-component',[
            'achats'=>AchatProduct::orderBy('created_at','DESC')
            ->whereMonth('created_at',$this->currentMonth)
            ->get()
        ]);
    }
}
