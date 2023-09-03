<?php

namespace App\Http\Livewire\Pharmacie;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class TrashProductComponent extends Component
{
    use WithPagination;
    public $keySearch='',$pageNumber=15;
    public $code='P-A-00X',$name,$numLot='INCONNUE',$conditionnement='CES',
    $quantity=0,$price=0.0,$price_abonne=0.0,$expirated_at;
    protected $listeners=['productUnTrashedListener'=>'unTrashedProduct'];

    public function updatingkeySearch()
    {
        $this->resetPage();
    }

    public function updatingpageNumber()
    {
        $this->resetPage();
    }

    public function show($id){
        $this->id_product=$id;
        $this->dispatchBrowserEvent('show-untrashed-product');
    }

    public function unTrashedProduct(){
        $product=Product::find($this->id_product);
        $product->is_depreciated=false;
        $product->update();

        $this->dispatchBrowserEvent('product-untrashed',['message'=>"Produit bien mis à la corbeille !"]);
    }

    public function makSpaciality($id){
        $product=Product::find($id);
        $product->is_speciality=true;
        $product->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Produit parqué specialité !"]);
    }

    public function unmakSpaciality ($id){
        $product=Product::find($id);
        $product->is_speciality=false;
        $product->update();
        $this->dispatchBrowserEvent('data-added',['message'=>"Produit parqué specialité !"]);
    }
    public function render()
    {
        return view('livewire.pharmacie.trash-product-component',[
            'products'=>Product::where('name','Like','%'.$this->keySearch.'%')
            ->where('is_depreciated',true)
            ->orderBy('name','ASC')
            ->paginate($this->pageNumber)
        ]);
    }
}
