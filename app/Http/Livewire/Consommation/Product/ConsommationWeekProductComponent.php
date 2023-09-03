<?php

namespace App\Http\Livewire\Consommation\Product;

use App\Models\Abonnement;
use App\Models\ConsommationProduct;
use App\Models\ConsommationWeek;
use App\Models\Product;
use App\Models\ProductDayCons;
use App\Models\ProductDayOder;
use Livewire\Component;

class ConsommationWeekProductComponent extends Component
{
    public $week;
    public $consommation;
    public $day_anme;
    public $keySearch='';
    public $day,$day_id;
    public $abonnements,$type;
    public $day_product_id,$qty,$day_product_order_id;
    public $current_day="LUNDI",$selected_day,$week_id;

    public function saveProds($id){
        $prod=new ProductDayCons();
        $prod->consommation_week_id=$this->day_id;
        $prod->product_id=$id;
        $prod->save();
        $this->dispatchBrowserEvent('data-added',['message'=>"Infos bien bien ajoutée"]);
    }
    public function saveProdOrders(){
        $order=new ProductDayOder();
        $order->product_day_con_id=$this->day_product_order_id;
        $order->type=$this->type;
        $order->qty=$this->qty;
        $order->save();
        $this->dispatchBrowserEvent('data-added',['message'=>"Infos bien bien ajoutée"]);
    }

    public function mount(){
        $this->consommation=ConsommationProduct::find($this->week);
        $this->selected_day=$this->current_day;
        $week_data=ConsommationWeek::where('day',$this->selected_day)->first();
        $this->week_id=$week_data->id;
        $this->abonnements=Abonnement::all();
    }
    public function render()
    {
        return view('livewire.consommation.product.consommation-week-product-component',
            [
                'days'=>ConsommationWeek::all(),
                'day_products'=>ProductDayCons::where('consommation_week_id',$this->week_id)->get(),
                'day_product_orders'=>ProductDayOder::all(),
                'products'=>Product::where('name','Like','%'.$this->keySearch.'%')
                ->where('is_depreciated',false)
                ->orderBy('name','ASC')
                ->paginate(10),
            ]);
    }

    public function save(){
        $this->validate([
            'day_anme'=>'required'
        ]);
        $day=new ConsommationWeek();
        $day->day=$this->day_anme;
        $day->consommation_product_id=$this->week;
        $day->save();
        $this->dispatchBrowserEvent('data-added',['message'=>"Infos bien bien ajoutée"]);
    }

    public function show($id){
        $this->day=ConsommationWeek::find($id);
        $this->day_id=$this->day->id;
    }
    public function showDay($id){
        $order=ProductDayCons::find($id);
        $this->day_product_order_id=$order->id;
    }

    public function showProdOorder($id){
        $order=ProductDayOder::find($id);
        $this->day_product_id=$order->id;
    }

    public function deleteOrder($id){
        $order=ProductDayOder::find($id);
        $order->delete();
        $this->dispatchBrowserEvent('data-deleted',['message'=>"Infos bien bien ajoutée"]);
    }

    public function getDayName($id){
        $week_data=ConsommationWeek::find($id);
        $this->selected_day=$week_data->day;
        $this->week_id=$week_data->id;
    }
}
