<?php

namespace App\Http\Livewire\Pharmacie\Sorties;

use App\Models\Product;
use App\Models\Service;
use App\Models\SortieService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SortieComponent extends Component
{

    protected $listeners=['SortieServiceListener'=>'store','deletesortieListener'=>'destroy'];
    public $sortie_id;
    public $products;
    public $sortie_orders;
    public $sortie;
    public $sortie_id_to_edit,$qtToEdit;
    public $services,$service_id;
    public $mois,$monthName;

    public $orderProducts=[];

    public function show($id){
        $this->sortie=SortieService::find($id);
    }

    public function showOrder($id){

        $this->sortie_orders=SortieService::find($id);
    }
    public function showDialog(){
        $this->dispatchBrowserEvent('show-add-sortie-confirmation');
    }
    public function store(){
      try {
          if ($this->service_id==null) {
                $this->dispatchBrowserEvent('data-add-faild',['message'=>"Aucun service selectionné !"]);
          } else {
                $sortie=SortieService::create(
                    [
                        'code'=>'PS-'.date('d').'.'.date('m').'.'.date('y').'-'.rand(10,1000).'-S',
                        'service_id'=>$this->service_id,
                        'user_id'=> Auth::user()->id            ]
                );
                $this->dispatchBrowserEvent('sortie-added',['message'=>"Entre en stock bien étabie"]);
          }


      } catch (\Illuminate\Database\QueryException $ex) {
            $this->dispatchBrowserEvent('data-add-faild',['message'=>"Echec de l'opération"]);
      }
    }

    public function refresh($id){
        $this->sortie_orders=SortieService::find($id);
        $this->sortie_id_to_edit=0;

    }



    public function showDeletesortie1Dialog($id){
        $this->sortie_id=$id;
        $this->dispatchBrowserEvent('show-delete-sortie-confirmation');
    }

    public function destroy(){
        $this->sortie_id;
        $sortie=SortieService::find($this->sortie_id);
        $sortie->products()->detach();
        $sortie->delete();
        $this->dispatchBrowserEvent('sortie-deleted',['message'=>"Bon de sortie bein retiré !"]);
    }

    public function addProductToOrder(){
        $this->orderProducts[]=['product_id'=>'','qty'=>0];
    }

    public function removeOrderProduct($index){
        unset($this->orderProducts[$index]);
        array_values($this->orderProducts);
    }

    public function addProduct(){
        //dd($this->sortie);
        foreach ($this->orderProducts as $orders) {
            if($orders['product_id']==""){
                $this->dispatchBrowserEvent('data-add-faild',['message'=>"Veillez remplir tout les champs"]);
            }else{
                $product=Product::find($orders['product_id']);
                $stock=$product->quantity+$product->getEntrees($product->id)-$product->getSortieService($product->id)-$product->getSortieDemande($product->id);
                $this->sortie->products()->attach($orders['product_id'],['qty'=>$orders['qty']]);
                $this->dispatchBrowserEvent('data-added',['message'=>"produit bien facturé(s)"]);
                /*if (($stock < $orders['qty'])) {
                    $this->dispatchBrowserEvent('data-add-faild',['message'=>$product->name." Stock insuffidant !"]);
                } else {

                }
                */


            }

        }
    }



    public function activeEditsortie($id){
        $order=DB::table('product_sortie_service')->where('id',$id)->first();
        $this->sortie_id_to_edit=$order->id;
        $this->qtToEdit=$order->qty;
    }

    public function updateOrder($id,$id_sortie){
        $labo = DB::table('product_sortie_service')
        ->where('id', $id)
        ->update([
            'qty' => $this->qtToEdit,
        ]);

        $this->dispatchBrowserEvent('data-added',['message'=>"Liste bien mise à jour!"]);
        $this->refresh($id_sortie);
        $this->sortie_id_to_edit=0;
    }

    public function deleteOrder($id,$id_sortie){
        DB::table('product_sortie_service')->where('id',$id)->delete();
        $this->dispatchBrowserEvent('data-added',['message'=>"Liste bien retiré !"]);
        $this->refresh($id_sortie);
        $this->sortie_id_to_edit=0;
    }

    public function validateOrder($id){
        $sortie=SortieService::find($id);
        $sortie->is_valided=true;
        $sortie->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Bon entrées bien validé !"]);
        $this->refresh($id);
    }

    public function unValidateOrder($id){
        $sortie=SortieService::find($id);
        $sortie->is_valided=false;
        $sortie->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Validation annulée !"]);
        $this->refresh($id);
    }

    public function mount(){
        $this->products=Product::where('is_depreciated',false)
        ->orderBy('name','ASC')
            ->get();
        $this->orderProducts=[
            [
                'product_id'=>'','qty'=>'0'
            ]
        ];
        $this->sortie_id_to_edit=0;
        $this->services=Service::all();
        $this->monthName=date('m');
        foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }
    }


    public function render()
    {
        return view('livewire.pharmacie.sorties.sortie-component',[
            'sorties'=>SortieService::orderBy('created_at','DESC')
                    ->whereMonth('created_at',$this->monthName)
                    ->get()
        ]);
    }
}
