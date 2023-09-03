<?php

namespace App\Http\Livewire\Produit;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class SituationPharmaStockProduct extends Component
{
    use WithPagination;
    public $keySearch='';
    public function render()
    {
        return view('livewire.produit.situation-pharma-stock-product',[
            'products'=>Product::where('name','Like','%'.$this->keySearch.'%')
            ->where('is_depreciated',false)
            ->orderBy('name','ASC')
            ->get()
        ]);
    }
}
