<?php

namespace App\Http\Livewire\Stock;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class StockProductsComponent extends Component
{
    use WithPagination;
    public $keySearch='';
    public function render()
    {
        return view('livewire.stock.stock-products-component',[
            'products'=>Product::where('name','Like','%'.$this->keySearch.'%')
            ->where('is_depreciated',false)
            ->orderBy('name','ASC')
            ->get()
        ]);
    }
}
