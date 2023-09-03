<?php

namespace App\Http\Livewire\Pharmacie\Produits;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProduitPharmacieComponent extends Component
{
    use WithPagination;
    public $keySearch='',$pageNumber=100;
    public $code='P-A-00X',$name,$numLot='INCONNUE',$conditionnement='CES',
    $quantity=0,$price=0.0,$price_abonne=0.0,$expirated_at,$qt_stock;

    public $product,$id_product;
    protected $listeners=['productTrashedListener'=>'makeProductInTrash'];

    protected $rules = [
        'code' => 'required|min:6',
        'name' => 'required',
        'numLot' => 'required',
        'conditionnement' => 'required',
        'quantity' => 'required|numeric',
        'price' => 'required|numeric',
        'price_abonne' => 'required|numeric',
        'expirated_at' => 'required|date'
    ];

    public function updatingkeySearch(){
        $this->resetPage();
    }


    public function create(){
        $this->dispatchBrowserEvent('show-add-product-form');
    }

    public function store(){
        $this->validate();
      try {
        $product=Product::create([
            'code'=>$this->code,
            'name'=>$this->name,
            'numero_lot'=>$this->numLot,
            'conditionnement'=>$this->conditionnement,
            'quantity'=>$this->quantity,
            'price'=>$this->price,
            'price_abonne'=>$this->price_abonne,
            'expirated_at'=>$this->expirated_at,
        ]);
        $this->dispatchBrowserEvent('data-added',['message'=>"Produit bien creé"]);
      } catch (\Illuminate\Database\QueryException $ex) {
          if ($ex->getCode()=="22007") {
            session()->flash('error_msg',"Vérifier le format de la date SVP!");
          }
      }
    }

    public function show($id){
        $this->id_product=$id;
        $this->dispatchBrowserEvent('show-delete-confirmation-product');
    }

    public function makeProductInTrash(){
        $product=Product::find($this->id_product);
        $product->is_depreciated=true;
        $product->update();

        $this->dispatchBrowserEvent('product-trashed',['message'=>"Produit bien mis à la corbeille !"]);
    }

    public function edit($id){
        $product=Product::find($id);

        $this->code=$product->code;
        $this->name=$product->name;
        $this->numLot=$product->numero_lot;
        $this->conditionnement=$product->conditionnement;
        $this->quantity=$product->quantity;
        $this->price=$product->price;
        $this->price_abonne=$product->price_abonne;
        $this->expirated_at=$product->expirated_at;

        $this->product=$product;
        $this->dispatchBrowserEvent('show-edit-product-form');

    }

    public function update(){
        $this->product->code=$this->code;
        $this->product->name=$this->name;
        $this->product->numero_lot=$this->numLot;
        $this->product->conditionnement=$this->conditionnement;
        $this->product->quantity=$this->quantity;
        $this->product->price=$this->price;
        $this->product->price_abonne=$this->price_abonne;
        $this->product->expirated_at=$this->expirated_at;
        $this->product->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Produit bien mis à jour"]);
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
        return view('livewire.pharmacie.produits.produit-pharmacie-component',[
            'products'=>Product::where('name','Like','%'.$this->keySearch.'%')
            ->where('is_depreciated',false)
            ->orderBy('name','ASC')
            ->paginate($this->pageNumber)
        ]);
    }
}
