<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class DataPharmaPeriode extends Component
{
    public $years=['2021','2022','2023','2024','2025'];
    public $currentYear;
    public $months=['01','02'];
    public $currentMonth;
    public function mount(){
        $this->currentYear=date('Y');
    }
    public function render()
    {
        $pproducts = Product::orderBy('name','ASC')->get();
        return view('livewire.data-pharma-periode',['products'=>$pproducts]);
    }
}
