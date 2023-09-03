<?php

namespace App\Http\Livewire\Consommation\Product;

use App\Models\ConsommationProduct;
use App\Models\Product;
use App\Models\Service;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ConsommationProductComponent extends Component
{
    protected $listeners=['deleteFacturePharmaListener'=>'destroy'];

    public $week,$service_id;
    public $products;
    public $services;
    public $consommation;
    public function getByDate(){
        $this->currentDate=$this->keySearch;
    }


    public function store(){
        $this->validate([
            'week'=>'required',
            'service_id'=>'required'
        ]);
        try {
          $facture_pharma=ConsommationProduct::create(
              [
                'code'=>'PS-'.date('d').'.'.date('m').'.'.date('y').'-'.rand(10,1000).'-CONS',
                'week'=>$this->week,
                'user_id'=> Auth::user()->id,
                'service_id'=> $this->service_id             ]
          );
          $this->dispatchBrowserEvent('data-added',['message'=>"Infos bien bien ajoutée"]);
        } catch (QueryException $ex) {
              $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function edit($id){
        $this->consommation=ConsommationProduct::find($id);
        $this->week=$this->consommation->week;
        $this->service_id=$this->consommation->service_id;
    }

    public function update(){
        try {
            $this->consommation->week=$this->week;
            $this->consommation->service_id=$this->service_id;
            $this->consommation->update();
            $this->dispatchBrowserEvent('data-updated',['message'=>"Infos bien mise à jour"]);
          } catch (\Illuminate\Database\QueryException $ex) {
                $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
          }

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
        $this->services=Service::all();
    }

    public function render()
    {
        return view('livewire.consommation.product.consommation-product-component',[
            'consommations'=>ConsommationProduct::orderBy('created_at','DESC')
                ->whereMonth('created_at',$this->currentDate)
                ->get()
        ]);
    }
}
